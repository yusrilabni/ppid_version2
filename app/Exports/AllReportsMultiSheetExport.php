<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
use App\Exports\DashboardStatsExport; // Import DashboardStatsExport

class AllReportsMultiSheetExport implements WithMultipleSheets, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $totalReportsData;
    protected $dashboardStatsForReports; // New property

    public function __construct(string $startDate = null, string $endDate = null, array $totalReportsData = [], array $dashboardStatsForReports = []) // New parameter
    {
        $this->startDate = $startDate ? Carbon::parse($startDate) : null;
        $this->endDate = $endDate ? Carbon::parse($endDate) : null;
        $this->totalReportsData = $totalReportsData;
        $this->dashboardStatsForReports = $dashboardStatsForReports; // Assign new parameter
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        // Sheet 1: Dashboard Statistics
        $sheets[] = new DashboardStatsExport($this->dashboardStatsForReports); // Retain this new sheet

        // Sheet 2: Informasi Details
        $sheets[] = new InformasiDetailExport($this->startDate, $this->endDate);

        // Sheet 3: Permohonan Details
        $sheets[] = new PermohonanDetailExport($this->startDate, $this->endDate);

        // Sheet 4: Survey Responses Details
        $sheets[] = new SurveyDetailExport($this->startDate, $this->endDate);

        return $sheets;
    }
}
