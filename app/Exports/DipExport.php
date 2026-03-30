<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DipExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.dip_excel', $this->data);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as header if needed, but since we use FromView, 
            // we can handle most styling in the Blade template.
        ];
    }
}
