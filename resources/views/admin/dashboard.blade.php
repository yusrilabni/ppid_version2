@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-6 md:p-10 space-y-12 bg-gray-50/30 min-h-screen">
    
    {{-- I. GRUP: INFORMASI & LAYANAN PUBLIK --}}
    <section>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-1.5 h-6 bg-blue-600 rounded-full"></div>
            <h2 class="text-lg font-black text-gray-800 uppercase tracking-tight">Informasi & Layanan</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Informasi --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col group hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-inner group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Informasi</p>
                        <p class="text-2xl font-black text-gray-900 leading-tight">{{ number_format($stats['informasi']['total']) }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-auto border-t pt-4">
                    <div class="text-[10px] font-bold text-gray-500 uppercase">Berkala: <span class="text-blue-600">{{ $stats['informasi']['berkala'] }}</span></div>
                    <div class="text-[10px] font-bold text-gray-500 uppercase">Setiap Saat: <span class="text-green-600">{{ $stats['informasi']['setiap_saat'] }}</span></div>
                </div>
            </div>

            {{-- Permohonan --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col group hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Permohonan</p>
                        <p class="text-2xl font-black text-gray-900 leading-tight">{{ number_format($stats['permohonan']['total']) }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-1 mt-auto border-t pt-4 text-center">
                    <div><p class="text-[8px] font-bold text-gray-400 uppercase">Wait</p><p class="text-[10px] font-black text-yellow-600">{{ $stats['permohonan']['pending'] }}</p></div>
                    <div><p class="text-[8px] font-bold text-gray-400 uppercase">Proses</p><p class="text-[10px] font-black text-blue-600">{{ $stats['permohonan']['diproses'] }}</p></div>
                    <div><p class="text-[8px] font-bold text-gray-400 uppercase">Done</p><p class="text-[10px] font-black text-green-600">{{ $stats['permohonan']['selesai'] }}</p></div>
                </div>
            </div>

            {{-- Kunjungan --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col group hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shadow-inner group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Kunjungan</p>
                        <p class="text-2xl font-black text-gray-900 leading-tight">{{ number_format($stats['activity']['visitors']) }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-auto border-t pt-4">
                    <div class="text-[10px] font-bold text-gray-500 uppercase italic">Page Views: <span class="text-purple-600">{{ number_format($stats['activity']['views']) }}</span></div>
                </div>
            </div>

            {{-- Downloads --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col group hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-inner group-hover:bg-amber-600 group-hover:text-white transition-colors">
                        <i class="fas fa-cloud-download-alt"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Unduhan</p>
                        <p class="text-2xl font-black text-gray-900 leading-tight">{{ number_format($stats['activity']['downloads']) }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-auto border-t pt-4">
                    <div class="text-[10px] font-bold text-gray-500 uppercase italic">Dokumen Terunduh</div>
                </div>
            </div>
        </div>
    </section>

    {{-- II. GRUP: SDM & ORGANISASI --}}
    <section>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-1.5 h-6 bg-emerald-600 rounded-full"></div>
            <h2 class="text-lg font-black text-gray-800 uppercase tracking-tight">SDM & Struktur Organisasi</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Pimpinan --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shadow-inner group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pimpinan</p>
                    <p class="text-2xl font-black text-gray-900">{{ number_format($stats['official']['total']) }}</p>
                </div>
            </div>

            {{-- LHKPN --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-2xl shadow-inner group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">LHKPN</p>
                    <p class="text-2xl font-black text-gray-900">{{ number_format($stats['official']['active']) }} <span class="text-[10px] text-gray-400 font-bold uppercase">Terdata</span></p>
                </div>
            </div>

            {{-- Organisasi --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-2xl shadow-inner group-hover:bg-teal-600 group-hover:text-white transition-colors">
                    <i class="fas fa-sitemap"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">OPD / Unit</p>
                    <p class="text-2xl font-black text-gray-900">{{ number_format($stats['organization']['total']) }}</p>
                </div>
            </div>

            {{-- Users --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-gray-50 text-gray-600 flex items-center justify-center text-2xl shadow-inner group-hover:bg-gray-800 group-hover:text-white transition-colors">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">User Admin</p>
                    <p class="text-2xl font-black text-gray-900">{{ number_format($stats['user']['total']) }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- III. GRUP: WEBSITE & INTERAKSI --}}
    <section>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-1.5 h-6 bg-pink-600 rounded-full"></div>
            <h2 class="text-lg font-black text-gray-800 uppercase tracking-tight">Website & Interaksi</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Sliders --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center text-2xl shadow-inner group-hover:bg-pink-600 group-hover:text-white transition-colors">
                    <i class="fas fa-images"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Sliders</p>
                    <p class="text-2xl font-black text-gray-900">{{ number_format($stats['slider']['total']) }}</p>
                </div>
            </div>

            {{-- Galeri --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl shadow-inner group-hover:bg-rose-600 group-hover:text-white transition-colors">
                    <i class="fas fa-photo-video"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Galeri</p>
                    <p class="text-2xl font-black text-gray-900">{{ number_format($stats['galeri']['total']) }}</p>
                </div>
            </div>

            {{-- Survei --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center text-2xl shadow-inner group-hover:bg-violet-600 group-hover:text-white transition-colors">
                    <i class="fas fa-poll"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Survei</p>
                    <p class="text-2xl font-black text-gray-900">{{ number_format($stats['survey_response']['total']) }} <span class="text-[10px] text-gray-400 font-bold uppercase">Respon</span></p>
                </div>
            </div>

            {{-- Pemasangan --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-2xl shadow-inner group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <i class="fas fa-link"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pemasangan</p>
                    <p class="text-2xl font-black text-gray-900">{{ number_format($externalWebsitesCount ?? 0) }} <span class="text-[10px] text-gray-400 font-bold uppercase">Web</span></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content: Charts & External Installs -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Chart Section --}}
        <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight flex items-center gap-3">
                    <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                    Statistik Kunjungan 30 Hari Terakhir
                </h3>
                <div class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase">Live Stats</div>
            </div>
            <div class="h-80 w-full">
                <canvas id="visitChart"></canvas>
            </div>
        </div>

        {{-- External Installation Table --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex flex-col overflow-hidden relative">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight">Pemasangan Luar</h3>
                <a href="{{ route('admin.reports.index', ['tab' => 'external']) }}" class="text-[10px] font-black text-blue-600 hover:underline uppercase">Lihat Semua</a>
            </div>
            
            @if(Auth::user()->isSuperAdmin())
                <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($externalLogs as $log)
                        <div class="flex items-center justify-between p-4 mb-3 bg-gray-50 rounded-2xl border border-transparent hover:border-blue-200 transition-all group/item">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-gray-400 shadow-sm group-hover/item:text-blue-500 transition-colors">
                                    <i class="fas fa-globe text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-black text-gray-800 truncate">{{ $log->domain }}</p>
                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">{{ $log->type }} • {{ \Carbon\Carbon::parse($log->last_access)->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-gray-900">{{ number_format($log->access_count) }}</p>
                                <p class="text-[8px] font-black text-gray-300 uppercase tracking-tighter">Hits</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full text-center py-10">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-link-slash text-gray-200 text-2xl"></i>
                            </div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-loose">Belum ada website luar<br>yang terdeteksi</p>
                        </div>
                    @endforelse
                </div>
            @else
                <div class="bg-blue-50 p-6 rounded-2xl text-center">
                    <i class="fas fa-shield-alt text-blue-200 text-3xl mb-3"></i>
                    <p class="text-xs font-bold text-blue-800 leading-relaxed uppercase tracking-tighter">Hanya dapat diakses oleh Super Admin Kabupaten</p>
                </div>
            @endif
        </div>
    </div>

    <!-- AI Usage Tracking Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
        {{-- Token Tracking --}}
        <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight flex items-center gap-3">
                    <span class="w-1.5 h-6 bg-purple-600 rounded-full"></span>
                    Tracking Penggunaan AI (Hari Ini)
                </h3>
                <a href="{{ route('admin.ai-settings.index') }}" class="text-[10px] font-black text-purple-600 hover:underline uppercase">Kelola Token</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($aiStats as $ai)
                    <div class="bg-gray-50 rounded-2xl p-5 border {{ $ai['is_active'] ? 'border-purple-200' : 'border-gray-100 opacity-70' }}">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-xs font-black text-gray-800">{{ $ai['provider'] }}</p>
                                <p class="text-[9px] text-gray-500 font-bold uppercase tracking-tighter">{{ $ai['model'] }}</p>
                            </div>
                            @if($ai['is_active'])
                                <span class="bg-purple-100 text-purple-700 text-[8px] font-black uppercase px-2 py-1 rounded-lg">Aktif</span>
                            @else
                                <span class="bg-gray-200 text-gray-600 text-[8px] font-black uppercase px-2 py-1 rounded-lg">Nonaktif</span>
                            @endif
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Big Numbers -->
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <p class="text-2xl font-black text-gray-900 leading-none">{{ number_format($ai['usage_today']) }}</p>
                                    <p class="text-[9px] font-black text-gray-400 uppercase mt-1">Requests</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-black text-purple-600 leading-none">{{ number_format($ai['token_words_today']) }}</p>
                                    <p class="text-[9px] font-black text-purple-400 uppercase mt-1">Token Teks</p>
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            <!-- Sisa Requests -->
                            <div>
                                <div class="flex justify-between items-end mb-1">
                                    <p class="text-[10px] font-black text-gray-500 uppercase">Sisa Req</p>
                                    <p class="text-[10px] font-black text-gray-900">{{ number_format($ai['remaining_req']) }} <span class="text-gray-400 font-normal">/ {{ number_format($ai['limit_req']) }}</span></p>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                    @php
                                        $percentReq = min(100, ($ai['usage_today'] / $ai['limit_req']) * 100);
                                        $colorReq = $percentReq > 80 ? 'bg-red-500' : ($percentReq > 50 ? 'bg-yellow-400' : 'bg-blue-500');
                                    @endphp
                                    <div class="{{ $colorReq }} h-1.5 rounded-full" style="width: {{ $percentReq }}%"></div>
                                </div>
                            </div>

                            <!-- Sisa Token Teks -->
                            <div>
                                <div class="flex justify-between items-end mb-1">
                                    <p class="text-[10px] font-black text-purple-500 uppercase">Sisa Token Teks</p>
                                    <p class="text-[10px] font-black text-purple-900">{{ number_format($ai['remaining_tokens']) }} <span class="text-purple-400 font-normal">/ 1.5M</span></p>
                                </div>
                                <div class="w-full bg-purple-100 rounded-full h-1.5">
                                    @php
                                        $percentTok = min(100, ($ai['token_words_today'] / $ai['limit_tokens']) * 100);
                                        $colorTok = $percentTok > 80 ? 'bg-red-500' : ($percentTok > 50 ? 'bg-orange-400' : 'bg-purple-500');
                                    @endphp
                                    <div class="{{ $colorTok }} h-1.5 rounded-full" style="width: {{ $percentTok }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-8 text-center bg-gray-50 rounded-2xl">
                        <i class="fas fa-robot text-3xl text-gray-300 mb-3"></i>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Belum ada API Key yang dikonfigurasi</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Top Users AI --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex flex-col overflow-hidden relative">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight flex items-center gap-3">
                    <span class="w-1.5 h-6 bg-pink-500 rounded-full"></span>
                    Pengguna AI
                </h3>
                <span class="text-[10px] font-black text-pink-500 bg-pink-50 px-3 py-1 rounded-full uppercase">{{ count($aiUserStats) }} OPD</span>
            </div>
            
            <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
                @forelse($aiUserStats as $userStat)
                    <div class="flex items-center justify-between p-4 mb-3 bg-gray-50 rounded-2xl border border-transparent hover:border-pink-200 transition-all group/item">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-gray-400 shadow-sm group-hover/item:text-pink-500 transition-colors">
                                <i class="fas fa-user-astronaut text-sm"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-black text-gray-800 truncate">{{ $userStat['name'] }}</p>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter truncate" title="{{ $userStat['dinas'] }}">{{ Str::limit($userStat['dinas'], 30) }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-gray-900">{{ number_format($userStat['count']) }}</p>
                            <p class="text-[8px] font-black text-gray-300 uppercase tracking-tighter">Kali</p>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center h-full text-center py-10">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-bed text-gray-200 text-2xl"></i>
                        </div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-loose">Belum ada OPD yang<br>memakai AI hari ini</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="mt-8 bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
            <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight flex items-center gap-3">
                <span class="w-1.5 h-6 bg-indigo-600 rounded-full"></span>
                Aktivitas Terbaru
            </h3>
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">30 Data Terakhir</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white border-b border-gray-50">
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tipe</th>
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Konten / Judul</th>
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Dibuat Oleh</th>
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($allRecentActivity as $activity)
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 text-[9px] font-black uppercase tracking-widest rounded-lg border 
                                    @if($activity->type === 'Informasi') bg-blue-50 text-blue-600 border-blue-100
                                    @elseif($activity->type === 'Galeri') bg-purple-50 text-purple-600 border-purple-100
                                    @else bg-green-50 text-green-600 border-green-100 @endif">
                                    {{ $activity->type }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition-colors line-clamp-1 leading-tight">{{ $activity->title }}</p>
                                <p class="text-[10px] text-gray-400 font-medium mt-1 uppercase tracking-tighter">{{ $activity->category ?? ($activity->gallery_type ?? 'Dokumen') }}</p>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-500 border border-white shadow-sm">
                                        {{ substr($activity->uploader_name, 0, 1) }}
                                    </div>
                                    <span class="text-xs font-bold text-gray-600">{{ $activity->uploader_name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <span class="text-[10px] font-bold text-gray-400 uppercase">{{ \Carbon\Carbon::parse($activity->date)->diffForHumans() }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('visitChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Kunjungan Harian',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#3b82f6',
                    borderWidth: 4,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' } },
                    x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' } }
                }
            }
        });
    });
</script>
@endsection
