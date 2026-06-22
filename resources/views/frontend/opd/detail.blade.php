@extends('frontend.layouts.app')

@section('title', 'Tentang OPD ' . $organization->name)

@section('meta')
    <meta property="og:title" content="Profil {{ $organization->name }} - Kabupaten Sinjai">
    <meta property="og:description" content="Profil resmi dan struktur organisasi {{ $organization->name }} Kabupaten Sinjai.">
    <meta property="og:image" content="{{ ($informasi && $informasi->file) ? asset('storage/' . $informasi->file) : asset('storage/logo/ppid_og.png') }}">
    <meta property="twitter:title" content="Profil {{ $organization->name }} - Kabupaten Sinjai">
    <meta property="twitter:description" content="Profil resmi dan struktur organisasi {{ $organization->name }} Kabupaten Sinjai.">
    <meta property="twitter:image" content="{{ ($informasi && $informasi->file) ? asset('storage/' . $informasi->file) : asset('storage/logo/ppid_og.png') }}">
@endsection

@section('content')
<div class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <div class="mb-8">
            <x-breadcrumbs :breadcrumbs="[
                ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                ['title' => 'Tentang OPD', 'url' => route('opd.list'), 'icon' => 'fas fa-building'],
                ['title' => $organization->name, 'url' => '#', 'icon' => 'fas fa-info-circle']
            ]" />
        </div>

        <div class="bg-white rounded-[3rem] shadow-xl overflow-hidden border border-gray-100">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 p-8 md:p-12 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 p-12 opacity-10 transform translate-x-1/4 -translate-y-1/4">
                    <i class="fas fa-building text-[150px]"></i>
                </div>
                <div class="relative z-10 text-center">
                    <span class="inline-block px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-6 border border-white/20">Profil Organisasi Perangkat Daerah</span>
                    <h1 class="text-3xl md:text-5xl font-black mb-6 leading-tight">{{ $organization->name }}</h1>
                    
                    @if($organization->website_url)
                        <div class="flex flex-col md:flex-row items-center justify-center gap-4 mt-8">
                            <div class="flex items-center bg-white/10 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/20">
                                <i class="fas fa-globe mr-3 text-blue-300"></i>
                                <span class="text-sm font-bold tracking-wide">{{ preg_replace('(^https?://)', '', $organization->website_url) }}</span>
                            </div>
                            <a href="{{ $organization->website_url }}" target="_blank" class="inline-flex items-center justify-center bg-white text-blue-700 font-black text-xs px-8 py-4 rounded-2xl hover:bg-blue-50 transition-all duration-300 shadow-xl uppercase tracking-widest gap-2">
                                <i class="fas fa-external-link-alt"></i> Kunjungi Website Resmi
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-8 md:p-16">
                <div class="mb-12 flex items-center gap-4">
                    <div class="h-10 w-2 bg-blue-600 rounded-full"></div>
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 uppercase tracking-tight">Struktur Organisasi</h2>
                </div>

                @if ($informasi && $informasi->file)
                    <div class="relative group">
                        <div class="absolute -inset-4 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-[3rem] opacity-0 group-hover:opacity-10 blur-2xl transition-opacity duration-500"></div>
                        <div class="relative bg-white rounded-[2.5rem] p-4 md:p-8 shadow-2xl border border-gray-100 overflow-hidden">
                            <img src="{{ asset('storage/' . $informasi->file) }}" 
                                 alt="Struktur Organisasi {{ $organization->name }}" 
                                 class="w-full h-auto rounded-[1.5rem] shadow-sm group-hover:scale-[1.01] transition-transform duration-700">
                            
                            <!-- Zoom/Download Overlay (Optional) -->
                            <div class="mt-8 flex justify-center">
                                <a href="{{ asset('storage/' . $informasi->file) }}" target="_blank" class="inline-flex items-center gap-2 text-blue-600 font-black text-xs uppercase tracking-widest hover:text-blue-800 transition-colors">
                                    <i class="fas fa-search-plus text-lg"></i> Lihat Gambar Ukuran Penuh
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-50 rounded-[3rem] p-16 md:p-24 text-center border-2 border-dashed border-gray-200">
                        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-8 shadow-sm">
                            <i class="fas fa-sitemap text-gray-300 text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-4">Struktur Belum Tersedia</h3>
                        <p class="text-gray-500 max-w-sm mx-auto leading-relaxed">Saat ini belum ada gambar struktur organisasi yang diunggah untuk unit kerja ini.</p>
                        
                        @if(auth()->check() && (auth()->user()->unit_id == $organization->remote_id))
                        <div class="mt-10">
                            <a href="{{ route('opd.manage-public', $organization->id) }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-blue-100">
                                <i class="fas fa-upload"></i> Unggah Struktur Sekarang
                            </a>
                        </div>
                        @endif
                    </div>
                @endif
            </div>
            
            <!-- Footer Info -->
            <div class="bg-gray-50/50 p-8 border-t border-gray-100 text-center">
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">
                    <i class="fas fa-info-circle mr-2 text-blue-400"></i> Sumber Data: PPID Kabupaten Sinjai - Terakhir Diperbarui: {{ $organization->updated_at->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>
        
        <div class="mt-12 text-center">
            <a href="{{ route('opd.list') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-600 font-black text-xs uppercase tracking-widest transition-colors">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar OPD
            </a>
        </div>
    </div>
</div>
@endsection
