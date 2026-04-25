@php
    $unitId = trim((string)$info->unit_id);
    $unit = ($unitMap ?? collect())->get($unitId);
    $unitName = $unit['unit_nama'] ?? ($info->organization->name ?? ($info->user->opd_name ?? 'Unit Tidak Terdaftar'));

    $uploaderName = 'Administrator';
    if ($info->user) {
        $user = $info->user;
        if ($user->role === 'superadmin') {
            if ($info->unit_id && (string)$info->unit_id !== (string)$user->unit_id) {
                $uploaderName = 'Admin PPID ' . $unitName;
            } else {
                $uploaderName = $user->name;
            }
        } else {
            $uploaderName = $user->name;
        }
    } else {
        $uploaderName = 'Admin PPID ' . $unitName;
    }

    $catColor = match($info->category) {
        'Informasi Berkala' => 'blue',
        'Informasi Setiap Saat' => 'green',
        'Informasi Serta Merta' => 'yellow',
        'Informasi Dikecualikan' => 'red',
        default => 'gray'
    };

    // FontAwesome equivalents for Lucide icons
    $unitIcon = 'fa-building';
    $calendarIcon = 'fa-calendar-alt';
    $fileIcon = 'fa-file-alt';
    $arrowIcon = 'fa-external-link-alt';
@endphp

<div class="bg-white rounded-3xl border-l-4 border-{{ $catColor }}-500 shadow-sm hover:shadow-2xl transition-all duration-500 h-full flex flex-col group/card p-5 hover:-translate-y-2 relative overflow-hidden">
    {{-- Decorative Background Icon --}}
    <div class="absolute -right-6 -top-6 text-{{ $catColor }}-50 group-hover/card:scale-110 transition-transform duration-700 opacity-30 pointer-events-none">
        <i class="fas {{ $fileIcon }} fa-9x"></i>
    </div>

    {{-- Header: Unit & Admin --}}
    <div class="mb-4 relative z-10">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-8 h-8 rounded-xl bg-{{ $catColor }}-50 flex items-center justify-center text-{{ $catColor }}-600 border border-{{ $catColor }}-100/50 shadow-sm">
                <i class="fas {{ $unitIcon }} text-xs"></i>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="text-[10px] font-extrabold text-gray-800 uppercase tracking-tight line-clamp-1 leading-tight">{{ $unitName }}</span>
                <span class="text-[8px] text-gray-400 font-bold uppercase tracking-wider">Oleh: {{ $uploaderName }}</span>
            </div>
        </div>
    </div>

    {{-- Title --}}
    <a href="{{ route('frontend.informasi.detail', $info->slug) }}" target="_blank" class="block mb-4 relative z-10 flex-1">
        <h3 class="text-gray-900 font-bold text-sm line-clamp-2 leading-tight group-hover/card:text-{{ $catColor }}-600 transition-colors">
            {{ $info->title }}
        </h3>
    </a>

    {{-- Footer Info --}}
    <div class="mt-auto pt-4 border-t border-gray-50 flex items-end justify-between relative z-10">
        <div class="flex flex-col gap-2">
            <div class="flex flex-col gap-1">
                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest flex items-center">
                    <i class="fas {{ $calendarIcon }} mr-1.5 text-blue-500"></i>
                    {{ \Carbon\Carbon::parse($info->tanggal_upload)->locale('id')->isoFormat('D MMMM Y') }}
                </span>
                <span class="text-[9px] text-gray-500 font-bold flex items-center">
                    <i class="fas {{ $fileIcon }} mr-1.5 text-blue-500"></i>
                    {{ Str::limit($info->jenis_dokumen ?: 'Dokumen Publik', 25) }}
                </span>
            </div>
            <span class="inline-flex items-center w-fit text-[8px] font-black px-2 py-0.5 rounded-lg bg-{{ $catColor }}-50 text-{{ $catColor }}-600 border border-{{ $catColor }}-100 uppercase tracking-wider">
                {{ $info->category }}
            </span>
        </div>
        
        <a href="{{ route('frontend.informasi.detail', $info->slug) }}" target="_blank" 
           class="w-10 h-10 rounded-2xl bg-gray-900 text-white flex items-center justify-center hover:bg-{{ $catColor }}-600 transition-all shadow-lg active:scale-90 group/btn">
            <i class="fas {{ $arrowIcon }} text-sm group-hover/btn:scale-110 transition-transform"></i>
        </a>
    </div>
</div>
