<div class="group h-full bg-white rounded-[2.5rem] shadow-md hover:shadow-2xl border border-gray-100 overflow-hidden flex flex-col transition-all duration-500 hover:-translate-y-2 relative">
    <!-- Decorative background -->
    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-br from-gray-50 to-white opacity-50"></div>
    
    <div class="p-8 pb-8 flex flex-col items-center text-center flex-grow relative z-10">
        {{-- Profile Image Section --}}
        <div class="relative mb-6">
            <div class="absolute inset-0 bg-blue-600 rounded-full blur-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
            
            @php
                $leader = \App\Models\Official::where('organization_id', $organization->id)
                    ->where('status', 'active')
                    ->first();
            @endphp

            @if($leader && $leader->photo)
                <img src="{{ asset('storage/' . $leader->photo) }}"
                     alt="{{ $leader->full_name }}"
                     class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover border-4 border-white shadow-2xl relative z-10 transition-transform duration-500 group-hover:scale-105">
            @else
                <div class="w-32 h-32 md:w-36 md:h-36 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 border-4 border-white shadow-2xl flex items-center justify-center text-gray-300 text-4xl md:text-5xl relative z-10">
                    <i class="fas fa-building"></i>
                </div>
            @endif
        </div>

        <div class="min-h-[4rem] flex items-center justify-center mb-2">
            <h3 class="text-xl font-black text-gray-900 leading-tight group-hover:text-blue-600 transition-colors">
                {{ $organization->name }}
            </h3>
        </div>

        @if($leader)
            <p class="text-sm font-bold text-gray-500 mb-4 min-h-[1.25rem]">{{ $leader->full_name }}</p>
        @else
            <div class="mb-4 min-h-[1.25rem]"></div>
        @endif
        
        <div class="flex items-start text-gray-500 font-bold text-[11px] mb-8 bg-gray-50 px-5 py-3 rounded-2xl border border-gray-100 w-full min-h-[60px]">
            <i class="fas fa-map-marker-alt mr-3 mt-0.5 text-blue-400"></i>
            <span class="leading-relaxed text-left line-clamp-2">{!! $organization->api_address ?? 'Alamat belum ditambahkan.' !!}</span>
        </div>

        <div class="mt-auto space-y-3 w-full">
            <a href="{{ route('opd.detail', $organization) }}" class="inline-flex items-center justify-center w-full bg-blue-600 text-white font-black text-xs py-4 rounded-2xl transition-all duration-500 uppercase tracking-widest gap-2 shadow-lg shadow-blue-100 group-hover:shadow-blue-200">
                <i class="fas fa-sitemap mr-1"></i> Struktur & Website
            </a>

            @auth
                @php
                    $canManage = false;
                    $user = auth()->user();
                    if ($user->isSuperAdmin()) {
                        $canManage = true;
                    } elseif ($user->unit_id && (string)$user->unit_id === (string)$organization->remote_id) {
                        $canManage = true;
                    } elseif (isset($api_unit_id) && (string)$api_unit_id === (string)$organization->remote_id) {
                        $canManage = true;
                    }
                @endphp

                @if ($canManage)
                    <div class="pt-2">
                        <a href="{{ route('opd.manage-public', ['organization' => $organization->id]) }}" class="inline-flex items-center justify-center w-full bg-white text-blue-600 border-2 border-blue-100 hover:border-blue-500 hover:bg-blue-50 font-black text-xs py-4 rounded-2xl transition-all duration-500 uppercase tracking-widest gap-2">
                            <i class="fas fa-edit"></i> Kelola Profil Unit
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>
