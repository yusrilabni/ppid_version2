<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lhkpn;
use App\Models\Official;
use Illuminate\Http\Request;

class LhkpnController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', null);
        $search = $request->get('search', '');
        
        $latestYear = Lhkpn::max('report_year') ?? date('Y');
        
        if (is_null($year) || $year === '') {
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
        
        $specialPositions = \App\Models\Position::whereIn('slug', $pimpinanSlugs)
            ->orderByRaw("FIELD(slug, 'bupati-sinjai', 'wakil-bupati-sinjai', 'sekretaris-daerah-sinjai', 'asisten-i-pemerintahan-dan-kesra', 'asisten-ii-perekonomian-dan-pembangunan', 'asisten-iii-administrasi-umum', 'staf-ahli-bidang-politik-hukum-dan-pemerintahan', 'staf-ahli-bidang-ekonomi-keuangan-dan-pembangunan', 'staf-ahli-bidang-sosial-dan-sumber-daya-manusia')")
            ->get();

        $specialPositionIds = $specialPositions->pluck('id');
        $officials = Official::with(['lhkpns', 'organization'])
            ->whereIn('position_id', $specialPositionIds)
            ->get()
            ->keyBy('position_id');

        foreach ($specialPositions as $position) {
            $official = $officials->get($position->id);

            $group = 'pimpinan';
            $pimpinanSlugsOnly = ['bupati-sinjai', 'wakil-bupati-sinjai', 'sekretaris-daerah-sinjai'];
            if (!in_array($position->slug, $pimpinanSlugsOnly)) {
                $group = 'eselon2';
            }

            $orgName = $official->organization->name ?? 'Pemerintah Daerah';
            $fullName = $official ? $official->full_name : 'Belum Ada Pejabat';
            
            if ($search && !str_contains(strtolower($fullName), strtolower($search)) && !str_contains(strtolower($orgName), strtolower($search)) && !str_contains(strtolower($position->name), strtolower($search))) {
                continue;
            }

            $items->push([
                'type' => $official ? 'official' : 'unit',
                'full_name' => $fullName,
                'display_title' => $position->name,
                'organization_name' => $orgName,
                'photo' => $official ? ($official->photo ? asset('storage/' . $official->photo) : null) : null,
                'lhkpns' => $official ? $official->lhkpns->sortByDesc('report_year')->values() : [],
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

            $fullName = $head ? $head->full_name : 'Belum Ada Pejabat';
            
            if ($search && !str_contains(strtolower($fullName), strtolower($search)) && !str_contains(strtolower($org->name), strtolower($search)) && !str_contains(strtolower($title), strtolower($search))) {
                continue;
            }

            $items->push([
                'type' => $head ? 'official' : 'unit',
                'full_name' => $fullName,
                'display_title' => $title,
                'organization_name' => $org->name,
                'photo' => $head ? ($head->photo ? asset('storage/' . $head->photo) : null) : null,
                'lhkpns' => $head ? $head->lhkpns->sortByDesc('report_year')->values() : [],
                'group' => $group,
            ]);
        }

        $availableYears = Lhkpn::select('report_year')->distinct()->orderBy('report_year', 'desc')->pluck('report_year');

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $items,
                'stats' => [
                    'selected_year' => $year,
                    'available_years' => $availableYears
                ]
            ]
        ]);
    }
}
