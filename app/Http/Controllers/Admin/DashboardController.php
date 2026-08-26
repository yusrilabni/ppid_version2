<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Slider;
use App\Models\Galeri;
use App\Models\Informasi;
use App\Models\Statistik;
use App\Models\SubStandarLayanan;
use App\Models\PermohonanInformasi;
use App\Models\Laporan;

use App\Models\User; // Added
use App\Models\Official; // Added
use App\Models\Organization; // Added
use App\Models\ProfilPpid; // Added
use App\Models\StrukturOrganisasi; // Added
use App\Models\Survey; // Added
use App\Models\SurveyResponse; // Added
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Auto-clear route cache if we just updated routes (temporary fix for RouteNotFoundException)
        if (!\Illuminate\Support\Facades\Cache::has('routes_refreshed_v2')) {
            try {
                \Illuminate\Support\Facades\Artisan::call('route:clear');
                \Illuminate\Support\Facades\Artisan::call('view:clear');
                \Illuminate\Support\Facades\Cache::put('routes_refreshed_v2', true, 60);
            } catch (\Exception $e) {
                \Log::error('Dashboard Auto-Clear Cache Error: ' . $e->getMessage());
            }
        }

        $sliderCount = Slider::count();
        $activeSliderCount = Slider::where('active', true)->count();
        $galeriCount = Galeri::count();
        $fotoGaleriCount = Galeri::where('type', 'foto')->count();
        $videoGaleriCount = Galeri::where('type', 'video')->count();

        $totalInformasiCount = Informasi::count();

        // Permohonan Informasi
        $permohonanPendingCount = PermohonanInformasi::where('status_permohonan', 'pending')->count();
        $permohonanDiprosesCount = PermohonanInformasi::where('status_permohonan', 'diproses')->count();
        $permohonanSelesaiCount = PermohonanInformasi::where('status_permohonan', 'selesai')->count();
        $totalPermohonanCount = PermohonanInformasi::count();

        // SubStandarLayanan
        $subStandarLayananCount = SubStandarLayanan::count();

        // Laporan
        $laporanCount = \App\Models\Laporan::count();



        // Users
        $userCount = \App\Models\User::count();
        $superadminCount = \App\Models\User::where('role', 'superadmin')->count();
        $adminCount = \App\Models\User::where('role', 'admin')->count();
        $normalUserCount = $userCount - ($superadminCount + $adminCount); // Assuming other users are 'normal'

        // Officials
        $officialCount = \App\Models\Official::count();
        $activeOfficialCount = \App\Models\Official::where('status', 'active')->count();
        $inactiveOfficialCount = \App\Models\Official::where('status', 'inactive')->count();
        $draftOfficialCount = \App\Models\Official::where('status', 'draft')->count();

        // Organizations
        $organizationCount = \App\Models\Organization::count();

        // ProfilPpid
        $profilPpidCount = \App\Models\ProfilPpid::count();
        $activeProfilPpidCount = \App\Models\ProfilPpid::where('status', true)->count();

        // StrukturOrganisasi
        $strukturOrganisasiCount = \App\Models\StrukturOrganisasi::count();

        // Surveys
        $surveyCount = \App\Models\Survey::count();
        $activeSurveyCount = \App\Models\Survey::where('status', 'Aktif')->count();
        $surveyResponseCount = \App\Models\SurveyResponse::count();

        // Calculate comprehensive statistics
        $totalViews = Informasi::sum('views_count') + SubStandarLayanan::sum('views_count');
        $totalDownloads = Informasi::sum('download_count') + SubStandarLayanan::sum('download_count');
        
        $latestVisitorRecord = Statistik::latest('nama')->first();
        $latestVisitorsCount = $latestVisitorRecord ? $latestVisitorRecord->jumlah : 0;
        
        // --- Chart Data Logic (Last 30 Days Daily) ---
        $chartLabels = [];
        $chartData = [];

        $visitStats = Statistik::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(jumlah) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $label = Carbon::now()->subDays($i)->isoFormat('DD MMM');

            $chartLabels[] = $label;
            $chartData[] = isset($visitStats[$date]) ? $visitStats[$date]->count : 0;
        }
        // --- End of Chart Data Logic ---

        $totalVisitors = Statistik::sum('jumlah');






        $informasiBerkalaCount = Informasi::where('category', 'Informasi Berkala')->count();
        $informasiSetiapSaatCount = Informasi::where('category', 'Informasi Setiap Saat')->count();
        $informasiSertaMertaCount = Informasi::where('category', 'Informasi Serta Merta')->count();
        $informasiDikecualikanCount = Informasi::where('category', 'Informasi Dikecualikan')->count();

        // Recent Activity Logic
        $allRecentActivity = $this->getRecentActivity();

        // Widget & RSS Usage Stats
        $externalWebsitesCount = 0;
        $externalLogs = collect();
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('ppid_external_logs')) {
                $externalWebsitesCount = \App\Models\ExternalLinkLog::distinct('domain')->count();
                $externalLogs = \App\Models\ExternalLinkLog::orderBy('last_access', 'desc')->take(5)->get();
            }
        } catch (\Exception $e) {
            \Log::warning("ExternalLinkLog Error: " . $e->getMessage());
        }

        // AI Token Usage Stats
        $aiTokens = \App\Models\AiSetting::all();
        $aiStats = [];
        foreach($aiTokens as $token) {
            $cacheKey = "ai_usage_token_{$token->id}_" . date('Y-m-d');
            $tokenCountKey = "ai_tokens_count_{$token->id}_" . date('Y-m-d');
            
            $usage = \Illuminate\Support\Facades\Cache::get($cacheKey, 0);
            $tokenWords = \Illuminate\Support\Facades\Cache::get($tokenCountKey, 0);
            
            $aiStats[] = [
                'provider' => $token->provider,
                'model' => $token->model,
                'is_active' => $token->is_active,
                'usage_today' => $usage,
                'token_words_today' => $tokenWords,
                'limit_req' => 1500,
                'remaining_req' => max(0, 1500 - $usage),
                'limit_tokens' => 1500000,
                'remaining_tokens' => max(0, 1500000 - $tokenWords),
            ];
        }

        // AI Usage User Details
        $aiUsageToday = \App\Models\AiUsageLog::with('user')
            ->where('created_at', '>=', \Carbon\Carbon::now()->startOfDay())
            ->get();
            
        $unitData = \App\Helpers\GeneralHelper::getUnitData();
        $aiUserStats = [];
        
        foreach($aiUsageToday as $log) {
            $userId = $log->user_id;
            if (!isset($aiUserStats[$userId])) {
                $user = $log->user;
                $unitName = 'Super Admin / Umum';
                if ($user && $user->unit_id) {
                    $unit = $unitData->get((string)$user->unit_id);
                    if ($unit && isset($unit['unit_nama'])) {
                        $unitName = $unit['unit_nama'];
                    }
                }
                
                $aiUserStats[$userId] = [
                    'name' => $user ? $user->display_name : 'User Tidak Diketahui',
                    'dinas' => $unitName,
                    'count' => 0
                ];
            }
            $aiUserStats[$userId]['count']++;
        }
        
        // Sort users by highest usage
        usort($aiUserStats, function($a, $b) {
            return $b['count'] <=> $a['count'];
        });

        $stats = [

            'slider' => ['total' => $sliderCount, 'active' => $activeSliderCount],
            'galeri' => ['total' => $galeriCount, 'foto' => $fotoGaleriCount, 'video' => $videoGaleriCount],
            'informasi' => ['total' => $totalInformasiCount, 'berkala' => $informasiBerkalaCount, 'setiap_saat' => $informasiSetiapSaatCount, 'serta_merta' => $informasiSertaMertaCount, 'dikecualikan' => $informasiDikecualikanCount],
            'permohonan' => [
                'total' => $totalPermohonanCount,
                'pending' => $permohonanPendingCount,
                'diproses' => $permohonanDiprosesCount,
                'selesai' => $permohonanSelesaiCount,
            ],
            'sub_standar_layanan' => ['total' => $subStandarLayananCount],
            'laporan' => ['total' => $laporanCount],
            'user' => [
                'total' => $userCount,
                'superadmin' => $superadminCount,
                'admin' => $adminCount,
                'normal' => $normalUserCount,
            ],
            'official' => [
                'total' => $officialCount,
                'active' => $activeOfficialCount,
                'inactive' => $inactiveOfficialCount,
                'draft' => $draftOfficialCount,
            ],
            'organization' => ['total' => $organizationCount],
            'profil_ppid' => ['total' => $profilPpidCount, 'active' => $activeProfilPpidCount],
            'struktur_organisasi' => ['total' => $strukturOrganisasiCount],
            'survey' => ['total' => $surveyCount, 'active' => $activeSurveyCount],
            'survey_response' => ['total' => $surveyResponseCount],
            'activity' => ['views' => $totalViews, 'downloads' => $totalDownloads, 'visitors' => $totalVisitors, 'latest_visitors' => $latestVisitorsCount],

        ];

        $latestLogins = \App\Models\User::whereNotNull('last_login_at')
            ->orderBy('last_login_at', 'desc')
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'allRecentActivity',
            'chartLabels',
            'chartData',
            'externalWebsitesCount',
            'externalLogs',
            'aiStats',
            'aiUserStats',
            'latestLogins'
        ));
    }

    private function getRecentActivity(): Collection
    {
        $recentGaleri = Galeri::with('user')->latest()->take(20)->get()->map(function ($item) {
            return (object)[
                'type' => 'Galeri', 
                'title' => $item->title, 
                'date' => $item->created_at, 
                'icon' => $item->type === 'foto' ? 'fa-image' : 'fa-video', 
                'status' => $item->type, 
                'status_color' => 'blue',
                'uploader_name' => $item->user->name ?? 'Administrator'
            ];
        });

        $recentInformasi = Informasi::with('user')->latest()->take(20)->get()->map(function ($item) {
            return (object)[
                'type' => 'Informasi', 
                'title' => $item->title, 
                'date' => $item->created_at, 
                'icon' => 'fa-file-alt', 
                'status' => $item->category, 
                'status_color' => 'purple',
                'uploader_name' => $item->user->name ?? 'Administrator'
            ];
        });
        
        $recentStandarLayanan = SubStandarLayanan::with(['standarLayanan', 'user'])->latest()->take(20)->get()->map(function ($item) {
            return (object)[
                'type' => 'Standar Layanan', 
                'title' => $item->title, 
                'date' => $item->created_at, 
                'icon' => 'fa-clipboard-list', 
                'status' => $item->standarLayanan->title ?? 'N/A', 
                'status_color' => 'yellow',
                'uploader_name' => $item->user->name ?? 'Administrator'
            ];
        });

        return (new Collection)
            ->merge($recentGaleri)
            ->merge($recentInformasi)
            ->merge($recentStandarLayanan)
            ->sortByDesc('date')
            ->take(30);
    }
}
