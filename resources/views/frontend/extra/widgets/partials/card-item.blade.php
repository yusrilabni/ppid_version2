@php
    $colors = ['blue', 'indigo', 'emerald', 'amber', 'rose', 'cyan', 'fuchsia'];
    $color = $colors[($index ?? 0) % count($colors)];
@endphp
<div class="info-card group bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl overflow-hidden flex flex-col h-full relative">
    <div class="absolute top-0 right-0 p-4 z-10">
         <div class="w-8 h-8 rounded-full bg-{{ $color }}-50 text-{{ $color }}-500 flex items-center justify-center group-hover:bg-{{ $color }}-500 group-hover:text-white transition-colors duration-300 shadow-sm">
             <i class="fas fa-arrow-up-right-from-square text-[10px]"></i>
         </div>
    </div>
    <div class="p-6 flex-1 flex flex-col">
        <div class="mb-4">
            <span class="text-[10px] font-extrabold uppercase tracking-widest text-{{ $color }}-600 bg-{{ $color }}-50 px-3 py-1 rounded-full border border-{{ $color }}-100">
                {{ $info->category }}
            </span>
        </div>
        <a href="{{ route('frontend.informasi.detail', $info->slug) }}" target="_blank" class="block flex-1">
            <h3 class="text-base font-extrabold text-gray-900 leading-tight group-hover:text-{{ $color }}-600 transition-colors line-clamp-3 mb-4">
                {{ $info->title }}
            </h3>
        </a>
        <div class="pt-4 border-t border-gray-50 flex items-center justify-between mt-auto">
            <div class="flex items-center space-x-3 text-[10px] font-bold text-gray-400">
                <span class="flex items-center"><i class="far fa-calendar-alt mr-1.5 text-{{ $color }}-400"></i> {{ \Carbon\Carbon::parse($info->tanggal_upload)->isoFormat('D MMM Y') }}</span>
                <span class="flex items-center"><i class="far fa-eye mr-1.5 text-{{ $color }}-400"></i> {{ number_format($info->views_count ?? 0) }}</span>
            </div>
        </div>
    </div>
</div>
