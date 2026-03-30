<div class="ml-4">
    <div class="p-3 bg-{{ $level == 0 ? 'blue' : ($level == 1 ? 'green' : ($level == 2 ? 'yellow' : ($level == 3 ? 'red' : 'purple'))) }}-50 rounded-lg border border-{{ $level == 0 ? 'blue' : ($level == 1 ? 'green' : ($level == 2 ? 'yellow' : ($level == 3 ? 'red' : 'purple'))) }}-100">
        <div>
            <h{{ min($level + 4, 6) }} class="font-medium text-gray-800">{{ $position->title }}</h{{ min($level + 4, 6) }}>
            <p class="text-sm text-gray-600">{{ $position->name ?? '' }}</p>
            @if($position->members->count() > 0)
                <div class="mt-1">
                    <span class="text-xs text-gray-500">Anggota:</span>
                    @foreach($position->members as $member)
                        <span class="text-xs bg-{{ $level == 0 ? 'blue' : ($level == 1 ? 'green' : ($level == 2 ? 'yellow' : ($level == 3 ? 'red' : 'purple'))) }}-100 text-{{ $level == 0 ? 'blue' : ($level == 1 ? 'green' : ($level == 2 ? 'yellow' : ($level == 3 ? 'red' : 'purple'))) }}-800 px-2 py-0.5 rounded-full ml-1">{{ $member->user->name }}</span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @if($position->children->count() > 0)
        <div class="relative pl-6 ml-4 border-l-2 border-gray-100 space-y-4 mt-4">
            @foreach($position->children as $childPosition)
                @include('frontend.pages.profil.text-hierarchy-position', [
                    'position' => $childPosition,
                    'level' => $level + 1
                ])
            @endforeach
        </div>
    @endif
</div>