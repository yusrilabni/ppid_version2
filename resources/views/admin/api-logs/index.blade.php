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
<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-800">Riwayat API (Log)</h3>
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
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $log->origin }}
                                    </span>
                                @elseif($log->origin === 'Aplikasi Eksternal / Bot')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ $log->origin }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
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
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $log->response_status >= 400 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $log->response_status }} ({{ $log->response_time }}ms)
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if($log->risk_level === 'good')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Good
                                    </span>
                                @elseif($log->risk_level === 'middle')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Middle
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Hard
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <button type="button" onclick="showPayload({{ $log->id }})" class="text-blue-600 hover:text-blue-900 text-sm">
                                    Lihat Payload
                                </button>
                                <div id="payload-{{ $log->id }}" class="hidden">
                                    {{ $log->payload }}
                                </div>
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
                {{ $apiLogs->links() }}
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
