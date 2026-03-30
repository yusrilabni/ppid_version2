@extends('frontend.layouts.app')

@section('title', $pageTitle ?? 'Informasi')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <x-breadcrumbs :breadcrumbs="$breadcrumbs" />
        <div class="mb-8">
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('deleted'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('deleted') }}</span>
                </div>
            @endif
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $pageTitle }}</h1>
                </div>
                @can('create', App\Models\Informasi::class)
                    <a href="{{ route('informasi-crud.create', ['category' => request()->segment(2)]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i> Tambah Informasi
                    </a>
                @endcan
            </div>

            <!-- Search and Filter Controls -->
            <div class="mt-6 p-3 bg-gray-50 rounded-lg border border-gray-200">
                <form id="searchForm" method="GET" action="">
                    <div class="flex flex-col md:flex-row md:flex-wrap gap-3 md:items-end">
                        <!-- Combined Search Input (Title/Description/Unit) -->
                        <div class="w-full md:flex-1 md:min-w-[250px]">
                            <label for="search" class="block text-xs font-medium text-gray-600 mb-1">Pencarian</label>
                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ request('search') ?? '' }}"
                                placeholder="Cari judul, unit kerja..."
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
                                    <option value="tanggal_upload_desc" {{ request('sort') === 'tanggal_upload_desc' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                                    <option value="tanggal_upload_asc" {{ request('sort') === 'tanggal_upload_asc' ? 'selected' : '' }}>Terlama</option>
                                    <option value="title_asc" {{ request('sort') === 'title_asc' ? 'selected' : '' }}>Judul (A-Z)</option>
                                    <option value="title_desc" {{ request('sort') === 'title_desc' ? 'selected' : '' }}>Judul (Z-A)</option>
                                </select>
                            </div>

                            <!-- Items Per Page Control -->
                            <div class="md:flex-1 md:min-w-[120px]">
                                <label for="per_page" class="block text-xs font-medium text-gray-600 mb-1">Tampilan</label>
                                <select id="per_page" name="per_page" class="w-full border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10/hal</option>
                                    <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>20/hal</option>
                                    <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50/hal</option>
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

                    <!-- Results Info -->
                    <div class="mt-2 text-xs text-gray-600">
                        Menampilkan {{ $informasis->firstItem() ?? 0 }} - {{ $informasis->lastItem() ?? 0 }} dari {{ $informasis->total() }} data
                        @if(request('search') || request('date_from') || request('date_to'))
                            <span class="ml-2 text-blue-600">
                                Filter aktif:
                                @if(request('search')) "{{ request('search') }}" @endif
                                @if(request('date_from') || request('date_to'))
                                    Tgl:
                                    @if(request('date_from')) {{ request('date_from') }} @endif
                                    @if(request('date_from') && request('date_to'))-@endif
                                    @if(request('date_to')) {{ request('date_to') }} @endif
                                @endif
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel/Mobile Cards -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">No.</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Unit Kerja / OPD</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Tgl. Upload</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Aktivitas</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($informasis as $index => $informasi)
                            <tr class="hover:bg-gray-50 transition duration-150 {{ $informasi->status == 'ARSIP' ? 'bg-gray-50 opacity-70' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $informasis->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('frontend.informasi.detail', $informasi->slug) }}" class="text-sm font-semibold text-gray-900 hover:text-blue-700">
                                        {{ $informasi->title }}
                                    </a>
                                    <div class="mt-1">
                                        @if($informasi->status == 'ARSIP')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800">ARSIP</span>
                                        @elseif(in_array($informasi->status, ['BERLAKU', 'aktif']))
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">BERLAKU</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-sm">{{ Str::limit($informasi->deskripsi, 80) }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $unitId = trim((string)$informasi->unit_id);
                                        $unit = $unitMap->get($unitId);
                                        $unitName = $unit['unit_nama'] ?? ($informasi->user->opd_name ?? 'PPID Kabupaten Sinjai');
                                    @endphp
                                    <span class="inline-block px-2.5 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $unitName }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar text-blue-500 mr-2"></i>
                                        {{ \Carbon\Carbon::parse($informasi->tanggal_upload)->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex flex-col space-y-1">
                                        <div class="flex items-center">
                                            <i class="fas fa-eye text-purple-500 mr-2 text-xs"></i>
                                            <span class="text-xs">Lihat: {{ $informasi->views_count ?? 0 }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-download text-blue-500 mr-2 text-xs"></i>
                                            <span class="text-xs">Unduh: {{ $informasi->download_count ?? 0 }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('frontend.informasi.detail', $informasi->slug) }}" class="text-blue-600 bg-blue-50 hover:bg-blue-100 p-2 rounded transition-colors" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($informasi->url)
                                            <a href="{{ route('frontend.informasi.visit-url', $informasi->id) }}" target="_blank" class="text-green-600 bg-green-50 hover:bg-green-100 p-2 rounded transition-colors" title="Buka URL">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @elseif($informasi->file)
                                            <a href="{{ route('frontend.informasi.download', $informasi->id) }}" target="_blank" class="text-green-600 bg-green-50 hover:bg-green-100 p-2 rounded transition-colors" title="Unduh">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                        @can('update', $informasi)
                                            <a href="{{ route('informasi-crud.edit', $informasi) }}" class="text-yellow-600 bg-yellow-50 hover:bg-yellow-100 p-2 rounded transition-colors" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete', $informasi)
                                            <form action="{{ route('informasi-crud.destroy', $informasi) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded transition-colors" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    Tidak ada data ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-gray-100">
                @forelse ($informasis as $informasi)
                    <div class="p-4 bg-white hover:bg-gray-50 transition-colors {{ $informasi->status == 'ARSIP' ? 'bg-gray-50 opacity-80' : '' }}">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">
                                @php
                                    $unitId = trim((string)$informasi->unit_id);
                                    $unit = $unitMap->get($unitId);
                                    echo $unit['unit_nama'] ?? ($informasi->user->opd_name ?? 'PPID Kabupaten Sinjai');
                                @endphp
                            </span>
                            @if($informasi->status == 'ARSIP')
                                <span class="px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-gray-200 text-gray-700">ARSIP</span>
                            @elseif(in_array($informasi->status, ['BERLAKU', 'aktif']))
                                <span class="px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-green-100 text-green-700">BERLAKU</span>
                            @endif
                        </div>
                        
                        <a href="{{ route('frontend.informasi.detail', $informasi->slug) }}" class="block mb-2">
                            <h3 class="text-sm font-bold text-gray-900 leading-tight mb-1">{{ $informasi->title }}</h3>
                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">{{ $informasi->deskripsi }}</p>
                        </a>

                        <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-50">
                            <div class="flex items-center gap-4 text-[10px] text-gray-500">
                                <span class="flex items-center"><i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($informasi->tanggal_upload)->format('d/m/y') }}</span>
                                <span class="flex items-center"><i class="far fa-eye mr-1"></i> {{ $informasi->views_count ?? 0 }}</span>
                                <span class="flex items-center"><i class="far fa-arrow-alt-circle-down mr-1"></i> {{ $informasi->download_count ?? 0 }}</span>
                            </div>
                            
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('frontend.informasi.detail', $informasi->slug) }}" class="p-2 text-blue-600 bg-blue-50 rounded-md">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                @if($informasi->url)
                                    <a href="{{ route('frontend.informasi.visit-url', $informasi->id) }}" target="_blank" class="p-2 text-green-600 bg-green-50 rounded-md">
                                        <i class="fas fa-external-link-alt text-sm"></i>
                                    </a>
                                @elseif($informasi->file)
                                    <a href="{{ route('frontend.informasi.download', $informasi->id) }}" target="_blank" class="p-2 text-green-600 bg-green-50 rounded-md">
                                        <i class="fas fa-download text-sm"></i>
                                    </a>
                                @endif
                                @can('update', $informasi)
                                    <a href="{{ route('informasi-crud.edit', $informasi) }}" class="p-2 text-yellow-600 bg-yellow-50 rounded-md">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500 text-sm">
                        Tidak ada data ditemukan
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $informasis->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<script>
    function clearFilters() {
        document.getElementById('search').value = '';
        document.getElementById('date_from').value = '';
        document.getElementById('date_to').value = '';
        document.getElementById('sort').value = 'tanggal_upload_desc';
        document.getElementById('per_page').value = '10';
        document.getElementById('searchForm').submit();
    }
</script>
@endsection
