<div class="flex flex-col items-center mx-2">
    <!-- Position card -->
    <div class="bg-white border border-gray-300 rounded-lg p-3 text-center shadow-sm min-w-[140px]">
        <h6 class="font-medium text-gray-800 text-sm leading-tight">{{ $position->title }}</h6>
        @if($position->name && $position->name !== $position->title)
            <p class="text-xs text-gray-600 mt-1">{{ $position->name }}</p>
        @endif
    </div>

    <!-- Children if any -->
    @if($position->children->count() > 0)
        <!-- Vertical connector down from parent -->
        <div class="w-0.5 h-4 bg-gray-400"></div>

        <!-- Horizontal connector line -->
        <div class="relative">
            @php
                $childCount = $position->children->count();
                $totalWidth = $childCount * 160 + ($childCount - 1) * 40; // 140px card + 40px gap
            @endphp

            <!-- Horizontal line across all children -->
            <div class="h-0.5 bg-gray-400" style="width: {{ $totalWidth }}px;"></div>

            <!-- Children container -->
            <div class="flex justify-center gap-10 mt-0 pt-2">
                @foreach($position->children as $index => $child)
                    <div class="flex flex-col items-center relative">
                        <!-- Vertical connector up to horizontal line -->
                        <div class="w-0.5 h-4 bg-gray-400 absolute -top-4" style="left: 50%; transform: translateX(-50%);"></div>
                        <!-- Child position recursively -->
                        @include('admin.organizations.shared.position-node', [
                            'position' => $child,
                            'level' => $level + 1
                        ])
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>