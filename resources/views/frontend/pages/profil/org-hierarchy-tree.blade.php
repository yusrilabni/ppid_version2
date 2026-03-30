@if($positions)
    <ul class="hierarchy-list @if($level == 0) root-list @endif">
        @foreach($positions as $position)
            <li class="hierarchy-item level-{{ $level }}">
                <div class="position-card">
                    <div class="position-title">{{ $position->title }}</div>
                    @if($position->name && $position->name != $position->title)
                        <div class="position-name">{{ $position->name }}</div>
                    @endif
                    @if($position->members->count() > 0)
                        <div class="position-members mt-2">
                            @foreach($position->members as $member)
                                <div class="member-item">{{ $member->user->name ?? 'N/A' }}</div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                @if($position->children->count() > 0)
                    <div class="children-container">
                        @include('frontend.pages.profil.org-hierarchy-tree', ['positions' => $position->children, 'level' => $level + 1])
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
@endif