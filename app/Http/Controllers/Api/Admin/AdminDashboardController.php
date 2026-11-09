<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Slider;
use App\Models\Galeri;
use App\Models\Informasi;
use App\Models\Statistik;
use App\Models\SubStandarLayanan;
use App\Models\PermohonanInformasi;
use App\Models\Laporan;
use App\Models\User;
use App\Models\Official;
use App\Models\Organization;
use App\Models\ProfilPpid;
use App\Models\StrukturOrganisasi;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\ExternalLinkLog;
use App\Models\AiSetting;
use App\Models\AiUsageLog;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = auth('sanctum')->user() ?? $request->user();

        $sliderCount = Slider::count();
        $activeSliderCount = Slider::where('active', true)->count();
        $galeriCount = Galeri::count();
        $fotoGaleriCount = Galeri::where('type', 'foto')->count();
        $videoGaleriCount = Galeri::where('type', 'video')->count();

        $totalInformasiCount = Informasi::count();
        $informasiBerkalaCount = Informasi::where('category', 'Informasi Berkala')->count();
        $informasiSetiapSaatCount = Informasi::where('category', 'Informasi Setiap Saat')->count();
        $informasiSertaMertaCount = Informasi::where('category', 'Informasi Serta Merta')->count();
        $informasiDikecualikanCount = Informasi::where('category', 'Informasi Dikecualikan')->count();

        // Permohonan Informasi
        $permohonanPendingCount = PermohonanInformasi::where('status_permohonan', 'pending')->count();
        $permohonanDiprosesCount = PermohonanInformasi::where('status_permohonan', 'diproses')->count();
        $permohonanSelesaiCount = PermohonanInformasi::where('status_permohonan', 'selesai')->count();
        $totalPermohonanCount = PermohonanInformasi::count();

        // SubStandarLayanan & Laporan
        $subStandarLayananCount = SubStandarLayanan::count();
        $laporanCount = Laporan::count();

        // Users
        $userCount = User::count();
        $superadminCount = User::where('role', 'superadmin')->count();
        $adminCount = User::where('role', 'admin')->count();
        $normalUserCount = $userCount - ($superadminCount + $adminCount);

        // Officials
        $officialCount = Official::count();
        $activeOfficialCount = Official::where('status', 'active')->count();
        $inactiveOfficialCount = Official::where('status', 'inactive')->count();
        $draftOfficialCount = Official::where('status', 'draft')->count();

        // Organizations & Profil
        $organizationCount = Organization::count();
        $profilPpidCount = ProfilPpid::count();
        $activeProfilPpidCount = ProfilPpid::where('status', true)->count();
        $strukturOrganisasiCount = StrukturOrganisasi::count();

        // Surveys
        $surveyCount = Survey::count();
        $activeSurveyCount = Survey::where('status', 'Aktif')->orWhere('is_active', true)->count();
        $surveyResponseCount = SurveyResponse::count();

        // Activity Stats
        $totalViews = Informasi::sum('views_count') + SubStandarLayanan::sum('views_count');
        $totalDownloads = Informasi::sum('download_count') + SubStandarLayanan::sum('download_count');
        $totalVisitors = Statistik::sum('jumlah');

        // Chart Data (30 Hari Terakhir)
        $chartLabels = [];
        $chartData = [];
        try {
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
                $chartData[] = isset($visitStats[$date]) ? (int)$visitStats[$date]->count : 0;
            }
        } catch (\Exception $e) {}

        // External logs
        $externalWebsitesCount = 0;
        $externalLogs = [];
        try {
            if (Schema::hasTable('ppid_external_logs')) {
                $externalWebsitesCount = ExternalLinkLog::distinct('domain')->count();
                $externalLogs = ExternalLinkLog::orderBy('last_access', 'desc')->take(5)->get();
            }
        } catch (\Exception $e) {}

        // AI Stats
        $aiStats = [];
        try {
            $aiTokens = AiSetting::all();
            foreach ($aiTokens as $token) {
                $cacheKey = "ai_usage_token_{$token->id}_" . date('Y-m-d');
                $tokenCountKey = "ai_tokens_count_{$token->id}_" . date('Y-m-d');
                $usage = Cache::get($cacheKey, 0);
                $tokenWords = Cache::get($tokenCountKey, 0);

                $aiStats[] = [
                    'provider' => $token->provider,
                    'model' => $token->model,
                    'is_active' => (bool)$token->is_active,
                    'usage_today' => $usage,
                    'token_words_today' => $tokenWords,
                    'limit_req' => 1500,
                    'remaining_req' => max(0, 1500 - $usage),
                    'limit_tokens' => 1500000,
                    'remaining_tokens' => max(0, 1500000 - $tokenWords),
                ];
            }
        } catch (\Exception $e) {}

        // AI User Stats
        $aiUserStats = [];
        try {
            $aiUsageToday = AiUsageLog::with('user')
                ->where('created_at', '>=', Carbon::now()->startOfDay())
                ->get();
            $unitData = GeneralHelper::getUnitData();

            foreach ($aiUsageToday as $log) {
                $userId = $log->user_id;
                if (!isset($aiUserStats[$userId])) {
                    $u = $log->user;
                    $unitName = 'Super Admin / Umum';
                    if ($u && $u->unit_id && $unitData->has((string)$u->unit_id)) {
                        $unit = $unitData->get((string)$u->unit_id);
                        if (isset($unit['unit_nama'])) {
                            $unitName = $unit['unit_nama'];
                        }
                    }

                    $aiUserStats[$userId] = [
                        'name' => $u ? $u->display_name : 'User Tidak Diketahui',
                        'dinas' => $unitName,
                        'count' => 0
                    ];
                }
                $aiUserStats[$userId]['count']++;
            }
            usort($aiUserStats, function($a, $b) {
                return $b['count'] <=> $a['count'];
            });
        } catch (\Exception $e) {}

        // Recent Activity
        $recentActivity = $this->getRecentActivity();

        $stats = [
            'slider' => ['total' => $sliderCount, 'active' => $activeSliderCount],
            'galeri' => ['total' => $galeriCount, 'foto' => $fotoGaleriCount, 'video' => $videoGaleriCount],
            'informasi' => [
                'total' => $totalInformasiCount,
                'berkala' => $informasiBerkalaCount,
                'setiap_saat' => $informasiSetiapSaatCount,
                'serta_merta' => $informasiSertaMertaCount,
                'dikecualikan' => $informasiDikecualikanCount
            ],
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
            'activity' => [
                'views' => $totalViews,
                'downloads' => $totalDownloads,
                'visitors' => $totalVisitors
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'chart' => [
                    'labels' => $chartLabels,
                    'data' => $chartData,
                ],
                'externalWebsitesCount' => $externalWebsitesCount,
                'externalLogs' => $externalLogs,
                'aiStats' => $aiStats,
                'aiUserStats' => array_values($aiUserStats),
                'recentActivity' => $recentActivity,
            ]
        ]);
    }

    private function getRecentActivity(): array
    {
        try {
            $recentGaleri = Galeri::with('user')->latest()->take(10)->get()->map(function ($item) {
                return [
                    'type' => 'Galeri',
                    'title' => $item->title,
                    'date' => $item->created_at ? $item->created_at->diffForHumans() : '-',
                    'raw_date' => $item->created_at,
                    'icon' => $item->type === 'foto' ? 'fas fa-image' : 'fas fa-video',
                    'status' => $item->type,
                    'uploader' => $item->user->name ?? 'Administrator'
                ];
            });

            $recentInformasi = Informasi::with('user')->latest()->take(10)->get()->map(function ($item) {
                return [
                    'type' => 'Informasi',
                    'title' => $item->title,
                    'date' => $item->created_at ? $item->created_at->diffForHumans() : '-',
                    'raw_date' => $item->created_at,
                    'icon' => 'fas fa-file-alt',
                    'status' => $item->category,
                    'uploader' => $item->user->name ?? 'Administrator'
                ];
            });

            $recentStandar = SubStandarLayanan::with(['standarLayanan', 'user'])->latest()->take(10)->get()->map(function ($item) {
                return [
                    'type' => 'Standar Layanan',
                    'title' => $item->title,
                    'date' => $item->created_at ? $item->created_at->diffForHumans() : '-',
                    'raw_date' => $item->created_at,
                    'icon' => 'fas fa-clipboard-list',
                    'status' => $item->standarLayanan->title ?? 'N/A',
                    'uploader' => $item->user->name ?? 'Administrator'
                ];
            });

            return (new Collection)
                ->merge($recentGaleri)
                ->merge($recentInformasi)
                ->merge($recentStandar)
                ->sortByDesc('raw_date')
                ->values()
                ->take(20)
                ->all();
        } catch (\Exception $e) {
            return [];
        }
    }
}
