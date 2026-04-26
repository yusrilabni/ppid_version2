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
        
        // --- Chart Data Logic ---
        $totalVisitors = Statistik::sum('jumlah');
        $visitStats = Statistik::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(jumlah) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        $chartLabels = [];
        $chartData = [];
        $months = collect(range(1, 12))->map(function ($month) {
            return Carbon::now()->month($month)->shortMonthName;
        });

        $statsByMonth = $visitStats->keyBy(function ($item) {
            return $item->year . '-' . $item->month;
        });

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $year = $date->year;
            $month = $date->month;
            $key = $year . '-' . $month;
            
            $chartLabels[] = $date->shortMonthName;
            $chartData[] = $statsByMonth->has($key) ? $statsByMonth->get($key)->count : 0;
        }
        // --- End of Chart Data Logic ---






        $informasiBerkalaCount = Informasi::where('category', 'Informasi Berkala')->count();
        $informasiSetiapSaatCount = Informasi::where('category', 'Informasi Setiap Saat')->count();
        $informasiSertaMertaCount = Informasi::where('category', 'Informasi Serta Merta')->count();
        $informasiDikecualikanCount = Informasi::where('category', 'Informasi Dikecualikan')->count();

        // Recent Activity Logic
        $allRecentActivity = $this->getRecentActivity();

        // Widget & RSS Usage Stats
        $externalWebsitesCount = 0;
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('ppid_external_logs')) {
                $externalWebsitesCount = \App\Models\ExternalLinkLog::distinct('domain')->count();
            }
        } catch (\Exception $e) {
            \Log::warning("ExternalLinkLog Error: " . $e->getMessage());
        }

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

        return view('admin.dashboard', compact(
            'stats',
            'allRecentActivity',
            'chartLabels',
            'chartData',
            'externalWebsitesCount'
        ));
    }

    private function getRecentActivity(): Collection
    {
        $recentGaleri = Galeri::latest()->take(5)->get()->map(function ($item) {
            return (object)['type' => 'Galeri', 'title' => $item->title, 'date' => $item->created_at, 'icon' => $item->type === 'foto' ? 'fa-image' : 'fa-video', 'status' => $item->type, 'status_color' => 'blue'];
        });

        $recentInformasi = Informasi::latest()->take(5)->get()->map(function ($item) {
            return (object)['type' => 'Informasi', 'title' => $item->title, 'date' => $item->created_at, 'icon' => 'fa-file-alt', 'status' => $item->category, 'status_color' => 'purple'];
        });
        
        $recentStandarLayanan = SubStandarLayanan::with('standarLayanan')->latest()->take(5)->get()->map(function ($item) {
            return (object)['type' => 'Standar Layanan', 'title' => $item->title, 'date' => $item->created_at, 'icon' => 'fa-clipboard-list', 'status' => $item->standarLayanan->title ?? 'N/A', 'status_color' => 'yellow'];
        });

        return (new Collection)
            ->merge($recentGaleri)
            ->merge($recentInformasi)
            ->merge($recentStandarLayanan)
            ->sortByDesc('date')
            ->take(10);
    }
}
