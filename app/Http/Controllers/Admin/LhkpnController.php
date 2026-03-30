<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lhkpn;
use App\Models\Official;
use App\Models\Organization;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Informasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LhkpnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $year = null)
    {
        $latestYear = Lhkpn::max('report_year') ?? date('Y');
        
        // If no year is provided in the URL, default to the latest year.
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
        $specialPositions = Position::whereIn('slug', $pimpinanSlugs)
            ->orderByRaw("FIELD(slug, 'bupati-sinjai', 'wakil-bupati-sinjai', 'sekretaris-daerah-sinjai', 'asisten-i-pemerintahan-dan-kesra', 'asisten-ii-perekonomian-dan-pembangunan', 'asisten-iii-administrasi-umum', 'staf-ahli-bidang-politik-hukum-dan-pemerintahan', 'staf-ahli-bidang-ekonomi-keuangan-dan-pembangunan', 'staf-ahli-bidang-sosial-dan-sumber-daya-manusia')")
            ->get();

        foreach ($specialPositions as $position) {
            $official = Official::with('lhkpns')
                ->where('position_id', $position->id)
                ->first();

            $items->push((object)[
                'type' => $official ? 'official' : 'unit',
                'id' => $official ? $official->id : $position->id,
                'unit_id' => $official ? $official->organization_id : 39, // Default to PEMDA if no official
                'position_id' => $position->id,
                'full_name' => $official ? $official->full_name : 'Belum Ada Pejabat',
                'display_title' => $position->name,
                'organization_name' => $official->organization->name ?? 'Pemerintah Daerah',
                'photo' => $official ? $official->photo : null,
                'official' => $official,
                'lhkpns' => $official ? $official->lhkpns : collect(),
                'current_year_lhkpn' => $official ? $official->lhkpns->where('report_year', $year)->first() : null,
            ]);
        }

        // 2. Get all Organizations (Units) and their heads
        $organizations = Organization::with(['officials' => function($q) {
            $q->whereHas('position', function($pq) {
                $pq->where('slug', 'kepala-opd');
            })->with('lhkpns');
        }])->get();

        foreach ($organizations as $org) {
            // Find head if any
            $head = $org->officials->first(); // We already filtered for 'kepala-opd' in with()
            
            // Determine title
            $title = 'Kepala ' . $org->name;
            // Simplified title logic similar to blade but here for the object
            $orgNameLower = strtolower($org->name);
            if (str_contains($orgNameLower, 'dinas')) {
                $title = 'Kepala ' . $org->name;
            } elseif (str_contains($orgNameLower, 'kecamatan')) {
                $title = 'Camat ' . str_ireplace('kantor kecamatan ', '', $org->name);
            } elseif (str_contains($orgNameLower, 'inspektorat')) {
                $title = 'Inspektur';
            } elseif (str_contains($orgNameLower, 'rsud') || str_contains($orgNameLower, 'rumah sakit')) {
                $title = 'Direktur ' . $org->name;
            }

            $items->push((object)[
                'type' => $head ? 'official' : 'unit',
                'id' => $head ? $head->id : $org->id,
                'unit_id' => $org->id,
                'position_id' => $head ? $head->position_id : 10, // Default to Kepala OPD if no head
                'full_name' => $head ? $head->full_name : 'Belum Ada Pejabat',
                'display_title' => $title,
                'organization_name' => $org->name,
                'photo' => $head ? $head->photo : null,
                'official' => $head,
                'lhkpns' => $head ? $head->lhkpns : collect(),
                'current_year_lhkpn' => $head ? $head->lhkpns->where('report_year', $year)->first() : null,
            ]);
        }

        // Search functionality
        if ($search = $request->input('search')) {
            $search = strtolower($search);
            $items = $items->filter(function($item) use ($search) {
                return str_contains(strtolower($item->full_name), $search) || 
                       str_contains(strtolower($item->display_title), $search) || 
                       str_contains(strtolower($item->organization_name), $search);
            });
        }

        // Stats
        $stats = [
            'total_officials' => $items->count(),
            'total_lhkpn' => Lhkpn::count(),
            'latest_report_year' => $latestYear,
            'selected_year' => $year,
            'available_years' => Lhkpn::select('report_year')->distinct()->orderBy('report_year', 'desc')->pluck('report_year'),
        ];

        return view('admin.lhkpn.index', ['items' => $items, 'stats' => $stats]);
    }

    /**
     * Show the form for creating a new resource for a specific unit/position.
     */
    public function createForUnit(Request $request)
    {
        $unit = Organization::find($request->unit_id);
        $position = Position::find($request->position_id);
        $official = $unit ? $unit->officials()->where('position_id', $request->position_id)->first() : null;

        return view('admin.lhkpn.create', [
            'unit' => $unit,
            'position' => $position,
            'official' => $official,
        ]);
    }

    /**
     * Store a newly created resource in storage for a specific unit/position.
     */
    public function storeForUnit(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:organizations,id',
            'position_id' => 'required|exists:positions,id',
            'full_name' => 'nullable|string|max:255',
            'report_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'report_date' => 'required|date',
            'total_wealth' => 'nullable|numeric',
            'report_type' => 'nullable|string|max:255',
            'file' => 'required|mimes:pdf|max:10240',
        ]);

        DB::transaction(function () use ($request) {
            $filePath = $request->file('file')->store('lhkpn', 'public');

            $official = Official::where('organization_id', $request->unit_id)
                                ->where('position_id', $request->position_id)
                                ->first();

            $lhkpn = new Lhkpn($request->only(['report_year', 'report_date', 'total_wealth', 'report_type', 'full_name']));
            $lhkpn->file_path = $filePath;
            $lhkpn->organization_id = $request->unit_id;
            $lhkpn->position_id = $request->position_id;
            $lhkpn->official_id = $official ? $official->id : null;
            $lhkpn->save();
            
            // Set ARSIP for old ones for this specific unit and position
            Informasi::where('unit_id', $request->unit_id)
                     ->where('position_id', $request->position_id)
                     ->whereNotNull('lhkpn_id')
                     ->update(['status' => 'ARSIP']);

            // Create 'Informasi' record
            $user = Auth::user();
            $unit = Organization::find($request->unit_id);
            $position = Position::find($request->position_id);
            
            $displayTitle = $position->name;
            if ($position->slug === 'kepala-opd' && $unit) {
                $displayTitle = 'Kepala ' . $unit->name;
            }

            // Title is now just LHKPN [Jabatan], excluding name as requested
            $infoTitle = "LHKPN {$displayTitle}";

            Informasi::create([
                'title' => $infoTitle,
                'deskripsi' => "Dokumen Ini berisi Tentang LHKPN Jabatan/Unit",
                'file' => $lhkpn->file_path,
                'category' => 'Informasi Berkala',
                'jenis_dokumen' => 'Informasi Organisasi & Kepegawaian',
                'status' => 'BERLAKU',
                'tahun' => $lhkpn->report_year,
                'tanggal_upload' => $lhkpn->report_date,
                'user_id' => $user->id,
                'unit_id' => $request->unit_id,
                'official_id' => $official ? $official->id : null,
                'lhkpn_id' => $lhkpn->id,
                'position_id' => $request->position_id // Ensure this is tracked
            ]);
        });

        return redirect()->route('admin.lhkpn.index')->with('success', 'Laporan LHKPN berhasil diunggah.');
    }

    /**
     * Show the form for creating a new resource for a specific official.
     */
    public function createForOfficial(Official $official)
    {
        return view('admin.lhkpn.create', ['official' => $official]);
    }

    /**
     * Store a newly created resource in storage for a specific official.
     */
    public function storeForOfficial(Request $request, Official $official)
    {
        $request->validate([
            'report_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'report_date' => 'required|date',
            'total_wealth' => 'nullable|numeric',
            'report_type' => 'nullable|string|max:255',
            'file' => 'required|mimes:pdf|max:10240', // Max 10MB, only PDF as requested
        ]);

        DB::transaction(function () use ($request, $official) {
            $filePath = $request->file('file')->store('lhkpn', 'public');

            $lhkpn = new Lhkpn($request->only(['report_year', 'report_date', 'total_wealth', 'report_type']));
            $lhkpn->file_path = $filePath;
            
            // Populate new fields for unit-based tracking
            $lhkpn->official_id = $official->id;
            $lhkpn->organization_id = $official->organization_id;
            $lhkpn->position_id = $official->position_id;
            $lhkpn->full_name = $official->full_name;
            
            $lhkpn->save();
            
            // 1. Set all other LHKPN-related 'Informasi' for this official to ARSIP
            // Also consider same unit/position?
            Informasi::where('official_id', $official->id)
                     ->whereNotNull('lhkpn_id')
                     ->update(['status' => 'ARSIP']);
            
            // 2. Create the new 'Informasi' record as BERLAKU
            $user = Auth::user();
            
            // Determine title for Informasi
            $positionName = $official->position->name;
            if ($official->position->slug === 'kepala-opd' && $official->organization) {
                 $positionName = 'Kepala ' . $official->organization->name;
            }

            Informasi::create([
                'title' => "LHKPN {$positionName} {$official->full_name}",
                'deskripsi' => "Dokumen Ini berisi Tentang LHKPN Pimpinan",
                'file' => $lhkpn->file_path,
                'category' => 'Informasi Berkala',
                'jenis_dokumen' => 'Informasi Organisasi & Kepegawaian',
                'status' => 'BERLAKU',
                'tahun' => $lhkpn->report_year,
                'tanggal_upload' => $lhkpn->report_date,
                'user_id' => $user->id,
                'unit_id' => $official->organization_id ?? $user->unit_id,
                'official_id' => $official->id,
                'lhkpn_id' => $lhkpn->id
            ]);
        });

        return redirect()->route('admin.lhkpn.index')->with('success', 'Laporan LHKPN untuk ' . $official->full_name . ' berhasil dibuat.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lhkpn $lhkpn)
    {
        Storage::disk('public')->delete($lhkpn->file_path);
        $lhkpn->delete();

        return redirect()->route('admin.lhkpn.index')->with('success', 'Laporan LHKPN berhasil dihapus.');
    }

    public function viewFile(Lhkpn $lhkpn)
    {
        $lhkpn->increment('views_count');

        return redirect(asset('storage/' . $lhkpn->file_path));
    }
}
