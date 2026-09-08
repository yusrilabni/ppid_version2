@extends('admin.layouts.app')

@section('title', 'Daftar IP Diblokir')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-xl font-bold text-gray-800"><i class="fas fa-shield-alt text-red-500 mr-2"></i>Security Blocks</h2>
            <p class="text-gray-600">Manajemen daftar IP yang diblokir oleh WAF & Anti-Spam</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-gray-50 rounded-lg p-5 mb-8 border border-gray-200">
        <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wider">Tambah Blokir Manual</h3>
        <form action="{{ route('admin.security.store') }}" method="POST" class="flex flex-col md:flex-row gap-4">
            @csrf
            <div class="flex-1">
                <input type="text" name="ip_address" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Masukkan IP Address (Contoh: 192.168.1.1)" required>
            </div>
            <div class="flex-[2]">
                <input type="text" name="reason" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Alasan Blokir (Opsional)">
            </div>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-lg transition flex items-center justify-center whitespace-nowrap">
                <i class="fas fa-ban mr-2"></i> Blokir IP
            </button>
        </form>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Informasi Penyerang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Serangan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Waktu Kejadian</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($blocks as $block)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $loop->iteration + $blocks->firstItem() - 1 }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="mb-1">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800 font-mono">
                                    {{ $block->ip_address }}
                                </span>
                            </div>
                            @if($block->request_data && isset($block->request_data['_location']))
                                <div class="text-xs text-gray-600 flex items-center mt-2">
                                    <i class="fas fa-map-marker-alt w-4 text-gray-400"></i>
                                    <span>{{ $block->request_data['_location'] }}</span>
                                </div>
                            @endif
                            @if($block->request_data && isset($block->request_data['_device_info']))
                                <div class="text-xs text-gray-600 flex items-center mt-1">
                                    <i class="fas fa-mobile-alt w-4 text-gray-400"></i> 
                                    <span class="truncate max-w-[200px]" title="{{ $block->request_data['_device_info'] }}">
                                        {{ Str::limit($block->request_data['_device_info'], 40) }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 font-medium mb-1">
                                <span class="text-red-600"><i class="fas fa-exclamation-triangle mr-1"></i> Alasan:</span> {{ $block->reason }}
                            </div>
                            @if($block->request_data && isset($block->request_data['_url_accessed']))
                                <div class="text-xs text-gray-500 flex items-center mt-2 bg-gray-100 p-1 rounded">
                                    <i class="fas fa-link w-4 text-gray-400"></i>
                                    <span class="truncate max-w-sm text-blue-600 font-mono" title="{{ $block->request_data['_url_accessed'] }}">
                                        {{ $block->request_data['_url_accessed'] }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $block->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form action="{{ route('admin.security.destroy', $block->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin membuka blokir IP ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-green-600 hover:text-green-900 transition flex items-center justify-end w-full" title="Buka Blokir (Unblock)">
                                    <i class="fas fa-unlock-alt mr-1"></i> Buka
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 whitespace-nowrap text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-shield-check text-4xl text-green-300 mb-3"></i>
                                <p>Belum ada IP yang diblokir oleh sistem keamanan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $blocks->links() }}
    </div>
</div>
@endsection
