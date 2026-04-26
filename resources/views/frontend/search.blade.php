@extends('frontend.layouts.app')

@section('title', 'Pencarian: ' . $query)

@section('content')
<div class="bg-gray-50 min-h-screen pb-12">
    <div class="container mx-auto py-6 md:py-8 px-4">
        <div class="max-w-7xl mx-auto">
            <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

            <!-- Search Header Body -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
                <div class="p-6 md:p-10 border-b border-gray-100">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2 uppercase tracking-tight">Hasil Pencarian</h1>
                    <p class="text-gray-500">Menampilkan hasil pencarian untuk kata kunci: <span class="text-blue-600 font-bold">"{{ $query }}"</span></p>
                </div>
                
                {{-- Stats Body --}}
                <div class="px-6 md:px-10 py-4 bg-gray-50/50 flex flex-wrap gap-6 text-sm">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-search mr-2 text-gray-400"></i>
                        Total ditemukan: <span class="ml-1 font-bold text-gray-900">{{ $informasiResults->total() + $standarLayananResults->count() + $orgResults->count() }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                        Waktu pencarian: <span class="ml-1 font-bold text-gray-900">{{ number_format(microtime(true) - LARAVEL_START, 2) }} detik</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Main Body Results -->
                <div class="lg:col-span-3 space-y-8">
                    
                    {{-- Informasi Publik Results Body --}}
                    @if($informasiResults->isNotEmpty())
                    <section>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-black text-gray-800 flex items-center">
                                <i class="fas fa-info-circle mr-3 text-blue-500 text-2xl"></i> INFORMASI PUBLIK
                            </h2>
                            <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-widest border border-blue-100">Halaman {{ $informasiResults->currentPage() }} dari {{ $informasiResults->lastPage() }}</span>
                        </div>
                        <div class="space-y-6">
                            @foreach($informasiResults as $index => $item)
                                @php
                                    // Highlight item pertama jika skornya sangat tinggi (Best Match)
                                    $isBestMatch = ($informasiResults->currentPage() == 1 && $index === 0 && ($item->search_score ?? 0) > 100);
                                    
                                    $catColor = match($item->category) {
                                        'Informasi Berkala' => 'blue',
                                        'Informasi Setiap Saat' => 'green',
                                        'Informasi Serta Merta' => 'yellow',
                                        'Informasi Dikecualikan' => 'red',
                                        default => 'slate'
                                    };

                                    $unitId = trim((string)$item->unit_id);
                                    $unit = ($unitMap ?? collect())->get($unitId);
                                    $unitName = $unit['unit_nama'] ?? ($item->organization->name ?? ($item->user->opd_name ?? 'Unit Tidak Terdaftar'));
                                @endphp

                                <div class="relative group">
                                    @if($isBestMatch)
                                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-[2.5rem] blur opacity-20 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
                                        <div class="absolute -top-3 left-8 bg-blue-600 text-white text-[10px] font-black px-4 py-1 rounded-full uppercase tracking-[0.2em] shadow-lg z-20">Hasil Paling Sesuai</div>
                                    @endif

                                    <div class="relative bg-white p-6 md:p-8 rounded-[2rem] border {{ $isBestMatch ? 'border-blue-400 shadow-xl' : 'border-gray-100 shadow-sm' }} hover:border-blue-300 hover:shadow-xl transition-all duration-500 h-full flex flex-col group/card overflow-hidden">
                                        {{-- Decorative Background --}}
                                        <div class="absolute -right-8 -top-8 text-{{ $catColor }}-50 group-hover/card:scale-110 transition-transform duration-700 opacity-30 pointer-events-none">
                                            <i class="fas fa-file-alt fa-9x"></i>
                                        </div>

                                        <div class="relative z-10">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="w-10 h-10 rounded-2xl bg-{{ $catColor }}-50 flex items-center justify-center text-{{ $catColor }}-600 border border-{{ $catColor }}-100/50 shadow-sm">
                                                    <i class="fas fa-building text-sm"></i>
                                                </div>
                                                <div class="flex flex-col min-w-0">
                                                    <span class="text-[11px] font-black text-gray-800 uppercase tracking-tight line-clamp-1 leading-tight">{{ $unitName }}</span>
                                                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Diterbitkan pada {{ \Carbon\Carbon::parse($item->tanggal_upload)->locale('id')->isoFormat('D MMMM Y') }}</span>
                                                </div>
                                            </div>

                                            <a href="{{ route('frontend.informasi.detail', $item->slug) }}" class="block mb-4">
                                                <h3 class="text-lg md:text-xl font-black text-gray-900 leading-tight group-hover/card:text-blue-600 transition-colors">
                                                    {{ $item->title }}
                                                </h3>
                                            </a>
                                            <p class="text-sm text-gray-500 line-clamp-3 leading-relaxed mb-6">{{ $item->deskripsi }}</p>
                                        </div>

                                        <div class="mt-auto pt-5 border-t border-gray-50 flex items-center justify-between relative z-10">
                                            <div class="flex flex-col gap-2">
                                                <span class="inline-flex items-center w-fit text-[9px] font-black px-3 py-1 rounded-full bg-{{ $catColor }}-50 text-{{ $catColor }}-600 border border-{{ $catColor }}-100 uppercase tracking-[0.1em]">
                                                    {{ $item->category }}
                                                </span>
                                                <span class="text-[10px] text-gray-400 font-bold flex items-center">
                                                    <i class="fas fa-eye mr-2 text-blue-500"></i> {{ $item->views_count ?? 0 }} Dilihat
                                                </span>
                                            </div>
                                            
                                            <a href="{{ route('frontend.informasi.detail', $item->slug) }}" 
                                               class="px-6 py-3 rounded-2xl bg-gray-900 text-white text-xs font-black uppercase tracking-widest flex items-center gap-2 hover:bg-{{ $catColor }}-600 transition-all shadow-lg active:scale-95 group/btn">
                                                <span>Detail</span>
                                                <i class="fas fa-arrow-right group-hover/btn:translate-x-1 transition-transform"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination Body -->
                        <div class="mt-12 px-4 py-6 bg-white rounded-[2rem] border border-gray-100 shadow-sm">
                            {{ $informasiResults->onEachSide(1)->links() }}
                        </div>
                    </section>
                    @endif

                    {{-- Standar Layanan Results Body --}}
                    @if($standarLayananResults->isNotEmpty())
                    <section>
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-black text-gray-800 flex items-center">
                                <i class="fas fa-file-alt mr-3 text-green-500"></i> STANDAR LAYANAN
                            </h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($standarLayananResults as $item)
                                <div class="bg-white p-6 rounded-[2rem] border border-gray-100 hover:border-green-300 hover:shadow-xl transition-all duration-500 group/sl shadow-sm overflow-hidden relative">
                                    <div class="absolute -right-4 -top-4 text-green-50 opacity-0 group-hover/sl:opacity-100 transition-opacity duration-500">
                                        <i class="fas fa-folder-open fa-6x"></i>
                                    </div>
                                    <a href="{{ route('frontend.standar-layanan.file-detail', $item->slug) }}" class="block relative z-10 h-full flex flex-col">
                                        <div class="flex items-center text-[10px] font-black text-green-600 uppercase tracking-widest mb-4">
                                            <span class="px-2.5 py-1 bg-green-50 rounded-lg border border-green-100">{{ $item->standarLayanan->title ?? 'Dokumen' }}</span>
                                        </div>
                                        <h3 class="text-base font-bold text-gray-900 group-hover/sl:text-green-600 transition-colors mb-6 line-clamp-2 leading-tight flex-1">{{ $item->title }}</h3>
                                        <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tahun {{ $item->tahun_dokumen }}</span>
                                            <div class="w-8 h-8 rounded-xl bg-gray-900 text-white flex items-center justify-center group-hover/sl:bg-green-600 transition-all shadow-md">
                                                <i class="fas fa-external-link-alt text-[10px]"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    @if($informasiResults->isEmpty() && $standarLayananResults->isEmpty() && $orgResults->isEmpty())
                        <div class="bg-white py-20 px-6 rounded-[3rem] border-2 border-dashed border-gray-200 text-center shadow-inner">
                            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8 shadow-sm">
                                <i class="fas fa-search-minus text-gray-300 text-4xl"></i>
                            </div>
                            <h3 class="text-2xl font-black text-gray-800 mb-3">Tidak ada hasil ditemukan</h3>
                            <p class="text-gray-500 max-w-md mx-auto leading-relaxed">Kami tidak dapat menemukan hasil yang cocok dengan kata kunci <span class="font-bold text-blue-600">"{{ $query }}"</span>. Silakan coba kata kunci yang lebih umum.</p>
                            <div class="mt-10">
                                <a href="{{ route('home') }}" class="px-8 py-3 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">Kembali ke Beranda</a>
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Sidebar Body -->
                <div class="space-y-8">
                    {{-- OPD Results Body --}}
                    @if($orgResults->isNotEmpty())
                    <section>
                        <h2 class="text-xl font-black text-gray-800 mb-6 flex items-center uppercase tracking-tight">
                            <i class="fas fa-university mr-3 text-purple-500"></i> Unit / OPD
                        </h2>
                        <div class="space-y-4">
                            @foreach($orgResults as $item)
                                <div class="bg-white p-4 rounded-2xl border border-gray-100 hover:border-purple-300 hover:shadow-xl transition-all duration-500 group/opd shadow-sm">
                                    <a href="{{ route('opd.detail', $item->slug) }}" class="flex items-center">
                                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center mr-4 group-hover/opd:bg-purple-600 group-hover/opd:text-white transition-all shadow-inner">
                                            <i class="fas fa-building text-base"></i>
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span class="text-xs font-black text-gray-700 group-hover/opd:text-purple-600 transition-colors leading-tight line-clamp-2">{{ $item->name }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    {{-- Help Body --}}
                    <div class="bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 p-10 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-125 transition-transform duration-1000 rotate-12">
                            <i class="fas fa-paper-plane text-[12rem]"></i>
                        </div>
                        <h3 class="text-2xl font-black mb-4 relative z-10 leading-tight">Belum Menemukan Data?</h3>
                        <p class="text-sm text-blue-100/80 mb-8 relative z-10 leading-relaxed font-medium">Anda dapat mengajukan permohonan informasi publik secara resmi jika data yang Anda cari belum tersedia di portal kami.</p>
                        <a href="{{ route('laporan.permohonan.create') }}" class="block w-full bg-white text-blue-800 text-center text-xs font-black uppercase tracking-[0.2em] py-4 rounded-2xl hover:bg-blue-50 transition-all shadow-xl active:scale-95 relative z-10">
                            Ajukan Permohonan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Pagination Styling */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        list-style: none;
    }
    .page-item .page-link {
        border: none;
        background: #f8fafc;
        color: #64748b;
        padding: 0.75rem 1rem;
        border-radius: 1rem;
        font-weight: 800;
        font-size: 0.75rem;
        transition: all 0.3s;
    }
    .page-item.active .page-link {
        background: #2563eb;
        color: white;
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
    }
    .page-item:hover:not(.active) .page-link {
        background: #eff6ff;
        color: #2563eb;
    }
</style>
@endsection
