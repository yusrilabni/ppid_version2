@extends('frontend.layouts.app')

@section('title', 'Profil PPID')

@section('meta')
    <meta property="og:title" content="Profil PPID Kabupaten Sinjai">
    <meta property="og:description" content="Profil Pejabat Pengelola Informasi dan Dokumentasi (PPID) Kabupaten Sinjai. Melayani permintaan informasi publik dengan transparan.">
    <meta name="twitter:title" content="Profil PPID Kabupaten Sinjai">
    <meta name="twitter:description" content="Profil Pejabat Pengelola Informasi dan Dokumentasi (PPID) Kabupaten Sinjai. Melayani permintaan informasi publik dengan transparan.">
@endsection

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs Aligned with Content -->
            <div class="mb-4">
                <x-breadcrumbs :breadcrumbs="[
                    ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                    ['title' => 'Profil PPID', 'url' => '#', 'icon' => 'fas fa-info-circle'],
                ]" />
            </div>

            @if ($profilPpid)
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
                    <!-- Hero Section / Title & Status -->
                    <div class="relative bg-gradient-to-r from-indigo-600 via-blue-500 to-indigo-700 text-white p-8 md:p-12">
                        <div class="absolute inset-0 opacity-10">
                            <div
                                class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full -translate-x-1/2 -translate-y-1/2">
                            </div>
                            <div
                                class="absolute bottom-0 right-0 w-96 h-96 bg-blue-300 rounded-full translate-x-1/2 translate-y-1/2">
                            </div>
                        </div>
                        <div class="relative z-10">
                            <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-3">
                                Profil PPID
                            </h1>
                            <p class="text-xl md:text-2xl font-light opacity-90 max-w-2xl">
                                Pejabat Pengelola Informasi dan Dokumentasi
                            </p>
                        </div>
                    </div>

                    <!-- Visi Section -->
                    <div class="p-8 md:p-12">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-14 h-14 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                                <i class="fas fa-eye text-2xl text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold text-gray-800">Visi</h2>
                                <div class="w-16 h-1 bg-gradient-to-r from-indigo-500 to-blue-500 mt-2"></div>
                            </div>
                        </div>
                        <div class="ml-18">
                            <p
                                class="text-gray-700 leading-relaxed text-lg bg-blue-50 p-6 rounded-xl border-l-4 border-blue-500">
                                {{ $profilPpid->vision }}
                            </p>
                        </div>
                    </div>

                    <!-- Misi Section -->
                    @if ($profilPpid->mission && is_array($profilPpid->mission) && count($profilPpid->mission) > 0)
                        <div class="p-8 md:p-12 border-t border-gray-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-14 h-14 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class="fas fa-bullseye text-2xl text-white"></i>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-gray-800">Misi</h2>
                                    <div class="w-16 h-1 bg-gradient-to-r from-green-500 to-emerald-500 mt-2"></div>
                                </div>
                            </div>
                            <div class="ml-18">
                                <ul class="space-y-4">
                                    @foreach ($profilPpid->mission as $index => $mission)
                                        <li class="flex items-start p-4 bg-green-50 rounded-xl border-l-4 border-green-500">
                                            <div class="flex-shrink-0 mr-4">
                                                <div
                                                    class="w-10 h-10 bg-gradient-to-r from-green-400 to-emerald-400 rounded-full flex items-center justify-center shadow-md">
                                                    <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                                                </div>
                                            </div>
                                            <span class="text-gray-700 text-lg pt-1">{{ $mission }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Struktur Organisasi Section -->
                    <div class="p-8 md:p-12 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-indigo-50">
                        <div class="text-center mb-8">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl shadow-lg mb-4">
                                <i class="fas fa-sitemap text-2xl text-white"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-3">Struktur Organisasi PPID</h2>
                            <p class="text-gray-600 max-w-2xl mx-auto">Diagram organisasi Pejabat Pengelola Informasi dan
                                Dokumentasi</p>
                        </div>
                        @if ($profilPpid->structure_image)
                            <div class="flex justify-center">
                                <div class="relative group">
                                    <div
                                        class="absolute -inset-4 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-3xl blur opacity-30 group-hover:opacity-50 transition-opacity duration-500">
                                    </div>
                                    <img class="relative max-w-full h-auto rounded-xl shadow-2xl border-4 border-white transform transition-transform group-hover:scale-[1.02]"
                                        src="{{ asset('storage/' . $profilPpid->structure_image) }}"
                                        alt="Struktur Organisasi PPID">
                                </div>
                            </div>
                        @else
                            <div class="max-w-4xl mx-auto">
                                <div
                                    class="bg-gradient-to-r from-blue-100 to-indigo-100 rounded-2xl p-8 border-2 border-dashed border-blue-300">
                                    <div class="text-center py-8">
                                        <div
                                            class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full mb-6 shadow-lg">
                                            <i class="fas fa-project-diagram text-3xl text-white"></i>
                                        </div>
                                        <h3 class="text-2xl font-bold text-gray-700 mb-3">Struktur Organisasi</h3>
                                        <p class="text-gray-600 mb-6">Gambar struktur organisasi akan segera diunggah</p>
                                        <div
                                            class="inline-flex items-center px-4 py-2 bg-white/80 backdrop-blur-sm rounded-lg text-gray-700">
                                            <i class="fas fa-clock mr-2"></i>
                                            <span>Sedang dalam proses penyiapan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Hubungi Kami Section -->
                    <div class="p-8 md:p-12 border-t border-gray-200 bg-gradient-to-b from-white to-gray-50">
                        <!-- Header -->
                        <div class="mb-8 text-center">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-amber-500 to-orange-500 rounded-2xl shadow-lg mb-4">
                                <i class="fas fa-address-book text-2xl text-white"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-3">Hubungi Kami</h2>
                            <p class="text-gray-600">Terhubung dengan PPID untuk informasi lebih lanjut</p>
                        </div>

                        <!-- Container dengan flex untuk membuat kedua kolom memiliki tinggi yang sama -->
                        <div class="flex flex-col lg:flex-row gap-8">
                            <!-- Kolom 1: Detail Kontak -->
                            <div class="lg:w-1/2 bg-white rounded-xl shadow-lg p-6 border border-gray-200 flex flex-col">
                                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                    <i class="fas fa-info-circle text-blue-500 mr-3"></i> Detail Kontak
                                </h3>

                                <div class="space-y-6 flex-grow">
                                    <!-- Alamat -->
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mr-4 mt-1">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-map-marker-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800 mb-1">Alamat</h4>
                                            <p class="text-gray-700">{{ $profilPpid->address }}</p>
                                        </div>
                                    </div>

                                    <!-- Telepon -->
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mr-4 mt-1">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-r from-green-400 to-emerald-400 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-phone text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800 mb-1">Telepon</h4>
                                            <p class="text-gray-700 font-medium">{{ $profilPpid->phone }}</p>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mr-4 mt-1">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-r from-purple-400 to-pink-400 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-envelope text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800 mb-1">Email</h4>
                                            <a href="mailto:{{ $profilPpid->email }}"
                                                class="text-blue-600 hover:text-blue-800 font-medium">
                                                {{ $profilPpid->email }}
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Jam Operasional (contoh tambahan konten) -->
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mr-4 mt-1">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-r from-amber-400 to-orange-400 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-clock text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800 mb-1">Jam Operasional</h4>
                                            <p class="text-gray-700">Senin - Jumat: 08:00 - 16:00 WITA</p>
                                            <p class="text-gray-500 text-sm mt-1">Sabtu - Minggu: Tutup</p>
                                        </div>
                                    </div>

                                    <!-- Media Sosial -->
                                    @if($profilPpid->instagram || $profilPpid->facebook || $profilPpid->twitter || $profilPpid->tiktok || $profilPpid->youtube || $profilPpid->website)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mr-4 mt-1">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-r from-indigo-400 to-blue-400 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-share-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800 mb-2">Media Sosial & Website</h4>
                                            <div class="flex flex-wrap gap-3 mt-1">
                                                @if($profilPpid->instagram)
                                                    <a href="{{ $profilPpid->instagram }}" target="_blank" class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] flex items-center justify-center text-white shadow-md hover:scale-110 transition-transform" title="Instagram">
                                                        <i class="fab fa-instagram text-xl"></i>
                                                    </a>
                                                @endif
                                                @if($profilPpid->facebook)
                                                    <a href="{{ $profilPpid->facebook }}" target="_blank" class="w-10 h-10 rounded-full bg-[#1877F2] flex items-center justify-center text-white shadow-md hover:scale-110 transition-transform" title="Facebook">
                                                        <i class="fab fa-facebook-f text-xl"></i>
                                                    </a>
                                                @endif
                                                @if($profilPpid->twitter)
                                                    <a href="{{ $profilPpid->twitter }}" target="_blank" class="w-10 h-10 rounded-full bg-[#1DA1F2] flex items-center justify-center text-white shadow-md hover:scale-110 transition-transform" title="Twitter">
                                                        <i class="fab fa-twitter text-xl"></i>
                                                    </a>
                                                @endif
                                                @if($profilPpid->tiktok)
                                                    <a href="{{ $profilPpid->tiktok }}" target="_blank" class="w-10 h-10 rounded-full bg-black flex items-center justify-center text-white shadow-md hover:scale-110 transition-transform" title="TikTok">
                                                        <i class="fab fa-tiktok text-xl"></i>
                                                    </a>
                                                @endif
                                                @if($profilPpid->youtube)
                                                    <a href="{{ $profilPpid->youtube }}" target="_blank" class="w-10 h-10 rounded-full bg-[#FF0000] flex items-center justify-center text-white shadow-md hover:scale-110 transition-transform" title="YouTube">
                                                        <i class="fab fa-youtube text-xl"></i>
                                                    </a>
                                                @endif
                                                @if($profilPpid->website)
                                                    <a href="{{ $profilPpid->website }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white shadow-md hover:scale-110 transition-transform" title="Website Pemda">
                                                        <i class="fas fa-globe text-xl"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Kolom 2: Lokasi Maps -->
                            <div class="lg:w-1/2 flex flex-col">
                                <div
                                    class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 flex-grow flex flex-col">
                                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                        <i class="fas fa-map-marked-alt text-amber-500 mr-3"></i> Lokasi
                                    </h3>

                                    @if ($profilPpid->maps_url)
                                        <!-- Container maps yang menyesuaikan tinggi -->
                                        <div class="flex-grow relative overflow-hidden rounded-lg border border-gray-300">
                                            <iframe src="{{ $profilPpid->maps_url }}"
                                                class="absolute top-0 left-0 w-full h-full" style="border:0;"
                                                allowfullscreen="" loading="lazy"
                                                referrerpolicy="no-referrer-when-downgrade">
                                            </iframe>
                                        </div>
                                        <div class="mt-4 flex items-center justify-between">
                                            <div class="text-gray-600 text-sm">
                                                <i class="fab fa-google mr-2"></i>
                                                Google Maps
                                            </div>
                                            <a href="{{ $profilPpid->maps_url }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Buka peta lengkap
                                            </a>
                                        </div>
                                    @else
                                        <!-- Placeholder yang menyesuaikan tinggi -->
                                        <div
                                            class="flex-grow bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg p-8 border-2 border-dashed border-amber-300 flex items-center justify-center">
                                            <div class="text-center">
                                                <div
                                                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-amber-400 to-orange-400 rounded-full mb-4 shadow-md">
                                                    <i class="fas fa-map-marker-alt text-2xl text-white"></i>
                                                </div>
                                                <h4 class="text-lg font-bold text-gray-700 mb-2">Lokasi Kantor</h4>
                                                <p class="text-gray-600 mb-4">Koordinat lokasi akan segera ditambahkan</p>
                                                <div class="bg-white p-3 rounded-lg border border-amber-200">
                                                    <p class="text-gray-700 text-sm">{{ $profilPpid->address }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div
                    class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-xl p-12 text-center border-2 border-dashed border-blue-200">
                    <div
                        class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-r from-gray-300 to-blue-300 rounded-full mb-8 shadow-lg">
                        <i class="fas fa-exclamation-circle text-4xl text-white"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Profil PPID Tidak Ditemukan</h2>
                    <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">
                        Tidak ada profil PPID aktif yang dapat ditampilkan saat ini.
                    </p>
                    <div
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-semibold rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-home mr-3"></i>
                        Kembali ke Beranda
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
