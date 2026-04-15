<?php

namespace App\Http\Controllers;

use App\Models\Official;
use App\Models\Organization;
use App\Models\Position;
use App\Helpers\GeneralHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UnitLokalController extends Controller
{
    /**
     * Display a list of all Village and Kelurahan heads, grouped by Kecamatan.
     */
    public function index()
    {
        $cached = GeneralHelper::syncExternalUnitsIfNeeded();
        $organizations = Organization::all();
        
        // Find the 'Kepala OPD' position or similar that is used for Village Heads
        $position = Position::where('slug', 'kepala-opd')->first();
        
        $query = Official::with(['organization', 'position']);
        
        $user = auth()->user();
        if (!$user || !$user->isAdmin()) {
            $query->where('status', 'active');
        }

        // Fetch all officials belonging to Village/Kelurahan organizations
        $allOfficials = $query->get()->filter(function($official) {
            $orgName = $official->organization->name ?? '';
            return stripos($orgName, 'Desa ') !== false || stripos($orgName, 'Kelurahan ') !== false;
        });

        // Grouping logic
        $groupedData = [];
        
        // Initialize groups for each Kecamatan found in API
        if (!empty($cached['units'])) {
            foreach ($cached['units'] as $unit) {
                if (stripos($unit['unit_nama'], 'Kecamatan') !== false) {
                    $kecName = trim(preg_replace('/\s*Kantor Kecamatan\s*/i', '', $unit['unit_nama']));
                    $groupedData[$kecName] = [
                        'name' => $unit['unit_nama'],
                        'officials' => []
                    ];
                }
            }
        }

        // Fill groups with officials
        foreach ($allOfficials as $official) {
            $unitId = (string)($official->organization->remote_id ?? '');
            $foundGroup = false;

            // Try to find the kecamatan group via API grouping
            if (!empty($cached['villages_grouped'])) {
                foreach ($cached['villages_grouped'] as $kecGroupName => $villages) {
                    foreach ($villages as $v) {
                        if ((string)$v['desa_id'] === $unitId) {
                            $groupedData[$kecGroupName]['officials'][] = $official;
                            $foundGroup = true;
                            break 2;
                        }
                    }
                }
            }

            // Fallback: If not found in API grouping, try ID prefix or Name matching
            if (!$foundGroup) {
                $kecPrefix = substr($unitId, 0, 6);
                $orgName = $official->organization->name ?? '';
                
                foreach ($groupedData as $kecKey => &$group) {
                    // Match by name in parenthesis if exists, e.g., "Desa X (Kec. Bulupoddo)"
                    if (stripos($orgName, $kecKey) !== false) {
                        $group['officials'][] = $official;
                        $foundGroup = true;
                        break;
                    }
                }
            }
            
            // If still not grouped, put in 'Lainnya'
            if (!$foundGroup) {
                $groupedData['Lainnya']['name'] = 'Wilayah Lainnya';
                $groupedData['Lainnya']['officials'][] = $official;
            }
        }

        // Clean up empty groups and sort
        $groupedData = array_filter($groupedData, function($group) {
            return count($group['officials']) > 0;
        });
        ksort($groupedData);

        return view('frontend.pages.profil.unit-lokal-list', compact('groupedData'));
    }
}
