@php
    $photoUrl = $item->photo ? asset('storage/' . $item->photo) : null;
    $photoExists = $photoUrl && file_exists(public_path('storage/' . $item->photo));
    $allLhkpns = $item->lhkpns->sortByDesc('report_year');
@endphp

<div class="bg-white rounded-3xl shadow-md hover:shadow-2xl border border-gray-100 overflow-hidden flex flex-col transition-all duration-500 hover:-translate-y-2 group">
    
    <!-- Card Header / Image Section -->
    <div class="p-8 pb-4 flex flex-col items-center text-center">
        <div class="relative mb-6">
            <div class="absolute inset-0 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-full blur-lg opacity-20 group-hover:opacity-40 transition-opacity"></div>
            @if ($photoExists)
                <img class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-xl relative z-10" src="{{ $photoUrl }}" alt="{{ $item->full_name }}">
            @else
                <div class="w-28 h-28 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 border-4 border-white shadow-xl flex items-center justify-center text-gray-300 text-4xl relative z-10">
                    <i class="fas fa-{{ $item->type === 'unit' ? 'building' : 'user' }}"></i>
                </div>
            @endif
        </div>

        <h3 class="font-black text-gray-900 text-xl leading-tight mb-2 group-hover:text-blue-600 transition-colors">{{ $item->display_title }}</h3>
        <div class="inline-flex items-center px-3 py-1 bg-gray-50 rounded-full text-[10px] font-bold text-gray-400 uppercase tracking-tighter border border-gray-100 mb-4">
            <i class="fas fa-landmark mr-1.5 text-blue-400"></i>
            {{ $item->organization_name }}
        </div>
    </div>
    
    <!-- LHKPN List Section -->
    <div class="px-6 pb-8 pt-2 mt-auto">
        <div class="space-y-3">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-center border-b border-gray-50 pb-2 mb-4">Daftar Laporan Tersedia</p>
            
            @forelse($allLhkpns as $lhkpn)
                <a href="{{ route('frontend.lhkpn.view', $lhkpn) }}" target="_blank" 
                    class="w-full flex items-center justify-between bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white px-4 py-3 rounded-2xl transition-all duration-300 border border-blue-100 hover:border-blue-600 group/link">
                    <div class="flex items-center">
                        <i class="fas fa-file-pdf mr-3 text-blue-500 group-hover/link:text-white transition-colors"></i>
                        <span class="font-bold text-sm">TAHUN {{ $lhkpn->report_year }}</span>
                    </div>
                    <div class="flex flex-col items-end">
                        @if($lhkpn->full_name)
                            <span class="text-[9px] font-medium opacity-70 group-hover/link:text-white line-clamp-1 max-w-[120px]">{{ $lhkpn->full_name }}</span>
                        @endif
                        <i class="fas fa-external-link-alt text-[10px] opacity-30 group-hover/link:opacity-100"></i>
                    </div>
                </a>
            @empty
                <div class="w-full flex flex-col items-center justify-center bg-gray-50 text-gray-400 py-6 rounded-2xl border-2 border-dashed border-gray-100">
                    <i class="fas fa-folder-open mb-2 text-xl opacity-20"></i>
                    <span class="font-bold tracking-wide uppercase text-[10px]">Laporan Belum Tersedia</span>
                </div>
            @endforelse
        </div>
    </div>
</div>
