@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-6 md:p-10 space-y-8 bg-gray-50/30 min-h-screen">
    
    <!-- Top Statistics Grid (Modern & Compact) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Card: Total Informasi --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shadow-inner group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <i class="fas fa-file-alt"></i>
            </div>
            <div>
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Informasi</p>
                <p class="text-2xl font-black text-gray-900">{{ number_format($stats['informasi']['total']) }}</p>
            </div>
        </div>

        {{-- Card: Permohonan --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                <i class="fas fa-paper-plane"></i>
            </div>
            <div>
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Permohonan</p>
                <p class="text-2xl font-black text-gray-900">{{ number_format($stats['permohonan']['total']) }}</p>
            </div>
        </div>

        {{-- Card: Pengunjung --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl shadow-inner group-hover:bg-purple-600 group-hover:text-white transition-colors">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Kunjungan</p>
                <p class="text-2xl font-black text-gray-900">{{ number_format($stats['activity']['visitors']) }}</p>
            </div>
        </div>

        {{-- Card: Widget Installs --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-14 h-14 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center text-2xl shadow-inner group-hover:bg-pink-600 group-hover:text-white transition-colors">
                <i class="fas fa-link"></i>
            </div>
            <div>
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Pemasangan</p>
                <p class="text-2xl font-black text-gray-900">{{ number_format($externalWebsitesCount ?? 0) }} <span class="text-[10px] text-gray-400 font-bold">Web</span></p>
            </div>
        </div>
    </div>

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

        {{-- External Installation Table (NEW) --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight">Pemasangan Luar</h3>
                <a href="{{ route('admin.reports.index', ['tab' => 'external']) }}" class="text-[10px] font-black text-blue-600 hover:underline uppercase">Lihat Semua</a>
            </div>
            
            @if(Auth::user()->isSuperAdmin())
                <div class="flex-1">
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

    <!-- Recent Activity Section -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('visitChart').getContext('2d');
        
        // Gradient effect
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)');
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
                    pointRadius: 6,
                    pointHoverRadius: 8
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
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        cornerRadius: 12,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9', drawBorder: false },
                        ticks: { font: { size: 11, weight: 'bold' }, color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, weight: 'bold' }, color: '#94a3b8' }
                    }
                }
            }
        });
    });
</script>
@endsection
