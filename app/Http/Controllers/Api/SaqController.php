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

        $data = $opds->map(function ($opd) {
            // Total pertanyaan sesuai scope OPD ini (dari mapping indicator_opd)
            $totalQuestions = DB::table('indicator_opd')
                ->where('organization_id', $opd->id)->count();
            // Terisi = sudah ada jawaban Ya/Tidak
            $answered = SaqAnswer::where('organization_id', $opd->id)
                ->whereNotNull('jawaban')->count();
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
                $answer->links()->create([
                    'judul' => $l['judul'],
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

        $info = Informasi::with(['user:id,name', 'organization:id,name'])
            ->where('url', $url)
            ->orWhere('file', $url)
            ->first();

        if ($info) {
            return response()->json([
                'success' => true,
                'found' => true,
                'data' => [
                    'judul' => $info->title,
                    'deskripsi' => $info->deskripsi ?? $info->content,
                    'kategori' => $info->category,
                    'pengupload' => $info->user->name ?? null,
                    'opd' => $info->organization->name ?? null,
                    'tanggal' => $info->tanggal_upload ?? $info->created_at,
                    'sumber' => 'informasi',
                ],
            ]);
        }

        $pemkab = InformasiPemkab::with(['user:id,name', 'organization:id,name'])
            ->where('file_path', 'like', '%' . basename($url) . '%')
            ->first();

        if ($pemkab) {
            return response()->json([
                'success' => true,
                'found' => true,
                'data' => [
                    'judul' => $pemkab->judul,
                    'deskripsi' => $pemkab->deskripsi,
                    'kategori' => $pemkab->kategori,
                    'jenis_dokumen' => $pemkab->jenis_dokumen,
                    'pengupload' => $pemkab->user->name ?? null,
                    'opd' => $pemkab->organization->name ?? null,
                    'tanggal' => $pemkab->published_at ?? $pemkab->created_at,
                    'sumber' => 'informasi_pemkab',
                ],
            ]);
        }

        return response()->json(['success' => true, 'found' => false]);
    }
}
