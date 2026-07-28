@extends('frontend.layouts.app')

@section('title', 'Informasi Pemkab')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-600 pt-20 pb-24 overflow-hidden">
    <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-overlay"></div>
    <div class="container max-w-6xl mx-auto px-4 relative z-10 text-center">
        <!-- Breadcrumbs -->
        <div class="flex flex-wrap items-center justify-start gap-y-2 space-x-2 md:space-x-3 text-blue-200 text-xs md:text-sm mb-6 font-medium w-full text-left">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors flex items-center"><i class="fas fa-home mr-1"></i> Beranda</a>
            <i class="fas fa-chevron-right text-[10px] opacity-50"></i>
            <span class="text-white opacity-80 flex items-center"><i class="fas fa-layer-group mr-1"></i> Transparansi</span>
            <i class="fas fa-chevron-right text-[10px] opacity-50"></i>
            <span class="text-white opacity-80 flex items-center"><i class="fas fa-file-pdf mr-1"></i> Informasi Pemkab</span>
        </div>

        <div class="flex justify-center items-center mb-4">
            <div class="w-full relative">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight drop-shadow-lg">
                    Informasi Pemkab
                </h1>
            </div>
        </div>
        <p class="text-blue-100 text-lg md:text-xl max-w-2xl mx-auto font-light mt-4">
            Transparansi Dokumen Pemerintah Kabupaten yang dapat Anda akses, telusuri, dan unduh dengan mudah.
        </p>
    </div>
    
    <!-- Wave Shape Divider -->
    <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-none transform translate-y-1">
        <svg class="relative block w-full h-[50px] md:h-[80px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118,130.83,121.22,201.2,110.53Z" class="fill-gray-50"></path>
        </svg>
    </div>
</div>

<div class="bg-gray-50 pb-16">
    <div class="container max-w-6xl mx-auto px-4 -mt-8 relative z-20">
        <!-- Kotak Filter Glassmorphism -->
        <div class="bg-white/90 backdrop-blur-md p-6 md:p-8 rounded-2xl shadow-xl border border-gray-100 mb-10 transition-all duration-300 hover:shadow-2xl">
            <form action="{{ route('frontend.informasi-pemkab.index') }}" method="GET" id="filterForm">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6 items-end">
                    
                    <!-- Filter Kategori -->
                    <div class="relative" style="z-index: 50;">
                        <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-layer-group text-blue-500 mr-1"></i> Kategori
                        </label>
                        <select name="kategori" id="kategori" class="w-full custom-select2" onchange="resetJenisAndSubmit()">
                            <option value="">Semua Kategori</option>
                            @foreach($kategori_jenis as $kat => $jenis)
                                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Filter Jenis Dokumen -->
                    <div class="relative" style="z-index: 49;">
                        <label for="jenis_dokumen" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-file-alt text-blue-500 mr-1"></i> Jenis Dokumen
                        </label>
                        <select name="jenis_dokumen" id="jenis_dokumen" class="w-full custom-select2" onchange="this.form.submit()">
                            <option value="">Semua Jenis Dokumen</option>
                        </select>
                    </div>

                    <!-- Filter Tahun -->
                    <div class="relative">
                        <label for="tahun" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-calendar-alt text-blue-500 mr-1"></i> Tahun
                        </label>
                        <select name="tahun" id="tahun" class="w-full custom-select2" onchange="this.form.submit()">
                            <option value="">Semua Tahun</option>
                            @php
                                $currentYear = date('Y');
                                $startYear = 2000;
                            @endphp
                            @for($y = $currentYear; $y >= $startYear; $y--)
                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Per Halaman -->
                    <div class="relative">
                        <label for="per_page" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-list-ol text-blue-500 mr-1"></i> Tampilkan
                        </label>
                        <select name="per_page" id="per_page" class="w-full custom-select2" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 Baris</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Baris</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Baris</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 Baris</option>
                        </select>
                    </div>

                    <!-- Pencarian Teks -->
                    <div class="relative flex flex-col">
                        <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-search text-blue-500 mr-1"></i> Cari
                        </label>
                        <div class="flex items-center space-x-2">
                            <div class="relative flex-grow">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Judul..." 
                                    class="w-full pl-10 pr-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all h-[44px] text-sm bg-gray-50 focus:bg-white">
                            </div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white shadow-md hover:shadow-lg rounded-xl h-[44px] px-4 transition-all flex items-center justify-center">
                                Cari
                            </button>
                            <a href="{{ route('frontend.informasi-pemkab.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 shadow-sm rounded-xl h-[44px] px-3 transition-all flex items-center justify-center border border-gray-200" title="Reset Filter">
                                <i class="fas fa-sync-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Indikator Filter Aktif -->
        @if(request('kategori') || request('jenis_dokumen') || request('tahun') || request('search'))
        <div class="flex flex-wrap items-center gap-2 mb-6 px-2">
            <span class="text-sm text-gray-500 font-medium">Filter aktif:</span>
            @if(request('kategori')) <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold shadow-sm border border-blue-200">{{ request('kategori') }}</span> @endif
            @if(request('jenis_dokumen')) <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold shadow-sm border border-indigo-200">{{ request('jenis_dokumen') }}</span> @endif
            @if(request('tahun')) <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold shadow-sm border border-purple-200">Tahun: {{ request('tahun') }}</span> @endif
            @if(request('search')) <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold shadow-sm border border-gray-300">Pencarian: "{{ request('search') }}"</span> @endif
            
            <a href="{{ route('frontend.informasi-pemkab.index') }}" class="text-red-500 hover:text-red-700 text-xs font-medium ml-2 underline decoration-dashed underline-offset-4">Hapus Semua Filter</a>
        </div>
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-4 relative z-10">
            <h2 class="text-xl font-bold text-gray-800">Daftar Dokumen</h2>
            
            @auth
                @can('create', App\Models\Informasi::class)
                <a href="{{ route('admin.informasi-pemkab.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl transition-all flex items-center shadow shadow-blue-500/30 hover:shadow-lg transform hover:-translate-y-0.5 text-sm md:text-base w-full sm:w-auto justify-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Dokumen
                </a>
                @endcan
            @endauth
        </div>

        <!-- Daftar Dokumen Grid/List -->
        <div class="bg-white/80 rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative min-h-[400px]" style="z-index: 10;">
            
            <!-- Watermark Background Dynamic -->
            <div class="absolute inset-0 z-0 flex items-center justify-center pointer-events-none overflow-hidden" style="opacity: 0.03;">
                <div class="w-full h-full" style="background-image: url('{{ asset('storage/logo/Lambang_Kabupaten_Sinjai.png') }}'); background-repeat: repeat-y; background-position: center top; background-size: contain; min-height: 800px; filter: grayscale(100%);"></div>
            </div>

            <div class="overflow-x-hidden md:overflow-x-auto relative z-10">
                <table class="min-w-full w-full whitespace-nowrap md:whitespace-normal bg-transparent">
                    <thead class="hidden md:table-header-group">
                        <tr class="bg-gray-100/60 border-b border-gray-200 text-left backdrop-blur-sm">
                            <th class="py-4 px-6 font-bold text-gray-700 text-sm tracking-wide uppercase">Detail Dokumen</th>
                            <th class="py-4 px-6 font-bold text-gray-700 text-sm tracking-wide uppercase w-48">Kategori</th>
                            <th class="py-4 px-6 font-bold text-gray-700 text-sm tracking-wide uppercase w-32 text-center">Tahun</th>
                            <th class="py-4 px-6 font-bold text-gray-700 text-sm tracking-wide uppercase w-32 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-transparent md:divide-gray-100/50 block md:table-row-group bg-gray-50/30 md:bg-transparent p-3 md:p-0 space-y-4 md:space-y-0">
                        @forelse ($informasi_pemkabs as $dokumen)
                            <tr class="block md:table-row bg-white md:bg-transparent rounded-2xl md:rounded-none shadow-sm md:shadow-none border {{ $dokumen->visibility === 'private' ? 'border-orange-200 md:border-none bg-orange-50/20 md:bg-orange-50/40 md:hover:bg-orange-100/60' : 'border-gray-100 md:border-none hover:bg-blue-50/60' }} p-4 md:p-0 transition-colors group">
                                <td class="block md:table-cell py-2 md:py-4 px-1 md:px-6 whitespace-normal align-top md:align-middle">
                                    <div class="flex flex-col md:flex-row md:items-center gap-3 md:gap-0">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-xl {{ $dokumen->visibility === 'private' ? 'bg-gradient-to-tr from-orange-100 to-amber-50 border-orange-200 text-orange-600' : 'bg-gradient-to-tr from-blue-100 to-indigo-50 border-blue-100 text-blue-600' }} flex items-center justify-center border shadow-sm">
                                                <i class="fas fa-file-pdf text-lg"></i>
                                            </div>
                                        </div>
                                        <div class="md:ml-4 flex-grow">
                                            <a href="{{ route('frontend.informasi-pemkab.show', $dokumen->slug ?? $dokumen->id) }}" class="block text-base font-bold text-gray-800 hover:text-blue-700 transition-colors leading-tight">
                                                {{ $dokumen->judul }}
                                                @if($dokumen->visibility === 'private')
                                                    <span class="mt-1 md:mt-0 md:ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800 border border-orange-200" title="Hanya tampil bagi yang login atau memiliki link">
                                                        <i class="fas fa-lock mr-1 text-[10px]"></i> Private
                                                    </span>
                                                @endif
                                            </a>
                                            @if($dokumen->deskripsi)
                                                <p class="text-sm text-gray-500 mt-1 line-clamp-1 group-hover:line-clamp-none transition-all duration-300">
                                                    {{ $dokumen->deskripsi }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="block md:table-cell py-2 md:py-4 px-1 md:px-6 whitespace-normal align-middle md:border-t-0 border-t border-gray-100/60 mt-3 pt-3 md:mt-0 md:pt-4">
                                    <div class="flex flex-wrap gap-2 md:block">
                                        <span class="inline-block px-3 py-1 bg-white/80 md:bg-white/80 text-gray-700 text-[11px] md:text-xs font-semibold rounded-lg border border-gray-200 shadow-sm md:mb-1">
                                            {{ $dokumen->kategori }}
                                        </span>
                                        <span class="inline-block px-3 py-1 bg-blue-50/80 text-blue-700 text-[11px] md:text-xs font-semibold rounded-lg border border-blue-100 shadow-sm md:mt-1">
                                            {{ $dokumen->jenis_dokumen }}
                                        </span>
                                        <!-- Tahun on mobile only -->
                                        <span class="md:hidden inline-block px-3 py-1 bg-gray-100/80 text-gray-700 text-[11px] md:text-xs font-semibold rounded-lg border border-gray-200 shadow-sm">
                                            <i class="fas fa-calendar mr-1"></i> {{ $dokumen->tahun }}
                                        </span>
                                    </div>
                                </td>
                                <td class="hidden md:table-cell py-4 px-6 text-center align-middle">
                                    <span class="inline-block bg-white/80 px-3 py-1.5 rounded-lg text-sm font-bold text-gray-600 border border-gray-200 shadow-sm">
                                        {{ $dokumen->tahun }}
                                    </span>
                                </td>
                                <td class="block md:table-cell py-3 md:py-4 px-1 md:px-6 align-middle md:w-48 md:border-t-0 border-t border-gray-100/60 mt-3 pt-3 md:mt-0 md:pt-4">
                                    <div class="flex items-center justify-start md:justify-center space-x-2">
                                        <!-- Lihat Detail -->
                                        <a href="{{ route('frontend.informasi-pemkab.show', $dokumen->slug ?? $dokumen->id) }}" class="inline-flex items-center justify-center w-9 h-9 bg-blue-50 border border-blue-200 text-blue-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 hover:shadow-lg rounded-lg text-sm transition-all duration-300" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Buka Link / Unduh -->
                                        @if ($dokumen->file_path)
                                            <a href="{{ route('frontend.informasi-pemkab.download', $dokumen->slug ?? $dokumen->id) }}" target="_blank" class="inline-flex items-center justify-center w-9 h-9 bg-green-50 border border-green-200 text-green-600 hover:bg-green-600 hover:text-white hover:border-green-600 hover:shadow-lg rounded-lg text-sm transition-all duration-300" title="{{ str_starts_with($dokumen->file_path, 'http') ? 'Buka Tautan Eksternal' : 'Unduh Dokumen' }}">
                                                <i class="fas {{ str_starts_with($dokumen->file_path, 'http') ? 'fa-external-link-alt' : 'fa-cloud-download-alt' }}"></i>
                                            </a>
                                        @endif

                                        <!-- Edit dan Hapus (Auth) -->
                                        @if(auth()->check() && (auth()->user()->isAdmin() || $dokumen->organization_id == auth()->user()->unit_id))
                                            <div class="h-6 w-px bg-gray-300 mx-1"></div>
                                            
                                            <a href="{{ route('admin.informasi-pemkab.edit', $dokumen->id) }}" class="inline-flex items-center justify-center w-9 h-9 bg-orange-50 border border-orange-200 text-orange-600 hover:bg-orange-600 hover:text-white hover:border-orange-600 hover:shadow-lg rounded-lg text-sm transition-all duration-300" title="Edit Dokumen">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.informasi-pemkab.destroy', $dokumen->id) }}" method="POST" class="inline-block m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-9 h-9 bg-red-50 border border-red-200 text-red-600 hover:bg-red-600 hover:text-white hover:border-red-600 hover:shadow-lg rounded-lg text-sm transition-all duration-300" onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')" title="Hapus Dokumen">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="block md:table-row bg-white md:bg-transparent rounded-2xl md:rounded-none">
                                <td colspan="4" class="block md:table-cell py-16 md:py-20 text-center">
                                    <div class="flex flex-col items-center justify-center relative z-20">
                                        <div class="w-24 h-24 bg-white/80 shadow-sm rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-folder-open text-4xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Dokumen</h3>
                                        <p class="text-gray-500 font-medium">Silakan sesuaikan filter pencarian Anda.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($informasi_pemkabs->hasPages())
            <div class="relative z-10 px-6 py-4 border-t border-gray-100 bg-white/50 backdrop-blur-sm">
                {{ $informasi_pemkabs->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Select2 & Scripts -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 44px !important;
        border: 1px solid #d1d5db !important;
        border-radius: 0.75rem !important;
        display: flex;
        align-items: center;
        background-color: #f9fafb !important;
        transition: all 0.2s;
    }
    .select2-container--open .select2-selection--single {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #374151 !important;
        font-weight: 500;
        padding-left: 1rem !important;
    }
    .select2-dropdown {
        border-radius: 0.75rem !important;
        border-color: #e5e7eb !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        overflow: hidden;
    }
    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
        background-color: #eff6ff !important;
        color: #1d4ed8 !important;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    const mapping = @json($kategori_jenis);
    const oldJenis = "{{ request('jenis_dokumen') }}";
    
    function resetJenisAndSubmit() {
        // Reset jenis_dokumen so it doesn't send old invalid value for the new category
        let $jenis = $('#jenis_dokumen');
        $jenis.empty();
        $jenis.append('<option value="">Semua Jenis Dokumen</option>');
        
        // Submit the form immediately to refresh the URL and page
        document.getElementById('filterForm').submit();
    }

    $(document).ready(function() {
        $('.custom-select2').select2({
            width: '100%',
            dropdownAutoWidth: true,
            minimumResultsForSearch: 10
        });

        // Initialize Jenis Dokumen based on current URL Kategori
        let currentKategori = $('#kategori').val();
        let $jenis = $('#jenis_dokumen');
        
        if (currentKategori && mapping[currentKategori]) {
            $jenis.prop('disabled', false);
            $jenis.removeClass('bg-gray-100 cursor-not-allowed').addClass('bg-gray-50');
            
            // Re-populate options
            mapping[currentKategori].forEach(function(item) {
                // If it's already there (from backend), don't duplicate, but since we start empty except for placeholder:
                if($jenis.find("option[value='" + item + "']").length === 0) {
                    let selected = (oldJenis === item) ? 'selected' : '';
                    $jenis.append(`<option value="${item}" ${selected}>${item}</option>`);
                }
            });
        } else {
            $jenis.prop('disabled', true);
            $jenis.addClass('bg-gray-100 cursor-not-allowed').removeClass('bg-gray-50');
            $jenis.empty().append('<option value="">-- Pilih Kategori Dulu --</option>');
        }
    });
</script>
@endsection
