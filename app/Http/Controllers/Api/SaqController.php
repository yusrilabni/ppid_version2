<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Models\InformasiPemkab;
use App\Models\Galeri;
use App\Models\Official;
use App\Models\Organization;
use App\Models\Lhkpn;
use App\Models\SaqAnswer;
use App\Models\SaqIndicator;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SaqController extends Controller
{
    /**
     * Cek status penguncian pengisian jawaban SAQ.
     * Default adalah '1' (terkunci) jika belum ada di database.
     */
    public static function isLocked(): bool
    {
        $val = Setting::where('key', 'saq_submissions_locked')->value('value');
        if ($val === null) {
            return true;
        }
        return in_array((string)$val, ['1', 'true'], true);
    }

    /**
     * Endpoint status penguncian SAQ publik.
     * GET /api/v1/saq/lock-status
     */
    public function lockStatus()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'locked' => self::isLocked(),
            ]
        ]);
    }
    /**
     * Daftar OPD untuk SAQ: unit tanpa kecamatan/desa/kelurahan,
     * beserta profil pimpinan & progres pengisian.
     * GET /api/v1/saq/opds
     */
    public function opds(Request $request)
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

        $data = $opds->map(function ($opd) use ($saqTabs, $request) {
            // Kartu Kabupaten di /saq harus memakai progres konsolidasi full,
            // bukan progres OPD 127 sendiri (19): total semua soal, terisi soal
            // yang sudah dijawab minimal satu OPD (filter privasi sama seperti
            // structure full / allAnswers, supaya angkanya sama dengan halaman detail).
            if ($opd->slug === 'kabupaten-sinjai') {
                $fullTotal = 0;
                foreach ($saqTabs as $tab) {
                    foreach ($tab->children as $sec) {
                        foreach ($sec->children as $child) {
                            if ($child->is_category) {
                                foreach ($child->children as $qu) {
                                    if (!$qu->is_category) $fullTotal++;
                                }
                            } else {
                                $fullTotal++;
                            }
                        }
                    }
                }
                $fullQuery = SaqAnswer::whereNotNull('jawaban');
                $fullUser = $request->user();
                $fullSuper = $fullUser && $fullUser->role === 'superadmin';
                if (!$fullSuper) {
                    $fullUserOrgId = null;
                    if ($fullUser) {
                        $fullUserOrg = \App\Models\Organization::where('remote_id', (string)$fullUser->unit_id)->first();
                        $fullUserOrgId = $fullUserOrg ? $fullUserOrg->id : null;
                    }
                    $fullQuery->where(function($q) use ($fullUserOrgId) {
                        $q->where('visibility', 'public')
                          ->orWhere(function($qq) use ($fullUserOrgId) {
                              $qq->where('visibility', 'private')
                                 ->where('organization_id', $fullUserOrgId ?: -1);
                          });
                    });
                }
                $fullAnswered = $fullQuery->distinct()->count('indicator_id');
                return [
                    'id' => $opd->id,
                    'name' => $opd->name,
                    'slug' => $opd->slug,
                    'is_ppid_utama' => true,
                    'pimpinan' => $opd->officials->map(fn($o) => [
                        'nama' => $o->full_name,
                        'jabatan' => $o->position->name ?? null,
                        'foto' => $o->photo,
                    ])->values(),
                    'progres' => [
                        'terisi' => $fullAnswered,
                        'total' => $fullTotal,
                        'persen' => $fullTotal > 0 ? round($fullAnswered / $fullTotal * 100) : 0,
                    ],
                ];
            }
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
                'remote_id' => (string)($opd->remote_id ?? ''),
                'unit_id' => (string)($opd->unit_id ?? $opd->remote_id ?? ''),
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
        $alasanMap = [];
        $answerIdMap = [];
        // Mode full: terisi = soal yang punya minimal satu jawaban OPD yang lolos privasi.
        // jawabanMap sengaja kosong: badge Ya/Tidak tunggal tidak berlaku untuk konsolidasi.
        if ($request->boolean('full')) {
            $fullQuery = SaqAnswer::whereNotNull('jawaban');
            $fullUser = $request->user();
            $fullSuper = $fullUser && $fullUser->role === 'superadmin';
            if (!$fullSuper) {
                $fullUserOrgId = null;
                if ($fullUser) {
                    $fullUserOrg = \App\Models\Organization::where('remote_id', (string)$fullUser->unit_id)->first();
                    $fullUserOrgId = $fullUserOrg ? $fullUserOrg->id : null;
                }
                $fullQuery->where(function($q) use ($fullUserOrgId) {
                    $q->where('visibility', 'public')
                      ->orWhere(function($qq) use ($fullUserOrgId) {
                          $qq->where('visibility', 'private')
                             ->where('organization_id', $fullUserOrgId ?: -1);
                      });
                });
            }
            $answeredIds = $fullQuery->distinct()->pluck('indicator_id')->toArray();
            $kabAnswers = SaqAnswer::where('organization_id', 127)->get(['id', 'indicator_id']);
            $answerIdMap = $kabAnswers->pluck('id', 'indicator_id')->toArray();
        }
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
            $cols = ['id', 'indicator_id', 'jawaban', 'judul'];
            if (\Schema::hasColumn('saq_answers', 'alasan')) {
                $cols[] = 'alasan';
            }
            $rows = $rowsQuery->get($cols);
            $answeredIds = $rows->pluck('indicator_id')->toArray();
            $jawabanMap = $rows->pluck('jawaban', 'indicator_id')->toArray();
            $answerIdMap = $rows->pluck('id', 'indicator_id')->toArray();
            foreach ($rows as $r) {
                $alasanMap[$r->indicator_id] = $r->alasan;
            }
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
        $buildQuestion = function($qu) use ($orgId, $mappedIds, $bagianMap, $answeredIds, $jawabanMap, $alasanMap, $answerIdMap) {
            return [
                'id' => $qu->id,
                'answer_id' => $answerIdMap[$qu->id] ?? null,
                'kode' => $qu->kode,
                'tab' => $qu->tab,
                'pertanyaan' => $qu->pertanyaan,
                'bagian' => $bagianMap[$qu->id] ?? null,
                'dokumen_upload' => $qu->dokumen_upload,
                'input_type' => $qu->input_type ?? 'dokumen',
                'klasifikasi_otomatis' => $qu->klasifikasi_otomatis,
                'target_upload' => $qu->target_upload ?? 'ppid',
                'terisi' => in_array($qu->id, $answeredIds),
                'jawaban' => $jawabanMap[$qu->id] ?? null,
                'alasan' => $alasanMap[$qu->id] ?? null,
                'order' => (int)($qu->order ?? 0),
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
                                'order' => (int)($child->order ?? 0),
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

                // Gabungkan questions dan groups ke satu alur berurutan berdasarkan kolom order
                $allItems = array_merge(
                    array_map(fn($q) => array_merge($q, ['type' => 'question']), $questions),
                    array_map(fn($g) => array_merge($g, ['type' => 'group']), $groups)
                );
                usort($allItems, fn($a, $b) => ($a['order'] ?? 0) <=> ($b['order'] ?? 0));

                $sections[] = [
                    'kode' => $sec->kode,
                    'section' => $sec->section,
                    'items' => $allItems,
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

        $user = $request->user();
        $canEdit = false;
        if ($user) {
            if ($user->role === 'superadmin' || $user->admin_kabupaten == 1) {
                $canEdit = true;
            } else if (!self::isLocked()) {
                // Semua admin OPD diizinkan mengisi SAQ di Kabupaten Sinjai (id 127)
                if ((int)$orgId === 127) {
                    $canEdit = true;
                } else {
                    $uUnit = (string)($user->unit_id ?? '');
                    if (!$uUnit && $user->nip) {
                        $apiData = \App\Models\User::getDataFromApi($user->nip);
                        $uUnit = (string)($apiData['unit_id'] ?? '');
                    }
                    $userOrg = \App\Models\Organization::where('remote_id', $uUnit)
                        ->orWhere('unit_id', $uUnit)
                        ->orWhere('id', $uUnit)
                        ->first();
                    if ($userOrg && (int)$userOrg->id === (int)$orgId) {
                        $canEdit = true;
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'can_edit' => $canEdit,
            'locked' => self::isLocked(),
        ]);
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
     * Konsolidasi jawaban semua OPD per indikator, untuk halaman Kabupaten full.
     * GET /api/v1/saq/all-answers (publik, optional.sanctum; privasi sama seperti answers()).
     */
    public function allAnswers(Request $request)
    {
        $query = SaqAnswer::whereNotNull('jawaban')
            ->with(['organization:id,name', 'creator:id,name', 'links']);
        $user = $request->user();
        $isSuperadmin = $user && $user->role === 'superadmin';
        if (!$isSuperadmin) {
            $userOrgId = null;
            if ($user) {
                $userOrg = \App\Models\Organization::where('remote_id', (string)$user->unit_id)->first();
                $userOrgId = $userOrg ? $userOrg->id : null;
            }
            $query->where(function($q) use ($userOrgId) {
                $q->where('visibility', 'public')
                  ->orWhere(function($qq) use ($userOrgId) {
                      $qq->where('visibility', 'private')
                         ->where('organization_id', $userOrgId ?: -1);
                  });
            });
        }
        $answers = $query->orderBy('organization_id')->orderBy('id')->get();
        $data = [];
        foreach ($answers as $a) {
            $data[$a->indicator_id][] = [
                'id' => $a->id,
                'opd_name' => $a->organization->name ?? null,
                'penulis' => $a->creator->name ?? null,
                'jawaban' => $a->jawaban,
                'alasan' => $a->alasan,
                'links' => $a->links->map(fn($l) => [
                    'id' => $l->id,
                    'judul' => $l->judul,
                    'link' => $l->link,
                    'sumber_informasi' => $l->sumber_informasi ?? null,
                    'deskripsi' => $l->deskripsi ?? null,
                ])->values(),
            ];
        }
        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * Download file bukti dukung SAQ dengan nama file deskriptif
     * (mengandung kode soal dan nama OPD).
     * GET /api/v1/saq/download-evidence
     */
    public function downloadEvidence(Request $request)
    {
        $rawUrl = (string)$request->get('url', '');
        $requestedName = (string)$request->get('filename', '');

        if (empty($rawUrl)) {
            abort(404, 'URL berkas tidak ditemukan.');
        }

        // Jika URL adalah link detail dokumen PPID atau Portal Pemkab Sinjai,
        // lookup dokumen untuk mendapatkan tautan file berkas aslinya.
        if (str_contains($rawUrl, 'sinjaikab.go.id') && str_contains($rawUrl, '/informasi')) {
            $doc = $this->lookupPpidDocument($rawUrl);
            if ($doc && !empty($doc['file_url'])) {
                $rawUrl = $doc['file_url'];
            }
        }

        // Cek jika link Google Drive / Docs / Sheets -> redirect langsung ke URL download
        if (str_contains($rawUrl, 'drive.google.com/file/d/')) {
            if (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/', $rawUrl, $matches)) {
                return redirect()->away('https://drive.google.com/uc?export=download&id=' . $matches[1]);
            }
        } elseif (str_contains($rawUrl, 'drive.google.com/open?id=') || str_contains($rawUrl, 'drive.google.com/uc?')) {
            if (preg_match('/[?&]id=([a-zA-Z0-9_-]+)/', $rawUrl, $matches)) {
                return redirect()->away('https://drive.google.com/uc?export=download&id=' . $matches[1]);
            }
        } elseif (str_contains($rawUrl, 'docs.google.com/document/d/')) {
            if (preg_match('/docs\.google\.com\/document\/d\/([a-zA-Z0-9_-]+)/', $rawUrl, $matches)) {
                return redirect()->away('https://docs.google.com/document/d/' . $matches[1] . '/export?format=pdf');
            }
        } elseif (str_contains($rawUrl, 'docs.google.com/spreadsheets/d/')) {
            if (preg_match('/docs\.google\.com\/spreadsheets\/d\/([a-zA-Z0-9_-]+)/', $rawUrl, $matches)) {
                return redirect()->away('https://docs.google.com/spreadsheets/d/' . $matches[1] . '/export?format=xlsx');
            }
        } elseif (str_contains($rawUrl, 'docs.google.com/presentation/d/')) {
            if (preg_match('/docs\.google\.com\/presentation\/d\/([a-zA-Z0-9_-]+)/', $rawUrl, $matches)) {
                return redirect()->away('https://docs.google.com/presentation/d/' . $matches[1] . '/export?format=pdf');
            }
        }

        // Ekstrak path storage relatif dari URL
        $storagePath = null;
        if (str_contains($rawUrl, '/storage/')) {
            $storagePath = substr($rawUrl, strpos($rawUrl, '/storage/') + strlen('/storage/'));
        } elseif (!str_starts_with($rawUrl, 'http://') && !str_starts_with($rawUrl, 'https://')) {
            $storagePath = ltrim($rawUrl, '/');
        }

        // Sanitasi path untuk mencegah directory traversal
        if (!$storagePath || str_contains($storagePath, '..') || str_starts_with($storagePath, '/') || str_starts_with($storagePath, '\\')) {
            return redirect()->away($rawUrl);
        }

        // Cek keberadaan file di storage disk public
        if (!Storage::disk('public')->exists($storagePath)) {
            return redirect()->away($rawUrl);
        }

        // Tentukan nama file unduhan yang bersih (izinkan tanda kurung siku, kurung biasa, strip, titik)
        $ext = strtolower(pathinfo($storagePath, PATHINFO_EXTENSION));
        if (!empty($requestedName)) {
            $safeName = preg_replace('/[^\w\s\.\-\(\)\[\]]/u', '_', $requestedName);
            $safeName = preg_replace('/\s+/', '_', trim($safeName));
            $safeName = preg_replace('/_+/', '_', $safeName);
            if (!empty($ext) && !str_ends_with(strtolower($safeName), '.' . $ext)) {
                $safeName .= '.' . $ext;
            }
        } else {
            $safeName = 'Bukti_Dukung_SAQ_' . basename($storagePath);
        }

        return Storage::disk('public')->download($storagePath, $safeName);
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
            'alasan' => 'nullable|string',
            'visibility' => 'nullable|in:public,private',
            'links' => 'nullable|array|max:20',
            'links.*.judul' => 'nullable|string|max:255',
            'links.*.link' => 'required_with:links|string|max:2000',
            'links.*.deskripsi' => 'nullable|string',
            'links.*.mode' => 'nullable|in:baru,sync_ppid,link,drive,lampiran,galeri',
            'links.*.sync_url' => 'nullable|string|max:2000',
            // Jalur upload dokumen SAQ (2 tab): file lampiran, boleh >1 file.
            // Validasi file terpisah dari links agar FormData multipart lolos.
            'dokumen_files' => 'nullable|array|max:20',
            'dokumen_files.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:2048',
            'dokumen_judul' => 'nullable|array|max:20',
            'dokumen_judul.*' => 'nullable|string|max:255',
            'dokumen_deskripsi' => 'nullable|array|max:20',
            'dokumen_deskripsi.*' => 'nullable|string',
            'dokumen_jadikan' => 'nullable|array|max:20',
            'dokumen_jadikan.*' => 'nullable|in:0,1,true,false',
            'upload_destination' => 'nullable|string|in:storage,informasi,galeri',
            'kategori' => 'nullable|string|max:255',
            'target_upload' => 'nullable|in:ppid,pemkab',
            'kata_kunci' => 'nullable|string|max:255',
            'doc_content' => 'nullable|string',
            'jenis_dokumen' => 'nullable|string|max:255',
            // Jalur upload foto SAQ (hanya untuk pertanyaan tipe foto atau pilihan ke galeri)
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'judul_foto' => 'nullable|string|max:255',
            'tanggal_upload' => 'nullable|date',
            'tanggal_dokumen' => 'nullable|date',
        ]);

        // Validasi: jika jawaban Tidak Ada, alasan wajib diisi
        if ($validated['jawaban'] === 'tidak') {
            $alasanVal = trim((string)($request->input('alasan') ?? ''));
            if ($alasanVal === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Alasan wajib diisi jika memilih "Tidak Ada".',
                ], 422);
            }
        }

        // Validasi: parent-group (is_category=1) tidak bisa diisi jawaban
        $indicator = SaqIndicator::find($validated['indicator_id']);
        if ($indicator && $indicator->is_category) {
            return response()->json([
                'success' => false,
                'message' => 'Pertanyaan induk (header) tidak dapat diisi jawaban.',
            ], 422);
        }

        // Otorisasi: superadmin, admin kabupaten, atau admin OPD pemilik yang boleh isi
        $user = $request->user();
        $isSuperadmin = ($user && ($user->role === 'superadmin' || !empty($user->admin_kabupaten)));

        // Cek penguncian pengisian SAQ: jika terkunci, hanya superadmin yang diizinkan mengisi
        if (self::isLocked() && !$isSuperadmin) {
            return response()->json([
                'success' => false,
                'message' => 'Pengisian dan perubahan jawaban SAQ saat ini sedang dikunci oleh Superadmin. Hanya Superadmin yang dapat mengisi jawaban.',
            ], 403);
        }

        // Admin OPD dan Superadmin diizinkan mengisi SAQ Kabupaten Sinjai (id 127)
        $isKabupaten = ((int)$validated['organization_id'] === 127);

        // Jika bukan superadmin dan bukan pengisian untuk Kabupaten Sinjai, pastikan OPD milik user sendiri
        if (!$isSuperadmin && !$isKabupaten) {
            $uUnit = trim((string)($user->unit_id ?? ''));
            if ($uUnit === '' && !empty($user->nip)) {
                try {
                    $apiData = \App\Models\User::getDataFromApi($user->nip);
                    $uUnit = trim((string)($apiData['unit_id'] ?? ''));
                } catch (\Exception $e) {}
            }
            $reqOrgId = (int)$validated['organization_id'];
            $targetOrg = \App\Models\Organization::find($reqOrgId);

            $userOrg = null;
            if ($uUnit !== '') {
                $userOrg = \App\Models\Organization::where('remote_id', $uUnit)
                    ->orWhere('unit_id', $uUnit)
                    ->orWhere('id', $uUnit)
                    ->first();
            }
            if (!$userOrg && !empty($user->name)) {
                $userOrg = \App\Models\Organization::where('name', 'like', "%{$user->name}%")->first();
            }

            $isMatch = ($userOrg && (int)$userOrg->id === $reqOrgId);
            if (!$isMatch && $targetOrg) {
                if ($uUnit !== '') {
                    $targetUnits = array_filter([
                        (string)$targetOrg->id,
                        (string)($targetOrg->remote_id ?? ''),
                        (string)($targetOrg->unit_id ?? '')
                    ]);
                    if (in_array($uUnit, $targetUnits, true)) {
                        $isMatch = true;
                    }
                }
                if (!$isMatch && !empty($user->name)) {
                    if (stripos($targetOrg->name, $user->name) !== false || stripos($user->name, $targetOrg->name) !== false) {
                        $isMatch = true;
                    }
                }
            }

            if (!$isMatch) {
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

        // Upload foto berlaku untuk pertanyaan tipe foto atau bila memilih tujuan galeri
        $hasFotoFile = $request->hasFile('foto');
        if ($hasFotoFile && ($indicator->input_type ?? 'dokumen') !== 'foto' && $request->input('upload_destination') !== 'galeri') {
            return response()->json([
                'success' => false,
                'message' => 'Upload foto hanya untuk pertanyaan bertipe foto atau pilihan masuk ke galeri.',
            ], 422);
        }
        if ($hasFotoFile && empty(trim($validated['judul_foto'] ?? ''))) {
            $validated['judul_foto'] = $indicator->pertanyaan ?: 'Dokumentasi SAQ';
        }

        $links = array_values(array_filter(
            $validated['links'] ?? [],
            fn($l) => !empty($l['link'])
        ));

        // Khusus Digitalisasi: larang link Google Drive (harus link website/portal/aplikasi)
        $isDigitalisasi = ($indicator->tab === 'Digitalisasi' || str_starts_with($indicator->kode ?? '', '2.'));
        if ($isDigitalisasi && $validated['jawaban'] === 'ya') {
            foreach ($links as $l) {
                $host = parse_url($l['link'] ?? '', PHP_URL_HOST);
                if ($host && in_array(strtolower($host), ['drive.google.com', 'docs.google.com'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Link Google Drive tidak diterima untuk indikator Digitalisasi. Harap masukkan link website/portal/aplikasi langsung.',
                    ], 422);
                }
            }
        }

        // File dokumen upload: array paralel judul/deskripsi/jadikan.
        $dokumenFiles = $request->file('dokumen_files') ?: [];
        if (!is_array($dokumenFiles)) $dokumenFiles = [$dokumenFiles];
        $dokumenFiles = array_values(array_filter($dokumenFiles));
        $dokumenJudul = $request->input('dokumen_judul', []);
        $dokumenDeskripsi = $request->input('dokumen_deskripsi', []);
        $dokumenJadikan = $request->input('dokumen_jadikan', []);
        $hasDokumenFile = !empty($dokumenFiles);
        if ($validated['jawaban'] === 'ya' && empty($links) && !$hasFotoFile && !$hasDokumenFile) {
            return response()->json([
                'success' => false,
                'message' => 'Jawaban "Ya" wajib disertai minimal satu dokumen upload, satu link, atau satu foto upload.',
            ], 422);
        }
        if ($hasDokumenFile) {
            foreach ($dokumenFiles as $di => $df) {
                $dj = trim((string)($dokumenJudul[$di] ?? ''));
                if ($dj === '') {
                    $dokumenJudul[$di] = $indicator->pertanyaan ?: pathinfo($df->getClientOriginalName(), PATHINFO_FILENAME);
                }
            }
        }

        // Validasi mode drive / lampiran / baru SEBELUM ada tulisan (Blueprint v2 bagian 8).
        foreach ($links as $l) {
            $lm = $l['mode'] ?? 'baru';
            $ll = trim((string)($l['link'] ?? ''));
            if ($lm === 'drive') {
                $host = strtolower((string)(parse_url($ll, PHP_URL_HOST) ?? ''));
                if (!in_array($host, ['drive.google.com', 'www.drive.google.com', 'docs.google.com', 'www.docs.google.com'], true)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Link Drive harus berupa link Google Drive (drive.google.com / docs.google.com). Domain lain ditolak di sub-mode Drive.',
                    ], 422);
                }
            }
            if ($lm === 'lampiran' && !str_contains($ll, '/storage/saq/')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lampiran tersimpan tidak valid.',
                ], 422);
            }
            if ($lm === 'baru' && trim((string)($l['judul'] ?? '')) === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Judul wajib diisi untuk bukti yang dijadikan Informasi.',
                ], 422);
            }
        }

        // Privasi (koreksi 09:04): visibility HANYA berlaku bila ada bukti
        // yang dijadikan Informasi. Link/lampiran saja -> paksa public di
        // level jawaban, dan visibility tidak dipakai untuk Informasi (karena
        // tidak ada Informasi yang dibuat). Perhitungan hasInformasi di bawah
        // memakai mode link + toggle upload, bukan nilai visibility itu sendiri.
        $isDokumenType = ($indicator->input_type ?? 'dokumen') === 'dokumen';
        $hasInformasiEvidence = false;
        if ($isDokumenType) {
            foreach ($links as $l) {
                if (($l['mode'] ?? 'baru') === 'baru') { $hasInformasiEvidence = true; break; }
            }
            if (!$hasInformasiEvidence) {
                foreach ($dokumenFiles as $di => $df) {
                    $jv = $dokumenJadikan[$di] ?? '0';
                    if (in_array($jv, ['1', 1, true, 'true'], true)) { $hasInformasiEvidence = true; break; }
                }
            }
        }
        $visibility = $hasInformasiEvidence ? ($validated['visibility'] ?? 'public') : 'public';

        // Validasi awal mode sync: lookup semua baris sync SEBELUM ada tulisan,
        // supaya gagal sync tidak menyisakan jawaban/link/dokumen setengah jalan.
        if (true) {
            foreach ($links as $l) {
                if ((($l['mode'] ?? 'baru') === 'sync_ppid')
                    && !$this->lookupAnyPortalDocument(trim($l['sync_url'] ?? $l['link']))) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Link dokumen atau halaman resmi tidak ditemukan di database. Pastikan link berasal dari website resmi PPID atau Pemkab Sinjai.',
                    ], 422);
                }
            }
        }

        // Transaksi: simpan jawaban, link, dokumen, dan Galeri harus
        // berhasil semua atau tidak sama sekali, supaya 500 di tengah jalan
        // tidak meninggalkan jawaban kosong (bug foto 2026-10-24).
        DB::beginTransaction();
        $storedFotoPath = null;
        $storedDokumenPaths = [];
        // Lampiran lama (storage saq/) yang akan diganti: kumpulkan dulu,
        // dihapus SETELAH commit supaya rollback tidak kehilangan file.
        $oldLampiranPaths = [];
        $preAnswer = SaqAnswer::where('organization_id', $validated['organization_id'])
            ->where('indicator_id', $validated['indicator_id'])->first();
        if ($preAnswer) {
            foreach ($preAnswer->links as $ol) {
                $olink = (string)($ol->link ?? '');
                if (str_contains($olink, '/storage/saq/')) {
                    $pos = strpos($olink, '/storage/');
                    if ($pos !== false) $oldLampiranPaths[] = substr($olink, $pos + strlen('/storage/'));
                }
            }
            $oldLampiranPaths = array_values(array_unique(array_filter($oldLampiranPaths)));
        }
        // Lampiran storage yang dipertahankan di pengiriman baru (round-trip v2):
        // file tersimpan yang tidak dihapus di UI dikirim lagi mode lampiran/baru
        // dengan URL storage yang sama, jadi file itu JANGAN dihapus setelah commit.
        $keptLampiranPaths = [];
        foreach ($links as $l) {
            $kl = (string)($l['link'] ?? '');
            if (str_contains($kl, '/storage/saq/')) {
                $pos = strpos($kl, '/storage/');
                if ($pos !== false) $keptLampiranPaths[] = substr($kl, $pos + strlen('/storage/'));
            }
        }
        $keptLampiranPaths = array_values(array_unique(array_filter($keptLampiranPaths)));
        try {
        $answer = SaqAnswer::updateOrCreate(
            [
                'organization_id' => $validated['organization_id'],
                'indicator_id' => $validated['indicator_id'],
            ],
            [
                'jawaban' => $validated['jawaban'],
                // Kolom lama dipertahankan untuk kompatibilitas (diisi link pertama,
                // atau judul foto bila hanya mengunggah foto tanpa link, atau alasan jika tidak ada)
                'judul' => $validated['jawaban'] === 'tidak'
                    ? ('Tidak Ada: ' . mb_substr(trim((string)($request->input('alasan') ?? '')), 0, 240))
                    : ($links[0]['judul'] ?? ($hasDokumenFile ? trim((string)($dokumenJudul[0] ?? '')) : ($hasFotoFile ? trim($validated['judul_foto'] ?? '') : ''))),
                'link' => $validated['jawaban'] === 'tidak' ? '' : ($links[0]['link'] ?? ''),
                'created_by' => $request->user()->id,
            ]
        );
        if (\Schema::hasColumn('saq_answers', 'alasan')) {
            $answer->alasan = $validated['jawaban'] === 'tidak' ? trim((string)($request->input('alasan') ?? '')) : null;
            $answer->save();
        }
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
            $tanggalDok = $request->input('tanggal_dokumen') ?: ($request->input('tanggal_upload') ?: now());

            foreach ($links as $i => $l) {
                // Mode hybrid: pakai dokumen PPID yang sudah ada.
                // Server lookup ulang dari URL detail PPID; bila tidak
                // ditemukan -> 422. Bila ditemukan, HANYA buat SaqAnswerLink
                // (tanpa Informasi/InformasiPemkab baru, untuk semua target
                // dan semua klasifikasi). Dokumen asli tidak pernah dihapus:
                // simpan ulang hanya menghapus dokumen SAQ (saq_answer_id).
                $isSync = (($l['mode'] ?? 'baru') === 'sync_ppid');
                if ($isSync) {
                    $detailUrl = trim($l['sync_url'] ?? $l['link']);
                    $synced = $this->lookupAnyPortalDocument($detailUrl);
                    if (!$synced) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'Link dokumen atau halaman resmi tidak ditemukan di database. Pastikan link berupa https://ppid.sinjaikab.go.id/... atau https://sinjaikab.go.id/... dari data yang sudah terdaftar.',
                        ], 422);
                    }
                    $syncLink = [
                        'judul' => $synced['judul'],
                        'link' => $detailUrl,
                        'deskripsi' => ($synced['kategori'] ? 'Kategori: ' . $synced['kategori'] . '. ' : '')
                            . 'Dokumen/Halaman terdaftar (' . ($synced['sumber_label'] ?? $synced['sumber']) . ').'
                            . ($synced['tanggal'] ? ' Tanggal: ' . $synced['tanggal'] : '')
                            . ($synced['file_url'] ? '. File: ' . $synced['file_url'] : ''),
                        'order' => $i,
                    ];
                    // Kolom jejak hanya bila migrasi sudah jalan
                    if (\Schema::hasColumn('saq_answer_links', 'informasi_id') && !empty($synced['id'])) {
                        $syncLink['informasi_id'] = $synced['id'];
                        $syncLink['sumber_informasi'] = $synced['sumber'];
                    }
                    $answer->links()->create($syncLink);
                    continue;
                }

                // Simpan sebagai dokumen HANYA untuk tipe 'dokumen' DAN mode 'baru' / 'drive'.
                $isDokumen = ($indicator->input_type ?? 'dokumen') === 'dokumen'
                    && in_array(($l['mode'] ?? 'baru'), ['baru', 'drive'], true);

                $dok = null;
                $linkToSave = $l['link'];
                $sumberToSave = ($l['mode'] ?? 'baru');
                $informasiIdToSave = null;

                if ($isDokumen) {
                    $lJudul = trim((string)($l['judul'] ?? ''));
                    $lDesk = trim((string)($l['deskripsi'] ?? ''));
                    $lContent = trim((string)($request->input('doc_content') ?? ''));
                    $kataKunci = trim((string)($request->input('kata_kunci') ?? ''));

                    // Prioritaskan judul hasil AI / kata kunci daripada teks kalimat tanya indikator
                    if (empty($lJudul) || $lJudul === trim($indicator->pertanyaan)) {
                        if (!empty($kataKunci)) {
                            $lJudul = $kataKunci;
                        } else {
                            $cleanTitle = preg_replace('/^(Apakah\s+Pemerintah\s+Kabupaten\/Kota\s+Saudara\s+mengumumkan\s+informasi\s+(tentang\s+)?|Mengumumkan\s+informasi\s+(tentang\s+)?|Apakah\s+OPD\s+memiliki\/memenuhi\s+indikator\s+ini\??\s*)/iu', '', $indicator->pertanyaan);
                            $cleanTitle = rtrim(trim($cleanTitle), '? ');
                            $lJudul = ucfirst($cleanTitle) . ' Kabupaten Sinjai';
                        }
                    }
                    if (empty($lDesk) || $lDesk === trim($indicator->pertanyaan)) {
                        $lDesk = "Dokumen publik " . $lJudul . " yang diumumkan secara resmi oleh Pemerintah Kabupaten Sinjai dalam rangka pemenuhan Keterbukaan Informasi Publik.";
                    }
                    if (empty($lContent)) {
                        $lContent = $lDesk;
                    }

                    $dokTahun = !empty($tanggalDok) ? (int)date('Y', strtotime($tanggalDok)) : (int)date('Y');
                    if ($indicator->target_upload === 'pemkab') {
                        $dok = InformasiPemkab::create([
                            'saq_answer_id' => $answer->id,
                            'judul' => $lJudul,
                            'kategori' => $klasifikasi,
                            'jenis_dokumen' => $request->input('jenis_dokumen') ?: ($indicator->jenis_dokumen ?? 'Dokumen SAQ'),
                            'deskripsi' => $lDesk,
                            'tahun' => $dokTahun,
                            'file_path' => $l['link'],
                            'status' => $visibility === 'public' ? 'published' : 'draft',
                            'visibility' => $visibility,
                            'published_at' => $tanggalDok,
                            'unit_id' => $org->id,
                            'user_id' => $request->user()->id,
                        ]);
                        $linkToSave = 'https://sinjaikab.go.id/informasi/' . ($dok->slug ?? $dok->id);
                        $sumberToSave = 'informasi_pemkab';
                        $informasiIdToSave = $dok->id;
                    } else {
                        $targetUnitId = ($org && $org->remote_id !== null && $org->remote_id !== '') ? (string)$org->remote_id : '0';
                        $cleanCat = match (true) {
                            str_contains(strtolower((string)$klasifikasi), 'setiap saat') => 'Informasi Setiap Saat',
                            str_contains(strtolower((string)$klasifikasi), 'serta merta') => 'Informasi Serta Merta',
                            str_contains(strtolower((string)$klasifikasi), 'dikecualikan') => 'Informasi Dikecualikan',
                            default => 'Informasi Berkala',
                        };
                        $dok = Informasi::create([
                            'saq_answer_id' => $answer->id,
                            'title' => $lJudul,
                            'content' => $lContent,
                            'category' => $cleanCat,
                            'deskripsi' => $lDesk,
                            'tahun' => $dokTahun,
                            'visibility' => $visibility,
                            'published' => ($visibility === 'public'),
                            'status' => $visibility === 'public' ? 'published' : 'draft',
                            'url' => $l['link'],
                            'unit_id' => $targetUnitId,
                            'user_id' => $request->user()->id,
                            'tanggal_upload' => $tanggalDok,
                        ]);
                        $linkToSave = 'https://ppid.sinjaikab.go.id/informasi/detail/' . ($dok->slug ?? $dok->id);
                        $sumberToSave = 'informasi';
                        $informasiIdToSave = $dok->id;
                    }
                    $dokumenIds[] = $dok->id ?? null;
                    $l['judul'] = $lJudul;
                    $l['deskripsi'] = $lDesk;
                }

                $linkRow = [
                    // Situs/foto tanpa judul: '' dari frontend diubah Laravel jadi null; kolom judul NOT NULL, pakai '' agar tidak 500.
                    'judul' => $l['judul'] ?? '',
                    'link' => $linkToSave,
                    'deskripsi' => $l['deskripsi'] ?? '',
                    'order' => $i,
                ];
                if (\Schema::hasColumn('saq_answer_links', 'sumber_informasi')) {
                    $linkRow['sumber_informasi'] = $sumberToSave;
                }
                if (\Schema::hasColumn('saq_answer_links', 'informasi_id') && $informasiIdToSave) {
                    $linkRow['informasi_id'] = $informasiIdToSave;
                }
                $answer->links()->create($linkRow);

                if ($isDokumen && $i === 0) {
                    $answer->link = $linkToSave;
                    if (!empty($l['judul'])) {
                        $answer->judul = $l['judul'];
                    }
                    $answer->save();
                }
            }

            // Jalur upload dokumen (2 tab): simpan file ke storage public/saq/,
            // buat SaqAnswerLink ke link detail dokumen resmi (bukan URL fisik storage).
            // HANYA bila toggle jadikan aktif DAN tipe dokumen, buat Informasi/InformasiPemkab.
            // Bila toggle mati: simpan sebagai lampiran file mentah.
            if ($hasDokumenFile) {
                foreach ($dokumenFiles as $di => $df) {
                    $dJudul = trim((string)($dokumenJudul[$di] ?? pathinfo($df->getClientOriginalName(), PATHINFO_FILENAME)));
                    $dDesk = trim((string)($dokumenDeskripsi[$di] ?? ''));
                    $dJadikanRaw = $dokumenJadikan[$di] ?? '0';
                    $dJadikan = in_array($dJadikanRaw, ['1', 1, true, 'true'], true);
                    $dExt = strtolower(pathinfo($df->getClientOriginalName(), PATHINFO_EXTENSION));
                    if (in_array($dExt, ['jpg', 'jpeg', 'png'], true)) {
                        ini_set('memory_limit', '512M');
                        $dManager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                        $dQuality = 80;
                        $dTmp = tempnam(sys_get_temp_dir(), 'saq_dok_') . '.webp';
                        $dImg = $dManager->read($df->path())->toWebp($dQuality);
                        $dImg->save($dTmp);
                        while (filesize($dTmp) > 2 * 1024 * 1024 && $dQuality > 20) {
                            $dQuality -= 10;
                            $dImg = $dManager->read($df->path())->toWebp($dQuality);
                            $dImg->save($dTmp);
                        }
                        $dBase = pathinfo($df->getClientOriginalName(), PATHINFO_FILENAME);
                        $dFileName = str_replace(' ', '_', $dBase) . '_' . time() . '_' . $di . '.webp';
                        $dPath = 'saq/' . $dFileName;
                        Storage::disk('public')->put($dPath, file_get_contents($dTmp));
                        unlink($dTmp);
                    } else {
                        $dPath = Storage::disk('public')->putFile('saq', $df);
                    }
                    $storedDokumenPaths[] = $dPath;
                    $dUrl = $request->getSchemeAndHttpHost() . '/storage/' . $dPath;

                    $linkToSave = $dUrl;
                    $sumberToSave = 'lampiran';
                    $informasiIdToSave = null;

                    if ($dJadikan) {
                        $dJudul = trim((string)($dokumenJudul[$di] ?? ''));
                        $dDesk = trim((string)($dokumenDeskripsi[$di] ?? ''));
                        $dContent = trim((string)($request->input('doc_content') ?? ''));
                        $kataKunci = trim((string)($request->input('kata_kunci') ?? ''));

                        // Prioritaskan judul hasil AI / kata kunci daripada teks kalimat tanya indikator
                        if (empty($dJudul) || $dJudul === trim($indicator->pertanyaan)) {
                            if (!empty($kataKunci)) {
                                $dJudul = $kataKunci;
                            } else {
                                $cleanTitle = preg_replace('/^(Apakah\s+Pemerintah\s+Kabupaten\/Kota\s+Saudara\s+mengumumkan\s+informasi\s+(tentang\s+)?|Mengumumkan\s+informasi\s+(tentang\s+)?|Apakah\s+OPD\s+memiliki\/memenuhi\s+indikator\s+ini\??\s*)/iu', '', $indicator->pertanyaan);
                                $cleanTitle = rtrim(trim($cleanTitle), '? ');
                                $dJudul = ucfirst($cleanTitle) . ' Kabupaten Sinjai';
                            }
                        }
                        if (empty($dDesk) || $dDesk === trim($indicator->pertanyaan)) {
                            $dDesk = "Dokumen publik " . $dJudul . " yang diumumkan secara resmi oleh Pemerintah Kabupaten Sinjai dalam rangka pemenuhan Keterbukaan Informasi Publik.";
                        }
                        if (empty($dContent)) {
                            $dContent = $dDesk;
                        }

                        $dokTahun = !empty($tanggalDok) ? (int)date('Y', strtotime($tanggalDok)) : (int)date('Y');
                        $targetSys = $request->input('target_upload') ?: ($indicator->target_upload ?? 'ppid');
                        $kategoriToSave = $request->input('kategori') ?: ($request->input('klasifikasi') ?: ($indicator->klasifikasi_otomatis ?? 'Informasi Berkala'));
                        $jenisToSave = $request->input('jenis_dokumen') ?: ($indicator->jenis_dokumen ?? 'Dokumen SAQ');

                        if ($targetSys === 'pemkab') {
                            $dok = InformasiPemkab::create([
                                'saq_answer_id' => $answer->id,
                                'judul' => $dJudul,
                                'kategori' => $kategoriToSave,
                                'jenis_dokumen' => $jenisToSave,
                                'deskripsi' => $dDesk,
                                'tahun' => $dokTahun,
                                'file_path' => $dUrl,
                                'status' => $visibility === 'public' ? 'published' : 'draft',
                                'visibility' => $visibility,
                                'published_at' => $tanggalDok,
                                'unit_id' => $org->id,
                                'user_id' => $request->user()->id,
                            ]);
                            $linkToSave = 'https://sinjaikab.go.id/informasi/' . ($dok->slug ?? $dok->id);
                            $sumberToSave = 'informasi_pemkab';
                            $informasiIdToSave = $dok->id;
                        } else {
                            $targetUnitId = ($org && $org->remote_id !== null && $org->remote_id !== '') ? (string)$org->remote_id : '0';
                            $cleanCat = match (true) {
                                str_contains(strtolower((string)$kategoriToSave), 'setiap saat') => 'Informasi Setiap Saat',
                                str_contains(strtolower((string)$kategoriToSave), 'serta merta') => 'Informasi Serta Merta',
                                str_contains(strtolower((string)$kategoriToSave), 'dikecualikan') => 'Informasi Dikecualikan',
                                default => 'Informasi Berkala',
                            };
                            $dok = Informasi::create([
                                'saq_answer_id' => $answer->id,
                                'title' => $dJudul,
                                'content' => $dContent,
                                'category' => $cleanCat,
                                'deskripsi' => $dDesk,
                                'tahun' => $dokTahun,
                                'visibility' => $visibility,
                                'published' => ($visibility === 'public'),
                                'status' => $visibility === 'public' ? 'published' : 'draft',
                                'file' => $dPath,
                                'url' => $dUrl,
                                'unit_id' => $targetUnitId,
                                'user_id' => $request->user()->id,
                                'tanggal_upload' => $tanggalDok,
                            ]);
                            $linkToSave = 'https://ppid.sinjaikab.go.id/informasi/detail/' . ($dok->slug ?? $dok->id);
                            $sumberToSave = 'informasi';
                            $informasiIdToSave = $dok->id;
                        }
                        $dokumenIds[] = $dok->id ?? null;
                    }

                    $upRow = [
                        'judul' => $dJudul,
                        'link' => $linkToSave,
                        'deskripsi' => $dDesk,
                        'order' => count($links) + $di,
                    ];
                    if (\Schema::hasColumn('saq_answer_links', 'sumber_informasi')) {
                        $upRow['sumber_informasi'] = $sumberToSave;
                    }
                    if (\Schema::hasColumn('saq_answer_links', 'informasi_id') && $informasiIdToSave) {
                        $upRow['informasi_id'] = $informasiIdToSave;
                    }
                    $answer->links()->create($upRow);

                    if (empty($links) && $di === 0 && !$hasFotoFile) {
                        $answer->link = $linkToSave;
                        $answer->judul = $dJudul ?: $indicator->pertanyaan;
                        $answer->save();
                    }
                }
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
                // Tab Galeri: link foto diberi sumber_informasi='galeri'
                // supaya saat dibuka lagi kembali ke tab Galeri, bukan tab
                // Link. Tetap category=null di Galeri: TIDAK membuat Informasi.
                $photoLink = [
                    'judul' => trim($validated['judul_foto']),
                    'link' => $photoUrl,
                    'deskripsi' => '',
                    'order' => count($links) + count($dokumenFiles),
                ];
                if (\Schema::hasColumn('saq_answer_links', 'sumber_informasi')) {
                    $photoLink['sumber_informasi'] = 'galeri';
                }
                $answer->links()->create($photoLink);
                if (empty($links)) {
                    $answer->link = $photoUrl;
                    $answer->save();
                }
            }
        }
        DB::commit();
        // Baru hapus file lampiran lama setelah commit berhasil.
        foreach ($oldLampiranPaths as $olp) {
            // Hanya hapus path di bawah saq/ yang TIDAK dipertahankan (round-trip v2).
            if (str_starts_with($olp, 'saq/') && !in_array($olp, $keptLampiranPaths, true)) Storage::disk('public')->delete($olp);
        }
        } catch (\Throwable $e) {
            DB::rollBack();
            if (!empty($storedFotoPath)) {
                Storage::disk('public')->delete($storedFotoPath);
            }
            foreach ($storedDokumenPaths as $sdp) {
                Storage::disk('public')->delete($sdp);
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

        // Otorisasi: superadmin, admin kabupaten, atau admin OPD
        $user = $request->user();
        $isSuperadmin = ($user && ($user->role === 'superadmin' || !empty($user->admin_kabupaten)));

        // Cek penguncian pengisian SAQ: jika terkunci, hanya superadmin yang diizinkan menghapus
        if (self::isLocked() && !$isSuperadmin) {
            return response()->json([
                'success' => false,
                'message' => 'Penghapusan jawaban SAQ saat ini sedang dikunci oleh Superadmin.',
            ], 403);
        }
        $isKabupatenAnswer = ((int)$answer->organization_id === 127);
        if (!$isSuperadmin && !$isKabupatenAnswer) {
            $uUnit = (string)($user->unit_id ?? '');
            if (!$uUnit && $user->nip) {
                $apiData = \App\Models\User::getDataFromApi($user->nip);
                $uUnit = (string)($apiData['unit_id'] ?? '');
            }
            $userOrg = \App\Models\Organization::where('remote_id', $uUnit)
                ->orWhere('unit_id', $uUnit)
                ->orWhere('id', $uUnit)
                ->first();
            if (!$userOrg || (int)$userOrg->id !== (int)$answer->organization_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda hanya dapat menghapus jawaban OPD Anda sendiri.',
                ], 403);
            }
        }

        // Hapus file fisik lampiran SAQ di storage bila ada
        foreach ($answer->links as $ol) {
            $olink = (string)($ol->link ?? '');
            if (str_contains($olink, '/storage/saq/')) {
                $pos = strpos($olink, '/storage/');
                if ($pos !== false) {
                    $path = substr($olink, $pos + strlen('/storage/'));
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
        }

        // Hapus juga dokumen terkait via saq_answer_id
        \App\Models\Informasi::where('saq_answer_id', $answer->id)->delete();
        \App\Models\InformasiPemkab::where('saq_answer_id', $answer->id)->delete();
        $answer->links()->delete();
        $answer->delete();

        try { \Cache::tags(['informasi'])->flush(); } catch (\Exception $e) {}

        return response()->json(['success' => true, 'message' => 'Jawaban dan dokumen bukti berhasil dihapus.']);
    }

    /**
     * Auto-sync: cek apakah sebuah link sudah ada di data PPID atau Pemkab Sinjai.
     * Mendukung dokumen informasi publik, profil pimpinan/pejabat daerah (Bupati/Wakil/Sekda),
     * profil dan daftar OPD/Satuan Kerja, LHKPN, regulasi, SOP, maklumat, serta seluruh
     * halaman resmi terverifikasi di domain ppid.sinjaikab.go.id & sinjaikab.go.id.
     * GET /api/v1/saq/sync?url=
     */
    public function sync(Request $request)
    {
        $request->validate(['url' => 'required|string']);

        $url = trim($request->url);
        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');

        // Validasi domain resmi: PPID, Portal Pemkab Sinjai, Apps Sinjai, dan Localhost
        $isOfficialDomain = in_array($host, [
            'ppid.sinjaikab.go.id',
            'www.ppid.sinjaikab.go.id',
            'sinjaikab.go.id',
            'www.sinjaikab.go.id',
            'apps.sinjaikab.go.id',
            'localhost',
            '127.0.0.1',
        ], true);

        if (!$isOfficialDomain) {
            return response()->json([
                'success' => true,
                'found' => false,
                'message' => 'Hanya tautan resmi dari website PPID (ppid.sinjaikab.go.id) atau Portal Pemkab Sinjai (sinjaikab.go.id) yang dapat disinkronkan di Pilihan 2 ini. Untuk tautan luar lainnya, silakan gunakan Pilihan 1 (Upload Berkas / Google Drive).',
            ]);
        }

        // Cari di Dokumen PPID/Pemkab, Pejabat Daerah, OPD, atau Halaman Resmi Portal
        $found = $this->lookupAnyPortalDocument($url);
        if ($found) {
            return response()->json([
                'success' => true,
                'found' => true,
                'data' => $found,
            ]);
        }

        return response()->json([
            'success' => true,
            'found' => false,
            'message' => 'Data atau halaman resmi tidak ditemukan pada website PPID maupun Pemkab Sinjai. Pastikan tautan berasal dari website resmi.',
        ]);
    }

    /**
     * Parse link detail PPID atau Portal Pemkab -> slug, atau null bila bukan link detail.
     */
    private function parsePpidDetailSlug(string $url): ?string
    {
        $parts = parse_url(trim($url));
        if (!$parts || empty($parts['host'])) {
            return null;
        }
        $host = strtolower($parts['host']);
        if (!in_array($host, ['ppid.sinjaikab.go.id', 'www.ppid.sinjaikab.go.id', 'sinjaikab.go.id', 'www.sinjaikab.go.id', 'localhost', '127.0.0.1'], true)) {
            return null;
        }
        $path = trim($parts['path'] ?? '', '/');
        if (empty($path)) {
            return null;
        }
        $segments = array_values(array_filter(explode('/', $path), fn($s) => $s !== ''));
        if (empty($segments)) {
            return null;
        }

        // 1. Jika ada segmen 'detail' (misal: /informasi/detail/{slug})
        $detailIdx = array_search('detail', $segments, true);
        if ($detailIdx !== false && isset($segments[$detailIdx + 1]) && $segments[$detailIdx + 1] !== '') {
            return urldecode($segments[$detailIdx + 1]);
        }

        // 2. Jika segmen pertama adalah 'informasi'
        if ($segments[0] === 'informasi') {
            if (count($segments) >= 2) {
                $last = end($segments);
                if ($last !== 'informasi' && $last !== 'detail') {
                    return urldecode($last);
                }
            }
            return null;
        }

        return null;
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
     * Cari dokumen atau halaman resmi apapun di domain PPID & Pemkab Sinjai.
     */
    private function lookupAnyPortalDocument(string $url): ?array
    {
        return $this->lookupPpidDocument($url)
            ?? $this->lookupOfficialDocument($url)
            ?? $this->lookupOrganizationDocument($url)
            ?? $this->lookupPublicPageDocument($url);
    }

    /**
     * Cari dokumen PPID atau Portal Pemkab dari sebuah URL.
     */
    private function lookupPpidDocument(string $url): ?array
    {
        $url = trim($url);
        $slug = $this->parsePpidDetailSlug($url);
        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');
        $isPemkabDomain = in_array($host, ['sinjaikab.go.id', 'www.sinjaikab.go.id'], true);

        if ($slug !== null) {
            if ($isPemkabDomain) {
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
                        'jenis_dokumen' => $pemkab->jenis_dokumen ?? 'Dokumen Pemkab',
                        'pengupload' => $pemkab->user->name ?? null,
                        'opd' => $pemkab->organization->name ?? null,
                        'tanggal' => $this->ppidDateStr($pemkab->published_at ?? $pemkab->created_at),
                        'file_url' => $this->ppidFileUrl($pemkab->file_path),
                        'detail_url' => 'https://sinjaikab.go.id/informasi/' . ($pemkab->slug ?? $pemkab->id),
                        'sumber' => 'informasi_pemkab',
                        'sumber_label' => 'Portal Pemkab Sinjai',
                    ];
                }
            }

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
                    'jenis_dokumen' => $info->jenis_dokumen ?? 'Dokumen PPID',
                    'pengupload' => $info->user->name ?? null,
                    'opd' => $info->organization->name ?? null,
                    'tanggal' => $this->ppidDateStr($info->tanggal_upload ?? $info->created_at),
                    'file_url' => $this->ppidFileUrl($info->file),
                    'detail_url' => 'https://ppid.sinjaikab.go.id/informasi/detail/' . ($info->slug ?? $info->id),
                    'sumber' => 'informasi',
                    'sumber_label' => 'PPID Kabupaten Sinjai',
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
                    'jenis_dokumen' => $pemkab->jenis_dokumen ?? 'Dokumen Pemkab',
                    'pengupload' => $pemkab->user->name ?? null,
                    'opd' => $pemkab->organization->name ?? null,
                    'tanggal' => $this->ppidDateStr($pemkab->published_at ?? $pemkab->created_at),
                    'file_url' => $this->ppidFileUrl($pemkab->file_path),
                    'detail_url' => 'https://sinjaikab.go.id/informasi/' . ($pemkab->slug ?? $pemkab->id),
                    'sumber' => 'informasi_pemkab',
                    'sumber_label' => 'Portal Pemkab Sinjai',
                ];
            }
        }

        // Pencocokan langsung dengan URL atau path berkas
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
                'jenis_dokumen' => $info->jenis_dokumen ?? 'Dokumen PPID',
                'pengupload' => $info->user->name ?? null,
                'opd' => $info->organization->name ?? null,
                'tanggal' => $this->ppidDateStr($info->tanggal_upload ?? $info->created_at),
                'file_url' => $this->ppidFileUrl($info->file),
                'detail_url' => 'https://ppid.sinjaikab.go.id/informasi/detail/' . ($info->slug ?? $info->id),
                'sumber' => 'informasi',
                'sumber_label' => 'PPID Kabupaten Sinjai',
            ];
        }

        $pemkab = InformasiPemkab::with(['user:id,name', 'organization:id,name'])
            ->where('file_path', $url)
            ->orWhere('file_path', 'like', '%' . basename($url) . '%')
            ->first();
        if ($pemkab) {
            return [
                'id' => $pemkab->id,
                'judul' => $pemkab->judul,
                'deskripsi' => $pemkab->deskripsi,
                'kategori' => $pemkab->kategori,
                'jenis_dokumen' => $pemkab->jenis_dokumen ?? 'Dokumen Pemkab',
                'pengupload' => $pemkab->user->name ?? null,
                'opd' => $pemkab->organization->name ?? null,
                'tanggal' => $this->ppidDateStr($pemkab->published_at ?? $pemkab->created_at),
                'file_url' => $this->ppidFileUrl($pemkab->file_path),
                'detail_url' => 'https://sinjaikab.go.id/informasi/' . ($pemkab->slug ?? $pemkab->id),
                'sumber' => 'informasi_pemkab',
                'sumber_label' => 'Portal Pemkab Sinjai',
            ];
        }

        return null;
    }

    /**
     * Cari profil Pejabat Daerah / Bupati / Wakil / Sekda / Pejabat Struktural dari URL.
     */
    private function lookupOfficialDocument(string $url): ?array
    {
        $path = strtolower(trim(parse_url($url, PHP_URL_PATH) ?? '', '/'));
        $query = strtolower(parse_url($url, PHP_URL_QUERY) ?? '');

        $isOfficialPath = str_contains($path, 'pejabat')
            || str_contains($path, 'pimpinan')
            || str_contains($path, 'bupati')
            || str_contains($path, 'wakil')
            || str_contains($path, 'sekda')
            || str_contains($query, 'bupati')
            || str_contains($query, 'wakil');

        if (!$isOfficialPath) {
            return null;
        }

        $segments = array_values(array_filter(explode('/', $path), fn($s) => $s !== ''));
        $lastSeg = end($segments) ?: '';

        // Jika ada segmen spesifik ID atau slug pejabat
        if (!empty($lastSeg) && !in_array($lastSeg, ['pejabat-daerah', 'pejabat', 'pimpinan', 'profil', 'profil-pimpinan'], true)) {
            $official = Official::with(['position', 'organization'])
                ->where(function ($q) use ($lastSeg) {
                    if (ctype_digit($lastSeg)) {
                        $q->where('id', (int) $lastSeg);
                    }
                    $q->orWhere('slug', $lastSeg)
                      ->orWhere('full_name', 'like', "%{$lastSeg}%");
                })
                ->first();

            if ($official) {
                $posName = $official->position->name ?? 'Pejabat Daerah';
                return [
                    'id' => $official->id,
                    'judul' => 'Profil Singkat ' . $posName . ': ' . $official->full_name,
                    'deskripsi' => $official->biography ?: ('Profil dan riwayat jabatan resmi ' . $posName . ' Pemerintah Kabupaten Sinjai.'),
                    'kategori' => 'Informasi Berkala',
                    'jenis_dokumen' => 'Profil Singkat Pejabat Struktural',
                    'pengupload' => 'Bagian Organisasi / PPID',
                    'opd' => $official->organization->name ?? 'Pemerintah Kabupaten Sinjai',
                    'tanggal' => $this->ppidDateStr($official->updated_at ?? $official->created_at),
                    'file_url' => $official->photo ? $this->ppidFileUrl($official->photo) : null,
                    'detail_url' => $url,
                    'sumber' => 'official',
                    'sumber_label' => 'Profil Pejabat Daerah Pemkab Sinjai',
                ];
            }
        }

        // Cek pencarian kata kunci bupati / wakil / sekda
        if (str_contains($path, 'wakil') || str_contains($query, 'wakil')) {
            $official = Official::with(['position', 'organization'])
                ->whereHas('position', fn($q) => $q->where('name', 'like', '%wakil bupati%'))
                ->orWhere('full_name', 'like', '%wakil bupati%')
                ->first();
            if ($official) {
                return [
                    'id' => $official->id,
                    'judul' => 'Profil Singkat Wakil Bupati Sinjai: ' . $official->full_name,
                    'deskripsi' => $official->biography ?: 'Profil dan riwayat jabatan resmi Wakil Bupati Kabupaten Sinjai.',
                    'kategori' => 'Informasi Berkala',
                    'jenis_dokumen' => 'Profil Singkat Pejabat Struktural',
                    'pengupload' => 'Bagian Organisasi / PPID',
                    'opd' => 'Pemerintah Kabupaten Sinjai',
                    'tanggal' => $this->ppidDateStr($official->updated_at ?? $official->created_at),
                    'file_url' => $official->photo ? $this->ppidFileUrl($official->photo) : null,
                    'detail_url' => $url,
                    'sumber' => 'official',
                    'sumber_label' => 'Profil Pejabat Daerah Pemkab Sinjai',
                ];
            }
        }

        if (str_contains($path, 'bupati') || str_contains($query, 'bupati')) {
            $official = Official::with(['position', 'organization'])
                ->whereHas('position', fn($q) => $q->where('name', 'like', '%bupati%')->where('name', 'not like', '%wakil%'))
                ->orWhere('full_name', 'like', '%bupati%')
                ->first();
            if ($official) {
                return [
                    'id' => $official->id,
                    'judul' => 'Profil Singkat Bupati Sinjai: ' . $official->full_name,
                    'deskripsi' => $official->biography ?: 'Profil dan riwayat jabatan resmi Bupati Kabupaten Sinjai.',
                    'kategori' => 'Informasi Berkala',
                    'jenis_dokumen' => 'Profil Singkat Pejabat Struktural',
                    'pengupload' => 'Bagian Organisasi / PPID',
                    'opd' => 'Pemerintah Kabupaten Sinjai',
                    'tanggal' => $this->ppidDateStr($official->updated_at ?? $official->created_at),
                    'file_url' => $official->photo ? $this->ppidFileUrl($official->photo) : null,
                    'detail_url' => $url,
                    'sumber' => 'official',
                    'sumber_label' => 'Profil Pejabat Daerah Pemkab Sinjai',
                ];
            }
        }

        // Halaman umum daftar pejabat struktural
        return [
            'id' => null,
            'judul' => 'Profil Singkat Pejabat Struktural Lingkup Pemerintah Kabupaten Sinjai',
            'deskripsi' => 'Pengumuman dan publikasi profil singkat pejabat struktural (Bupati, Wakil Bupati, Sekretaris Daerah, serta Pejabat Eselon II) di lingkungan Pemerintah Kabupaten Sinjai.',
            'kategori' => 'Informasi Berkala',
            'jenis_dokumen' => 'Profil Singkat Pejabat Struktural',
            'pengupload' => 'Bagian Organisasi / PPID',
            'opd' => 'Pemerintah Kabupaten Sinjai',
            'tanggal' => date('Y-m-d'),
            'file_url' => null,
            'detail_url' => $url,
            'sumber' => 'official',
            'sumber_label' => 'Portal Pejabat Daerah Pemkab Sinjai',
        ];
    }

    /**
     * Cari profil Satuan Kerja / OPD / Dinas dari URL.
     */
    private function lookupOrganizationDocument(string $url): ?array
    {
        $path = strtolower(trim(parse_url($url, PHP_URL_PATH) ?? '', '/'));

        $isOrgPath = str_contains($path, 'unit-lokal')
            || str_contains($path, 'tentang-opd')
            || str_contains($path, 'dinas')
            || str_contains($path, 'opd')
            || str_contains($path, 'satuan-kerja')
            || str_contains($path, 'organisasi');

        if (!$isOrgPath) {
            return null;
        }

        $segments = array_values(array_filter(explode('/', $path), fn($s) => $s !== ''));
        $lastSeg = end($segments) ?: '';

        // Jika ada segmen spesifik ID atau slug OPD
        if (!empty($lastSeg) && !in_array($lastSeg, ['unit-lokal', 'tentang-opd', 'dinas', 'opd', 'profil'], true)) {
            $org = Organization::where(function ($q) use ($lastSeg) {
                if (ctype_digit($lastSeg)) {
                    $q->where('id', (int) $lastSeg)
                      ->orWhere('unit_id', $lastSeg)
                      ->orWhere('remote_id', $lastSeg);
                }
                $q->orWhere('slug', $lastSeg)
                  ->orWhere('name', 'like', "%{$lastSeg}%");
            })->first();

            if ($org) {
                return [
                    'id' => $org->id,
                    'judul' => 'Profil & Alamat Resmi Satuan Kerja: ' . $org->name,
                    'deskripsi' => 'Informasi profil, alamat lengkap, tugas pokok dan fungsi, serta kontak resmi ' . $org->name . ' Pemerintah Kabupaten Sinjai.',
                    'kategori' => 'Informasi Berkala',
                    'jenis_dokumen' => 'Profil Satuan Kerja / OPD',
                    'pengupload' => 'Admin Satuan Kerja / PPID',
                    'opd' => $org->name,
                    'tanggal' => $this->ppidDateStr($org->updated_at ?? $org->created_at),
                    'file_url' => $org->website_url,
                    'detail_url' => $url,
                    'sumber' => 'organization',
                    'sumber_label' => 'Satuan Kerja Pemkab Sinjai',
                ];
            }
        }

        // Halaman umum daftar seluruh OPD / Satuan Kerja
        return [
            'id' => null,
            'judul' => 'Alamat Lengkap Setiap Satuan Kerja Lingkup Pemerintah Kabupaten Sinjai',
            'deskripsi' => 'Daftar alamat lengkap, kontak, dan tautan resmi seluruh Satuan Kerja / Perangkat Daerah di Lingkungan Pemerintah Kabupaten Sinjai.',
            'kategori' => 'Informasi Berkala',
            'jenis_dokumen' => 'Daftar Satuan Kerja / OPD',
            'pengupload' => 'PPID Utama',
            'opd' => 'Pemerintah Kabupaten Sinjai',
            'tanggal' => date('Y-m-d'),
            'file_url' => null,
            'detail_url' => $url,
            'sumber' => 'organization',
            'sumber_label' => 'Portal Satuan Kerja Pemkab Sinjai',
        ];
    }

    /**
     * Cari halaman publik resmi lainnya di domain PPID & Pemkab Sinjai (LHKPN, Regulasi, SOP, Profil Umum, dll).
     */
    private function lookupPublicPageDocument(string $url): ?array
    {
        $path = strtolower(trim(parse_url($url, PHP_URL_PATH) ?? '', '/'));
        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');
        $isPemkabDomain = in_array($host, ['sinjaikab.go.id', 'www.sinjaikab.go.id'], true);
        $sumberLabel = $isPemkabDomain ? 'Portal Pemkab Sinjai' : 'PPID Kabupaten Sinjai';

        // LHKPN
        if (str_contains($path, 'lhkpn')) {
            return [
                'id' => null,
                'judul' => 'Informasi LHKPN Pejabat Negara Pemerintah Kabupaten Sinjai Tahun 2025/2026',
                'deskripsi' => 'Pengumuman informasi LHKPN Pejabat Negara lingkup Pemerintah Kabupaten Sinjai yang telah diperiksa, diverifikasi, dan dikirimkan oleh Komisi Pemberantasan Korupsi (KPK).',
                'kategori' => 'Informasi Berkala',
                'jenis_dokumen' => 'LHKPN Pejabat Negara',
                'pengupload' => 'Inspektorat / PPID',
                'opd' => 'Pemerintah Kabupaten Sinjai',
                'tanggal' => date('Y-m-d'),
                'file_url' => null,
                'detail_url' => $url,
                'sumber' => 'lhkpn',
                'sumber_label' => $sumberLabel,
            ];
        }

        // Regulasi & Kebijakan
        if (str_contains($path, 'regulasi') || str_contains($path, 'peraturan') || str_contains($path, 'kebijakan')) {
            return [
                'id' => null,
                'judul' => 'Daftar Peraturan, Keputusan, dan Kebijakan Publik Pemerintah Kabupaten Sinjai',
                'deskripsi' => 'Daftar peraturan perundang-undangan, keputusan bupati, dan kebijakan yang mengikat dan berdampak bagi masyarakat Kabupaten Sinjai.',
                'kategori' => 'Informasi Berkala',
                'jenis_dokumen' => 'Regulasi & Produk Hukum',
                'pengupload' => 'Bagian Hukum / PPID',
                'opd' => 'Pemerintah Kabupaten Sinjai',
                'tanggal' => date('Y-m-d'),
                'file_url' => null,
                'detail_url' => $url,
                'sumber' => 'regulasi',
                'sumber_label' => $sumberLabel,
            ];
        }

        // Standar Layanan & SOP
        if (str_contains($path, 'sop') || str_contains($path, 'standar-layanan')) {
            return [
                'id' => null,
                'judul' => 'Standar Layanan dan Standar Operasional Prosedur (SOP) Pelayanan Informasi Publik',
                'deskripsi' => 'Dokumen resmi Standar Layanan dan Standar Operasional Prosedur (SOP) permohonan informasi dan pengajuan keberatan di PPID Kabupaten Sinjai.',
                'kategori' => 'Informasi Berkala',
                'jenis_dokumen' => 'Standar Layanan & SOP',
                'pengupload' => 'PPID Utama',
                'opd' => 'Dinas Komunikasi Informatika dan Persandian',
                'tanggal' => date('Y-m-d'),
                'file_url' => null,
                'detail_url' => $url,
                'sumber' => 'sop',
                'sumber_label' => $sumberLabel,
            ];
        }

        // Maklumat Layanan
        if (str_contains($path, 'maklumat')) {
            return [
                'id' => null,
                'judul' => 'Maklumat Pelayanan Informasi Publik Pemerintah Kabupaten Sinjai',
                'deskripsi' => 'Pernyataan kesanggupan dan komitmen resmi Pemerintah Kabupaten Sinjai dalam menyelenggarakan pelayanan informasi publik sesuai standar yang ditetapkan.',
                'kategori' => 'Informasi Berkala',
                'jenis_dokumen' => 'Maklumat Layanan',
                'pengupload' => 'PPID Utama',
                'opd' => 'Pemerintah Kabupaten Sinjai',
                'tanggal' => date('Y-m-d'),
                'file_url' => null,
                'detail_url' => $url,
                'sumber' => 'maklumat',
                'sumber_label' => $sumberLabel,
            ];
        }

        // Struktur Organisasi
        if (str_contains($path, 'struktur-organisasi') || str_contains($path, 'struktur')) {
            return [
                'id' => null,
                'judul' => 'Bagan Struktur Organisasi Pemerintah Kabupaten Sinjai',
                'deskripsi' => 'Pengumuman bagan struktur organisasi resmi dan tata hubungan kerja di Lingkungan Pemerintah Kabupaten Sinjai.',
                'kategori' => 'Informasi Berkala',
                'jenis_dokumen' => 'Struktur Organisasi',
                'pengupload' => 'Bagian Organisasi / PPID',
                'opd' => 'Pemerintah Kabupaten Sinjai',
                'tanggal' => date('Y-m-d'),
                'file_url' => null,
                'detail_url' => $url,
                'sumber' => 'struktur',
                'sumber_label' => $sumberLabel,
            ];
        }

        // Visi Misi / Tugas Fungsi / Profil Pemkab
        if (str_contains($path, 'visi-misi') || str_contains($path, 'tugas-fungsi') || str_contains($path, 'profil')) {
            return [
                'id' => null,
                'judul' => 'Profil, Visi Misi, Tugas dan Fungsi Pemerintah Kabupaten Sinjai',
                'deskripsi' => 'Informasi resmi mengenai profil umum, ruang lingkup kegiatan, serta tugas pokok dan fungsi Pemerintah Kabupaten Sinjai.',
                'kategori' => 'Informasi Berkala',
                'jenis_dokumen' => 'Profil Pemerintah Daerah',
                'pengupload' => 'PPID Utama',
                'opd' => 'Pemerintah Kabupaten Sinjai',
                'tanggal' => date('Y-m-d'),
                'file_url' => null,
                'detail_url' => $url,
                'sumber' => 'profil_daerah',
                'sumber_label' => $sumberLabel,
            ];
        }

        // Fallback Umum untuk Seluruh Halaman Resmi di Domain PPID & Pemkab Sinjai
        if (!empty($path)) {
            $segments = array_values(array_filter(explode('/', $path), fn($s) => $s !== ''));
            $lastSeg = end($segments) ?: 'Informasi';
            $cleaned = ucwords(str_replace(['-', '_'], ' ', $lastSeg));
            return [
                'id' => null,
                'judul' => $cleaned . ' Pemerintah Kabupaten Sinjai',
                'deskripsi' => 'Halaman informasi resmi yang dipublikasikan pada portal ' . $sumberLabel . '.',
                'kategori' => 'Informasi Berkala',
                'jenis_dokumen' => 'Halaman Portal Resmi',
                'pengupload' => 'Pemerintah Kabupaten Sinjai',
                'opd' => 'Pemerintah Kabupaten Sinjai',
                'tanggal' => date('Y-m-d'),
                'file_url' => null,
                'detail_url' => $url,
                'sumber' => 'portal_resmi',
                'sumber_label' => $sumberLabel,
            ];
        }

        return null;
    }
}
