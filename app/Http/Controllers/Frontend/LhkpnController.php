<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lhkpn;
use App\Models\Official;
use Illuminate\Http\Request;

class LhkpnController extends Controller
{
    public function index($year = null)
    {
        $latestYear = Lhkpn::max('report_year') ?? date('Y');
        
        // If no year is provided, use the latest year
        if (is_null($year)) {
            $year = $latestYear;
        }

        $items = collect();

        // 1. Get Special Pimpinan Positions (Bupati, Wakil Bupati, Sekda, Asisten, Staf Ahli)
        $pimpinanSlugs = [
            'bupati-sinjai', 
            'wakil-bupati-sinjai', 
            'sekretaris-daerah-sinjai',
            'asisten-i-pemerintahan-dan-kesra',
            'asisten-ii-perekonomian-dan-pembangunan',
            'asisten-iii-administrasi-umum',
            'staf-ahli-bidang-politik-hukum-dan-pemerintahan',
            'staf-ahli-bidang-ekonomi-keuangan-dan-pembangunan',
            'staf-ahli-bidang-sosial-dan-sumber-daya-manusia'
        ];
        
        // Let's get positions from DB to be safe and use their order
        $specialPositions = \App\Models\Position::whereIn('slug', $pimpinanSlugs)
            ->orderByRaw("FIELD(slug, 'bupati-sinjai', 'wakil-bupati-sinjai', 'sekretaris-daerah-sinjai', 'asisten-i-pemerintahan-dan-kesra', 'asisten-ii-perekonomian-dan-pembangunan', 'asisten-iii-administrasi-umum', 'staf-ahli-bidang-politik-hukum-dan-pemerintahan', 'staf-ahli-bidang-ekonomi-keuangan-dan-pembangunan', 'staf-ahli-bidang-sosial-dan-sumber-daya-manusia')")
            ->get();

        foreach ($specialPositions as $position) {
            $official = Official::with('lhkpns')
                ->where('position_id', $position->id)
                ->first();

            $group = 'pimpinan';
            $pimpinanSlugsOnly = ['bupati-sinjai', 'wakil-bupati-sinjai', 'sekretaris-daerah-sinjai'];
            if (!in_array($position->slug, $pimpinanSlugsOnly)) {
                $group = 'eselon2';
            }

            $items->push((object)[
                'type' => $official ? 'official' : 'unit',
                'full_name' => $official ? $official->full_name : 'Belum Ada Pejabat',
                'display_title' => $position->name,
                'organization_name' => $official->organization->name ?? 'Pemerintah Daerah',
                'photo' => $official ? $official->photo : null,
                'official' => $official,
                'lhkpns' => $official ? $official->lhkpns : collect(),
                'current_year_lhkpn' => $official ? $official->lhkpns->where('report_year', $year)->first() : null,
                'group' => $group,
            ]);
        }

        // 2. Get all Organizations (Units) and their heads
        $organizations = \App\Models\Organization::with(['officials' => function($q) {
            $q->whereHas('position', function($pq) {
                $pq->where('slug', 'kepala-opd');
            })->with('lhkpns');
        }])->get();

        foreach ($organizations as $org) {
            $head = $org->officials->first();
            
            // Determine title
            $title = 'Kepala ' . $org->name;
            $orgNameLower = strtolower($org->name);
            $group = 'eselon2';

            if (str_contains($orgNameLower, 'dinas')) {
                $title = 'Kepala ' . $org->name;
            } elseif (str_contains($orgNameLower, 'kecamatan')) {
                $title = 'Camat ' . str_ireplace('kantor kecamatan ', '', $org->name);
                $group = 'eselon3';
            } elseif (str_contains($orgNameLower, 'inspektorat')) {
                $title = 'Inspektur';
            } elseif (str_contains($orgNameLower, 'rsud') || str_contains($orgNameLower, 'rumah sakit')) {
                $title = 'Direktur ' . $org->name;
            }

            $items->push((object)[
                'type' => $head ? 'official' : 'unit',
                'full_name' => $head ? $head->full_name : 'Belum Ada Pejabat',
                'display_title' => $title,
                'organization_name' => $org->name,
                'photo' => $head ? $head->photo : null,
                'official' => $head,
                'lhkpns' => $head ? $head->lhkpns : collect(),
                'current_year_lhkpn' => $head ? $head->lhkpns->where('report_year', $year)->first() : null,
                'group' => $group,
            ]);
        }

        $stats = [
            'selected_year' => $year,
            'available_years' => Lhkpn::select('report_year')->distinct()->orderBy('report_year', 'desc')->pluck('report_year'),
        ];

        return view('frontend.lhkpn.index', compact('items', 'stats'));
    }

    public function viewFile(Lhkpn $lhkpn)
    {
        $lhkpn->increment('views_count');

        return redirect(asset('storage/' . $lhkpn->file_path));
    }
}
