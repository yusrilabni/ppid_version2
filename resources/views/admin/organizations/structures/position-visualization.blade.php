<div class="flex flex-col items-center">
    <!-- Position Card -->
    <div class="bg-white border border-blue-200 rounded-lg shadow-sm p-3 min-w-[180px] text-center mb-4">
        <h5 class="font-semibold text-gray-800">{{ $position->title }}</h5>
        @if($position->name)
            <p class="text-sm text-gray-600">{{ $position->name }}</p>
        @endif
        @if($position->members->count() > 0)
            <div class="mt-2">
                @foreach($position->members->take(2) as $member)
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1 mb-1">{{ $member->user->name }}</span>
                @endforeach
                @if($position->members->count() > 2)
                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">+{{ $position->members->count() - 2 }}</span>
                @endif
            </div>
        @endif
    </div>

    <!-- Children Positions -->
    @if($position->children->count() > 0)
        <div class="flex flex-col items-center">
            <!-- Connection Line -->
            <div class="h-4 w-0.5 bg-gray-300"></div>
            
            <div class="flex flex-wrap justify-center gap-4 mt-2">
                @foreach($position->children as $child)
                    <div class="flex flex-col items-center">
                        @include('admin.organizations.structures.position-visualization', [
                            'position' => $child,
                            'level' => $level + 1,
                            'organization' => $organization
                        ])
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>