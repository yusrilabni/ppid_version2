@extends('frontend.layouts.app')

@section('title', 'Detail Dokumen - ' . $informasi_pemkab->judul)

@section('meta')
    @php
        $shareImage = asset('storage/logo/Lambang_Kabupaten_Sinjai_OG.jpg');
        $isImage = false;
        if ($informasi_pemkab->file_path) {
            $ext = strtolower(pathinfo($informasi_pemkab->file_path, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) {
                $shareImage = asset('storage/' . $informasi_pemkab->file_path);
                $isImage = true;
            }
        }
    @endphp
    <meta property="og:title" content="{{ $informasi_pemkab->judul }} - PPID Kabupaten Sinjai">
    <meta property="og:description" content="{{ Str::limit(strip_tags($informasi_pemkab->deskripsi ?? 'Detail Dokumen Informasi Pemkab Kabupaten Sinjai'), 160) }}">
    <meta property="og:image" content="{{ $shareImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:title" content="{{ $informasi_pemkab->judul }} - PPID Kabupaten Sinjai">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($informasi_pemkab->deskripsi ?? 'Detail Dokumen Informasi Pemkab Kabupaten Sinjai'), 160) }}">
    <meta name="twitter:image" content="{{ $shareImage }}">
@endsection

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-600 pt-6 md:pt-10 pb-24 overflow-hidden">
    <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-overlay"></div>
    <div class="container max-w-5xl mx-auto px-4 relative z-10">
        <div class="flex flex-wrap items-center justify-start gap-y-2 space-x-2 md:space-x-3 text-blue-200 text-xs md:text-sm mb-6 font-medium w-full text-left">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors flex items-center"><i class="fas fa-home mr-1"></i> Beranda</a>
            <i class="fas fa-chevron-right text-[10px] opacity-50"></i>
            <span class="text-white opacity-80 flex items-center"><i class="fas fa-layer-group mr-1"></i> Transparansi</span>
            <i class="fas fa-chevron-right text-[10px] opacity-50"></i>
            <a href="{{ route('frontend.informasi-pemkab.index') }}" class="hover:text-white transition-colors flex items-center"><i class="fas fa-file-pdf mr-1"></i> Informasi Pemkab</a>
            <i class="fas fa-chevron-right text-[10px] opacity-50"></i>
            <span class="text-white opacity-90 truncate max-w-[150px] sm:max-w-[200px] md:max-w-md flex items-center"><i class="fas fa-eye mr-1"></i> {{ $informasi_pemkab->judul }}</span>
        </div>
        
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white tracking-tight drop-shadow-lg leading-tight max-w-4xl">
            {{ $informasi_pemkab->judul }}
        </h1>
        
        <div class="flex flex-wrap items-center mt-6 gap-3">
            <span class="bg-white/20 backdrop-blur-sm text-white px-4 py-1.5 rounded-full text-sm font-semibold border border-white/30 shadow-sm flex items-center">
                <i class="fas fa-calendar-alt mr-2 opacity-70"></i> {{ \Carbon\Carbon::parse($informasi_pemkab->published_at ?? ($informasi_pemkab->tahun . '-01-01'))->isoFormat('D MMMM Y') }}
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
                    @if($informasi_pemkab->deskripsi)
                    <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i> Deskripsi Dokumen
                        </h2>
                    </div>
                    <div class="p-6 md:p-8">
                        <div class="prose prose-blue max-w-none text-gray-700 leading-relaxed text-lg">
                            <p>{{ $informasi_pemkab->deskripsi }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Preview Dokumen Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-4 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-eye text-blue-500 mr-2"></i> Pratinjau Dokumen
                        </h2>
                        <span class="text-xs bg-blue-100 text-blue-700 font-bold px-3 py-1 rounded-full">
                            <i class="fas fa-chart-line mr-1"></i> {{ number_format($informasi_pemkab->views_count) }} Kali Dilihat
                        </span>
                    </div>
                    <div class="p-0 h-[600px] w-full bg-gray-100">
                        @if ($informasi_pemkab->file_path)
                            @php
                                $filePath = $informasi_pemkab->file_path;
                                $isExternal = str_starts_with($filePath, 'http');
                                $isGoogleDrive = false;
                                $previewUrl = $filePath;
                                
                                if ($isExternal && str_contains($filePath, 'drive.google.com/file/d/')) {
                                    $isGoogleDrive = true;
                                    // Mengubah link view/sharing gdrive menjadi link preview agar bisa di-embed
                                    $previewUrl = preg_replace('/\/view\?.*$/', '/preview', $filePath);
                                }
                            @endphp

                            @if($isGoogleDrive)
                                <iframe src="{{ $previewUrl }}" class="w-full h-full border-0" allow="autoplay"></iframe>
                            @elseif($isExternal)
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 p-8 text-center">
                                    <i class="fas fa-external-link-alt text-6xl text-gray-300 mb-4"></i>
                                    <h3 class="text-xl font-bold text-gray-700 mb-2">Dokumen Berupa Tautan Eksternal</h3>
                                    <p class="text-gray-500 mb-6">Tautan ini mengarah ke sumber eksternal dan tidak dapat dipratinjau langsung di sini.</p>
                                    <a href="{{ route('frontend.informasi-pemkab.download', $informasi_pemkab->slug ?? $informasi_pemkab->id) }}" target="_blank" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-lg shadow hover:bg-blue-700 transition">
                                        Kunjungi Tautan <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            @else
                                @php
                                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['png', 'jpg', 'jpeg', 'webp', 'svg', 'gif']);
                                @endphp
                                @if($isImage)
                                    <div class="w-full h-full flex items-center justify-center p-4 bg-gray-100 overflow-hidden">
                                        <img src="{{ asset('storage/' . $filePath) }}" alt="{{ $informasi_pemkab->judul }}" class="max-w-full max-h-full object-contain rounded-lg shadow-sm">
                                    </div>
                                @else
                                    <iframe src="{{ asset('storage/' . $filePath) }}#toolbar=0" class="w-full h-full border-0"></iframe>
                                @endif
                            @endif
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 flex-col">
                                <i class="fas fa-ban text-4xl mb-3"></i>
                                <p>File tidak tersedia</p>
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
                        
                        <div class="flex-shrink-0 w-full md:w-auto text-center md:text-right">
                            @if ($informasi_pemkab->file_path)
                                @php
                                    $isExternal = str_starts_with($informasi_pemkab->file_path, 'http');
                                    $isGdrive = $isExternal && str_contains($informasi_pemkab->file_path, 'drive.google.com');
                                    $btnColor = ($isExternal && !$isGdrive) ? 'from-blue-600 to-blue-700 shadow-blue-500/30 hover:shadow-blue-600/50' : 'from-green-500 to-emerald-600 shadow-green-500/30 hover:shadow-green-600/50';
                                    $btnIcon = ($isExternal && !$isGdrive) ? 'fa-external-link-alt' : 'fa-cloud-download-alt';
                                    $btnText = ($isExternal && !$isGdrive) ? 'Buka Tautan Eksternal' : 'Unduh File Dokumen';
                                @endphp
                                <a href="{{ route('frontend.informasi-pemkab.download', $informasi_pemkab->slug ?? $informasi_pemkab->id) }}" target="_blank" 
                                   class="w-full md:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r {{ $btnColor }} text-white font-bold rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                    <i class="fas {{ $btnIcon }} mr-2 text-xl"></i> 
                                    {{ $btnText }}
                                </a>
                                <p class="mt-3 text-xs text-gray-500 font-semibold"><i class="fas fa-download mr-1"></i> Telah diunduh/dibuka {{ number_format($informasi_pemkab->downloads_count) }} kali</p>
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
                
                <a href="{{ route('frontend.informasi-pemkab.index') }}" class="w-full flex items-center justify-center px-6 py-3.5 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900 transition-all duration-300 shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Dokumen
                </a>

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
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Di-upload oleh</span>
                                @if($informasi_pemkab->user)
                                <span class="text-sm font-bold text-gray-800 flex items-center mb-2">
                                    <i class="fas fa-user-circle mr-2 text-purple-500 opacity-80"></i> 
                                    @if($informasi_pemkab->user->isSuperAdmin())
                                        Admin Kabupaten ({{ $informasi_pemkab->user->name }})
                                    @else
                                        {{ $informasi_pemkab->user->name }}
                                    @endif
                                </span>
                                @endif
                                <span class="text-sm font-bold text-gray-800 flex items-start">
                                    <i class="fas fa-building mt-1 mr-2 text-emerald-500 opacity-80"></i> 
                                    {{ $informasi_pemkab->organization ? $informasi_pemkab->organization->name : 'Pemerintah Kabupaten' }}
                                </span>
                            </li>
                            <li class="pt-4 border-t border-gray-100 flex flex-col">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Kategori Utama</span>
                                <span class="text-sm font-semibold text-indigo-700 bg-indigo-50 border border-indigo-100 px-3 py-1.5 rounded-lg inline-block w-fit">
                                    <i class="fas fa-folder-open mr-1"></i> {{ $informasi_pemkab->kategori }}
                                </span>
                            </li>
                            <li class="pt-4 border-t border-gray-100 flex flex-col">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Jenis Dokumen</span>
                                <span class="text-sm font-semibold text-gray-700 bg-gray-100 px-3 py-1.5 rounded-lg inline-block w-fit">
                                    {{ $informasi_pemkab->jenis_dokumen }}
                                </span>
                            </li>
                            @if($informasi_pemkab->informasi)
                            <li class="pt-4 border-t border-gray-100 flex flex-col">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Klasifikasi PPID</span>
                                <span class="text-sm font-semibold text-blue-700 bg-blue-50 border border-blue-100 px-3 py-1.5 rounded-lg inline-block w-fit">
                                    <i class="fas fa-tag mr-1"></i> {{ $informasi_pemkab->informasi->category }}
                                </span>
                            </li>
                            @endif
                            <li class="pt-4 border-t border-gray-100 flex flex-col">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Sifat Akses</span>
                                @if($informasi_pemkab->visibility == 'public')
                                    <span class="text-sm font-bold text-green-600 flex items-center">
                                        <i class="fas fa-globe mr-1.5"></i> Publik
                                    </span>
                                @else
                                    <span class="text-sm font-bold text-orange-500 flex items-center">
                                        <i class="fas fa-lock mr-1.5"></i> Private (Link Terbatas)
                                    </span>
                                @endif
                            </li>
                            <li class="pt-4 border-t border-gray-100 flex flex-col">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tanggal Dokumen</span>
                                <span class="text-sm font-semibold text-gray-700 flex items-center">
                                    <i class="fas fa-calendar mr-1.5 text-blue-400"></i> {{ \Carbon\Carbon::parse($informasi_pemkab->published_at ?? ($informasi_pemkab->tahun . '-01-01'))->isoFormat('D MMMM Y') }}
                                </span>
                            </li>
                            <li class="pt-4 border-t border-gray-100 flex flex-col">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tanggal Dokumen</span>
                                <span class="text-sm font-semibold text-gray-700 flex items-center">
                                    <i class="fas fa-calendar-alt mr-1.5 text-blue-400"></i> {{ \Carbon\Carbon::parse($informasi_pemkab->published_at ?? ($informasi_pemkab->tahun . '-01-01'))->translatedFormat('d F Y') }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
