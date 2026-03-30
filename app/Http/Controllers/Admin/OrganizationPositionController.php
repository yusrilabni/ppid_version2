<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\OrganizationPosition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrganizationPositionController extends Controller
{
    /**
     * Display a listing of the resource with tree structure.
     */
    public function index(Organization $organization)
    {
        $positions = OrganizationPosition::with(['children', 'members.user'])
            ->where('organization_id', $organization->id)
            ->whereNull('parent_id')
            ->orderBy('order_number')
            ->get();

        // Get all positions for parent selection dropdown
        $allPositions = OrganizationPosition::where('organization_id', $organization->id)
            ->orderBy('title')
            ->get();

        // Prepare chart nodes for frontend
        $chartNodes = $this->buildChartNodes($positions, $organization->id);

        // Retrieve the StrukturOrganisasi record for the current organization
        $struktur = \App\Models\StrukturOrganisasi::where('organization_id', $organization->id)->first();

        return view('admin.organizations.positions.index', compact('organization', 'positions', 'allPositions', 'chartNodes', 'struktur'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Organization $organization)
    {
        $existingPositions = OrganizationPosition::where('organization_id', $organization->id)->pluck('id', 'title');
        $allPositions = OrganizationPosition::where('organization_id', $organization->id)->orderBy('title')->get();
        return view('admin.organizations.positions.create', compact('organization', 'existingPositions', 'allPositions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Organization $organization)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'parent_id' => [
                'nullable', 
                Rule::exists('organization_positions', 'id')->where(function ($query) use ($organization) {
                    $query->where('organization_id', $organization->id);
                }),
                function ($attribute, $value, $fail) use ($request, $organization) {
                    // Prevent circular reference
                    if ($value && $value == $request->id) {
                        $fail('Parent position cannot be the same as the position itself.');
                        return;
                    }
                    
                    if ($value && $request->id) {
                        $position = OrganizationPosition::find($request->id);
                        if ($position && $position->isAncestorOf($value)) {
                            $fail('Circular reference detected: cannot set parent to a child position.');
                        }
                    }
                }
            ],
            'order_number' => 'integer|min:0',
            'meta' => 'nullable|array',
        ]);

        $organization->positions()->create([
            'title' => $request->title,
            'name' => $request->name ?? $request->title,
            'parent_id' => $request->parent_id,
            'order_number' => $request->order_number ?? 0,
            'meta' => $request->meta ?? null,
        ]);

        return redirect()->route('admin.organizations.positions.index', $organization)->with('success', 'Jabatan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization, OrganizationPosition $position)
    {
        $allPositions = OrganizationPosition::where('organization_id', $organization->id)
            ->where('id', '!=', $position->id)
            ->orderBy('title')
            ->get();
        return view('admin.organizations.positions.edit', compact('organization', 'position', 'allPositions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organization $organization, OrganizationPosition $position)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'parent_id' => [
                'nullable', 
                Rule::exists('organization_positions', 'id')->where(function ($query) use ($organization) {
                    $query->where('organization_id', $organization->id);
                }),
                function ($attribute, $value, $fail) use ($position, $organization) {
                    // Prevent circular reference
                    if ($value && $value == $position->id) {
                        $fail('Parent position cannot be the same as the position itself.');
                        return;
                    }
                    
                    if ($value && $position->isAncestorOf($value)) {
                        $fail('Circular reference detected: cannot set parent to a child position.');
                    }
                }
            ],
            'order_number' => 'integer|min:0',
            'meta' => 'nullable|array',
        ]);

        $position->update([
            'title' => $request->title,
            'name' => $request->name ?? $request->title,
            'parent_id' => $request->parent_id,
            'order_number' => $request->order_number,
            'meta' => $request->meta ?? null,
        ]);

        return redirect()->route('admin.organizations.positions.index', $organization)->with('success', 'Jabatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization, OrganizationPosition $position)
    {
        $position->delete(); // With cascade, children will be deleted

        return redirect()->route('admin.organizations.positions.index', $organization)->with('deleted', 'Jabatan berhasil dihapus.');
    }

    /**
     * Display the hierarchical structure.
     */
    public function structures()
    {
        $organizations = Organization::with('struktur')->get();

        foreach ($organizations as $organization) {
            $organization->positions_tree = $this->getPositionsTree($organization->id);
        }

        // Prepare chart nodes for visualization
        $chartNodes = [];
        foreach ($organizations as $organization) {
            $nodes = $this->buildChartNodesForOrganization($organization->positions_tree, $organization->id);
            $chartNodes = array_merge($chartNodes, $nodes);
        }

        return view('admin.organizations.structures.index', compact('organizations', 'chartNodes'));
    }

    /**
     * Build chart nodes for a specific organization's positions
     */
    private function buildChartNodesForOrganization($positions, $orgId, $parentId = null)
    {
        $nodes = [];
        $orgPrefix = "Org-{$orgId}-"; // Add organization prefix to avoid ID conflicts

        foreach ($positions as $position) {
            $nodeId = $orgPrefix . $position->id;
            $pid = $parentId;

            $nodes[] = [
                'id' => $nodeId,
                'pid' => $pid,
                'title' => $position->title,
                'name' => $position->name ?? $position->title,
                'description' => $orgId, // Include organization ID for identification
            ];

            if ($position->children->count() > 0) {
                $childNodes = $this->buildChartNodesForOrganization($position->children, $orgId, $nodeId);
                $nodes = array_merge($nodes, $childNodes);
            }
        }

        return $nodes;
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        $positions = $organization->positions()->with(['parent', 'children', 'members.user'])->get();
        return view('admin.organizations.show', compact('organization', 'positions'));
    }

    /**
     * Assign a member to a position.
     */
    public function assignMember(Request $request, OrganizationPosition $position)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $position->members()->create([
            'user_id' => $request->user_id,
        ]);

        return back()->with('success', 'Anggota berhasil ditugaskan ke jabatan.');
    }

    /**
     * Remove a member from a position.
     */
    public function removeMember(OrganizationPosition $position, $memberId)
    {
        $member = $position->members()->find($memberId);
        if ($member) {
            $member->delete();
        }

        return back()->with('deleted', 'Anggota berhasil dihapus dari jabatan.');
    }

    /**
     * Reorder positions.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'positions' => 'required|array',
            'positions.*.id' => 'required|exists:organization_positions,id',
            'positions.*.order' => 'required|integer|min:0',
            'positions.*.children' => 'array',
        ]);

        foreach ($request->positions as $positionData) {
            $this->updatePositionOrder($positionData, null);
        }

        return response()->json(['message' => 'Struktur berhasil diperbarui.']);
    }

    /**
     * Get positions tree for a specific organization
     */
    private function getPositionsTree($organizationId, $parentId = null)
    {
        $positions = OrganizationPosition::where('organization_id', $organizationId)
            ->where('parent_id', $parentId)
            ->with(['members.user', 'organization'])
            ->orderBy('order_number')
            ->get();

        foreach ($positions as $position) {
            $position->children = $this->getPositionsTree($organizationId, $position->id);
        }

        return $positions;
    }

    /**
     * Build chart nodes for frontend visualization
     */
    private function buildChartNodes($positions, $organizationId, $parentTitle = 'root')
    {
        $nodes = [];

        foreach ($positions as $position) {
            $nodes[] = [
                'id' => $position->id,
                'pid' => $position->parent_id ?: null,
                'title' => $position->title,
                'name' => $position->name ?? $position->title,
                'depth' => $position->computeDepth(),
            ];

            if ($position->children->count() > 0) {
                $nodes = array_merge($nodes, $this->buildChartNodes($position->children, $organizationId, $position->title));
            }
        }

        return $nodes;
    }

    /**
     * API endpoint to return tree data as JSON for frontend
     */
    public function apiTree(Organization $organization)
    {
        $positions = OrganizationPosition::where('organization_id', $organization->id)
            ->with(['children', 'members.user'])
            ->whereNull('parent_id')
            ->orderBy('order_number')
            ->get();

        return response()->json($this->formatTreeForApi($positions));
    }

    /**
     * Format the tree structure for API response
     */
    private function formatTreeForApi($positions)
    {
        $result = [];

        foreach ($positions as $position) {
            $item = [
                'id' => $position->id,
                'title' => $position->title,
                'name' => $position->name ?? $position->title,
                'parent_id' => $position->parent_id,
                'order_number' => $position->order_number,
                'depth' => $position->computeDepth(),
                'children' => []
            ];

            if ($position->children->count() > 0) {
                $item['children'] = $this->formatTreeForApi($position->children);
            }

            $result[] = $item;
        }

        return $result;
    }

    /**
     * Generate SVG for organization chart
     */
    public function generateSvgChart(Organization $organization)
    {
        $positions = $organization->positions()->whereNull('parent_id')->with(['children' => function($query) {
            $query->with(['children' => function($subQuery) {
                $subQuery->with('children');
            }]);
        }])->get();

        // Build complete SVG with proper layout
        $svg = $this->generateOrganizationalChartSvg($positions, $organization->name);

        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'no-cache');
    }

    /**
     * Generate SVG for organization chart (public access)
     */
    public function generatePublicSvgChart(Organization $organization)
    {
        $positions = $organization->positions()->whereNull('parent_id')->with(['children' => function($query) {
            $query->with(['children' => function($subQuery) {
                $subQuery->with('children');
            }]);
        }])->get();

        // Build complete SVG with proper layout
        $svg = $this->generateOrganizationalChartSvg($positions, $organization->name);

        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'no-cache');
    }
    
    /**
     * Generate organizational chart SVG with proper layout
     */
    private function generateOrganizationalChartSvg($positions, $orgName)
    {
        // Calculate the complete layout first
        $layout = $this->calculateLayout($positions);
        
        $svg = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<svg width="100%" height="100%" viewBox="0 0 '.($layout['width'] + 100).' '.($layout['height'] + 100).'" xmlns="http://www.w3.org/2000/svg" font-family="Inter, sans-serif">
  <defs>
    <filter id="shadow" x="-20%" y="-20%" width="140%" height="140%">
      <feDropShadow dx="0" dy="2" stdDeviation="4" flood-color="#000" flood-opacity="0.1"/>
    </filter>
  </defs>
  <g font-family="sans-serif" font-size="14">
    <text x="20" y="30" font-size="20" font-weight="bold" fill="#333">'.htmlspecialchars($orgName).'</text>
  </g>
  '.$layout['svg'].'
</svg>';
        
        return $svg;
    }

    /**
     * Calculate the complete layout for the organizational chart with pyramid shape (narrow at top)
     */
    private function calculateLayout($positions)
    {
        $svg = '';
        $nodeHeight = 70;
        $verticalSpacing = 150;
        $horizontalSpacing = 40;

        // Calculate the depth of the tree and organize nodes by level
        $levels = [];
        $this->organizeByLevel($positions, $levels, 0);

        $totalLevels = count($levels);
        $maxWidth = 1400;
        $totalHeight = $totalLevels * $verticalSpacing + 100;

        // Calculate positions from top to bottom to create pyramid shape (narrow at top)
        $levelData = [];

        for ($level = 0; $level < $totalLevels; $level++) {
            $levelPositions = $levels[$level];
            $levelNodeCount = count($levelPositions);

            // Calculate total width needed for this level
            $totalLevelWidth = 0;
            $levelInfo = [];

            foreach ($levelPositions as $position) {
                // Calculate width for each node based on text length
                $titleWidth = max(140, (strlen($position->title) * 7) + 20);
                $nameWidth = max(140, (strlen($position->name ?? '') * 6) + 20);
                $boxWidth = max($titleWidth, $nameWidth, 140);

                $levelInfo[] = [
                    'position' => $position,
                    'width' => $boxWidth
                ];

                $totalLevelWidth += $boxWidth + $horizontalSpacing;
            }

            // Remove the extra spacing after the last node
            if ($levelNodeCount > 0) {
                $totalLevelWidth -= $horizontalSpacing;
            }

            // Calculate starting X position to center this level
            $startX = max(0, ($maxWidth - $totalLevelWidth) / 2);

            // Calculate Y position (from top)
            $yPos = 80 + $level * $verticalSpacing;

            // Store the calculated positions for this level
            $levelData[$level] = [
                'positions' => $levelInfo,
                'startX' => $startX,
                'yPos' => $yPos
            ];
        }

        // Draw nodes from each level
        foreach ($levelData as $level => $levelInfo) {
            $xPos = $levelInfo['startX'];
            $yPos = $levelInfo['yPos'];

            foreach ($levelInfo['positions'] as $nodeData) {
                $position = $nodeData['position'];
                $boxWidth = $nodeData['width'];

                // Calculate center position for this node
                $centerX = $xPos + $boxWidth/2;

                // Draw the node
                $svg .= "<g transform=\"translate({$xPos}, {$yPos})\" data-node-id=\"{$position->id}\">\n";
                $svg .= "  <rect x=\"0\" y=\"0\" width=\"{$boxWidth}\" height=\"{$nodeHeight}\" rx=\"8\" ry=\"8\" fill=\"white\" stroke=\"#ccc\" stroke-width=\"1\" filter=\"url(#shadow)\"/>\n";
                $svg .= "  <text x=\"".($boxWidth/2)."\" y=\"25\" font-size=\"16\" font-weight=\"600\" text-anchor=\"middle\" fill=\"#333\">".htmlspecialchars($position->title)."</text>\n";
                $svg .= "  <text x=\"".($boxWidth/2)."\" y=\"45\" font-size=\"12\" text-anchor=\"middle\" fill=\"#666\">".htmlspecialchars($position->name ?? '')."</text>\n";
                $svg .= "</g>\n";

                // Store position for connection lines
                $position->svgX = $centerX;
                $position->svgY = $yPos + $nodeHeight;

                // Move x position to next node
                $xPos += $boxWidth + $horizontalSpacing;
            }
        }

        // Draw connection lines ensuring each child connects to its actual parent
        for ($level = 0; $level < $totalLevels - 1; $level++) {
            $currentLevelPositions = $levels[$level];
            $nextLevelPositions = $levels[$level + 1]; // Get children from next level

            // We need to find children of each position in the current level
            $positionsById = [];
            foreach ($nextLevelPositions as $pos) {
                $positionsById[$pos->id] = $pos;
            }

            foreach ($currentLevelPositions as $position) {
                // Find the actual children of this position from the next level
                $actualChildren = [];
                foreach ($nextLevelPositions as $child) {
                    if ($child->parent_id == $position->id) {
                        $actualChildren[] = $child;
                    }
                }

                if (count($actualChildren) > 0) {
                    if (count($actualChildren) == 1) {
                        // Single child: draw direct straight line
                        $child = $actualChildren[0];
                        $svg .= "<line x1=\"{$position->svgX}\" y1=\"{$position->svgY}\" x2=\"{$child->svgX}\" y2=\"".($child->svgY - $nodeHeight)."\" stroke=\"#777\" stroke-width=\"2\" stroke-linecap=\"round\"/>\n";
                    } else {
                        // Multiple children: use patah-patah approach
                        // Vertical line from parent
                        $junctionY = $position->svgY + 25;
                        $svg .= "<line x1=\"{$position->svgX}\" y1=\"{$position->svgY}\" x2=\"{$position->svgX}\" y2=\"{$junctionY}\" stroke=\"#777\" stroke-width=\"2\" stroke-linecap=\"round\"/>\n";

                        // Horizontal line connecting all children
                        $childXCoords = [];
                        foreach ($actualChildren as $child) {
                            $childXCoords[] = $child->svgX;
                        }

                        if (!empty($childXCoords)) {
                            sort($childXCoords);
                            $firstChildX = $childXCoords[0];
                            $lastChildX = end($childXCoords);

                            // Draw horizontal line only if there are multiple distinct positions
                            if ($firstChildX != $lastChildX) {
                                $svg .= "<line x1=\"{$firstChildX}\" y1=\"{$junctionY}\" x2=\"{$lastChildX}\" y2=\"{$junctionY}\" stroke=\"#777\" stroke-width=\"2\" stroke-linecap=\"round\"/>\n";
                            }

                            // Vertical lines from horizontal line to each child
                            foreach ($actualChildren as $child) {
                                $svg .= "<line x1=\"{$child->svgX}\" y1=\"{$junctionY}\" x2=\"{$child->svgX}\" y2=\"".($child->svgY - $nodeHeight)."\" stroke=\"#777\" stroke-width=\"2\" stroke-linecap=\"round\"/>\n";
                            }
                        }
                    }
                }
            }
        }

        return [
            'svg' => $svg,
            'width' => $maxWidth,
            'height' => $totalHeight
        ];
    }

    /**
     * Organize positions by level for layout calculation
     */
    private function organizeByLevel($positions, &$result, $level)
    {
        if ($level === 0) {
            $result = [];
        }

        if (!isset($result[$level])) {
            $result[$level] = [];
        }

        foreach ($positions as $position) {
            $result[$level][] = $position;

            if ($position->children && $position->children->count() > 0) {
                $this->organizeByLevel($position->children, $result, $level + 1);
            }
        }
    }

    private function updatePositionOrder($positionData, $parentId)
    {
        $position = OrganizationPosition::find($positionData['id']);
        if ($position) {
            $position->update([
                'order_number' => $positionData['order'],
                'parent_id' => $parentId,
            ]);

            if (isset($positionData['children']) && is_array($positionData['children'])) {
                foreach ($positionData['children'] as $index => $childData) {
                    $this->updatePositionOrder($childData, $position->id);
                }
            }
        }
    }
}