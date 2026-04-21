<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Statistik;
use App\Models\Informasi;
use App\Models\SubStandarLayanan;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Models\Setting; // Import the Setting model

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\ProfilPpid;
use App\Models\Official;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FrontendController extends Controller
{
    /**
     * Display the home page.
     */
    public function home()
    {
        $this->recordVisit(); // Record a visit when the home page is accessed.
        $sliders = Slider::where('active', true)->orderBy('order', 'asc')->get();
        foreach ($sliders as $slider) {
            $slider->informasi = Informasi::where('title', $slider->title)->first();
        }
        $berita = Berita::where('published', true)->orderBy('created_at', 'desc')->take(6)->get();
        $galeri = Galeri::orderBy('created_at', 'desc')->take(8)->get();
        
        // --- START of Statistics Logic ---
        $informasiBerkalaCount = Informasi::where('category', 'Informasi Berkala')->count();
        $informasiSetiapSaatCount = Informasi::where('category', 'Informasi Setiap Saat')->count();
        $informasiSertaMertaCount = Informasi::where('category', 'Informasi Serta Merta')->count();
        $informasiDikecualikanCount = Informasi::where('category', 'Informasi Dikecualikan')->count();
        $totalInformasi = $informasiBerkalaCount + $informasiSetiapSaatCount + $informasiSertaMertaCount + $informasiDikecualikanCount; // Sum all active categories

        $totalGaleri = Galeri::count();
        $totalPermohonans = \App\Models\PermohonanInformasi::count(); // Calculate total permohonan
        $totalSurveyResponses = \App\Models\SurveyResponse::count(); // Calculate total survey responses
        
        // Merge into a single stats array if needed, or pass separately
        $frontendStats = [
            'informasi' => [
                'berkala' => $informasiBerkalaCount,
                'setiap_saat' => $informasiSetiapSaatCount,
                'serta_merta' => $informasiSertaMertaCount,
                'total' => $totalInformasi,
            ],
            'galeri' => $totalGaleri,
            'permohonan' => $totalPermohonans, // Add total permohonan
            'survey_responses' => $totalSurveyResponses, // Add total survey responses
        ];
        // --- END of Statistics Logic ---

        // --- START of Contact Info Logic ---
        $profilPpid = ProfilPpid::where('status', true)->first();
        $contactInfo = [
            'address' => $profilPpid->address ?? 'Alamat belum diatur',
            'phone' => $profilPpid->phone ?? 'Telepon belum diatur',
            'email' => $profilPpid->email ?? 'Email belum diatur',
            'service_hours_weekday' => '08:00 - 16:00 WITA',
            'service_hours_friday' => '08:00 - 11:30 WITA',
            'service_hours_weekend' => 'Tutup',
        ];
        // --- END of Contact Info Logic ---

        $api_url = 'https://humas.sinjaikab.go.id/v1/rss-widget/index.php';
        $rss_items = [];
        try {
            $response = Http::get($api_url);
            if ($response->successful()) {
                $data = $response->json();
                if (is_array($data)) {
                    foreach (array_slice($data, 0, 16) as $item) {
                        $rss_items[] = [
                            'title' => $item['title'] ?? '',
                            'link' => $item['link'] ?? '#',
                            'pubDate' => $item['pubDate'] ?? '',
                            'description' => $item['description'] ?? '',
                            'image' => $item['thumbnail'] ?? '',
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error fetching or parsing JSON feed: ' . $e->getMessage());
        }

        $globalSliderTransitionDuration = Setting::where('key', 'slider_transition_duration_ms')->first();
        $transitionDuration = $globalSliderTransitionDuration ? (int)$globalSliderTransitionDuration->value : 5000;

        $sliderAspectRatio = Setting::where('key', 'slider_aspect_ratio')->first()->value ?? 'aspect-video';
        $sliderAnimationType = Setting::where('key', 'slider_animation_type')->first()->value ?? 'slide';

        // --- START of Laporan Kinerja Logic ---
        $allPermohonans = \App\Models\PermohonanInformasi::all();
        $totalPermohonans = $allPermohonans->count();

        // Ambil 10 Penilaian (Rating) Terbaru untuk Running Ticker
        $latestRatings = \App\Models\PermohonanInformasi::whereNotNull('rating')
            ->with(['user', 'responses' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get()
            ->map(function($permohonan) {
                // Cari pesan terakhir dari pemohon (ini ulasan ratingnya)
                $ratingComment = $permohonan->responses
                    ->where('user_id', $permohonan->user_id)
                    ->first();
                
                $permohonan->rating_comment = $ratingComment ? $ratingComment->message : 'Memberikan penilaian tanpa komentar.';
                return $permohonan;
            });

        // Ambil pemohon yang memberikan rating untuk avatar
        $ratedPermohonans = $latestRatings->take(3);
        
        $totalRatings = \App\Models\PermohonanInformasi::whereNotNull('rating')->count();
        $averageRating = \App\Models\PermohonanInformasi::whereNotNull('rating')->avg('rating');
        $tingkatKepuasan = $averageRating !== null ? round(($averageRating / 5) * 100) : 0; 

        // Rata-rata Waktu Respon (Average Response Time)
        $completedPermohonans = $allPermohonans->where('status_permohonan', 'selesai');
        $totalResponseTime = 0;
        $completedCount = $completedPermohonans->count();

        foreach ($completedPermohonans as $permohonan) {
            // Assuming updated_at is the completion timestamp
            $createdAt = \Carbon\Carbon::parse($permohonan->created_at);
            $updatedAt = \Carbon\Carbon::parse($permohonan->updated_at);
            // Use diffInDays and ensure at least 1 day if it's the same day
            $diff = $updatedAt->diffInDays($createdAt);
            $totalResponseTime += max(1, $diff);
        }
        $rataRataWaktuRespon = $completedCount > 0 ? round($totalResponseTime / $completedCount) : 0; // In days
        if ($rataRataWaktuRespon === 0 && $completedCount > 0) {
            $rataRataWaktuRespon = 1;
        }

        // Tingkat Penyelesaian Permohonan (Request Completion Rate)
        $tingkatPenyelesaian = $totalPermohonans > 0 ? round(($completedCount / $totalPermohonans) * 100) : 0;
        // --- END of Laporan Kinerja Logic ---

        $latestInformasis = Informasi::with(['user', 'organization'])->latest()->take(16)->get();
        $unitMap = collect($this->getUnitData());

        return view('frontend.home', compact('sliders', 'berita', 'galeri', 'frontendStats', 'rss_items', 'contactInfo', 'transitionDuration', 'tingkatKepuasan', 'rataRataWaktuRespon', 'tingkatPenyelesaian', 'latestInformasis', 'unitMap', 'sliderAspectRatio', 'sliderAnimationType', 'ratedPermohonans', 'latestRatings'));
    }

    public function allGaleri()
    {
        $galeri = Galeri::orderBy('created_at', 'desc')->paginate(12); // Fetch all galleries, paginated
        
        $breadcrumbs = [
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Galeri', 'url' => '#', 'icon' => 'fas fa-images'],
        ];

        return view('frontend.galeri.all', compact('galeri', 'breadcrumbs'));
    }
    
    // ... (rest of the controller methods remain the same)
    
    public function debugUser()
    {
        $user = Auth::user();
        return view('debug.user', compact('user'));
    }

    public function showByCategory($category)
    {
        // ... (existing code)
    }

    public function informasiByCategory(Request $request, $category)
    {
        $pageTitle = 'Informasi ' . ucwords(str_replace('-', ' ', $category));
        
        $query = Informasi::query()->where('category', $pageTitle);

        $unitMap = $this->getUnitData(); // Moved this line here


        // Check for status filter first
        $searchTerm = $request->input('search');
        $isStatusFilter = false;
        if ($searchTerm) {
            $lowerSearchTerm = strtolower($searchTerm);
            if ($lowerSearchTerm === 'berlaku') {
                $query->where('status', 'BERLAKU');
                $isStatusFilter = true;
            } elseif ($lowerSearchTerm === 'arsip') {
                $query->where('status', 'ARSIP');
                $isStatusFilter = true;
            } elseif ($lowerSearchTerm === 'aktif') { // Also handle 'aktif' status for old records
                $query->where('status', 'aktif');
                $isStatusFilter = true;
            } elseif ($lowerSearchTerm === 'nonaktif') { // Also handle 'nonaktif' status for old records
                $query->where('status', 'nonaktif');
                $isStatusFilter = true;
            }
        }

        // Apply title/description search filter only if it's not a status filter
        if ($request->has('search') && $request->search != '' && !$isStatusFilter) {
            $searchTerm = $request->search;
            $matchingUnitIds = [];

            // Find unit_ids that match the search term in unit_nama
            foreach ($unitMap as $unitId => $unit) {
                if (stripos($unit['unit_nama'], $searchTerm) !== false) {
                    $matchingUnitIds[] = $unitId;
                }
            }

            $query->where(function($q) use ($searchTerm, $matchingUnitIds) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%');

                if (!empty($matchingUnitIds)) {
                    $q->orWhereIn('unit_id', $matchingUnitIds);
                }
            });
        }

        // Apply date filters
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('tanggal_upload', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('tanggal_upload', '<=', $request->date_to);
        }
        
        // Apply sorting
        $sort = $request->get('sort', 'tanggal_upload_desc');
        switch ($sort) {
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'tanggal_upload_asc':
                $query->orderBy('tanggal_upload', 'asc');
                break;
            case 'tanggal_upload_desc':
                $query->orderBy('tanggal_upload', 'desc');
                break;
            default:
                $query->orderBy('tanggal_upload', 'desc');
                break;
        }

        $perPage = $request->get('per_page', 10);
        $informasis = $query->paginate($perPage);
        
        $unitData = $this->getUnitData();
        $unitMap = collect($unitData); // Ensure it's a Collection

        $breadcrumbs = [
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
        ];

        // Dynamically get icon from menu config
        $menuConfig = config('menu');
        $categoryIcon = 'fas fa-folder-open'; // Default icon
        foreach ($menuConfig as $menuItem) {
            if (isset($menuItem['children'])) {
                foreach ($menuItem['children'] as $childItem) {
                    if (isset($childItem['title']) && $childItem['title'] === $pageTitle) {
                        $categoryIcon = 'fas fa-' . $childItem['icon'];
                        break 2; // Break from both loops
                    }
                }
            }
        }
        $breadcrumbs[] = ['title' => $pageTitle, 'url' => '', 'icon' => $categoryIcon];

        return view('frontend.informasi.category', compact('informasis', 'pageTitle', 'unitMap', 'breadcrumbs'));
    }
    
    private function getUnitData()
    {
        return GeneralHelper::getUnitData();
    }

    public function show(Informasi $informasi)
    {
        // ... (existing code)
    }

    public function detailBySlug($slug)
    {
        $informasi = Informasi::with(['official.position', 'organization'])->where('slug', $slug)->firstOrFail();
        
        // 1. If this is an official profile, redirect directly to the official's profile page
        if ($informasi->official) {
            $official = $informasi->official;
            $positionSlug = $official->position->slug ?? '';

            switch ($positionSlug) {
                case 'bupati-sinjai':
                    return redirect()->route('official.bupati');
                case 'wakil-bupati-sinjai':
                    return redirect()->route('official.wakil-bupati');
                case 'sekretaris-daerah-sinjai':
                    return redirect()->route('official.sekretaris-daerah');
                default:
                    return redirect()->route('official.profile.show', $official->slug);
            }
        }

        // 2. If this is an organization profile (Struktur Organisasi), redirect to the OPD detail page
        if (strpos($informasi->content, 'struktur_organisasi_') === 0) {
            $orgId = str_replace('struktur_organisasi_', '', $informasi->content);
            $organization = \App\Models\Organization::find($orgId);
            if ($organization) {
                return redirect()->route('opd.detail', $organization->slug);
            }
        }

        $informasi->increment('views_count');

        $unitName = '-';
        if ($informasi->unit_id) {
            $unitId = trim((string)$informasi->unit_id);
            $allUnits = $this->getUnitData();
            $unit = $allUnits->get($unitId);
            $unitName = $unit['unit_nama'] ?? 'Unit Kerja Tidak Terdaftar';
        } elseif ($informasi->user && $informasi->user->opd_name) {
            $unitName = $informasi->user->opd_name;
        }
        
        $officialProfileUrl = null;
        // (Removing previous logic here as it's now handled by the redirect above)

        $previousParams = session('previous_informasi_params');

        $uploaderName = 'Tidak Diketahui';
        if ($informasi->user) {
            $user = $informasi->user;
            if ($user->isSuperAdmin()) {
                // If it's a superadmin and they uploaded to a different unit, show "Admin PPID [Unit Name]"
                if ($informasi->unit_id && (string)$informasi->unit_id !== (string)$user->unit_id) {
                    $uploaderName = 'Admin PPID ' . $unitName;
                } else {
                    $uploaderName = $user->name;
                }
            } else {
                // For regular admins, just show their name
                $uploaderName = $user->name;
            }
        } else {
            // Fallback for records where user_id is NULL (likely uploaded by superadmin before fix)
            $uploaderName = 'Admin PPID ' . $unitName;
        }

        return view('frontend.informasi.detail', compact('informasi', 'unitName', 'previousParams', 'officialProfileUrl', 'uploaderName'));
    }

    public function download($id)
    {
        $informasi = Informasi::findOrFail($id);

        if ($informasi->file && Storage::disk('public')->exists($informasi->file)) {
            $informasi->increment('download_count');
            return Storage::disk('public')->download($informasi->file);
        }

        abort(404, 'File not found.');
    }

    public function visitUrl($id)
    {
        $informasi = Informasi::findOrFail($id);
        $informasi->increment('download_count');

        return redirect()->away($informasi->url);
    }

    public function page($page, $subpage = null)
    {
        $viewName = "frontend.pages.{$page}";
        if ($subpage) {
            $viewName .= ".{$subpage}";
        }

        if (view()->exists($viewName)) {
            $data = [];
            
            // Logic specific for 'laporan/survei'
            if ($page === 'laporan' && $subpage === 'survei') {
                $surveys = \App\Models\Survey::whereIn('type', ['default', 'skm', 'ppid'])
                                    ->where('status', 'Aktif')
                                    ->latest()
                                    ->get();
                $data['surveys'] = $surveys;
                // Keep defaultSurvey for backward compatibility if needed, but we'll use surveys in the view
                $data['defaultSurvey'] = $surveys->where('type', 'default')->first();
            }

            // Logic specific for 'laporan/ppid'
            if ($page === 'laporan' && $subpage === 'ppid') {
                $laporans = \App\Models\Laporan::where('type', 'tahunan')
                                    ->where('published', true)
                                    ->orderBy('tahun', 'desc')
                                    ->latest()
                                    ->get();
                $data['laporans'] = $laporans;
            }

            return view($viewName, $data);
        }

        abort(404);
    }
    
    private function getPositionsTree($organizationId, $parentId = null)
    {
        // ... (existing code)
    }
    
    private function countMembersInSubtree($position, &$organization)
    {
        // ... (existing code)
    }
    
    private function countMembersInTree($positions)
    {
        // ... (existing code)
    }
    
    private function generateOrganizationalChartSvg($positions, $orgName)
    {
        // ... (existing code)
    }
    
    private function calculateLayout($positions)
    {
        // ... (existing code)
    }
    
    private function organizeByLevel($positions, &$result, $level)
    {
        // ... (existing code)
    }
    
    public function organizationDetail(\App\Models\Organization $organization)
    {
        // ... (existing code)
    }
    
    private function buildChartNodesForOrganization($positions, $orgId, $parentId = null)
    {
        // ... (existing code)
    }

    public function opdList()
    {
        $organizations = \App\Models\Organization::with('strukturOrganisasi.informasi')->get();
        $user = auth()->user();
        $api_unit_id = null;

        if ($user && $user->nip) {
            $apiData = \App\Models\User::getDataFromApi($user->nip);
            if (isset($apiData['unit_id'])) {
                $api_unit_id = $apiData['unit_id'];
            }
        }

        // Fetch unit data from API
        $unitData = collect($this->getUnitData());

        // Map API address and Group Organizations
        $groupedOrganizations = [
            'Organisasi Perangkat Daerah' => [],
            'Wilayah Kecamatan' => [],
            'Wilayah Desa & Kelurahan' => [],
            'Lembaga Lainnya' => []
        ];

        $organizations->each(function ($organization) use ($unitData, &$groupedOrganizations) {
            // Exclude Government card
            if (stripos($organization->name, 'PEMERINTAH DAERAH KABUPATEN SINJAI') !== false) {
                return;
            }

            $matchingUnit = $unitData->get($organization->remote_id);
            if ($matchingUnit) {
                // Check if unit_alamat from API is explicitly '0', null, or empty
                if (empty($matchingUnit['unit_alamat']) || $matchingUnit['unit_alamat'] === '0') {
                    $organization->api_address = 'Alamat belum ditambahkan';
                } else {
                    $organization->api_address = $matchingUnit['unit_alamat'];
                }
            } else {
                $organization->api_address = 'Alamat belum ditambahkan';
            }

            // Specific Address Overrides based on User Request
            if (stripos($organization->name, 'Inspektorat') !== false) {
                $organization->api_address = 'Tanassang, Kel. Alehanuae, Kec. Sinjai Utara, Kab. Sinjai, Prov. Sulawesi Selatan. Kode Pos 92616';
            } elseif (stripos($organization->name, 'Satuan Polisi Pamong Praja') !== false) {
                $organization->api_address = 'Lingk. Tanassang Kel. Alehanuae Kec. Sinjai Utara Kab. Sinjai Telp. (0482) 23305 Kode Pos 92611';
            }

            // Grouping Logic
            $name = $organization->name;
            if (stripos($name, 'Desa') !== false || stripos($name, 'Kelurahan') !== false) {
                $groupedOrganizations['Wilayah Desa & Kelurahan'][] = $organization;
            } elseif (stripos($name, 'Kecamatan') !== false) {
                $groupedOrganizations['Wilayah Kecamatan'][] = $organization;
            } elseif (
                stripos($name, 'Dinas') !== false || 
                stripos($name, 'Badan') !== false || 
                stripos($name, 'Kantor') !== false || 
                stripos($name, 'Bagian') !== false || 
                stripos($name, 'Sekretariat') !== false ||
                stripos($name, 'Satuan') !== false ||
                stripos($name, 'Inspektorat') !== false ||
                stripos($name, 'Rumah Sakit') !== false
            ) {
                $groupedOrganizations['Organisasi Perangkat Daerah'][] = $organization;
            } else {
                $groupedOrganizations['Lembaga Lainnya'][] = $organization;
            }
        });

        // Remove empty groups
        $groupedOrganizations = array_filter($groupedOrganizations, function($group) {
            return count($group) > 0;
        });

        return view('frontend.opd.list', compact('groupedOrganizations', 'user', 'api_unit_id'));
    }

    public function opdDetail(\App\Models\Organization $organization)
    {
        $informasi = Informasi::where('content', 'struktur_organisasi_' . $organization->id)->first();
        return view('frontend.opd.detail', compact('organization', 'informasi'));
    }

    /**
     * Show the form for managing the organizational structure from the frontend.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function manageStrukturOrganisasiPublic(\App\Models\Organization $organization)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Anda harus login untuk mengakses halaman ini.');
        }

        $hasAccess = false;

        // 1. Cek unit_id lokal user
        if ($user->unit_id && (string)$user->unit_id === (string)$organization->remote_id) {
            $hasAccess = true;
        }

        // 2. Cek unit_id dari API (fallback jika lokal tidak cocok atau kosong)
        if (!$hasAccess && $user->nip) {
            $apiData = \App\Models\User::getDataFromApi($user->nip);
            $api_unit_id = $apiData['unit_id'] ?? null;
            
            if (!is_null($api_unit_id) && (string)$api_unit_id === (string)$organization->remote_id) {
                $hasAccess = true;
            }
        }

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola profil OPD ini. Akses hanya diberikan sesuai dengan unit kerja yang terdaftar pada NIP Anda.');
        }

        $struktur = \App\Models\StrukturOrganisasi::firstOrCreate(
            ['organization_id' => $organization->id],
            ['title' => 'Struktur ' . $organization->name]
        );

        return view('frontend.opd.manage-public', compact('organization', 'struktur'));
    }


    /**
     * Update the organizational structure details from the frontend.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function updateStrukturOrganisasiPublic(Request $request, \App\Models\Organization $organization)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Anda harus login untuk mengakses halaman ini.');
        }

        $hasAccess = false;

        // 1. Cek unit_id lokal
        if ($user->unit_id && (string)$user->unit_id === (string)$organization->remote_id) {
            $hasAccess = true;
        }

        // 2. Cek unit_id dari API
        if (!$hasAccess && $user->nip) {
            $apiData = \App\Models\User::getDataFromApi($user->nip);
            $api_unit_id = $apiData['unit_id'] ?? null;
            
            if (!is_null($api_unit_id) && (string)$api_unit_id === (string)$organization->remote_id) {
                $hasAccess = true;
            }
        }

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola profil OPD ini.');
        }

        $request->validate([
            'structure_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // 10 MB
            'website_url' => 'nullable|url',
        ]);

        $struktur = \App\Models\StrukturOrganisasi::firstOrCreate(
            ['organization_id' => $organization->id]
        );

        if ($request->hasFile('structure_image')) {
            $path = $this->processImage($request->file('structure_image'), 'struktur_organisasi');
            if ($struktur->image_path) {
                Storage::disk('public')->delete($struktur->image_path);
            }
            $struktur->image_path = $path;
        }
        
        $struktur->title = 'Struktur ' . $organization->name;
        $struktur->save();

        // Save the website_url to the organization
        $organization->website_url = $request->website_url;
        $organization->save(); // Save the organization model

        // Now, update or create the corresponding Informasi record
        $informasi = Informasi::firstOrNew(
            ['content' => 'struktur_organisasi_' . $organization->id]
        );

        // Set the data for a new record
        if (!$informasi->exists) {
            $informasi->fill([
                'title' => 'Profil ' . $organization->name,
                'deskripsi' => 'Informasi mengenai profil ' . $organization->name . ', termasuk struktur organisasi dan tautan situs web.',
                'status' => 'aktif',
                'category' => 'Informasi Berkala',
                'jenis_dokumen' => 'Profil Badan Publik',
                'user_id' => Auth::id(),
                'unit_id' => $organization->unit_id ?? Auth::user()->unit_id,
                'tahun' => now()->year,
                'tanggal_upload' => now()->toDateString(),
            ]);
        }

        // Update URL and image path if they exist
        $informasi->url = $request->website_url;
        if ($struktur->image_path) {
            $informasi->file = $struktur->image_path;
        }
        
        $informasi->save();

        return redirect()->back()->with('success', 'Struktur organisasi berhasil diperbarui.');
    }

    /**
     * Process the uploaded image: convert to WebP and save.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @return string The path to the saved image.
     */
    private function processImage($file, $directory)
    {
        $imageManager = new ImageManager(new Driver());
        $image = $imageManager->read($file->path());

        // Encode the image to WebP format with 80% quality
        $encodedImage = $image->toWebp(80);

        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.webp';
        $path = $directory . '/' . $fileName;

        Storage::disk('public')->put($path, (string) $encodedImage);

        return $path;
    }

    public function submitContactForm(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            // For now, just log the data. In a real application, you'd store this
            // in a database, send an email, or use a notification system.
            \Illuminate\Support\Facades\Log::info('New contact form submission:', $validatedData);

            return response()->json(['message' => 'Pesan berhasil dikirim!'], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Terdapat kesalahan dalam pengisian form.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error submitting contact form: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan pada server. Silakan coba lagi.'], 500);
        }
    }

    public function laporanPpid()
    {
        // Get all published reports, sorted by year descending
        $laporans = \App\Models\Laporan::where('published', true)
                                    ->orderBy('tahun', 'desc')
                                    ->get()
                                    ->map(function($laporan) {
                                        $laporan->encoded_id = strtoupper(base_convert(($laporan->id + 100000000) * 7, 10, 36));
                                        return $laporan;
                                    });

        $breadcrumbs = [
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Laporan PPID', 'url' => '#', 'icon' => 'fas fa-file-alt'],
        ];

        return view('frontend.pages.laporan.ppid', compact('laporans', 'breadcrumbs'));
    }

    public function previewLaporan($token)
    {
        try {
            $id = (base_convert(strtolower($token), 36, 10) / 7) - 100000000;
            $laporan = \App\Models\Laporan::findOrFail($id);
            return view('frontend.pages.laporan.preview', compact('laporan', 'token'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function serveLaporanFile($token)
    {
        try {
            $id = (base_convert(strtolower($token), 36, 10) / 7) - 100000000;
            $laporan = \App\Models\Laporan::findOrFail($id);
            
            $disk = \Illuminate\Support\Facades\Storage::disk('public');

            if (!$laporan->file || !$disk->exists($laporan->file)) {
                abort(404, 'File not found');
            }

            $path = $disk->path($laporan->file);

            return response()->file($path, [
                'Content-Type' => 'application/octet-stream',
            ]);
        } catch (\Exception $e) {
            abort(404);
        }
    }
    /**
     * Display the active Profil PPID on the frontend.
     */
    public function showProfilPpid()
    {
        $profilPpid = \App\Models\ProfilPpid::where('status', true)->first();

        // If no active profile found, you might want to show a 404 page or a default message
        if (!$profilPpid) {
            abort(404, 'Profil PPID aktif tidak ditemukan.');
        }

        return view('frontend.profil.show', compact('profilPpid'));
    }

    public function editPimpinanPublic(Official $official)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Anda harus login untuk mengakses halaman ini.');
        }

        $api_unit_id = null;
        if ($user->nip) {
            $apiData = \App\Models\User::getDataFromApi($user->nip);
            if (isset($apiData['unit_id'])) {
                $api_unit_id = $apiData['unit_id'];
            }
        }
        
        if (is_null($api_unit_id) || !isset($official->organization) || (string)$api_unit_id !== (string)$official->organization->remote_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola pimpinan ini.');
        }

        return view('frontend.profil.edit-pimpinan', compact('official'));
    }


    public function updatePimpinanPublic(Request $request, Official $official)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Anda harus login untuk mengakses halaman ini.');
        }

        $api_unit_id = null;
        if ($user->nip) {
            $apiData = \App\Models\User::getDataFromApi($user->nip);
            if (isset($apiData['unit_id'])) {
                $api_unit_id = $apiData['unit_id'];
            }
        }
        
        if (is_null($api_unit_id) || !isset($official->organization) || (string)$api_unit_id !== (string)$official->organization->remote_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola pimpinan ini.');
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'religion' => 'nullable|string|max:255',
            'nip' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_term' => 'nullable|date',
            'end_term' => 'nullable|date|after_or_equal:start_term',
            'status' => 'required|in:active,inactive,draft',
            'marital_status' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'home_address' => 'nullable|string',
            'spouse_name' => 'nullable|string|max:255',
            'status_jabatan' => 'nullable|string|max:255',
        ]);

        \Log::info('Updating Official ID: ' . $official->id, $request->except(['photo']));

        DB::transaction(function () use ($request, $official) {
            $photoPath = $official->photo;
            if ($request->hasFile('photo')) {
                if ($official->photo) {
                    Storage::disk('public')->delete($official->photo);
                }
                $photoPath = $request->file('photo')->store('officials', 'public');
            }

            $baseSlug = Str::slug($request->full_name);
            $slug = $baseSlug;
            $counter = 1;
            while (Official::where('slug', $slug)->where('id', '!=', $official->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $official->update([
                'full_name' => $request->full_name,
                'jenis_kelamin' => $request->jenis_kelamin,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'religion' => $request->religion,
                'nip' => $request->nip,
                'biography' => $request->biography,
                'photo' => $photoPath,
                'start_term' => $request->start_term,
                'end_term' => $request->end_term,
                'status' => $request->status,
                'slug' => $slug,
                'marital_status' => $request->marital_status,
                'occupation' => $request->occupation,
                'email' => $request->email,
                'home_address' => $request->home_address,
                'spouse_name' => $request->spouse_name,
                'status_jabatan' => $request->status_jabatan,
            ]);

            // Simplified update for related models: delete and recreate
            $official->careerHistories()->delete();
            if ($request->has('career_histories') && is_array($request->career_histories)) {
                foreach ($request->career_histories as $careerData) {
                    if (!empty($careerData['title'])) {
                        $official->careerHistories()->create([
                            'title' => $careerData['title'],
                            'organization_name' => $careerData['organization_name'] ?? '',
                            'start_year' => $careerData['start_year'] ?? null,
                            'end_year' => $careerData['end_year'] ?? null,
                            'description' => $careerData['description'] ?? null,
                        ]);
                    }
                }
            }

            $official->educations()->delete();
            if ($request->has('educations') && is_array($request->educations)) {
                foreach ($request->educations as $educationData) {
                    if (!empty($educationData['degree'])) {
                        $official->educations()->create([
                            'degree' => $educationData['degree'],
                            'institution' => $educationData['institution'] ?? '',
                            'start_year' => $educationData['start_year'] ?? null,
                            'end_year' => $educationData['end_year'] ?? null,
                        ]);
                    }
                }
            }

            $official->awards()->delete();
            if ($request->has('awards') && is_array($request->awards)) {
                foreach ($request->awards as $awardData) {
                    if (!empty($awardData['title'])) {
                        $official->awards()->create([
                            'title' => $awardData['title'],
                            'issuer' => $awardData['issuer'] ?? '',
                            'year' => $awardData['year'] ?? null,
                            'description' => $awardData['description'] ?? null,
                        ]);
                    }
                }
            }
            
            $official->children()->delete();
            if ($request->has('children') && is_array($request->children)) {
                foreach ($request->children as $childData) {
                    if (!empty($childData['name'])) {
                        $official->children()->create([
                            'name' => $childData['name'],
                            'birth_place' => $childData['birth_place'] ?? null,
                            'birth_date' => $childData['birth_date'] ?? null,
                        ]);
                    }
                }
            }

            $official->trainingHistories()->delete();
            if ($request->has('training_histories') && is_array($request->training_histories)) {
                foreach ($request->training_histories as $trainingData) {
                    if (!empty($trainingData['name'])) {
                        $official->trainingHistories()->create([
                            'name' => $trainingData['name'],
                            'year' => $trainingData['year'] ?? null,
                            'organizer' => $trainingData['organizer'] ?? null,
                        ]);
                    }
                }
            }

            $official->organizationalHistories()->delete();
            if ($request->has('organizational_histories') && is_array($request->organizational_histories)) {
                foreach ($request->organizational_histories as $orgData) {
                    if (!empty($orgData['organization_name'])) {
                        $official->organizationalHistories()->create([
                            'organization_name' => $orgData['organization_name'],
                            'position' => $orgData['position'] ?? '',
                            'start_year' => $orgData['start_year'] ?? null,
                            'end_year' => $orgData['end_year'] ?? null,
                        ]);
                    }
                }
            }

            // Update corresponding Informasi record
            $informasi = Informasi::firstOrNew(['official_id' => $official->id]);
            
            $organizationName = $official->organization->name ?? '';
            $positionName = $official->position ? $official->position->name : 'Pimpinan';

            $dynamicTitle = 'Profil Pimpinan ' . $positionName . ' ' . $organizationName;
            
            // Clean up title (remove double spaces or redundant "Kepala" if necessary)
            $dynamicTitle = preg_replace('/\s+/', ' ', $dynamicTitle);

            $informasi->title = $dynamicTitle;
            $informasi->deskripsi = 'Dokumen ini berisi data dari profil pimpinan.';
            $informasi->content = json_encode($official->load([
                'careerHistories', 'educations', 'awards', 'children', 'trainingHistories', 'organizationalHistories'
            ]));
            $informasi->status = $official->status === 'active' ? 'BERLAKU' : 'ARSIP';
            $informasi->category = 'Informasi Berkala'; // Explicitly set category
            $informasi->jenis_dokumen = 'Profil Badan Publik'; // Explicitly set jenis_dokumen
            $informasi->tahun = $official->start_term ? date('Y', strtotime($official->start_term)) : date('Y');
            $informasi->tanggal_upload = $official->start_term ?? now();
            $informasi->user_id = Auth::id();
            $informasi->unit_id = Auth::user()->unit_id;
            $informasi->save();
        });

        return redirect()->route('official.pejabat-daerah')->with('success', 'Profil pimpinan berhasil diperbarui.');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return redirect()->route('home');
        }

        $informasiResults = Informasi::where('title', 'like', "%{$query}%")
            ->orWhere('deskripsi', 'like', "%{$query}%")
            ->where('published', true)
            ->latest()
            ->take(20)
            ->get();

        $standarLayananResults = SubStandarLayanan::where('title', 'like', "%{$query}%")
            ->latest()
            ->take(10)
            ->get();

        $orgResults = \App\Models\Organization::where('name', 'like', "%{$query}%")
            ->take(10)
            ->get();

        $breadcrumbs = [
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Pencarian', 'url' => '#', 'icon' => 'fas fa-search'],
        ];

        return view('frontend.search', compact('informasiResults', 'standarLayananResults', 'orgResults', 'query', 'breadcrumbs'));
    }

    /**
     * Record a visit for today.
     */
    private function recordVisit()
    {
        $today = Carbon::today()->toDateString();

        \Log::info("Attempting to record visit for today: {$today}");

        $statistik = Statistik::firstOrCreate(
            ['nama' => $today],
            ['jumlah' => 0]
        );

        // Check if a new record was created or an existing one was found
        if ($statistik->wasRecentlyCreated) {
            \Log::info("New Statistik record created for {$today} with initial count 1.");
        } else {
            \Log::info("Existing Statistik record found for {$today}. Current count: {$statistik->jumlah}.");
        }

        $statistik->increment('jumlah');
        \Log::info("Statistik record for {$today} incremented. New count: {$statistik->jumlah}.");
    }
}
