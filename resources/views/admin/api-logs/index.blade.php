@extends('admin.layouts.app')

@section('title', 'API Tracker')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('API Tracker') }}
        </h2>
        <div class="text-sm text-gray-500">
            Pantau aktivitas dan keamanan lalu lintas API
        </div>
    </div>
@endsection

@section('content')
@php
    $cards = [
        [
            'title' => 'Per Menit', 'value' => $stats['per_minute'], 'standard' => 100, 'warning' => 300, 'desc' => 'Lonjakan instan',
            'baseText' => 'text-indigo-600', 'baseBg' => 'bg-indigo-50', 'baseBorder' => 'border-indigo-100', 
            'baseGlow' => 'shadow-indigo-100/50', 'iconColor' => 'text-indigo-500', 'iconBg' => 'bg-indigo-100',
            'progressBg' => 'bg-indigo-500', 'gradient' => 'from-indigo-50/50 to-white'
        ],
        [
            'title' => 'Per Jam', 'value' => $stats['per_hour'], 'standard' => 3000, 'warning' => 10000, 'desc' => 'Lalu lintas sejam terakhir',
            'baseText' => 'text-sky-600', 'baseBg' => 'bg-sky-50', 'baseBorder' => 'border-sky-100', 
            'baseGlow' => 'shadow-sky-100/50', 'iconColor' => 'text-sky-500', 'iconBg' => 'bg-sky-100',
            'progressBg' => 'bg-sky-500', 'gradient' => 'from-sky-50/50 to-white'
        ],
        [
            'title' => 'Per Hari', 'value' => $stats['per_day'], 'standard' => 50000, 'warning' => 150000, 'desc' => 'Total aktivitas harian',
            'baseText' => 'text-emerald-600', 'baseBg' => 'bg-emerald-50', 'baseBorder' => 'border-emerald-100', 
            'baseGlow' => 'shadow-emerald-100/50', 'iconColor' => 'text-emerald-500', 'iconBg' => 'bg-emerald-100',
            'progressBg' => 'bg-emerald-500', 'gradient' => 'from-emerald-50/50 to-white'
        ],
        [
            'title' => 'Per Minggu', 'value' => $stats['per_week'], 'standard' => 300000, 'warning' => 800000, 'desc' => 'Tren akses mingguan',
            'baseText' => 'text-violet-600', 'baseBg' => 'bg-violet-50', 'baseBorder' => 'border-violet-100', 
            'baseGlow' => 'shadow-violet-100/50', 'iconColor' => 'text-violet-500', 'iconBg' => 'bg-violet-100',
            'progressBg' => 'bg-violet-500', 'gradient' => 'from-violet-50/50 to-white'
        ],
        [
            'title' => 'Per Bulan', 'value' => $stats['per_month'], 'standard' => 1000000, 'warning' => 3000000, 'desc' => 'Akumulasi akses bulanan',
            'baseText' => 'text-fuchsia-600', 'baseBg' => 'bg-fuchsia-50', 'baseBorder' => 'border-fuchsia-100', 
            'baseGlow' => 'shadow-fuchsia-100/50', 'iconColor' => 'text-fuchsia-500', 'iconBg' => 'bg-fuchsia-100',
            'progressBg' => 'bg-fuchsia-500', 'gradient' => 'from-fuchsia-50/50 to-white'
        ],
        [
            'title' => 'Per Tahun', 'value' => $stats['per_year'], 'standard' => 10000000, 'warning' => 30000000, 'desc' => 'Total keseluruhan tahun ini',
            'baseText' => 'text-orange-600', 'baseBg' => 'bg-orange-50', 'baseBorder' => 'border-orange-100', 
            'baseGlow' => 'shadow-orange-100/50', 'iconColor' => 'text-orange-500', 'iconBg' => 'bg-orange-100',
            'progressBg' => 'bg-orange-500', 'gradient' => 'from-orange-50/50 to-white'
        ],
    ];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5 mb-8">
    @foreach($cards as $card)
        @php
            $status = 'Normal';
            $colorText = $card['baseText'];
            $colorBg = $card['baseBg'];
            $borderColor = $card['baseBorder'];
            $glowColor = $card['baseGlow'];
            $iconColor = $card['iconColor'];
            $iconBg = $card['iconBg'];
            $progressColor = $card['progressBg'];
            $gradient = $card['gradient'];
            $icon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'; // check-circle
            
            $percentage = min(100, ($card['value'] / max(1, $card['warning'])) * 100);

            if ($card['value'] > $card['warning']) {
                $status = 'Bahaya (Spam)';
                $colorText = 'text-rose-600';
                $colorBg = 'bg-rose-50';
                $borderColor = 'border-rose-200';
                $glowColor = 'shadow-rose-200/50';
                $iconColor = 'text-rose-600';
                $iconBg = 'bg-rose-100';
                $progressColor = 'bg-rose-500';
                $gradient = 'from-rose-50/50 to-white';
                $icon = 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'; // alert-circle
            } elseif ($card['value'] > $card['standard']) {
                $status = 'Waspada (Tinggi)';
                $colorText = 'text-amber-600';
                $colorBg = 'bg-amber-50';
                $borderColor = 'border-amber-200';
                $glowColor = 'shadow-amber-200/50';
                $iconColor = 'text-amber-500';
                $iconBg = 'bg-amber-100';
                $progressColor = 'bg-amber-500';
                $gradient = 'from-amber-50/50 to-white';
                $icon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'; // alert-triangle
            }
        @endphp
        <div class="relative bg-gradient-to-br {{ $gradient }} rounded-2xl p-5 border {{ $borderColor }} shadow-lg {{ $glowColor }} hover:-translate-y-1 transition-all duration-300 overflow-hidden group">
            <!-- Background Decoration -->
            <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full {{ $iconBg }} opacity-30 group-hover:scale-150 transition-transform duration-700 ease-out"></div>
            
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div>
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">{{ $card['title'] }}</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5 truncate">{{ $card['desc'] }}</p>
                </div>
                <div class="p-2 rounded-xl {{ $iconBg }} shadow-sm">
                    <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
                    </svg>
                </div>
            </div>
            
            <div class="relative z-10 mt-2">
                <div class="text-3xl font-black text-gray-800 mb-1 tracking-tight">{{ number_format($card['value'], 0, ',', '.') }}</div>
                
                <!-- Progress Bar -->
                <div class="w-full bg-gray-200/60 rounded-full h-1.5 mt-3 mb-2 overflow-hidden">
                    <div class="h-1.5 rounded-full {{ $progressColor }} transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                </div>
                
                <div class="flex justify-between items-center text-[11px] font-medium mt-2">
                    <span class="text-gray-400">Batas: {{ number_format($card['standard'], 0, ',', '.') }}</span>
                    <span class="px-2 py-1 rounded-md {{ $colorBg }} {{ $colorText }} font-bold border {{ $borderColor }} shadow-sm">{{ $status }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
    <div class="flex justify-between items-center p-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
        <div>
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Riwayat Log API
            </h3>
            <p class="text-xs text-gray-500 mt-1">Lalu lintas request secara real-time</p>
        </div>
            <form action="{{ route('admin.api-logs.index') }}" method="GET" class="flex space-x-2">
                <select name="risk_level" aria-label="Filter Risiko" class="border-gray-300 rounded-md shadow-sm text-sm" onchange="this.form.submit()">
                    <option value="">Semua Risiko</option>
                    <option value="good" {{ request('risk_level') == 'good' ? 'selected' : '' }}>Good</option>
                    <option value="middle" {{ request('risk_level') == 'middle' ? 'selected' : '' }}>Middle</option>
                    <option value="hard" {{ request('risk_level') == 'hard' ? 'selected' : '' }}>Hard</option>
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="py-3 px-6 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Waktu</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">IP & Method</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Asal Akses</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">URL</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Risiko</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($apiLogs as $log)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-4 px-6 text-sm text-gray-600">
                                {{ $log->created_at->format('d M Y H:i:s') }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-sm font-medium text-gray-900">{{ $log->ip_address }}</div>
                                <div class="text-xs text-gray-500 mt-1 font-bold">{{ $log->method }}</div>
                            </td>
                            <td class="py-4 px-6">
                                @if($log->origin === 'Aplikasi Frontend Legal')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md border text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $log->origin }}
                                    </span>
                                @elseif($log->origin === 'Aplikasi Eksternal / Bot')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md border text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ $log->origin }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md border text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $log->origin ?? 'Direct URL' }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-sm text-gray-900 break-all w-64 md:w-auto">
                                    {{ $log->url }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md border text-xs font-medium {{ $log->response_status >= 400 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $log->response_status }} ({{ $log->response_time }}ms)
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if($log->risk_level === 'good')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md border text-xs font-medium bg-green-100 text-green-800">
                                        Good
                                    </span>
                                @elseif($log->risk_level === 'middle')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md border text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Middle
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md border text-xs font-medium bg-red-100 text-red-800">
                                        Hard
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if(empty($log->payload) || $log->payload === '[]' || $log->payload === '{}' || $log->payload === 'null')
                                    <span class="text-gray-400 text-sm italic">Kosong</span>
                                @else
                                    <button type="button" onclick="showPayload({{ $log->id }})" class="text-blue-600 hover:text-blue-900 text-sm font-medium flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Lihat Data
                                    </button>
                                    <div id="payload-{{ $log->id }}" class="hidden">
                                        {{ $log->payload }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 px-6 text-center text-gray-500">
                                Belum ada log API.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($apiLogs->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $apiLogs->appends(request()->query())->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Detail Payload -->
<div id="payloadModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Detail Payload
                        </h3>
                        <div class="mt-2">
                            <pre id="modal-content" class="text-sm text-gray-500 bg-gray-50 p-4 rounded overflow-x-auto whitespace-pre-wrap break-all border"></pre>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showPayload(id) {
    var payloadContent = document.getElementById('payload-' + id).innerText;
    try {
        var parsed = JSON.parse(payloadContent);
        document.getElementById('modal-content').innerText = JSON.stringify(parsed, null, 2);
    } catch(e) {
        document.getElementById('modal-content').innerText = payloadContent;
    }
    document.getElementById('payloadModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('payloadModal').classList.add('hidden');
}
</script>
@endsection
