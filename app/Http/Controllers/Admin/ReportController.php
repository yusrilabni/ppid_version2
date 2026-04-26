<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Informasi;
use App\Models\PermohonanInformasi;
use App\Models\Statistik;
use App\Models\SurveyResponse;
use App\Models\Survey; // Import Survey
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SurveyReportsExport;
use App\Exports\AllReportsMultiSheetExport; // Add this new use statement
use App\Exports\InformasiReportsExport;
use App\Exports\PermohonanReportsExport;
use App\Exports\VisitorReportsExport;
use Illuminate\Support\Facades\Http; // Import Http facade
use Illuminate\Support\Facades\Cache; // Import Cache facade
use App\Models\User; // To check user's unit_id if needed
use App\Models\Organization;
use App\Models\Official;
use App\Models\Slider;
use App\Models\Galeri;
use App\Models\SubStandarLayanan;
use App\Models\Laporan;
use App\Helpers\GeneralHelper;

class ReportController extends Controller
{
    private function getUnitData()
    {
        return GeneralHelper::getUnitData();
    }

    public function index(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();

        $unitMap = $this->getUnitData();
        $selectedUnitId = $request->input('unit_id');

        // Total Reports
        $totalInformasi = Informasi::when($request->filled('start_date'), function ($query) use ($startDate) {
                                return $query->where('created_at', '>=', $startDate);
                            })
                            ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                return $query->where('created_at', '<=', $endDate->endOfDay());
                            })
                            ->when($selectedUnitId, function ($query) use ($selectedUnitId) {
                                return $query->where('unit_id', $selectedUnitId);
                            })
                            ->count();

        $totalPermohonan = PermohonanInformasi::when($request->filled('start_date'), function ($query) use ($startDate) {
                                return $query->where('created_at', '>=', $startDate);
                            })
                            ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                return $query->where('created_at', '<=', $endDate->endOfDay());
                            })
                            ->when($selectedUnitId, function ($query) use ($selectedUnitId) {
                                return $query->whereHas('user', function ($q) use ($selectedUnitId) {
                                    $q->where('unit_id', $selectedUnitId);
                                });
                            })
                            ->count();

        $totalSurveyResponses = SurveyResponse::when($request->filled('start_date'), function ($query) use ($startDate) {
                                return $query->where('created_at', '>=', $startDate);
                            })
                            ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                return $query->where('created_at', '<=', $endDate->endOfDay());
                            })
                            ->whereHas('survey', function ($query) { // Filter by active survey
                                $query->where('status', 'active');
                            })
                            ->when($selectedUnitId, function ($query) use ($selectedUnitId) {
                                return $query->whereHas('user', function ($q) use ($selectedUnitId) {
                                    $q->where('unit_id', $selectedUnitId);
                                });
                            })
                            ->count();
        
        // Corrected calculation for total visits (sum of all entries in Statistik for the period)
        $totalVisits = Statistik::when($request->filled('start_date'), function ($query) use ($startDate) {
                                return $query->whereDate('nama', '>=', $startDate);
                            })
                            ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                return $query->whereDate('nama', '<=', $endDate->endOfDay());
                            })
                            ->sum('jumlah');

        // Views are now handled by incrementing 'views_count' in Informasi model,
        // so this aggregate from Statistik is not directly equivalent to 'page views'.
        // If 'views' specifically means page views on Statistik table, this part needs re-evaluation.
        // For now, assuming 'totalVisits' covers the general access.
        $totalPageViews = 0; // Set to 0 or derive from elsewhere if needed.

        $totalDownloads = Informasi::when($request->filled('start_date'), function ($query) use ($startDate) {
                                return $query->where('created_at', '>=', $startDate);
                            })
                            ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                return $query->where('created_at', '<=', $endDate->endOfDay());
                            })
                            ->sum('download_count');


        $totalReportsData = [
            'totalInformasi' => $totalInformasi,
            'totalPermohonan' => $totalPermohonan,
            'totalSurveyResponses' => $totalSurveyResponses, // Add this
            'totalVisits' => $totalVisits,
            'totalPageViews' => $totalPageViews, // Using new name
            'totalDownloads' => $totalDownloads,
        ];

        // Informasi Reports
        $informasiReports = Informasi::when($request->filled('start_date'), function ($query) use ($startDate) {
                                return $query->where('created_at', '>=', $startDate);
                            })
                            ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                return $query->where('created_at', '<=', $endDate->endOfDay());
                            })
                            ->when($selectedUnitId, function ($query) use ($selectedUnitId) {
                                return $query->where('unit_id', $selectedUnitId);
                            })
                            ->with('organization') // Eager load organization
                            ->latest()
                            ->paginate(10, ['*'], 'informasi_page');

        // Permohonan Reports
        $permohonanReports = PermohonanInformasi::when($request->filled('start_date'), function ($query) use ($startDate) {
                                    return $query->where('created_at', '>=', $startDate);
                                })
                                ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                    return $query->where('created_at', '<=', $endDate->endOfDay());
                                })
                                ->when($selectedUnitId, function ($query) use ($selectedUnitId) {
                                    $query->whereHas('user', function ($q) use ($selectedUnitId) {
                                        $q->where('unit_id', $selectedUnitId);
                                    });
                                })
                                ->latest()
                                ->paginate(10, ['*'], 'permohonan_page');

        // Visitor Reports
        $visitorReports = Statistik::when($request->filled('start_date'), function ($query) use ($startDate) {
                                return $query->where('created_at', '>=', $startDate);
                            })
                            ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                return $query->where('created_at', '<=', $endDate->endOfDay());
                            })
                            ->selectRaw('DATE(created_at) as report_date, SUM(CASE WHEN nama = "visitors" THEN jumlah ELSE 0 END) as visitors_count, SUM(CASE WHEN nama = "views" THEN jumlah ELSE 0 END) as views_count')
                            ->groupBy('report_date')
                            ->orderBy('report_date', 'desc')
                            ->paginate(10, ['*'], 'visitor_page');

        // Survey Reports
        $surveyReports = SurveyResponse::when($request->filled('start_date'), function ($query) use ($startDate) {
                                return $query->where('created_at', '>=', $startDate);
                            })
                            ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                return $query->where('created_at', '<=', $endDate->endOfDay());
                            })
                            ->whereHas('survey', function ($query) { // Filter by active survey
                                $query->where('status', 'active');
                            })
                            ->when($selectedUnitId, function ($query) use ($selectedUnitId) {
                                return $query->whereHas('user', function ($q) use ($selectedUnitId) {
                                    $q->where('unit_id', $selectedUnitId);
                                });
                            })
                            ->with('survey') // Eager load the related survey
                            ->latest()
                            ->paginate(10, ['*'], 'survey_page');


        // Prepare dashboard-like statistics, filtered by date range
        $dashboardStatsForReports = [
            'totalInformasiCount' => Informasi::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                            ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', $endDate->endOfDay()))
                                            ->when($selectedUnitId, fn ($query) => $query->where('unit_id', $selectedUnitId))
                                            ->count(),

            'totalPermohonanCount' => PermohonanInformasi::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                                        ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', $endDate->endOfDay()))
                                                        ->when($selectedUnitId, fn ($query) => $query->whereHas('user', fn ($q) => $q->where('unit_id', $selectedUnitId)))
                                                        ->count(),

            'totalSurveyResponses' => SurveyResponse::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                                    ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', $endDate->endOfDay()))
                                                    ->whereHas('survey', fn ($query) => $query->where('status', 'active'))
                                                    ->when($selectedUnitId, fn ($query) => $query->whereHas('user', fn ($q) => $q->where('unit_id', $selectedUnitId)))
                                                    ->count(),

            'totalVisits' => Statistik::when($request->filled('start_date'), fn ($query) => $query->whereDate('created_at', '>=', $startDate))
                                        ->when($request->filled('end_date'), fn ($query) => $query->whereDate('created_at', '<=', $endDate->endOfDay()))
                                        ->sum('jumlah'), // Sum ALL 'jumlah' in Statistik, filtered by date

            'totalPageViews' => Informasi::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                        ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', $endDate->endOfDay()))
                                        ->sum('views_count') +
                                SubStandarLayanan::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                        ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', $endDate->endOfDay()))
                                        ->sum('views_count'),

            'totalDownloads' => Informasi::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                        ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', $endDate->endOfDay()))
                                        ->sum('download_count'),

            // The following stats are typically not date-filtered in the same way for a dashboard summary,
            // but for consistency with the reports page filter, we'll apply them if unit_id is selected.
            // If the user wants global totals regardless of date/unit filter for these, this logic would need adjustment.
            'totalUsers' => User::when($selectedUnitId, fn ($query) => $query->where('unit_id', $selectedUnitId))->count(),
            'totalOrganizations' => Organization::count(), // Organizations are not typically unit filtered by created_at
            'totalOfficials' => Official::count(), // Officials are not typically unit filtered by created_at
            'totalSliders' => Slider::count(),
            'totalGaleri' => Galeri::count(),
            'totalSubStandarLayanan' => SubStandarLayanan::count(),
            'totalLaporan' => Laporan::count(),
        ];

        $linkAccessLogs = \App\Models\LinkAccessLog::orderBy('last_access', 'desc')->get();

        $linkAccessLogs = \App\Models\LinkAccessLog::orderBy('last_access', 'desc')->get();

        return view('admin.reports.index', compact('totalReportsData', 'informasiReports', 'permohonanReports', 'visitorReports', 'surveyReports', 'startDate', 'endDate', 'unitMap', 'selectedUnitId', 'dashboardStatsForReports', 'linkAccessLogs'));
        }

    public function exportTotal(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedUnitId = $request->input('unit_id');

        $totalInformasi = Informasi::when($request->filled('start_date'), function ($query) use ($startDate) {
                                return $query->where('created_at', '>=', $startDate);
                            })
                            ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                return $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay());
                            })
                            ->when($selectedUnitId, function ($query) use ($selectedUnitId) {
                                return $query->where('unit_id', $selectedUnitId);
                            })
                            ->count();

        $totalPermohonan = PermohonanInformasi::when($request->filled('start_date'), function ($query) use ($startDate) {
                                return $query->where('created_at', '>=', $startDate);
                            })
                            ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                return $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay());
                            })
                            ->when($selectedUnitId, function ($query) use ($selectedUnitId) {
                                return $query->whereHas('user', function ($q) use ($selectedUnitId) {
                                    $q->where('unit_id', $selectedUnitId);
                                });
                            })
                            ->count();

        $totalSurveyResponses = SurveyResponse::when($request->filled('start_date'), function ($query) use ($startDate) {
                                return $query->where('created_at', '>=', $startDate);
                            })
                            ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                return $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay());
                            })
                            ->whereHas('survey', function ($query) { // Filter by active survey
                                $query->where('status', 'active');
                            })
                            ->when($selectedUnitId, function ($query) use ($selectedUnitId) {
                                return $query->whereHas('user', function ($q) use ($selectedUnitId) {
                                    $q->where('unit_id', $selectedUnitId);
                                });
                            })
                            ->count();
        
        // Corrected calculation for total visits (sum of all entries in Statistik for the period)
        $totalVisits = Statistik::when($request->filled('start_date'), function ($query) use ($startDate) {
                                return $query->whereDate('created_at', '>=', $startDate);
                            })
                            ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                return $query->whereDate('created_at', '<=', Carbon::parse($endDate)->endOfDay());
                            })
                            ->where('nama', 'visitors')
                            ->sum('jumlah');

        // Views are now handled by incrementing 'views_count' in Informasi model,
        // so this aggregate from Statistik is not directly equivalent to 'page views'.
        // For now, assuming 'totalVisits' covers the general access.
        $totalPageViews = Statistik::when($request->filled('start_date'), function ($query) use ($startDate) {
                                return $query->whereDate('created_at', '>=', $startDate);
                            })
                            ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                return $query->whereDate('created_at', '<=', Carbon::parse($endDate)->endOfDay());
                            })
                            ->where('nama', 'views')
                            ->sum('jumlah');

        $totalDownloads = Informasi::when($request->filled('start_date'), function ($query) use ($startDate) {
                                return $query->where('created_at', '>=', $startDate);
                            })
                            ->when($request->filled('end_date'), function ($query) use ($endDate) {
                                return $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay());
                            })
                            ->sum('download_count');


        $data = [
            'totalInformasi' => $totalInformasi,
            'totalPermohonan' => $totalPermohonan,
            'totalSurveyResponses' => $totalSurveyResponses, // Add this
            'totalVisits' => $totalVisits,
            'totalPageViews' => $totalPageViews, // Using new name
            'totalDownloads' => $totalDownloads,
        ];

        // Prepare dashboard-like statistics, filtered by date range for export
        $dashboardStatsForReports = [
            'totalInformasiCount' => Informasi::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                            ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay()))
                                            ->when($selectedUnitId, fn ($query) => $query->where('unit_id', $selectedUnitId))
                                            ->count(),

            'totalPermohonanCount' => PermohonanInformasi::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                                        ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay()))
                                                        ->when($selectedUnitId, fn ($query) => $query->whereHas('user', fn ($q) => $q->where('unit_id', $selectedUnitId)))
                                                        ->count(),

            'totalSurveyResponses' => SurveyResponse::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                                    ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay()))
                                                    ->whereHas('survey', fn ($query) => $query->where('status', 'active'))
                                                    ->when($selectedUnitId, fn ($query) => $query->whereHas('user', fn ($q) => $q->where('unit_id', $selectedUnitId)))
                                                    ->count(),

            'totalVisits' => Statistik::when($request->filled('start_date'), fn ($query) => $query->whereDate('created_at', '>=', $startDate))
                                        ->when($request->filled('end_date'), fn ($query) => $query->whereDate('created_at', '<=', Carbon::parse($endDate)->endOfDay()))
                                        ->sum('jumlah'), // Sum ALL 'jumlah' in Statistik, filtered by date

            'totalPageViews' => Informasi::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                        ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay()))
                                        ->sum('views_count') +
                                SubStandarLayanan::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                        ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay()))
                                        ->sum('views_count'),

            'totalDownloads' => Informasi::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                        ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay()))
                                        ->sum('download_count'),

            'totalUsers' => User::when($selectedUnitId, fn ($query) => $query->where('unit_id', $selectedUnitId))->count(),
            'totalOrganizations' => Organization::count(),
            'totalOfficials' => Official::count(),
            'totalSliders' => Slider::count(),
            'totalGaleri' => Galeri::count(),
            'totalSubStandarLayanan' => SubStandarLayanan::count(),
            'totalLaporan' => Laporan::count(),
        ];

        $fileName = 'Laporan_Total_' . ($startDate ? Carbon::parse($startDate)->format('Ymd') : '') . '_to_' . ($endDate ? Carbon::parse($endDate)->format('Ymd') : '') . '.xlsx';

        return Excel::download(new AllReportsMultiSheetExport($startDate, $endDate, $data, $dashboardStatsForReports), $fileName);
    }

    public function exportInformasi(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $fileName = 'Laporan_Informasi_' . ($startDate ? Carbon::parse($startDate)->format('Ymd') : '') . '_to_' . ($endDate ? Carbon::parse($endDate)->format('Ymd') : '') . '.xlsx';

        return Excel::download(new InformasiReportsExport($startDate, $endDate), $fileName);
    }

    public function exportPermohonan(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $fileName = 'Laporan_Permohonan_' . ($startDate ? Carbon::parse($startDate)->format('Ymd') : '') . '_to_' . ($endDate ? Carbon::parse($endDate)->format('Ymd') : '') . '.xlsx';

        return Excel::download(new PermohonanReportsExport($startDate, $endDate), $fileName);
    }

    public function exportVisitors(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedUnitId = $request->input('unit_id'); // Make sure to get unit_id for filtering

        // Calculate dashboardStatsForReports
        $dashboardStatsForReports = [
            'totalInformasiCount' => Informasi::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                            ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay()))
                                            ->when($selectedUnitId, fn ($query) => $query->where('unit_id', $selectedUnitId))
                                            ->count(),

            'totalPermohonanCount' => PermohonanInformasi::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                                        ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay()))
                                                        ->when($selectedUnitId, fn ($query) => $query->whereHas('user', fn ($q) => $q->where('unit_id', $selectedUnitId)))
                                                        ->count(),

            'totalSurveyResponses' => SurveyResponse::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                                    ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay()))
                                                    ->whereHas('survey', fn ($query) => $query->where('status', 'active'))
                                                    ->when($selectedUnitId, fn ($query) => $query->whereHas('user', fn ($q) => $q->where('unit_id', $selectedUnitId)))
                                                    ->count(),

            'totalVisits' => Statistik::when($request->filled('start_date'), fn ($query) => $query->whereDate('created_at', '>=', $startDate))
                                        ->when($request->filled('end_date'), fn ($query) => $query->whereDate('created_at', '<=', Carbon::parse($endDate)->endOfDay()))
                                        ->sum('jumlah'), // Sum ALL 'jumlah' in Statistik, filtered by date

            'totalPageViews' => Informasi::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                        ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay()))
                                        ->sum('views_count') +
                                SubStandarLayanan::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                        ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay()))
                                        ->sum('views_count'),

            'totalDownloads' => Informasi::when($request->filled('start_date'), fn ($query) => $query->where('created_at', '>=', $startDate))
                                        ->when($request->filled('end_date'), fn ($query) => $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay()))
                                        ->sum('download_count'),
            'totalUsers' => User::when($selectedUnitId, fn ($query) => $query->where('unit_id', $selectedUnitId))->count(),
            'totalOrganizations' => Organization::count(),
            'totalOfficials' => Official::count(),
            'totalSliders' => Slider::count(),
            'totalGaleri' => Galeri::count(),
            'totalSubStandarLayanan' => SubStandarLayanan::count(),
            'totalLaporan' => Laporan::count(),
        ];

        $fileName = 'Statistik_Laporan_' . ($startDate ? Carbon::parse($startDate)->format('Ymd') : '') . '_to_' . ($endDate ? Carbon::parse($endDate)->format('Ymd') : '') . '.xlsx';

        return Excel::download(new DashboardStatsExport($dashboardStatsForReports), $fileName);
    }

    public function exportSurvey(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $fileName = 'Laporan_Survei_' . ($startDate ? Carbon::parse($startDate)->format('Ymd') : '') . '_to_' . ($endDate ? Carbon::parse($endDate)->format('Ymd') : '') . '.xlsx';

        return Excel::download(new SurveyReportsExport($startDate, $endDate), $fileName);
    }
}
