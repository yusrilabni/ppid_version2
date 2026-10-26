<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Models\InformasiPemkab;
use App\Models\Galeri;
use App\Models\Organization;
use App\Models\SaqAnswer;
use App\Models\SaqIndicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SaqController extends Controller
{
    /**
     * Daftar OPD untuk SAQ: unit tanpa kecamatan/desa/kelurahan,
     * beserta profil pimpinan & progres pengisian.
     * GET /api/v1/saq/opds
     */
    public function opds()
    {
        $opds = Organization::where('type', 'unit')
            ->where('name', 'not like', 'Kantor Kecamatan%')
            ->where('name', 'not like', 'Desa %')
            ->where('name', 'not like', 'Kelurahan %')
            ->where('slug', 'not like', 'bagian-%')
            ->with(['officials' => function ($q) {
                $q->where('status', 'active')->with('position')->limit(3);
            }])
            ->orderByRaw("CASE WHEN slug = 'kabupaten-sinjai' THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'remote_id']);

        // Pohon indikator sekali pakai untuk menghitung total tampil (lihat di bawah).
        $saqTabs = SaqIndicator::whereNull('parent_id')
            ->with('children.children.children')
            ->get();

        $data = $opds->map(function ($opd) use ($saqTabs) {
            // Scope OPD ini; Setda (42) menampilkan gabungan Bagian-bagiannya
            // (sama seperti SaqController@structure), jadi totalnya juga gabungan.
            $scopeOrgIds = [$opd->id];
            if ($opd->id == 42) {
                $scopeOrgIds = array_merge($scopeOrgIds, Organization::where('slug', 'like', 'bagian-%')->pluck('id')->toArray());
            }
            // Total = jumlah pertanyaan yang BENAR-BENAR TAMPIL di halaman ini,
            // dihitung dengan logika yang sama persis dengan structure(): pertanyaan
            // langsung di section bila terpetakan, pertanyaan dalam grup hanya bila
            // induk grupnya juga terpetakan. Bukan COUNT semua baris indicator_opd
            // (yang ikut menghitung grup induk + section sehingga header selalu
            // lebih besar dari jumlah tampil, mis. Diskominfo 130 vs 100).
            // Perbaikan 24 Okt 2026: header kini sama dengan jumlah tampil di halaman.
            $mappedIds = DB::table('indicator_opd')
                ->whereIn('organization_id', $scopeOrgIds)
                ->pluck('indicator_id')->toArray();
            $totalQuestions = 0;
            foreach ($saqTabs as $tab) {
                foreach ($tab->children as $sec) {
                    foreach ($sec->children as $child) {
                        if ($child->is_category) {
                            // Grup tampil hanya bila induknya terpetakan ke scope ini
                            if (!in_array($child->id, $mappedIds)) continue;
                            foreach ($child->children as $qu) {
                                if ($qu->is_category) continue;
                                if (in_array($qu->id, $mappedIds)) $totalQuestions++;
                            }
                        } elseif (in_array($child->id, $mappedIds)) {
                            $totalQuestions++;
                        }
                    }
                }
            }
            // Terisi = pertanyaan berjawaban yang sudah ada jawaban Ya/Tidak (distinct)
            $answered = SaqAnswer::whereIn('organization_id', $scopeOrgIds)
                ->whereNotNull('jawaban')->distinct()->count('indicator_id');
            return [
                'id' => $opd->id,
                'name' => $opd->name,
                'slug' => $opd->slug,
                'is_ppid_utama' => $opd->slug === 'kabupaten-sinjai',
                'pimpinan' => $opd->officials->map(fn($o) => [
                    'nama' => $o->full_name,
                    'jabatan' => $o->position->name ?? null,
                    'foto' => $o->photo,
                ])->values(),
                'progres' => [
                    'terisi' => $answered,
                    'total' => $totalQuestions,
                    'persen' => $totalQuestions > 0 ? round($answered / $totalQuestions * 100) : 0,
                ],
            ];
        });

        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * Struktur SAQ hirarkis: tab > seksi > pertanyaan.
     * Opsional ?organization_id= untuk menandai status terisi per pertanyaan.
     * GET /api/v1/saq/structure
     */
    public function structure(Request $request)
    {
        $orgId = $request->get('organization_id');
        // Mode full: tampilkan SEMUA pertanyaan tanpa filter OPD
        // (untuk halaman kabupaten-sinjai full, khusus superadmin)
        if ($request->boolean('full')) {
            $orgId = null;
        }

        $answeredIds = [];
        $jawabanMap = [];
        // Daftar indicator yang dipetakan ke org ini
        $mappedIds = [];
        $bagianMap = [];
        if ($orgId) {
            $rowsQuery = SaqAnswer::where('organization_id', $orgId)
                ->whereNotNull('jawaban');
            // Filter privasi untuk status terisi
            $user = $request->user();
            $isSuperadmin = $user && $user->role === 'superadmin';
            if (!$isSuperadmin) {
                $userOrgId = null;
                if ($user) {
                    $userOrg = \App\Models\Organization::where('remote_id', (string)$user->unit_id)->first();
                    $userOrgId = $userOrg ? $userOrg->id : null;
                }
                $rowsQuery->where(function($q) use ($userOrgId, $orgId) {
                    $q->where('visibility', 'public')
                      ->orWhere(function($qq) use ($userOrgId) {
                          $qq->where('visibility', 'private')
                             ->where('organization_id', $userOrgId ?: -1);
                      });
                });
            }
            $rows = $rowsQuery->get(['indicator_id', 'jawaban']);
            $answeredIds = $rows->pluck('indicator_id')->toArray();
            $jawabanMap = $rows->pluck('jawaban', 'indicator_id')->toArray();
            $orgIds = [$orgId];
            $bagianIds = [];
            // Jika Setda, sertakan juga Bagian-bagiannya
            if ($orgId == 42) {
                $bagianIds = Organization::where('slug', 'like', 'bagian-%')->pluck('id')->toArray();
                $orgIds = array_merge($orgIds, $bagianIds);
            }
            $mappedIds = DB::table('indicator_opd')
                ->whereIn('organization_id', $orgIds)
                ->pluck('indicator_id')->toArray();
            // Petakan indicator -> nama Bagian (untuk label di frontend)
            $bagianMap = [];
            if ($orgId == 42) {
                $bagianNames = Organization::where('slug', 'like', 'bagian-%')->pluck('name', 'id')->toArray();
                $rows2 = DB::table('indicator_opd')->whereIn('organization_id', $bagianIds)->get(['indicator_id', 'organization_id']);
                foreach ($rows2 as $r) {
                    $bagianMap[$r->indicator_id] = str_replace(' Sekretariat Daerah', '', $bagianNames[$r->organization_id] ?? '');
                }
            }
        }

        // Semua tab, tanpa filter scope (scope hanya di level pertanyaan)
        $tabs = SaqIndicator::whereNull('parent_id')->orderBy('order')
            ->with(['children' => function ($q) {
                $q->orderBy('order')->with(['children' => function ($qq) {
                    $qq->orderBy('order')->with(['children' => function ($qqq) {
                        $qqq->orderBy('order');
                    }]);
                }]);
            }])
            ->get();

        $data = [];
        // Helper untuk membangun array pertanyaan
        $buildQuestion = function($qu) use ($orgId, $mappedIds, $bagianMap, $answeredIds, $jawabanMap) {
            return [
                'id' => $qu->id,
                'kode' => $qu->kode,
                'pertanyaan' => $qu->pertanyaan,
                'bagian' => $bagianMap[$qu->id] ?? null,
                'dokumen_upload' => $qu->dokumen_upload,
                'input_type' => $qu->input_type ?? 'dokumen',
                'klasifikasi_otomatis' => $qu->klasifikasi_otomatis,
                'target_upload' => $qu->target_upload ?? 'ppid',
                'terisi' => in_array($qu->id, $answeredIds),
                'jawaban' => $jawabanMap[$qu->id] ?? null,
            ];
        };

        foreach ($tabs as $tab) {
            $sections = [];
            foreach ($tab->children as $sec) {
                $questions = [];
                $groups = [];
                foreach ($sec->children as $child) {
                    // Jika ini parent-group (is_category=1), buat grup dengan nested questions
                    if ($child->is_category) {
                        $groupQuestions = [];
                        foreach ($child->children as $qu) {
                            // Hanya tampilkan pertanyaan yang dipetakan ke org ini
                            if ($orgId && !in_array($qu->id, $mappedIds)) continue;
                            // Skip jika ini juga category (tidak seharusnya terjadi)
                            if ($qu->is_category) continue;
                            $groupQuestions[] = $buildQuestion($qu);
                        }
                        // Tampilkan grup jika ada pertanyaan di dalamnya, atau jika mode full
                        // (parent juga harus ter-mapping ke org agar grup tampil)
                        $parentMapped = !$orgId || in_array($child->id, $mappedIds);
                        if (!empty($groupQuestions) && $parentMapped) {
                            $gTerisi = count(array_filter($groupQuestions, fn($x) => $x['terisi']));
                            $groups[] = [
                                'id' => $child->id,
                                'kode' => $child->kode,
                                'pertanyaan' => $child->pertanyaan, // teks induk
                                'questions' => $groupQuestions,
                                'terisi' => $gTerisi,
                                'total' => count($groupQuestions),
                            ];
                        }
                    } else {
                        // Pertanyaan standalone (langsung di bawah section)
                        $qu = $child;
                        // Hanya tampilkan pertanyaan yang dipetakan ke org ini
                        if ($orgId && !in_array($qu->id, $mappedIds)) continue;
                        $questions[] = $buildQuestion($qu);
                    }
                }
                if (empty($questions) && empty($groups)) continue; // seksi kosong -> sembunyikan
                $terisi = count(array_filter($questions, fn($x) => $x['terisi']));
                $gTerisi = array_sum(array_map(fn($g) => $g['terisi'], $groups));
                $gTotal = array_sum(array_map(fn($g) => $g['total'], $groups));
                $sections[] = [
                    'kode' => $sec->kode,
                    'section' => $sec->section,
                    'questions' => $questions,
                    'groups' => $groups,
                    'terisi' => $terisi + $gTerisi,
                    'total' => count($questions) + $gTotal,
                ];
            }
            if (empty($sections)) continue; // tab kosong -> sembunyikan
            // Tandai tab PPID Utama bila semua pertanyaannya scope ppid_utama
            $isPpidUtamaTab = $tab->children->flatMap(fn($s) => $s->children->flatMap(fn($c) =>
                    $c->is_category ? $c->children : collect([$c])
                ))
                ->filter(fn($q) => !$q->is_category && (!$orgId || in_array($q->id, $mappedIds)))
                ->every(fn($q) => $q->scope === 'ppid_utama');
            $data[] = [
                'kode' => $tab->kode,
                'tab' => $tab->tab,
                'scope' => $isPpidUtamaTab ? 'ppid_utama' : 'semua_opd',
                'sections' => $sections,
            ];
        }

        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * Jawaban SAQ per OPD.
     * GET /api/v1/saq/answers?organization_id=
     */
    public function answers(Request $request)
    {
        $request->validate(['organization_id' => 'required|integer']);

        $query = SaqAnswer::where('organization_id', $request->organization_id)
            ->with(['indicator:id,kode,pertanyaan,tab', 'links']);

        // Filter privasi: private hanya untuk superadmin & admin OPD pemilik
        $user = $request->user();
        $isSuperadmin = $user && $user->role === 'superadmin';
        if (!$isSuperadmin) {
            $userOrgId = null;
            if ($user) {
                $userOrg = \App\Models\Organization::where('remote_id', (string)$user->unit_id)->first();
                $userOrgId = $userOrg ? $userOrg->id : null;
            }
            $query->where(function($q) use ($userOrgId, $request) {
                $q->where('visibility', 'public')
                  ->orWhere(function($qq) use ($userOrgId, $request) {
                      $qq->where('visibility', 'private')
                         ->where('organization_id', $userOrgId ?: -1);
                  });
            });
        }

        $answers = $query->orderBy('id')->get();

        return response()->json(['success' => true, 'data' => $answers]);
    }

    /**
     * Simpan jawaban SAQ (admin login).
     * Bila `klasifikasi` diisi -> sekaligus tercatat sebagai Informasi (draft).
     * POST /api/v1/saq/answers (auth:sanctum)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'required|integer|exists:organizations,id',
            'indicator_id' => 'required|integer|exists:saq_indicators,id',
            'jawaban' => 'required|in:ya,tidak',
            'visibility' => 'nullable|in:public,private',
            'links' => 'nullable|array|max:20',
            'links.*.judul' => 'nullable|string|max:255',
            'links.*.link' => 'required_with:links|string|max:2000',
            'links.*.deskripsi' => 'nullable|string',
            'links.*.mode' => 'nullable|in:baru,sync_ppid',
            'links.*.sync_url' => 'nullable|string|max:2000',
            // Jalur upload foto SAQ (hanya untuk pertanyaan tipe foto)
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'judul_foto' => 'nullable|string|max:255',
            'tanggal_upload' => 'nullable|date',
        ]);

        // Validasi: parent-group (is_category=1) tidak bisa diisi jawaban
        $indicator = SaqIndicator::find($validated['indicator_id']);
        if ($indicator && $indicator->is_category) {
            return response()->json([
                'success' => false,
                'message' => 'Pertanyaan induk (header) tidak dapat diisi jawaban.',
            ], 422);
        }

        // Otorisasi: hanya superadmin atau admin OPD pemilik yang boleh isi
        $user = $request->user();
        $isSuperadmin = ($user->role === 'superadmin');
        // Kabupaten Sinjai (PPID Utama, id 127) hanya boleh diisi superadmin
        if ((int)$validated['organization_id'] === 127 && !$isSuperadmin) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya superadmin yang dapat mengisi SAQ PPID Utama (Kabupaten Sinjai).',
            ], 403);
        }
        // Admin OPD hanya boleh isi OPD-nya sendiri
        if (!$isSuperadmin) {
            $userOrg = \App\Models\Organization::where('remote_id', (string)$user->unit_id)->first();
            if (!$userOrg || (int)$userOrg->id !== (int)$validated['organization_id']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda hanya dapat mengisi SAQ untuk OPD Anda sendiri.',
                ], 403);
            }
        }

        $indicator = SaqIndicator::findOrFail($validated['indicator_id']);
        if ($indicator->is_category) {
            return response()->json([
                'success' => false,
                'message' => 'Indikator tidak valid (kategori, bukan pertanyaan).',
            ], 422);
        }

        // Upload foto hanya berlaku untuk pertanyaan tipe foto, dan
        // wajib disertai judul (judul dipakai sebagai title Galeri).
        $hasFotoFile = $request->hasFile('foto');
        if ($hasFotoFile && ($indicator->input_type ?? 'dokumen') !== 'foto') {
            return response()->json([
                'success' => false,
                'message' => 'Upload foto hanya untuk pertanyaan bertipe foto.',
            ], 422);
        }
        if ($hasFotoFile && empty(trim($validated['judul_foto'] ?? ''))) {
            return response()->json([
                'success' => false,
                'message' => 'Judul foto wajib diisi bila mengunggah foto.',
            ], 422);
        }

        $links = array_values(array_filter(
            $validated['links'] ?? [],
            fn($l) => !empty($l['link'])
        ));

        if ($validated['jawaban'] === 'ya' && empty($links) && !$hasFotoFile) {
            return response()->json([
                'success' => false,
                'message' => 'Jawaban "Ya" wajib disertai minimal satu link dokumen.',
            ], 422);
        }

        $visibility = $validated['visibility'] ?? 'public';

        // Validasi awal mode sync: lookup semua baris sync SEBELUM ada tulisan,
        // supaya gagal sync tidak menyisakan jawaban/link/dokumen setengah jalan.
        if (($indicator->input_type ?? 'dokumen') === 'dokumen') {
            foreach ($links as $l) {
                if ((($l['mode'] ?? 'baru') === 'sync_ppid')
                    && !$this->lookupPpidDocument(trim($l['sync_url'] ?? $l['link']))) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Link detail PPID tidak ditemukan di data PPID. Pastikan link berupa https://ppid.sinjaikab.go.id/informasi/{slug} dari dokumen yang sudah ada di web PPID.',
                    ], 422);
                }
            }
        }

        // Transaksi: simpan jawaban, link, dokumen, dan Galeri harus
        // berhasil semua atau tidak sama sekali, supaya 500 di tengah jalan
        // tidak meninggalkan jawaban kosong (bug foto 2026-10-24).
        DB::beginTransaction();
        $storedFotoPath = null;
        try {
        $answer = SaqAnswer::updateOrCreate(
            [
                'organization_id' => $validated['organization_id'],
                'indicator_id' => $validated['indicator_id'],
            ],
            [
                'jawaban' => $validated['jawaban'],
                // Kolom lama dipertahankan untuk kompatibilitas (diisi link pertama,
                // atau judul foto bila hanya mengunggah foto tanpa link)
                'judul' => $links[0]['judul'] ?? ($hasFotoFile ? trim($validated['judul_foto'] ?? '') : ''),
                'link' => $links[0]['link'] ?? '',
                'created_by' => $request->user()->id,
            ]
        );
        if (\Schema::hasColumn('saq_answers', 'visibility')) {
            $answer->visibility = $visibility;
            $answer->save();
        }

        // Sinkronkan daftar link (ganti total)
        $answer->links()->delete();
        // Timpa dokumen: hapus dokumen lama dari SAQ answer ini via saq_answer_id (aman, presisi)
        // 1 pertanyaan = 1 dokumen, tidak duplikat
        \App\Models\Informasi::where('saq_answer_id', $answer->id)->delete();
        \App\Models\InformasiPemkab::where('saq_answer_id', $answer->id)->delete();
        $dokumenIds = [];
        if ($validated['jawaban'] === 'ya') {
            $org = Organization::find($validated['organization_id']);
            // Klasifikasi otomatis dari pertanyaan (tidak dipilih manual)
            $klasifikasi = $indicator->klasifikasi_otomatis ?? 'Informasi Berkala';

            foreach ($links as $i => $l) {
                // Mode hybrid: pakai dokumen PPID yang sudah ada.
                // Server lookup ulang dari URL detail PPID; bila tidak
                // ditemukan -> 422. Bila ditemukan, HANYA buat SaqAnswerLink
                // (tanpa Informasi/InformasiPemkab baru, untuk semua target
                // dan semua klasifikasi). Dokumen asli tidak pernah dihapus:
                // simpan ulang hanya menghapus dokumen SAQ (saq_answer_id).
                $isSync = ($indicator->input_type ?? 'dokumen') === 'dokumen'
                    && (($l['mode'] ?? 'baru') === 'sync_ppid');
                if ($isSync) {
                    $detailUrl = trim($l['sync_url'] ?? $l['link']);
                    $synced = $this->lookupPpidDocument($detailUrl);
                    if (!$synced) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'Link detail PPID tidak ditemukan di data PPID. Pastikan link berupa https://ppid.sinjaikab.go.id/informasi/{slug} dari dokumen yang sudah ada di web PPID.',
                        ], 422);
                    }
                    $syncLink = [
                        'judul' => $synced['judul'],
                        'link' => $detailUrl,
                        'deskripsi' => ($synced['kategori'] ? 'Kategori: ' . $synced['kategori'] . '. ' : '')
                            . 'Dokumen PPID yang sudah ada (sinkronisasi, bukan dokumen baru). Sumber: ' . $synced['sumber']
                            . ($synced['tanggal'] ? '. Tanggal: ' . $synced['tanggal'] : '')
                            . ($synced['file_url'] ? '. File: ' . $synced['file_url'] : ''),
                        'order' => $i,
                    ];
                    // Kolom jejak hanya bila migrasi sudah jalan (pengaman
                    // bila frontend ter-deploy sebelum migrate production).
                    if (\Schema::hasColumn('saq_answer_links', 'informasi_id')) {
                        $syncLink['informasi_id'] = $synced['id'];
                        $syncLink['sumber_informasi'] = $synced['sumber'];
                    }
                    $answer->links()->create($syncLink);
                    continue;
                }

                $answer->links()->create([
                    // Situs/foto tanpa judul: '' dari frontend diubah Laravel jadi null; kolom judul NOT NULL, pakai '' agar tidak 500.
                    'judul' => $l['judul'] ?? '',
                    'link' => $l['link'],
                    'deskripsi' => $l['deskripsi'] ?? '',
                    'order' => $i,
                ]);

                // Simpan sebagai dokumen HANYA untuk tipe 'dokumen'
                // Tipe 'situs'/'foto' hanya bukti URL, tidak jadi dokumen terkategori
                $isDokumen = ($indicator->input_type ?? 'dokumen') === 'dokumen';
                if ($isDokumen && $indicator->target_upload === 'pemkab') {
                    $dok = InformasiPemkab::create([
                        'saq_answer_id' => $answer->id,
                        'judul' => $l['judul'],
                        'kategori' => $klasifikasi,
                        'jenis_dokumen' => 'Dokumen SAQ',
                        'deskripsi' => $l['deskripsi'] ?? $indicator->pertanyaan,
                        'file_path' => $l['link'],
                        'status' => 'draft',
                        'visibility' => $visibility,
                        'unit_id' => $org->id,
                        'user_id' => $request->user()->id,
                    ]);
                } elseif ($isDokumen) {
                    $dok = Informasi::create([
                        'saq_answer_id' => $answer->id,
                        'title' => $l['judul'],
                        'content' => $l['deskripsi'] ?? $indicator->pertanyaan,
                        'category' => $klasifikasi,
                        'deskripsi' => $l['deskripsi'] ?? '',
                        'visibility' => $visibility,
                        'published' => false,
                        'url' => $l['link'],
                        'unit_id' => $org->remote_id ?? null,
                        'user_id' => $request->user()->id,
                        'tanggal_upload' => now(),
                    ]);
                }
                if ($isDokumen) $dokumenIds[] = $dok->id ?? null;
            }

            // Jalur upload foto: olah seperti Admin GaleriController
            // (Intervention Image -> WebP, turunkan kualitas sampai <2MB),
            // simpan ke storage public/galeri/, buat record Galeri yang
            // TAMPIL di galeri publik, dan satu SaqAnswerLink ke file itu.
            // category sengaja NULL supaya TIDAK ikut membuat Informasi
            // (logika auto-Informasi hanya ada di Admin GaleriController
            // dan hanya bila category + jenis_dokumen terisi).
            // Catatan: menyimpan ulang jawaban TIDAK menghapus record
            // Galeri lama (galeri bersifat publik, bukan dokumen per jawaban);
            // yang diganti total hanya daftar SaqAnswerLink-nya.
            $galeriId = null;
            if ($hasFotoFile) {
                ini_set('memory_limit', '512M');
                $image = $request->file('foto');
                $imageManager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                $quality = 80;
                $imageInstance = $imageManager->read($image->path())->toWebp($quality);
                $tmpPath = tempnam(sys_get_temp_dir(), 'saq_foto_') . '.webp';
                $imageInstance->save($tmpPath);
                while (filesize($tmpPath) > 2 * 1024 * 1024 && $quality > 20) {
                    $quality -= 10;
                    $imageInstance = $imageManager->read($image->path())->toWebp($quality);
                    $imageInstance->save($tmpPath);
                }
                $baseName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '_', $baseName) . '_' . time() . '.webp';
                $imagePathFinal = 'galeri/' . $fileName;
                Storage::disk('public')->put($imagePathFinal, file_get_contents($tmpPath));
                $storedFotoPath = $imagePathFinal;
                unlink($tmpPath);

                $galeri = Galeri::create([
                    'title' => trim($validated['judul_foto']),
                    'description' => $indicator->pertanyaan,
                    'image' => $imagePathFinal,
                    'type' => 'foto',
                    'category' => null,
                    'tanggal_upload' => $validated['tanggal_upload'] ?? now()->toDateString(),
                    'saq_answer_id' => $answer->id,
                    'user_id' => $request->user()->id,
                ]);
                $galeriId = $galeri->id;
                $photoUrl = $request->getSchemeAndHttpHost() . '/storage/' . $imagePathFinal;
                $answer->links()->create([
                    'judul' => trim($validated['judul_foto']),
                    'link' => $photoUrl,
                    'deskripsi' => '',
                    'order' => count($links),
                ]);
                if (empty($links)) {
                    $answer->link = $photoUrl;
                    $answer->save();
                }
            }
        }
        DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            if (!empty($storedFotoPath)) {
                Storage::disk('public')->delete($storedFotoPath);
            }
            \Log::error('SAQ store gagal, transaksi dibatalkan', ['error' => $e->getMessage(), 'organization_id' => $validated['organization_id'], 'indicator_id' => $validated['indicator_id']]);
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan jawaban SAQ.'], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Jawaban SAQ tersimpan.',
            'data' => $answer->load(['indicator:id,kode,pertanyaan', 'links']),
            'dokumen_ids' => $dokumenIds,
            'galeri_id' => $galeriId ?? null,
        ]);
    }

    /**
     * Hapus jawaban SAQ (admin login).
     * DELETE /api/v1/saq/answers/{id} (auth:sanctum)
     */
    public function destroy(Request $request, $id)
    {
        $answer = SaqAnswer::findOrFail($id);

        // Otorisasi: hanya superadmin atau admin OPD pemilik yang boleh hapus
        $user = $request->user();
        $isSuperadmin = ($user->role === 'superadmin');
        if (!$isSuperadmin) {
            $userOrg = \App\Models\Organization::where('remote_id', (string)$user->unit_id)->first();
            if (!$userOrg || (int)$userOrg->id !== (int)$answer->organization_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda hanya dapat menghapus jawaban OPD Anda sendiri.',
                ], 403);
            }
        }

        // Hapus juga dokumen terkait via saq_answer_id
        \App\Models\Informasi::where('saq_answer_id', $answer->id)->delete();
        \App\Models\InformasiPemkab::where('saq_answer_id', $answer->id)->delete();
        $answer->links()->delete();
        $answer->delete();

        return response()->json(['success' => true, 'message' => 'Jawaban dihapus.']);
    }

    /**
     * Auto-sync: cek apakah sebuah link sudah ada di data PPID.
     * Bila ada -> kembalikan judul/deskripsi/pengupload/tanggal untuk auto-fill form.
     * GET /api/v1/saq/sync?url= (auth:sanctum)
     */
    public function sync(Request $request)
    {
        $request->validate(['url' => 'required|string']);

        $url = trim($request->url);
        $found = $this->lookupPpidDocument($url);
        if ($found) {
            return response()->json([
                'success' => true,
                'found' => true,
                'data' => $found,
            ]);
        }

        // Pesan jelas bila URL-nya link detail PPID tapi slug tidak ada.
        if ($this->parsePpidDetailSlug($url) !== null) {
            return response()->json([
                'success' => true,
                'found' => false,
                'message' => 'Link detail PPID tidak ditemukan: tidak ada dokumen dengan slug tersebut di data PPID.',
            ]);
        }

        return response()->json([
            'success' => true,
            'found' => false,
            'message' => 'Link belum ada di data PPID. Untuk mode sinkronisasi, gunakan link detail PPID (https://ppid.sinjaikab.go.id/informasi/{slug}).',
        ]);
    }

    /**
     * Parse link detail PPID -> slug, atau null bila bukan link detail PPID.
     * Host yang diterima hanya ppid.sinjaikab.go.id (dengan/without www).
     */
    private function parsePpidDetailSlug(string $url): ?string
    {
        $parts = parse_url(trim($url));
        if (!$parts || empty($parts['host'])) {
            return null;
        }
        $host = strtolower($parts['host']);
        if (!in_array($host, ['ppid.sinjaikab.go.id', 'www.ppid.sinjaikab.go.id'], true)) {
            return null;
        }
        $path = trim($parts['path'] ?? '', '/');
        $segments = explode('/', $path);
        if (count($segments) < 2 || $segments[0] !== 'informasi' || $segments[1] === '') {
            return null;
        }
        return urldecode($segments[1]);
    }

    private function ppidDateStr($value): ?string
    {
        if (!$value) {
            return null;
        }
        return substr((string) $value, 0, 10);
    }

    private function ppidFileUrl($file): ?string
    {
        if (!$file) {
            return null;
        }
        if (str_starts_with($file, 'http://') || str_starts_with($file, 'https://')) {
            return $file;
        }
        return url('storage/' . $file);
    }

    /**
     * Cari dokumen PPID dari sebuah URL.
     * Urutan: (1) link detail PPID /informasi/{slug} -> Informasi by slug/id,
     * lalu InformasiPemkab by slug/id; (2) pencocokan lama (Informasi.url/file,
     * InformasiPemkab.file_path like basename) untuk kompatibilitas.
     * Mengembalikan null bila tidak ditemukan.
     */
    private function lookupPpidDocument(string $url): ?array
    {
        $url = trim($url);
        $slug = $this->parsePpidDetailSlug($url);
        if ($slug !== null) {
            $detailUrl = 'https://ppid.sinjaikab.go.id/informasi/' . $slug;
            $info = Informasi::with(['user:id,name', 'organization:id,name'])
                ->where(function ($q) use ($slug) {
                    $q->where('slug', $slug);
                    if (ctype_digit($slug)) {
                        $q->orWhere('id', (int) $slug);
                    }
                })
                ->first();
            if ($info) {
                return [
                    'id' => $info->id,
                    'judul' => $info->title,
                    'deskripsi' => $info->deskripsi ?? $info->content,
                    'kategori' => $info->category,
                    'pengupload' => $info->user->name ?? null,
                    'opd' => $info->organization->name ?? null,
                    'tanggal' => $this->ppidDateStr($info->tanggal_upload ?? $info->created_at),
                    'file_url' => $this->ppidFileUrl($info->file),
                    'detail_url' => $detailUrl,
                    'sumber' => 'informasi',
                ];
            }
            $pemkab = InformasiPemkab::with(['user:id,name', 'organization:id,name'])
                ->where(function ($q) use ($slug) {
                    $q->where('slug', $slug);
                    if (ctype_digit($slug)) {
                        $q->orWhere('id', (int) $slug);
                    }
                })
                ->first();
            if ($pemkab) {
                return [
                    'id' => $pemkab->id,
                    'judul' => $pemkab->judul,
                    'deskripsi' => $pemkab->deskripsi,
                    'kategori' => $pemkab->kategori,
                    'jenis_dokumen' => $pemkab->jenis_dokumen,
                    'pengupload' => $pemkab->user->name ?? null,
                    'opd' => $pemkab->organization->name ?? null,
                    'tanggal' => $this->ppidDateStr($pemkab->published_at ?? $pemkab->created_at),
                    'file_url' => $this->ppidFileUrl($pemkab->file_path),
                    'detail_url' => $detailUrl,
                    'sumber' => 'informasi_pemkab',
                ];
            }
            return null;
        }

        // Pencocokan lama (kompatibilitas tombol sync lama).
        $info = Informasi::with(['user:id,name', 'organization:id,name'])
            ->where('url', $url)
            ->orWhere('file', $url)
            ->first();
        if ($info) {
            return [
                'id' => $info->id,
                'judul' => $info->title,
                'deskripsi' => $info->deskripsi ?? $info->content,
                'kategori' => $info->category,
                'pengupload' => $info->user->name ?? null,
                'opd' => $info->organization->name ?? null,
                'tanggal' => $this->ppidDateStr($info->tanggal_upload ?? $info->created_at),
                'file_url' => $this->ppidFileUrl($info->file),
                'detail_url' => $url,
                'sumber' => 'informasi',
            ];
        }

        $pemkab = InformasiPemkab::with(['user:id,name', 'organization:id,name'])
            ->where('file_path', 'like', '%' . basename($url) . '%')
            ->first();
        if ($pemkab) {
            return [
                'id' => $pemkab->id,
                'judul' => $pemkab->judul,
                'deskripsi' => $pemkab->deskripsi,
                'kategori' => $pemkab->kategori,
                'jenis_dokumen' => $pemkab->jenis_dokumen,
                'pengupload' => $pemkab->user->name ?? null,
                'opd' => $pemkab->organization->name ?? null,
                'tanggal' => $this->ppidDateStr($pemkab->published_at ?? $pemkab->created_at),
                'file_url' => $this->ppidFileUrl($pemkab->file_path),
                'detail_url' => $url,
                'sumber' => 'informasi_pemkab',
            ];
        }

        return null;
    }
}
