<?php

namespace App\Http\Controllers;

use App\Models\Official;
use App\Models\Position;
use App\Models\Organization;
use Illuminate\Http\Request;

class OfficialProfileController extends Controller
{
    /**
     * Display the specified official profile.
     */
    public function show($slug)
    {
        // For named routes (bupati, wakil-bupati, sekretariat-daerah), use the slug as position slug
        $specialPositions = [
            'bupati' => 'bupati-sinjai',
            'wakil-bupati' => 'wakil-bupati-sinjai',
            'sekretariat-daerah' => 'sekretaris-daerah-sinjai'
        ];
        $icon = 'user'; // default icon

        if (array_key_exists($slug, $specialPositions) || in_array($slug, $specialPositions)) {
            $positionSlug = $specialPositions[$slug] ?? $slug;

            // Determine main and penjabat slugs
            $isPenjabatSlug = str_starts_with($positionSlug, 'penjabat-');
            if ($isPenjabatSlug) {
                $mainPositionSlug = substr($positionSlug, strlen('penjabat-'));
                $penjabatPositionSlug = $positionSlug;
            } else {
                $mainPositionSlug = $positionSlug;
                $penjabatPositionSlug = 'penjabat-' . $positionSlug;
            }

            // Find both positions
            $mainPosition = Position::where('slug', $mainPositionSlug)->first();
            $penjabatPosition = Position::where('slug', $penjabatPositionSlug)->first();

            $positionIds = [];
            if ($mainPosition) $positionIds[] = $mainPosition->id;
            if ($penjabatPosition) $positionIds[] = $penjabatPosition->id;

            if (empty($positionIds)) {
                abort(404);
            }

            // Find an active official in either position
            $query = Official::whereIn('position_id', $positionIds)
                              ->with(['position', 'organization', 'careerHistories', 'educations', 'awards', 'children', 'trainingHistories', 'organizationalHistories']);
            
            $user = \Illuminate\Support\Facades\Auth::user();
            if (!$user || ($user && !$user->isAdmin())) {
                $query->where('status', 'active');
            }
            
            $official = $query->first();
        } else {
            // If the slug is not a special position, assume it's an official's slug.
            $query = Official::where('slug', $slug)
                              ->with(['position', 'organization', 'careerHistories', 'educations', 'awards', 'children', 'trainingHistories', 'organizationalHistories']);

            $user = \Illuminate\Support\Facades\Auth::user();
            if (!$user || ($user && !$user->isAdmin())) {
                $query->where('status', 'active');
            }

            $official = $query->first();

            // If no official is found, we might be looking for a Kepala OPD via the organization slug as a fallback.
            if (!$official) {
                $organization = Organization::where('slug', $slug)->first();
                if ($organization) {
                    $position = Position::where('slug', 'kepala-opd')->first();
                    if ($position) {
                        $query = Official::where('position_id', $position->id)
                                          ->where('organization_id', $organization->id)
                                          ->with(['position', 'organization', 'careerHistories', 'educations', 'awards', 'children', 'trainingHistories', 'organizationalHistories']);
                        
                        if (!$user || ($user && !$user->isAdmin())) {
                            $query->where('status', 'active');
                        }
                        
                        $official = $query->first();
                    }
                }
            }
        }

        if (!$official) {
            return view('frontend.pages.profil.official-not-found', [
                'slug' => $slug,
                'organization' => isset($organization) ? $organization : null
            ]);
        }

        $menus = config('menu');
        foreach ($menus as $menu) {
            if ($menu['title'] === 'Profil' && !empty($menu['children'])) {
                foreach ($menu['children'] as $child) {
                    // Match if the child URL contains the slug or if the slug contains the core word of the URL
                    $urlPath = parse_url($child['url'], PHP_URL_PATH);
                    $urlSlug = last(explode('/', trim($urlPath, '/')));
                    
                    if (str_contains($slug, $urlSlug) || str_contains($urlSlug, $slug)) {
                        $icon = $child['icon'];
                        break 2;
                    }
                }
            }
        }


        return view('frontend.pages.profil.official-profile', compact('official', 'icon'));
    }

    /**
     * Display a list of all Kepala OPD officials.
     */
    public function listKepalaOpd()
    {
        $position = Position::where('slug', 'kepala-opd')->first();

        if (!$position) {
            abort(404, 'Posisi Kepala OPD tidak ditemukan.');
        }

        $query = Official::where('position_id', $position->id)
                         ->with(['position', 'organization']);

        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user || ($user && !$user->isAdmin())) { // If not logged in OR logged in but not an Admin/SuperAdmin
            $query->where('status', '!=', 'draft');
        }
        
        $kepalaOpdsRaw = $query->orderBy('full_name')->get();
        
        $kepalaOpds = $kepalaOpdsRaw->groupBy(function($official) {
            $orgNameLower = strtolower($official->organization->name ?? '');
            if (str_contains($orgNameLower, 'kecamatan')) {
                return 'eselon3';
            }
            return 'eselon2';
        });
        
        $menus = config('menu');
        $icon = 'user-tie'; // default icon
        foreach ($menus as $menu) {
            if ($menu['title'] === 'Profil') {
                if (!empty($menu['children'])) {
                    foreach ($menu['children'] as $child) {
                        if ($child['title'] === 'Pejabat Daerah') {
                            $icon = $child['icon'];
                            break 2;
                        }
                    }
                }
            }
        }

        $user = \Illuminate\Support\Facades\Auth::user();
        $api_unit_id = null;

        if ($user && $user->nip) {
            $apiData = \App\Models\User::getDataFromApi($user->nip);
            if (isset($apiData['unit_id'])) {
                $api_unit_id = $apiData['unit_id'];
            }
        }

        return view('frontend.pages.profil.kepala-opd-list', compact('kepalaOpds', 'icon', 'user', 'api_unit_id'));
    }
}