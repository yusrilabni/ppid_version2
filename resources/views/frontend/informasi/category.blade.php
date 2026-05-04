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
            <div class="mt-8 mb-10">
                <form id="searchForm" method="GET" action="">
                    <!-- 1. Minimalist Search Bar -->
                    <div class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-end bg-white/80 backdrop-blur-md p-6 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-white mb-6">
                        <!-- Search Input -->
                        <div class="flex-1">
                            <label for="search" class="block text-[10px] font-black text-blue-900/40 mb-2 uppercase tracking-[0.2em] ml-4">Pencarian Pintar</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-blue-400 group-focus-within:text-blue-600 transition-colors">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" id="search" name="search" value="{{ request('search') ?? '' }}" placeholder="Ketik kata kunci atau nama unit..."
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
                        @endphp
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 lg:w-auto">
                            <div class="min-w-[140px]">
                                <label class="block text-[10px] font-black text-blue-900/40 mb-2 uppercase tracking-[0.2em] ml-2">Mulai</label>
                                <input type="date" name="date_from" value="{{ request('date_from') ?? '' }}" 
                                    class="w-full px-4 py-4 text-xs border-none bg-gray-50/50 rounded-2xl focus:ring-4 focus:ring-blue-500/10 font-bold text-gray-600">
                            </div>
                            <div class="min-w-[140px]">
                                <label class="block text-[10px] font-black text-blue-900/40 mb-2 uppercase tracking-[0.2em] ml-2">Sampai</label>
                                <input type="date" name="date_to" value="{{ request('date_to') ?? '' }}" 
                                    class="w-full px-4 py-4 text-xs border-none bg-gray-50/50 rounded-2xl focus:ring-4 focus:ring-blue-500/10 font-bold text-gray-600">
                            </div>
                            <div class="min-w-[120px]">
                                <label class="block text-[10px] font-black text-blue-900/40 mb-2 uppercase tracking-[0.2em] ml-2">Urutan</label>
                                <x-custom-select name="sort" :options="$sortOptions" :value="request('sort', 'tanggal_upload_desc')" :searchable="false" />
                            </div>
                            <div class="min-w-[100px]">
                                <label class="block text-[10px] font-black text-blue-900/40 mb-2 uppercase tracking-[0.2em] ml-2">Limit</label>
                                <x-custom-select name="per_page" :options="$perPageOptions" :value="request('per_page', '10')" :searchable="false" />
                            </div>
                        </div>

                        <!-- Search Button -->
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white w-full lg:w-14 h-14 rounded-2xl transition-all shadow-lg shadow-blue-600/20 flex items-center justify-center group">
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>

                    <!-- 2. Minimalist Toggles (PRECISE OVER TABLE) -->
                    <div class="flex flex-wrap items-center gap-3 px-2">
                        @auth
                            @if(!auth()->user()->isSuperAdmin())
                            <label class="relative flex items-center cursor-pointer group">
                                <input type="hidden" name="filter_unit" value="0">
                                <input type="checkbox" name="filter_unit" value="1" {{ request('filter_unit', '1') == '1' ? 'checked' : '' }} onchange="this.form.submit()" class="sr-only peer">
                                <div class="px-5 py-2.5 rounded-full bg-white border border-gray-100 shadow-sm flex items-center gap-2 peer-checked:bg-blue-600 peer-checked:text-white transition-all hover:border-blue-200">
                                    <div class="w-2 h-2 rounded-full bg-gray-300 peer-checked:bg-white animate-pulse"></div>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Unit Saya</span>
                                </div>
                            </label>
                            @endif
                        @endauth

                        <label class="relative flex items-center cursor-pointer group">
                            <input type="hidden" name="sort_created" value="0">
                            <input type="checkbox" name="sort_created" value="1" {{ request('sort_created', '1') == '1' ? 'checked' : '' }} onchange="this.form.submit()" class="sr-only peer">
                            <div class="px-5 py-2.5 rounded-full bg-white border border-gray-100 shadow-sm flex items-center gap-2 peer-checked:bg-indigo-600 peer-checked:text-white transition-all hover:border-indigo-200">
                                <i class="fas fa-bolt text-[10px] text-gray-300 peer-checked:text-white"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest">Terbaru Upload</span>
                            </div>
                        </label>

                        <button type="button" onclick="clearFilters()" class="px-5 py-2.5 rounded-full bg-gray-100 text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all flex items-center gap-2 ml-auto group">
                            <i class="fas fa-undo text-[10px] group-hover:rotate-[-45deg] transition-transform"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest">Reset</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel/Mobile Cards -->
        <div class="mt-4 bg-white rounded-[3rem] shadow-2xl shadow-blue-900/5 overflow-hidden border border-gray-50">
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-800 to-slate-900 text-white">
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
                                        <span class="text-[9px] text-gray-300 font-bold uppercase tracking-tighter">ID: {{ $informasi->id }}</span>
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
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                            <form action="{{ route('informasi-crud.destroy', $informasi) }}" method="POST" onsubmit="return confirm('Hapus informasi ini?')">
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
        <div class="mt-8 flex justify-center">
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
        
        // Reset Checkboxes to default (checked)
        const filterUnit = document.querySelector('input[name="filter_unit"][type="checkbox"]');
        if (filterUnit) filterUnit.checked = true;
        
        const sortCreated = document.querySelector('input[name="sort_created"][type="checkbox"]');
        if (sortCreated) sortCreated.checked = true;

        document.getElementById('searchForm').submit();
    }
</script>
@endsection
