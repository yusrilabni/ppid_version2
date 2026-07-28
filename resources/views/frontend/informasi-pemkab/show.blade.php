@extends('frontend.layouts.app')

@section('title', 'Detail Dokumen - ' . $informasi_pemkab->judul)

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-600 pt-20 pb-24 overflow-hidden">
    <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-overlay"></div>
    <div class="container max-w-5xl mx-auto px-4 relative z-10">
        <div class="flex items-center space-x-3 text-blue-200 text-sm mb-6 font-medium">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors"><i class="fas fa-home"></i> Beranda</a>
            <i class="fas fa-chevron-right text-xs opacity-50"></i>
            <a href="{{ route('frontend.informasi-pemkab.index') }}" class="hover:text-white transition-colors">Informasi Pemkab</a>
            <i class="fas fa-chevron-right text-xs opacity-50"></i>
            <span class="text-white opacity-80">Detail Dokumen</span>
        </div>
        
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white tracking-tight drop-shadow-lg leading-tight max-w-4xl">
            {{ $informasi_pemkab->judul }}
        </h1>
        
        <div class="flex flex-wrap items-center mt-6 gap-3">
            <span class="bg-white/20 backdrop-blur-sm text-white px-4 py-1.5 rounded-full text-sm font-semibold border border-white/30 shadow-sm flex items-center">
                <i class="fas fa-calendar-alt mr-2 opacity-70"></i> {{ $informasi_pemkab->tahun }}
            </span>
            <span class="bg-blue-700/50 backdrop-blur-sm text-blue-100 px-4 py-1.5 rounded-full text-sm font-semibold border border-blue-400/30 shadow-sm flex items-center">
                <i class="fas fa-folder-open mr-2 opacity-70"></i> {{ $informasi_pemkab->kategori }}
            </span>
        </div>
    </div>
    
    <!-- Wave Shape Divider -->
    <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-none transform translate-y-1">
        <svg class="relative block w-full h-[50px] md:h-[80px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118,130.83,121.22,201.2,110.53Z" class="fill-gray-50"></path>
        </svg>
    </div>
</div>

<div class="bg-gray-50 pb-20">
    <div class="container max-w-5xl mx-auto px-4 -mt-10 relative z-20">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Kolom Konten Utama -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Deskripsi Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i> Deskripsi Dokumen
                        </h2>
                    </div>
                    <div class="p-6 md:p-8">
                        @if($informasi_pemkab->deskripsi)
                            <div class="prose prose-blue max-w-none text-gray-700 leading-relaxed text-lg">
                                <p>{{ $informasi_pemkab->deskripsi }}</p>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                                <i class="fas fa-align-left text-4xl mb-3 opacity-30"></i>
                                <p class="text-sm font-medium">Tidak ada deskripsi untuk dokumen ini.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Aksi Unduh Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl shadow-md border border-blue-100 overflow-hidden p-6 md:p-8 relative">
                    <div class="absolute right-0 bottom-0 opacity-5">
                        <i class="fas fa-cloud-download-alt text-9xl -mr-6 -mb-6"></i>
                    </div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Akses Dokumen</h3>
                            <p class="text-sm text-gray-600">Klik tombol di samping untuk melihat atau mengunduh dokumen secara lengkap.</p>
                        </div>
                        
                        <div class="flex-shrink-0 w-full md:w-auto">
                            @if ($informasi_pemkab->file_path)
                                @if(str_starts_with($informasi_pemkab->file_path, 'http'))
                                    <a href="{{ $informasi_pemkab->file_path }}" target="_blank" 
                                       class="w-full md:w-auto flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-600/50 transition-all duration-300 transform hover:-translate-y-1">
                                        <i class="fas fa-external-link-alt mr-2"></i> Buka Tautan Eksternal
                                    </a>
                                @else
                                    <a href="{{ asset('storage/' . $informasi_pemkab->file_path) }}" target="_blank" 
                                       class="w-full md:w-auto flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-green-500/30 hover:shadow-green-600/50 transition-all duration-300 transform hover:-translate-y-1">
                                        <i class="fas fa-cloud-download-alt mr-2 text-xl"></i> Unduh File Dokumen
                                    </a>
                                @endif
                            @else
                                <span class="flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-500 font-bold rounded-xl cursor-not-allowed">
                                    <i class="fas fa-ban mr-2"></i> File Tidak Tersedia
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Metadata Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Detail Info Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-4">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-list-ul text-blue-500 mr-2"></i> Metadata
                        </h2>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-4">
                            <li class="flex flex-col">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Dinas / Instansi</span>
                                <span class="text-sm font-bold text-gray-800 flex items-start">
                                    <i class="fas fa-building mt-1 mr-2 text-blue-500 opacity-80"></i> 
                                    {{ $informasi_pemkab->organization ? $informasi_pemkab->organization->name : 'Pemerintah Kabupaten' }}
                                </span>
                            </li>
                            <li class="pt-4 border-t border-gray-100 flex flex-col">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Jenis Dokumen</span>
                                <span class="text-sm font-semibold text-gray-700 bg-gray-100 px-3 py-1.5 rounded-lg inline-block w-fit">
                                    {{ $informasi_pemkab->jenis_dokumen }}
                                </span>
                            </li>
                            <li class="pt-4 border-t border-gray-100 flex flex-col">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Status Publikasi</span>
                                <span class="text-sm font-bold text-green-600 flex items-center">
                                    <i class="fas fa-check-circle mr-1.5"></i> Telah Dipublikasikan
                                </span>
                            </li>
                            <li class="pt-4 border-t border-gray-100 flex flex-col">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tanggal Rilis</span>
                                <span class="text-sm font-semibold text-gray-700">
                                    {{ $informasi_pemkab->published_at ? \Carbon\Carbon::parse($informasi_pemkab->published_at)->translatedFormat('d F Y') : \Carbon\Carbon::parse($informasi_pemkab->created_at)->translatedFormat('d F Y') }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <a href="{{ route('frontend.informasi-pemkab.index') }}" class="w-full flex items-center justify-center px-6 py-3.5 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900 transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Dokumen
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
