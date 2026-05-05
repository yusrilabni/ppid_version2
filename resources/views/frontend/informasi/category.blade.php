@extends('frontend.layouts.app')

@section('title', $pageTitle ?? 'Informasi')

@section('meta')
    <meta property="og:title" content="{{ $pageTitle }} - PPID Kabupaten Sinjai">
    <meta property="og:description" content="Daftar {{ $pageTitle }} Kabupaten Sinjai. Transparansi Informasi Publik untuk Masyarakat.">
    <meta property="twitter:title" content="{{ $pageTitle }} - PPID Kabupaten Sinjai">
    <meta property="twitter:description" content="Daftar {{ $pageTitle }} Kabupaten Sinjai. Transparansi Informasi Publik untuk Masyarakat.">
@endsection

@section('content')
<div class="container mx-auto py-8 px-4 overflow-x-hidden">
    <div class="max-w-7xl mx-auto w-full">
        <div class="overflow-x-auto mb-4">
            <x-breadcrumbs :breadcrumbs="$breadcrumbs" />
        </div>
        <div class="mb-8">
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
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
            <div class="mt-8 mb-10">
                <form id="searchForm" method="GET" action="" onsubmit="return false;">
                    <!-- 1. Minimalist Search Bar -->
                    <div class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-end bg-white/80 backdrop-blur-md p-6 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-white mb-6">
                        <!-- Search Input -->
                        <div class="flex-1">
                            <label for="search" class="block text-[10px] font-black text-blue-900/40 mb-2 uppercase tracking-[0.2em] ml-4">Pencarian Pintar</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-blue-400 group-focus-within:text-blue-600 transition-colors">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" id="search" name="search" value="{{ request('search') ?? '' }}" placeholder="Ketik kata kunci..."
                                    oninput="debounceUpdate()"
                                    class="w-full pl-14 pr-6 py-4 text-sm border-none bg-gray-50/50 rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all placeholder:text-gray-300 font-bold text-gray-700">
                            </div>
                        </div>

                        <!-- Grid Controls -->
                        @php
                            $sortOptions = [
                                ['value' => 'tanggal_upload_desc', 'label' => 'Terbaru'],
                                ['value' => 'tanggal_upload_asc', 'label' => 'Terlama'],
                                ['value' => 'title_asc', 'label' => 'Judul (A-Z)'],
                                ['value' => 'title_desc', 'label' => 'Judul (Z-A)'],
                            ];
                            $perPageOptions = [
                                ['value' => '10', 'label' => '10 Baris'],
                                ['value' => '20', 'label' => '20 Baris'],
                                ['value' => '50', 'label' => '50 Baris'],
                            ];
                            
                            $isAdmin = Auth::check() && (Auth::user()->isSuperAdmin() || Auth::user()->unit_id);
                        @endphp
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 lg:w-auto">
                            <div class="min-w-[140px]">
                                <label class="block text-[10px] font-black text-blue-900/40 mb-2 uppercase tracking-[0.2em] ml-2">Mulai</label>
                                <input type="date" name="date_from" value="{{ request('date_from') ?? '' }}" onchange="updateContent()"
                                    class="w-full px-4 py-4 text-xs border-none bg-gray-50/50 rounded-2xl focus:ring-4 focus:ring-blue-500/10 font-bold text-gray-600">
                            </div>
                            <div class="min-w-[140px]">
                                <label class="block text-[10px] font-black text-blue-900/40 mb-2 uppercase tracking-[0.2em] ml-2">Sampai</label>
                                <input type="date" name="date_to" value="{{ request('date_to') ?? '' }}" onchange="updateContent()"
                                    class="w-full px-4 py-4 text-xs border-none bg-gray-50/50 rounded-2xl focus:ring-4 focus:ring-blue-500/10 font-bold text-gray-600">
                            </div>
                            <div class="min-w-[120px]">
                                <label class="block text-[10px] font-black text-blue-900/40 mb-2 uppercase tracking-[0.2em] ml-2">Urutan</label>
                                <x-custom-select name="sort" :options="$sortOptions" :value="request('sort', 'tanggal_upload_desc')" :searchable="false" onchange="updateContent()" />
                            </div>
                            <div class="min-w-[100px]">
                                <label class="block text-[10px] font-black text-blue-900/40 mb-2 uppercase tracking-[0.2em] ml-2">Limit</label>
                                <x-custom-select name="per_page" :options="$perPageOptions" :value="request('per_page', '10')" :searchable="false" onchange="updateContent()" />
                            </div>
                        </div>

                        <!-- Search Button -->
                        <button type="button" onclick="updateContent()" class="bg-blue-600 hover:bg-blue-700 text-white w-full lg:w-14 h-14 rounded-2xl transition-all shadow-lg shadow-blue-600/20 flex items-center justify-center group">
                            <i class="fas fa-search group-hover:scale-110 transition-transform"></i>
                        </button>
                    </div>

                    <!-- 2. Lower Filter Row (Differentiated) -->
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-6 px-2">
                        <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                            @if($isAdmin)
                                <!-- ADMIN TOGGLES -->
                                @if(!auth()->user()->isSuperAdmin())
                                <label class="relative flex items-center cursor-pointer group select-none">
                                    <input type="hidden" name="filter_unit" value="0">
                                    <input type="checkbox" id="check_unit" name="filter_unit" value="1" {{ request('filter_unit', '1') == '1' ? 'checked' : '' }} onchange="updateContent()" class="sr-only peer">
                                    <div class="px-6 py-3 rounded-2xl bg-white border border-gray-100 shadow-sm transition-all duration-300 flex items-center gap-3 
                                        peer-checked:bg-gradient-to-r peer-checked:from-blue-600 peer-checked:to-blue-500 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-blue-200 peer-checked:border-transparent
                                        hover:border-blue-300 hover:shadow-md active:scale-95
                                        peer-checked:[&_.icon-box]:bg-emerald-500 peer-checked:[&_.fa-check]:scale-100 peer-checked:[&_.fa-check]:opacity-100 peer-checked:[&_.fa-check]:text-white peer-checked:[&_.fa-building]:scale-0 peer-checked:[&_.fa-building]:opacity-0">
                                        
                                        <div class="icon-box relative w-5 h-5 flex items-center justify-center rounded-lg bg-gray-100 transition-all duration-300 ring-4 ring-transparent peer-checked:ring-white/10">
                                            <i class="fas fa-check absolute text-[10px] opacity-0 scale-0 transition-all duration-300"></i>
                                            <i class="fas fa-building text-[10px] text-gray-400 transition-all duration-300"></i>
                                        </div>
                                        <span id="label_unit" class="text-[10px] font-black uppercase tracking-[0.15em]">
                                            {{ request('filter_unit', '1') == '1' ? 'Tampilkan Semua Unit' : 'Hanya Unit Saya' }}
                                        </span>
                                    </div>
                                </label>
                                @endif

                                <label class="relative flex items-center cursor-pointer group select-none">
                                    <input type="hidden" name="sort_created" value="0">
                                    <input type="checkbox" id="check_created" name="sort_created" value="1" {{ request('sort_created', '1') == '1' ? 'checked' : '' }} onchange="updateContent()" class="sr-only peer">
                                    <div class="px-6 py-3 rounded-2xl bg-white border border-gray-100 shadow-sm transition-all duration-300 flex items-center gap-3 
                                        peer-checked:bg-gradient-to-r peer-checked:from-indigo-600 peer-checked:to-purple-500 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-indigo-200 peer-checked:border-transparent
                                        hover:border-indigo-300 hover:shadow-md active:scale-95
                                        peer-checked:[&_.icon-box]:bg-emerald-500 peer-checked:[&_.fa-check]:scale-100 peer-checked:[&_.fa-check]:opacity-100 peer-checked:[&_.fa-check]:text-white peer-checked:[&_.fa-bolt]:scale-0 peer-checked:[&_.fa-bolt]:opacity-0">
                                        
                                        <div class="icon-box relative w-5 h-5 flex items-center justify-center rounded-lg bg-gray-100 transition-all duration-300 ring-4 ring-transparent peer-checked:ring-white/10">
                                            <i class="fas fa-check absolute text-[10px] opacity-0 scale-0 transition-all duration-300"></i>
                                            <i class="fas fa-bolt text-[10px] text-gray-400 transition-all duration-300"></i>
                                        </div>
                                        <span id="label_created" class="text-[10px] font-black uppercase tracking-[0.15em]">
                                            {{ request('sort_created', '1') == '1' ? 'Urutkan Tgl Dokumen' : 'Waktu Sistem Terbaru' }}
                                        </span>
                                    </div>
                                </label>
                            @else
                                <!-- PUBLIC / REGULAR USER: UNIT FILTER DROPDOWN -->
                                <div class="flex flex-col md:flex-row items-center gap-4 bg-white/50 backdrop-blur-sm p-2 pr-6 rounded-3xl border border-gray-100 shadow-sm w-full lg:w-auto">
                                    <div class="bg-blue-600 text-white px-5 py-2.5 rounded-2xl text-[9px] font-black uppercase tracking-widest shadow-lg shadow-blue-200 flex items-center gap-2 whitespace-nowrap">
                                        <i class="fas fa-building"></i> Filter Unit
                                    </div>
                                    <div class="min-w-[280px] w-full md:w-auto">
                                        @php
                                            $unitOptions = [['value' => '', 'label' => 'Semua Unit Kerja']];
                                            foreach($unitMap as $id => $u) {
                                                $unitOptions[] = ['value' => $id, 'label' => $u['unit_nama']];
                                            }
                                        @endphp
                                        <x-custom-select name="unit_filter" :options="$unitOptions" :value="request('unit_filter', '')" placeholder="Cari unit kerja..." onchange="updateContent()" />
                                    </div>
                                </div>
                            @endif
                        </div>

                        <button type="button" onclick="clearFilters()" class="px-6 py-3 rounded-2xl bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all duration-300 flex items-center gap-2 lg:ml-auto group border border-transparent hover:border-red-100 shadow-sm">
                            <i class="fas fa-sync-alt text-[10px] group-hover:rotate-180 transition-transform duration-500"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest">Reset Filter</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Content Area for AJAX -->
        <div id="contentArea" class="relative min-h-[400px]">
            <!-- Loading Overlay -->
            <div id="loadingOverlay" class="absolute inset-0 bg-white/40 backdrop-blur-[4px] z-[60] flex items-center justify-center hidden rounded-[3rem]">
                <div class="bg-white p-8 rounded-[2rem] shadow-2xl border border-gray-50 flex flex-col items-center">
                    <div class="relative w-16 h-16">
                        <div class="absolute inset-0 border-4 border-blue-100 rounded-full"></div>
                        <div class="absolute inset-0 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                    </div>
                    <span class="mt-6 text-[10px] font-black text-blue-900 uppercase tracking-[0.3em]">Memproses Data...</span>
                </div>
            </div>

            <!-- Tabel/Mobile Cards Container -->
            <div class="mt-4 bg-white rounded-t-2xl rounded-b-[3rem] shadow-2xl shadow-blue-900/5 overflow-hidden border border-gray-50">
                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                                <th class="px-6 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em]">No.</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em]">Dokumen / Judul</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em]">Deskripsi Ringkas</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em]">Unit Kerja</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em]">Tgl Upload</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em]">Aktivitas</th>
                                <th class="px-6 py-5 text-center text-[10px] font-black uppercase tracking-[0.2em]">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($informasis as $index => $informasi)
                                <tr class="hover:bg-blue-50/30 transition-colors {{ $informasi->status == 'ARSIP' ? 'bg-gray-50/50 opacity-70' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-gray-400 text-center">{{ $informasis->firstItem() + $index }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $primaryLink = route('frontend.informasi.detail', $informasi->slug);
                                            if ($informasi->official) {
                                                $posSlug = $informasi->official->position->slug ?? '';
                                                if ($posSlug === 'bupati-sinjai') $primaryLink = route('official.bupati');
                                                elseif ($posSlug === 'wakil-bupati-sinjai') $primaryLink = route('official.wakil-bupati');
                                                elseif ($posSlug === 'sekretaris-daerah-sinjai') $primaryLink = route('official.sekretaris-daerah');
                                                else $primaryLink = route('official.profile.show', $informasi->official->slug);
                                            } elseif (strpos($informasi->content, 'struktur_organisasi_') === 0) {
                                                $orgId = str_replace('struktur_organisasi_', '', $informasi->content);
                                                $organization = \App\Models\Organization::find($orgId);
                                                if ($organization) $primaryLink = route('opd.detail', $organization->slug);
                                            }
                                        @endphp
                                        <a href="{{ $primaryLink }}" class="text-sm font-black text-gray-900 hover:text-blue-600 block leading-tight mb-1">
                                            {{ $informasi->title }}
                                        </a>
                                        <div class="flex items-center gap-2">
                                            @if($informasi->status == 'ARSIP')
                                                <span class="inline-block px-2 py-0.5 rounded bg-gray-100 text-gray-500 text-[9px] font-black uppercase tracking-widest">ARSIP</span>
                                            @elseif(in_array($informasi->status, ['BERLAKU', 'aktif']))
                                                <span class="inline-block px-2 py-0.5 rounded bg-green-100 text-green-700 text-[9px] font-black uppercase tracking-widest">BERLAKU</span>
                                            @endif
                                            {{-- ID REMOVED FOR SECURITY --}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-500 leading-relaxed max-w-xs">{{ Str::limit($informasi->deskripsi, 80) }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $unitId = trim((string)$informasi->unit_id);
                                            $unit = $unitMap->get($unitId);
                                            $unitName = $unit['unit_nama'] ?? 'Unit Tidak Terdaftar';
                                        @endphp
                                        <span class="px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 text-[10px] font-black uppercase tracking-tight inline-block border border-blue-100/50">
                                            {{ $unitName }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-gray-700">{{ \Carbon\Carbon::parse($informasi->tanggal_upload)->translatedFormat('d M Y') }}</span>
                                            <span class="text-[9px] text-gray-400 uppercase tracking-widest">Tahun: {{ $informasi->tahun }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center gap-1.5" title="Dilihat">
                                                <i class="fas fa-eye text-indigo-400 text-xs"></i>
                                                <span class="text-xs font-bold text-gray-600">{{ $informasi->views_count ?? 0 }}</span>
                                            </div>
                                            <div class="flex items-center gap-1.5" title="Diunduh/Dikunjungi">
                                                <i class="fas fa-download text-blue-400 text-xs"></i>
                                                <span class="text-xs font-bold text-gray-600">{{ $informasi->download_count ?? 0 }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ $primaryLink }}" class="w-9 h-9 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Detail">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                            @if(!$informasi->official && strpos($informasi->content, 'struktur_organisasi_') !== 0)
                                                @if($informasi->url)
                                                    <a href="{{ route('frontend.informasi.visit-url', $informasi->id) }}" target="_blank" class="w-9 h-9 flex items-center justify-center bg-green-50 text-green-600 rounded-xl hover:bg-green-600 hover:text-white transition-all shadow-sm" title="Buka Link">
                                                        <i class="fas fa-external-link-alt text-sm"></i>
                                                    </a>
                                                @elseif($informasi->file)
                                                    <a href="{{ route('frontend.informasi.download', $informasi->id) }}" target="_blank" class="w-9 h-9 flex items-center justify-center bg-green-50 text-green-600 rounded-xl hover:bg-green-600 hover:text-white transition-all shadow-sm" title="Download">
                                                        <i class="fas fa-download text-sm"></i>
                                                    </a>
                                                @endif
                                            @endif
                                            @can('update', $informasi)
                                                <a href="{{ route('informasi-crud.edit', $informasi) }}" class="w-9 h-9 flex items-center justify-center bg-yellow-50 text-yellow-600 rounded-xl hover:bg-yellow-600 hover:text-white transition-all shadow-sm" title="Edit">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $informasi)
                                                <form action="{{ route('informasi-crud.destroy', $informasi) }}" method="POST" onsubmit="return confirm('Hapus informasi ini?')" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Hapus">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                                <i class="fas fa-search-minus text-2xl"></i>
                                            </div>
                                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Tidak ada data ditemukan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden divide-y divide-gray-50">
                    @forelse ($informasis as $informasi)
                        <div class="p-5 bg-white hover:bg-blue-50/20 transition-colors {{ $informasi->status == 'ARSIP' ? 'opacity-80' : '' }}">
                            <div class="flex justify-between items-start mb-3">
                                @php
                                    $unitId = trim((string)$informasi->unit_id);
                                    $unit = $unitMap->get($unitId);
                                    $unitName = $unit['unit_nama'] ?? 'Unit Tidak Terdaftar';
                                @endphp
                                <span class="text-[9px] font-black text-blue-600 uppercase tracking-wider bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-100/50 leading-none">{{ $unitName }}</span>
                                @if($informasi->status == 'ARSIP')
                                    <span class="px-1.5 py-0.5 rounded bg-gray-100 text-gray-400 text-[8px] font-black uppercase tracking-widest">ARSIP</span>
                                @endif
                            </div>
                            
                            <a href="{{ $primaryLink ?? '#' }}" class="block mb-4">
                                <h3 class="text-sm font-black text-gray-900 leading-snug mb-2">{{ $informasi->title }}</h3>
                                <p class="text-[11px] text-gray-400 line-clamp-2 leading-relaxed">{{ $informasi->deskripsi }}</p>
                            </a>

                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-50">
                                <div class="flex items-center gap-3 text-[9px] font-bold text-gray-400 uppercase tracking-tight">
                                    <span class="flex items-center gap-1"><i class="far fa-calendar-alt text-blue-400"></i> {{ \Carbon\Carbon::parse($informasi->tanggal_upload)->format('d/m/y') }}</span>
                                    <span class="flex items-center gap-1"><i class="far fa-eye text-indigo-400"></i> {{ $informasi->views_count ?? 0 }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ $primaryLink ?? '#' }}" class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg shadow-sm"><i class="fas fa-eye text-xs"></i></a>
                                    @can('update', $informasi)
                                        <a href="{{ route('informasi-crud.edit', $informasi) }}" class="w-8 h-8 flex items-center justify-center bg-yellow-50 text-yellow-600 rounded-lg shadow-sm"><i class="fas fa-edit text-xs"></i></a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-gray-400 font-bold uppercase tracking-widest text-xs">Kosong</div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div id="paginationArea" class="mt-8 flex justify-center">
                {{ $informasis->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    let debounceTimer;

    function debounceUpdate() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            updateContent();
        }, 500);
    }

    async function updateContent(url = null) {
        const form = document.getElementById('searchForm');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        
        // Handle hidden inputs duplication for checkboxes
        const uniqueParams = new URLSearchParams();
        params.forEach((value, key) => {
            if (key === 'filter_unit' || key === 'sort_created') {
                const values = params.getAll(key);
                uniqueParams.set(key, values[values.length - 1]);
            } else if (!uniqueParams.has(key)) {
                uniqueParams.set(key, value);
            }
        });

        const contentArea = document.getElementById('contentArea');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const targetUrl = url || `${window.location.pathname}?${uniqueParams.toString()}`;

        // Update Labels Immediately for Snappy Feel
        updateLabels();

        // Show loading state
        loadingOverlay.classList.remove('hidden');
        contentArea.style.opacity = '0.5';

        try {
            const response = await fetch(targetUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const html = await response.text();
            
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContent = doc.getElementById('contentArea').innerHTML;
            
            contentArea.innerHTML = newContent;
            
            // Re-update labels after content load to be sure
            updateLabels();
            
            // Update URL in browser
            window.history.pushState({}, '', targetUrl);
            
            // Re-intercept new pagination links
            attachPagination();
            
        } catch (error) {
            console.error('Error fetching data:', error);
        } finally {
            loadingOverlay.classList.add('hidden');
            contentArea.style.opacity = '1';
        }
    }

    function updateLabels() {
        const checkUnit = document.getElementById('check_unit');
        if (checkUnit) {
            document.getElementById('label_unit').innerText = checkUnit.checked ? 'Tampilkan Semua Unit' : 'Hanya Unit Saya';
        }
        const checkCreated = document.getElementById('check_created');
        if (checkCreated) {
            document.getElementById('label_created').innerText = checkCreated.checked ? 'Urutkan Tgl Dokumen' : 'Waktu Sistem Terbaru';
        }
    }

    function attachPagination() {
        document.querySelectorAll('#paginationArea a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                updateContent(this.href);
            });
        });
    }

    function clearFilters() {
        const form = document.getElementById('searchForm');
        form.reset();
        
        // Manual clear for custom elements
        document.getElementById('search').value = '';
        document.querySelector('input[type="date"][name="date_from"]').value = '';
        document.querySelector('input[type="date"][name="date_to"]').value = '';
        
        // Reset Checkboxes
        const filterUnit = document.getElementById('check_unit');
        if (filterUnit) filterUnit.checked = true;
        const sortCreated = document.getElementById('check_created');
        if (sortCreated) sortCreated.checked = true;

        updateContent();
    }

    document.addEventListener('DOMContentLoaded', attachPagination);
</script>
@endsection
