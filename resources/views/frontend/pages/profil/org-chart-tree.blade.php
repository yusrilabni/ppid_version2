@if($positions)
    <div class="org-level flex flex-col items-center">
        @foreach($positions as $position)
            <div class="org-node">
                <div class="org-node-title">{{ $position->title }}</div>
                @if($position->name && $position->name != $position->title)
                    <div class="org-node-name">{{ $position->name }}</div>
                @endif
                @if($position->members->count() > 0)
                    <div class="org-node-members">
                        @foreach($position->members as $member)
                            <div>{{ $member->user->name ?? 'N/A' }}</div>
                        @endforeach
                    </div>
                @endif
            </div>

            @if($position->children->count() > 0)
                <div class="org-children">
                    @include('frontend.pages.profil.org-chart-tree', ['positions' => $position->children, 'level' => $level + 1])
                </div>
            @endif
        @endforeach
    </div>
@endif