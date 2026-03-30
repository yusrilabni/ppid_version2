@if($positions)
    <div class="level-container level-{{ $level }}">
        <div class="position-row">
            @foreach($positions as $position)
                <div class="position-node level-{{ $level }}" data-position-id="{{ $position->id }}">
                    <div class="position-content">
                        <div class="position-title">{{ $position->title }}</div>
                        @if($position->name && $position->name != $position->title)
                            <div class="position-name">{{ $position->name }}</div>
                        @endif
                        @if($position->members->count() > 0)
                            <div class="position-members mt-2">
                                @foreach($position->members as $member)
                                    <div class="member-badge">{{ $member->user->name ?? 'N/A' }}</div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    @if($position->children->count() > 0)
                        <div class="children-connector">
                            <div class="connector-line vertical"></div>
                        </div>
                        
                        <div class="children-container">
                            <div class="children-connector">
                                <div class="connector-line horizontal"></div>
                            </div>
                            
                            <div class="sub-level">
                                @include('frontend.pages.profil.org-diagram-level', ['positions' => $position->children, 'level' => $level + 1])
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif