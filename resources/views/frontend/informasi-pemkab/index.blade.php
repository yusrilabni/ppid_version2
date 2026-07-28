@extends('frontend.layouts.app')

@section('title', 'Informasi Pemkab')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800 uppercase relative inline-block">
            Informasi Pemkab
            <span class="absolute bottom-0 left-0 w-full h-1 bg-blue-600 rounded mt-2 transform translate-y-3"></span>
        </h1>
        <p class="text-gray-600 mt-6">Daftar Dokumen Transparansi Pemerintah Kabupaten</p>
    </div>

    <!-- Kotak Pencarian / Filter -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8 border-t-4 border-blue-600 relative" style="z-index: 40;">
        <form action="{{ route('frontend.informasi-pemkab.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <!-- Filter Kategori -->
                <div class="relative" style="z-index: 50;">
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" id="kategori" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition custom-select2">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori_jenis as $kat => $jenis)
                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Filter Jenis Dokumen -->
                <div class="relative" style="z-index: 49;">
                    <label for="jenis_dokumen" class="block text-sm font-medium text-gray-700 mb-2">Jenis Dokumen</label>
                    <select name="jenis_dokumen" id="jenis_dokumen" disabled class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition bg-gray-100 cursor-not-allowed custom-select2">
                        <option value="">-- Pilih Kategori Dulu --</option>
                    </select>
                </div>

                <!-- Filter Tahun -->
                <div class="relative">
                    <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">Tahun Dokumen</label>
                    <select name="tahun" id="tahun" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition custom-select2">
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

                <!-- Pencarian & Tombol -->
                <div class="relative flex space-x-2">
                    <div class="flex-grow">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Pencarian Judul</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari..." 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition h-[42px] px-3 border">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold h-[42px] px-4 rounded-lg transition flex items-center justify-center whitespace-nowrap">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('frontend.informasi-pemkab.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold h-[42px] px-4 rounded-lg transition flex items-center justify-center ml-2" title="Reset Filter">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Dokumen -->
    <div class="bg-white p-6 rounded-lg shadow-md relative" style="z-index: 10;">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Judul</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Kategori</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Jenis Dokumen</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Tahun</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 divide-y divide-gray-200">
                    @forelse ($informasi_pemkabs as $dokumen)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="text-left py-4 px-4">
                                <div class="font-medium text-gray-900">{{ $dokumen->judul }}</div>
                                @if($dokumen->deskripsi)
                                    <div class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $dokumen->deskripsi }}</div>
                                @endif
                                @if($dokumen->organization)
                                    <div class="text-xs text-blue-600 mt-1 font-semibold">OPD: {{ $dokumen->organization->name }}</div>
                                @endif
                            </td>
                            <td class="text-left py-4 px-4">{{ $dokumen->kategori }}</td>
                            <td class="text-left py-4 px-4">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded font-semibold">{{ $dokumen->jenis_dokumen }}</span>
                            </td>
                            <td class="text-left py-4 px-4 font-medium">{{ $dokumen->tahun }}</td>
                            <td class="text-center py-4 px-4">
                                @if ($dokumen->file_path)
                                    <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="inline-flex items-center justify-center bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-sm transition">
                                        <i class="fas fa-download mr-1"></i> Unduh
                                    </a>
                                @else
                                    <span class="text-gray-400 text-sm">Tidak ada file</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-box-open text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500 font-medium">Tidak ada dokumen yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $informasi_pemkabs->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- Select2 & Logic -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 42px !important;
        border: 1px solid #d1d5db !important;
        border-radius: 0.5rem !important;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #374151 !important;
        line-height: 40px !important;
    }
    .select2-dropdown {
        border-radius: 0.5rem !important;
        border-color: #d1d5db !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    const mapping = @json($kategori_jenis);
    const oldJenis = "{{ request('jenis_dokumen') }}";
    
    $(document).ready(function() {
        $('.custom-select2').select2({
            width: '100%',
            dropdownAutoWidth: true
        });

        $('#kategori').on('change', function() {
            let kategori = $(this).val();
            let $jenis = $('#jenis_dokumen');
            
            $jenis.empty();
            
            if (kategori && mapping[kategori]) {
                $jenis.prop('disabled', false);
                $jenis.removeClass('bg-gray-100 cursor-not-allowed');
                $jenis.append('<option value="">Semua Jenis Dokumen</option>');
                
                mapping[kategori].forEach(function(item) {
                    let selected = (oldJenis === item) ? 'selected' : '';
                    $jenis.append(`<option value="${item}" ${selected}>${item}</option>`);
                });
            } else {
                $jenis.prop('disabled', true);
                $jenis.addClass('bg-gray-100 cursor-not-allowed');
                $jenis.append('<option value="">-- Pilih Kategori Dulu --</option>');
            }
        });

        // Trigger on load for active filter
        if ($('#kategori').val()) {
            $('#kategori').trigger('change');
        }
    });
</script>
@endsection
