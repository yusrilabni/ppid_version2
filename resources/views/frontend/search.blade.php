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
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2">Hasil Pencarian</h1>
                    <p class="text-gray-500">Menampilkan hasil pencarian untuk kata kunci: <span class="text-blue-600 font-bold">"{{ $query }}"</span></p>
                </div>
                
                {{-- Stats Body --}}
                <div class="px-6 md:px-10 py-4 bg-gray-50/50 flex flex-wrap gap-6 text-sm">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-search mr-2 text-gray-400"></i>
                        Total ditemukan: <span class="ml-1 font-bold text-gray-900">{{ $informasiResults->count() + $standarLayananResults->count() + $orgResults->count() }}</span>
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
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i> Informasi Publik
                            </h2>
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">{{ $informasiResults->count() }} data</span>
                        </div>
                        <div class="space-y-4">
                            @foreach($informasiResults as $item)
                                <div class="bg-white p-5 rounded-2xl border border-gray-100 hover:border-blue-300 hover:shadow-md transition-all group">
                                    <a href="{{ route('frontend.informasi.detail', $item->slug) }}" class="block">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">{{ $item->category }}</span>
                                            <span class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($item->tanggal_upload)->format('d M Y') }}</span>
                                        </div>
                                        <h3 class="text-base md:text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-2 leading-tight">{{ $item->title }}</h3>
                                        <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">{{ $item->deskripsi }}</p>
                                        <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between">
                                            <span class="text-[10px] text-gray-400 flex items-center">
                                                <i class="fas fa-eye mr-1"></i> {{ $item->views_count ?? 0 }} Dilihat
                                            </span>
                                            <span class="text-xs font-bold text-blue-600 group-hover:translate-x-1 transition-transform">Lihat Selengkapnya <i class="fas fa-arrow-right ml-1 text-[10px]"></i></span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    {{-- Standar Layanan Results Body --}}
                    @if($standarLayananResults->isNotEmpty())
                    <section>
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                                <i class="fas fa-file-alt mr-2 text-green-500"></i> Dokumen Standar Layanan
                            </h2>
                            <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg">{{ $standarLayananResults->count() }} data</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($standarLayananResults as $item)
                                <div class="bg-white p-5 rounded-2xl border border-gray-100 hover:border-green-300 hover:shadow-md transition-all group">
                                    <a href="{{ route('frontend.standar-layanan.file-detail', $item->slug) }}" class="block">
                                        <div class="flex items-center text-[10px] font-bold text-green-600 uppercase mb-3">
                                            <i class="fas fa-folder-open mr-2"></i> {{ $item->standarLayanan->title ?? 'Dokumen' }}
                                        </div>
                                        <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-green-600 transition-colors mb-4 h-10 line-clamp-2 leading-snug">{{ $item->title }}</h3>
                                        <div class="flex items-center justify-between text-[10px] text-gray-400">
                                            <span>Tahun {{ $item->tahun_dokumen }}</span>
                                            <span class="font-bold text-green-600">Buka Dokumen <i class="fas fa-external-link-alt ml-1"></i></span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    @if($informasiResults->isEmpty() && $standarLayananResults->isEmpty() && $orgResults->isEmpty())
                        <div class="bg-white py-16 px-6 rounded-3xl border-2 border-dashed border-gray-200 text-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-search text-gray-300 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak ada hasil ditemukan</h3>
                            <p class="text-gray-500 max-w-md mx-auto">Kami tidak dapat menemukan hasil yang cocok dengan kata kunci <span class="font-bold text-blue-600">"{{ $query }}"</span>. Silakan coba kata kunci lain.</p>
                        </div>
                    @endif

                </div>

                <!-- Sidebar Body -->
                <div class="space-y-8">
                    {{-- OPD Results Body --}}
                    <section>
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-university mr-2 text-purple-500"></i> Unit Kerja / OPD
                        </h2>
                        <div class="space-y-3">
                            @forelse($orgResults as $item)
                                <div class="bg-white p-4 rounded-xl border border-gray-100 hover:border-purple-300 hover:shadow-sm transition-all group">
                                    <a href="{{ route('opd.detail', $item->slug) }}" class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-500 flex items-center justify-center mr-3 group-hover:bg-purple-500 group-hover:text-white transition-all">
                                            <i class="fas fa-building text-sm"></i>
                                        </div>
                                        <span class="text-sm font-bold text-gray-700 group-hover:text-purple-600 transition-colors leading-tight">{{ $item->name }}</span>
                                    </a>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic text-center py-4">Tidak ada unit kerja yang cocok.</p>
                            @endforelse
                        </div>
                    </section>

                    {{-- Help Body --}}
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-800 p-8 rounded-3xl text-white shadow-xl relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-paper-plane text-8xl"></i>
                        </div>
                        <h3 class="text-lg font-bold mb-3 relative z-10">Belum Menemukan?</h3>
                        <p class="text-xs text-blue-100 mb-6 relative z-10 leading-relaxed">Anda dapat mengajukan permohonan informasi publik secara resmi jika data yang Anda cari belum tersedia.</p>
                        <a href="{{ route('laporan.permohonan.create') }}" class="block w-full bg-white text-blue-700 text-center text-sm font-bold py-3 rounded-xl hover:bg-blue-50 transition-all shadow-md relative z-10">
                            Ajukan Permohonan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
