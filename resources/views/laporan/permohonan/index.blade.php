@extends('frontend.layouts.app')

@section('title', 'Permohonan Informasi')

@section('content')
<div class="container mx-auto py-6 md:py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Permohonan Informasi', 'url' => '#', 'icon' => 'fas fa-file-signature']
        ]" />

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-indigo-600 flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-list-ul mr-3"></i>
                     @if(request()->routeIs('laporan.permohonan.saya'))
                        {{ __('Permohonan Saya') }}
                    @else
                        {{ __('Daftar Semua Permohonan') }}
                    @endif
                </h2>
                <div class="flex flex-wrap items-center justify-center gap-2">
                    @auth
                        @if(request()->routeIs('laporan.permohonan.saya'))
                            <a href="{{ route('laporan.permohonan.index') }}" class="inline-flex items-center justify-center px-4 py-2 text-xs md:text-sm font-bold rounded-xl bg-gray-200 text-gray-800 shadow-md hover:bg-gray-300 transition-all duration-200">
                                <i class="fas fa-globe-asia mr-2"></i>
                                {{ __('Lihat Semua') }}
                            </a>
                        @else
                            <a href="{{ route('laporan.permohonan.saya') }}" class="inline-flex items-center justify-center px-4 py-2 text-xs md:text-sm font-bold rounded-xl bg-yellow-300 text-yellow-900 shadow-md hover:bg-yellow-400 transition-all duration-200">
                                <i class="fas fa-user-check mr-2"></i>
                                {{ __('Permohonan Saya') }}
                            </a>
                        @endif
                    @endauth
                    <a href="{{ route('laporan.permohonan.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-xs md:text-sm font-bold rounded-xl bg-white text-blue-600 shadow-md hover:bg-gray-100 transition-all duration-200">
                        <i class="fas fa-plus-circle mr-2"></i>
                        {{ __('Buat Permohonan') }}
                    </a>
                </div>
            </div>

            <!-- Search and Filter Controls -->
            <div class="mt-6 p-4 bg-gray-50 border-y border-gray-100">
                <form id="searchForm" method="GET" action="">
                    <div class="flex flex-col md:flex-row md:flex-wrap gap-3 md:items-end">
                        <!-- Combined Search Input -->
                        <div class="w-full md:flex-1 md:min-w-[250px]">
                            <label for="search" class="block text-xs font-medium text-gray-600 mb-1">Pencarian</label>
                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ request('search') ?? '' }}"
                                placeholder="Cari nama, rincian..."
                                class="w-full border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                            >
                        </div>

                        <div class="grid grid-cols-2 md:contents gap-3">
                            <!-- Date From Filter -->
                            <div class="md:flex-1 md:min-w-[130px]">
                                <label for="date_from" class="block text-xs font-medium text-gray-600 mb-1">Tgl Awal</label>
                                <input
                                    type="date"
                                    id="date_from"
                                    name="date_from"
                                    value="{{ request('date_from') ?? '' }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>

                            <!-- Date To Filter -->
                            <div class="md:flex-1 md:min-w-[130px]">
                                <label for="date_to" class="block text-xs font-medium text-gray-600 mb-1">Tgl Akhir</label>
                                <input
                                    type="date"
                                    id="date_to"
                                    name="date_to"
                                    value="{{ request('date_to') ?? '' }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>

                            <!-- Sort Control -->
                            <div class="md:flex-1 md:min-w-[150px]">
                                <label for="sort" class="block text-xs font-medium text-gray-600 mb-1">Urutkan</label>
                                <select id="sort" name="sort" class="w-full border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    <option value="created_at_desc" {{ request('sort', 'created_at_desc') === 'created_at_desc' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="created_at_asc" {{ request('sort') === 'created_at_asc' ? 'selected' : '' }}>Terlama</option>
                                    <option value="nama_pemohon_asc" {{ request('sort') === 'nama_pemohon_asc' ? 'selected' : '' }}>Pemohon (A-Z)</option>
                                    <option value="nama_pemohon_desc" {{ request('sort') === 'nama_pemohon_desc' ? 'selected' : '' }}>Pemohon (Z-A)</option>
                                </select>
                            </div>

                            <!-- Items Per Page Control -->
                            <div class="md:flex-1 md:min-w-[100px]">
                                <label for="per_page" class="block text-xs font-medium text-gray-600 mb-1">Tampilan</label>
                                <select id="per_page" name="per_page" class="w-full border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                                </select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 md:flex gap-2 mb-1">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-1.5 px-4 rounded-md transition flex items-center justify-center">
                                <i class="fas fa-search mr-2"></i> Cari
                            </button>
                            <button type="button" onclick="clearFilters()" class="bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium py-1.5 px-4 rounded-md transition flex items-center justify-center">
                                <i class="fas fa-eraser mr-2"></i> Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rincian Informasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Sifat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($permohonan as $index => $item)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $permohonan->firstItem() + $index }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @php $isOwner = auth()->check() && auth()->id() == $item->user_id; @endphp
                                    @if ($item->privacy_status == 'Anonim' && !$isOwner)
                                        {{ substr($item->nama_pemohon, 0, 1) . '*****' }}
                                    @else
                                        {{ $item->nama_pemohon }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($item->detail_informasi, 100) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($item->status_permohonan == 'selesai')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                    @elseif($item->status_permohonan == 'ditolak')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($item->status_permohonan) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    @php
                                        $privacyColors = ['Publik' => 'bg-sky-100 text-sky-800', 'Anonim' => 'bg-slate-100 text-slate-800', 'Rahasia' => 'bg-red-100 text-red-800'];
                                        $privacyIcons = ['Publik' => 'fas fa-globe-asia', 'Anonim' => 'fas fa-user-secret', 'Rahasia' => 'fas fa-lock'];
                                    @endphp
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full {{ $privacyColors[$item->privacy_status] ?? 'bg-gray-100' }}">
                                        <i class="{{ $privacyIcons[$item->privacy_status] ?? 'fas fa-shield-alt' }} mr-1"></i>
                                        {{ $item->privacy_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        @if(request()->routeIs('laporan.permohonan.saya') && $item->status_permohonan == 'pending')
                                            <a href="{{ route('laporan.permohonan.edit', $item) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('laporan.permohonan.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus permohonan ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('laporan.permohonan.show', $item) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded-lg transition-colors">
                                                <i class="fas fa-eye mr-1"></i> Detail
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card List -->
            <div class="md:hidden divide-y divide-gray-100">
                @forelse($permohonan as $index => $item)
                    <div class="p-4 bg-white hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center">
                                <span class="text-[10px] font-bold text-blue-600 mr-2">#{{ $permohonan->firstItem() + $index }}</span>
                                @php $isOwner = auth()->check() && auth()->id() == $item->user_id; @endphp
                                <h3 class="text-sm font-bold text-gray-900">
                                    @if ($item->privacy_status == 'Anonim' && !$isOwner)
                                        {{ substr($item->nama_pemohon, 0, 1) . '*****' }}
                                    @else
                                        {{ $item->nama_pemohon }}
                                    @endif
                                </h3>
                            </div>
                            @if($item->status_permohonan == 'selesai')
                                <span class="px-2 py-0.5 text-[9px] font-bold rounded-full bg-green-100 text-green-700">SELESAI</span>
                            @elseif($item->status_permohonan == 'ditolak')
                                <span class="px-2 py-0.5 text-[9px] font-bold rounded-full bg-red-100 text-red-700">DITOLAK</span>
                            @else
                                <span class="px-2 py-0.5 text-[9px] font-bold rounded-full bg-gray-100 text-gray-600 uppercase">{{ $item->status_permohonan }}</span>
                            @endif
                        </div>

                        <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed mb-4">
                            {{ $item->detail_informasi }}
                        </p>

                        <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                            <div class="flex gap-3">
                                @php
                                    $privacyIcons = ['Publik' => 'fas fa-globe-asia', 'Anonim' => 'fas fa-user-secret', 'Rahasia' => 'fas fa-lock'];
                                @endphp
                                <span class="text-[10px] text-gray-500 flex items-center">
                                    <i class="{{ $privacyIcons[$item->privacy_status] ?? 'fas fa-shield-alt' }} mr-1"></i>
                                    {{ $item->privacy_status }}
                                </span>
                                <span class="text-[10px] text-gray-500 flex items-center">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ $item->created_at->format('d/m/y') }}
                                </span>
                            </div>

                            <div class="flex gap-2">
                                @if(request()->routeIs('laporan.permohonan.saya') && $item->status_permohonan == 'pending')
                                    <a href="{{ route('laporan.permohonan.edit', $item) }}" class="p-2 text-blue-600 bg-blue-50 rounded-md">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('laporan.permohonan.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus permohonan?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 bg-red-50 rounded-md">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('laporan.permohonan.show', $item) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-lg bg-indigo-600 text-white shadow-sm">
                                        Detail
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500 text-sm">
                        Tidak ada permohonan ditemukan
                    </div>
                @endforelse
            </div>

             <!-- Pagination -->
            <div class="mt-6">
                {{ $permohonan->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    function clearFilters() {
        document.getElementById('search').value = '';
        document.getElementById('date_from').value = '';
        document.getElementById('date_to').value = '';
        document.getElementById('sort').value = 'created_at_desc';
        document.getElementById('per_page').value = '10';
        document.getElementById('searchForm').submit();
    }
</script>
@endsection
