@extends('frontend.layouts.app')

@section('title', 'Detail Permohonan Informasi')

@section('content')
<div class="container mx-auto py-4 md:py-8 px-2 sm:px-4">
    <div class="max-w-6xl mx-auto">
        <div class="mb-4">
            <x-breadcrumbs :breadcrumbs="[
                ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                ['title' => 'Permohonan Saya', 'url' => route('laporan.permohonan.saya'), 'icon' => 'fas fa-file-alt'],
                ['title' => 'Detail', 'url' => '#', 'icon' => 'fas fa-info-circle']
            ]" />
        </div>

        <div class="text-center mb-6 md:mb-10 mt-4">
            <div
                class="inline-flex items-center justify-center w-24 h-24 md:w-36 md:h-36 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-4 md:mb-6 shadow-lg overflow-hidden">
                <img src="{{ asset('storage/logo/ppid.webp') }}" alt="Logo PPID" class="w-20 h-20 md:w-32 md:h-32 object-contain">
            </div>
            <h1 class="text-2xl md:text-4xl font-extrabold text-gray-800 mb-2 px-2">{{ __('Detail Permohonan') }}</h1>
            <p class="text-sm md:text-base text-gray-600 max-w-2xl mx-auto px-4 leading-relaxed">
                {{ __('Rincian lengkap permohonan informasi Anda, status, dan riwayat tanggapan.') }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-gray-100 mx-1 sm:mx-0">
            <!-- Header dengan warna biru -->
            <div class="px-4 py-5 md:px-6 md:py-4 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 border-b border-blue-500">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <h2 class="text-lg md:text-xl font-bold text-white flex items-center">
                        <div class="bg-white/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        #{{ $permohonan->unique_code }}
                    </h2>
                    <div class="grid grid-cols-2 sm:flex sm:flex-row items-center gap-2 w-full lg:w-auto">
                        <a href="{{ route('laporan.permohonan.pdf', ['permohonanInformasi' => $permohonan, 'action' => 'preview']) }}"
                           target="_blank"
                           class="flex items-center justify-center px-3 py-2 text-xs md:text-sm font-semibold rounded-lg bg-blue-500/30 text-white hover:bg-blue-500/50 border border-white/30 backdrop-blur-sm transition-all">
                            <i class="fas fa-eye mr-1.5 md:mr-2"></i>
                            Preview
                        </a>
                        <a href="{{ route('laporan.permohonan.pdf', $permohonan) }}"
                           target="_blank"
                           class="flex items-center justify-center px-3 py-2 text-xs md:text-sm font-semibold rounded-lg bg-emerald-500 text-white hover:bg-emerald-600 shadow-md transition-all">
                            <i class="fas fa-file-pdf mr-1.5 md:mr-2"></i>
                            PDF
                        </a>
                        <a href="{{ route('laporan.permohonan.saya') }}"
                           class="col-span-2 flex items-center justify-center px-3 py-2 text-xs md:text-sm font-semibold rounded-lg bg-white text-blue-700 hover:bg-blue-50 shadow-md transition-all">
                            <i class="fas fa-arrow-left mr-1.5 md:mr-2"></i>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4 md:p-8">
                <!-- Status Badges -->
                <div class="mb-8 flex flex-wrap gap-2 md:gap-4">
                    <!-- Status Permohonan -->
                    @php
                        $statusColors = [
                            'selesai' => 'bg-green-100 text-green-800 border-green-200',
                            'diproses' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'pending' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'ditolak' => 'bg-red-100 text-red-800 border-red-200'
                        ];
                        $statusColor = $statusColors[$permohonan->status_permohonan] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                    @endphp
                    <span class="px-4 py-2 inline-flex items-center text-sm font-medium rounded-full border {{ $statusColor }}">
                        @if($permohonan->status_permohonan == 'selesai')
                            <i class="fas fa-check-circle mr-2"></i>
                        @elseif($permohonan->status_permohonan == 'diproses')
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                        @elseif($permohonan->status_permohonan == 'pending')
                            <i class="fas fa-clock mr-2"></i>
                        @elseif($permohonan->status_permohonan == 'ditolak')
                            <i class="fas fa-times-circle mr-2"></i>
                        @endif
                        {{ ucfirst($permohonan->status_permohonan) }}
                    </span>

                    <!-- Privacy Status -->
                    @php
                        $privacyColors = [
                            'Publik' => 'bg-sky-100 text-sky-800 border-sky-200',
                            'Anonim' => 'bg-slate-100 text-slate-800 border-slate-200',
                            'Rahasia' => 'bg-red-100 text-red-800 border-red-200',
                        ];
                        $privacyColor = $privacyColors[$permohonan->privacy_status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                        
                        $privacyIcons = [
                            'Publik' => 'fas fa-globe-asia',
                            'Anonim' => 'fas fa-user-secret',
                            'Rahasia' => 'fas fa-lock',
                        ];
                        $privacyIcon = $privacyIcons[$permohonan->privacy_status] ?? 'fas fa-shield-alt';
                    @endphp
                    <span class="px-4 py-2 inline-flex items-center text-sm font-medium rounded-full border {{ $privacyColor }}">
                        <i class="{{ $privacyIcon }} mr-2"></i>
                        {{ $permohonan->privacy_status }}
                    </span>
                </div>

                <!-- Informasi Pemohon -->
                <div class="mb-10">
                    <h3 class="text-base md:text-lg font-bold text-gray-900 mb-5 pb-2 border-b-2 border-blue-100 flex items-center">
                        <span class="bg-blue-500 text-white p-1.5 rounded-lg mr-3 shadow-sm">
                            <i class="fas fa-user-circle"></i>
                        </span>
                        Informasi Pemohon
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                        <!-- Kolom Kiri -->
                        <div class="space-y-5">
                            <div class="bg-gray-50/50 p-3 rounded-xl border border-gray-100 transition-all hover:bg-white hover:shadow-md">
                                <label class="block text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">
                                    Nama Pemohon
                                </label>
                                <div class="text-gray-900 font-semibold text-base">
                                    @if ($permohonan->privacy_status == 'Anonim' && !$isOwner)
                                        <span class="text-gray-500 flex items-center">
                                            <i class="fas fa-user-secret mr-2 text-gray-400"></i>
                                            {{ substr($permohonan->nama_pemohon, 0, 1) . '*****' }}
                                        </span>
                                    @else
                                        {{ $permohonan->nama_pemohon }}
                                    @endif
                                </div>
                            </div>
                            
                            <div class="bg-gray-50/50 p-3 rounded-xl border border-gray-100 transition-all hover:bg-white hover:shadow-md">
                                <label class="block text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">
                                    Pekerjaan
                                </label>
                                <div class="text-gray-900 font-medium">{{ $permohonan->pekerjaan ?? '-' }}</div>
                            </div>
                            
                            <div class="bg-gray-50/50 p-3 rounded-xl border border-gray-100 transition-all hover:bg-white hover:shadow-md">
                                <label class="block text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">
                                    Nomor Telepon
                                </label>
                                <div class="text-gray-900 font-medium">
                                    @if ($permohonan->privacy_status == 'Anonim' && !$isOwner)
                                        <span class="text-gray-500">
                                            {{ substr($permohonan->nomor_telepon_pemohon, 0, 3) . '*****' }}
                                        </span>
                                    @else
                                        {{ $permohonan->nomor_telepon_pemohon ?? '-' }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan -->
                        <div class="space-y-5">
                            <div class="bg-gray-50/50 p-3 rounded-xl border border-gray-100 transition-all hover:bg-white hover:shadow-md">
                                <label class="block text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">
                                    Alamat
                                </label>
                                <div class="text-gray-900 font-medium text-sm leading-relaxed">{{ $permohonan->alamat_pemohon }}</div>
                            </div>
                            
                            <div class="bg-gray-50/50 p-3 rounded-xl border border-gray-100 transition-all hover:bg-white hover:shadow-md">
                                <label class="block text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">
                                    Email
                                </label>
                                <div class="text-gray-900 font-medium">
                                    @if ($permohonan->privacy_status == 'Anonim' && !$isOwner)
                                        <span class="text-gray-500">
                                            {{ substr($permohonan->email_pemohon, 0, 3) . '*****' }}
                                        </span>
                                    @else
                                        <span class="break-all">{{ $permohonan->email_pemohon ?? '-' }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="bg-gray-50/50 p-3 rounded-xl border border-gray-100 transition-all hover:bg-white hover:shadow-md">
                                <label class="block text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">
                                    Petugas Penerima
                                </label>
                                <div class="text-gray-900 font-bold">
                                    @php
                                        $lastResponder = $permohonan->responses->whereNotNull('user_id')->last();
                                    @endphp
                                    @if($lastResponder && $lastResponder->user)
                                        {{ $lastResponder->user->name }}
                                    @else
                                        <span class="text-gray-400 italic">Belum ada tanggapan</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Permohonan -->
                <div class="space-y-8">
                    <!-- Informasi yang Dimohon -->
                    <div class="group">
                        <h3 class="text-base md:text-lg font-bold text-gray-900 mb-3 flex items-center">
                            <span class="bg-indigo-500 text-white p-1.5 rounded-lg mr-3 shadow-sm group-hover:scale-110 transition-transform">
                                <i class="fas fa-search"></i>
                            </span>
                            Informasi yang Dimohon
                        </h3>
                        <div class="bg-gradient-to-br from-blue-50 to-white p-4 md:p-5 rounded-2xl border border-blue-100 shadow-sm leading-relaxed text-gray-800 text-base md:text-lg italic font-medium">
                            "{{ $permohonan->detail_informasi }}"
                        </div>
                    </div>

                    <!-- Tujuan Penggunaan -->
                    <div class="group">
                        <h3 class="text-base md:text-lg font-bold text-gray-900 mb-3 flex items-center">
                            <span class="bg-emerald-500 text-white p-1.5 rounded-lg mr-3 shadow-sm group-hover:scale-110 transition-transform">
                                <i class="fas fa-bullseye"></i>
                            </span>
                            Tujuan Penggunaan
                        </h3>
                        <div class="bg-emerald-50/30 p-4 md:p-5 rounded-2xl border border-emerald-100 shadow-sm leading-relaxed text-gray-700">
                            {{ $permohonan->tujuan_penggunaan_informasi }}
                        </div>
                    </div>

                    <!-- Cara Memperoleh dan Mendapatkan Salinan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                        <div class="group">
                            <h3 class="text-sm md:text-base font-bold text-gray-900 mb-3 flex items-center">
                                <span class="bg-orange-500 text-white p-1.5 rounded-lg mr-2 shadow-sm">
                                    <i class="fas fa-download"></i>
                                </span>
                                Cara Memperoleh
                            </h3>
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-200">
                                @php
                                    $caraMemperoleh = json_decode($permohonan->cara_memperoleh_informasi, true);
                                @endphp
                                @if (!empty($caraMemperoleh))
                                    <ul class="space-y-2">
                                        @foreach ($caraMemperoleh as $cara)
                                            <li class="flex items-center text-sm md:text-base text-gray-700 font-medium">
                                                <div class="bg-green-100 p-1 rounded-full mr-2">
                                                    <i class="fas fa-check text-green-600 text-[10px]"></i>
                                                </div>
                                                {{ $cara }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-400 italic text-sm">-</p>
                                @endif
                            </div>
                        </div>

                        <div class="group">
                            <h3 class="text-sm md:text-base font-bold text-gray-900 mb-3 flex items-center">
                                <span class="bg-purple-500 text-white p-1.5 rounded-lg mr-2 shadow-sm">
                                    <i class="fas fa-copy"></i>
                                </span>
                                Cara Salinan
                            </h3>
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-200">
                                @php
                                    $caraSalinan = json_decode($permohonan->cara_mendapatkan_salinan, true);
                                @endphp
                                @if (!empty($caraSalinan))
                                    <ul class="space-y-2">
                                        @foreach ($caraSalinan as $cara)
                                            <li class="flex items-center text-sm md:text-base text-gray-700 font-medium">
                                                <div class="bg-green-100 p-1 rounded-full mr-2">
                                                    <i class="fas fa-check text-green-600 text-[10px]"></i>
                                                </div>
                                                {{ $cara }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-400 italic text-sm">-</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tempat Mendapatkan Salinan -->
                    @if($permohonan->tempat_mendapatkan_salinan)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">
                            <i class="fas fa-map-pin mr-2 text-blue-500"></i>
                            Tempat Mendapatkan Salinan
                        </h3>
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            @php
                                $unitName = $permohonan->tempat_mendapatkan_salinan;
                                if (isset($units) && !empty($units)) {
                                    $unitsMap = collect($units)->keyBy('unit_id');
                                    $unitCode = $permohonan->tempat_mendapatkan_salinan;
                                    if ($unitsMap->has($unitCode)) {
                                        $unitName = $unitsMap->get($unitCode)['unit_nama'];
                                    }
                                }
                            @endphp
                            <p class="text-gray-800">{{ $unitName }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Riwayat Tanggapan -->
                @if ($permohonan->responses->count() > 0)
                <div class="mt-12">
                    <h3 class="text-base md:text-lg font-bold text-gray-900 mb-6 pb-2 border-b-2 border-blue-100 flex items-center">
                        <span class="bg-blue-500 text-white p-1.5 rounded-lg mr-3 shadow-sm">
                            <i class="fas fa-comments"></i>
                        </span>
                        Riwayat Tanggapan
                    </h3>
                    
                    <div class="space-y-6">
                        @foreach ($permohonan->responses as $response)
                        <div class="relative pl-2 md:pl-0">
                            <!-- Vertical Line Connection -->
                            @if(!$loop->last)
                            <div class="absolute left-6 md:left-7 top-10 bottom-0 w-0.5 bg-blue-100"></div>
                            @endif

                            <div class="flex items-start gap-3 md:gap-4">
                                <div class="flex-shrink-0 z-10">
                                    <div class="h-10 w-10 md:h-14 md:w-14 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 border-2 border-white shadow-md flex items-center justify-center text-blue-600">
                                        <i class="fas fa-user-tie text-lg md:text-2xl"></i>
                                    </div>
                                </div>
                                
                                <div class="flex-1">
                                    <div class="bg-white p-4 md:p-5 rounded-2xl rounded-tl-none border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-3 gap-1">
                                            <p class="font-bold text-gray-900 text-sm md:text-base">{{ $response->user->name ?? 'Petugas PPID' }}</p>
                                            <p class="text-[10px] md:text-xs font-medium text-gray-400 flex items-center italic">
                                                <i class="far fa-clock mr-1"></i>
                                                {{ $response->created_at->translatedFormat('d M Y, H:i') }}
                                            </p>
                                        </div>
                                        
                                        <div class="text-gray-700 text-sm md:text-base leading-relaxed mb-4 whitespace-pre-line">{!! nl2br(e($response->message)) !!}</div>
                                        
                                        @if ($response->file_path || $response->link)
                                        <div class="pt-4 border-t border-gray-50 space-y-3">
                                            @if ($response->file_path)
                                                @php
                                                    $iconClass = getFileIcon($response->file_path);
                                                    $fileExtension = pathinfo($response->file_path, PATHINFO_EXTENSION);
                                                    $fileName = \Illuminate\Support\Str::limit($permohonan->detail_informasi, 30);
                                                @endphp
                                                <div class="inline-block w-full">
                                                    <a href="{{ \App\Helpers\StorageHelper::getUrl($response->file_path) }}" 
                                                       target="_blank"
                                                       class="group flex items-center p-2 rounded-xl bg-blue-50 border border-blue-100 hover:bg-blue-600 hover:border-blue-600 transition-all duration-300">
                                                        <div class="h-10 w-10 rounded-lg bg-white flex items-center justify-center text-blue-600 shadow-sm group-hover:scale-90 transition-transform">
                                                            <i class="{{ $iconClass }} text-lg"></i>
                                                        </div>
                                                        <div class="ml-3 flex-1 overflow-hidden">
                                                            <p class="text-xs font-bold text-blue-800 group-hover:text-white truncate uppercase tracking-tighter">Unduh Lampiran</p>
                                                            <p class="text-[10px] text-blue-500 group-hover:text-blue-100 truncate italic">Klik untuk membuka file .{{ $fileExtension }}</p>
                                                        </div>
                                                        <i class="fas fa-external-link-alt text-xs text-blue-300 ml-2 mr-1 group-hover:text-white"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            
                                            @if ($response->link)
                                            <a href="{{ $response->link }}" target="_blank"
                                               class="flex items-center text-xs md:text-sm text-indigo-600 hover:text-indigo-800 font-medium break-all">
                                                <i class="fas fa-link mr-2"></i>
                                                {{ $response->link }}
                                            </a>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Form Tanggapan Pemohon -->
                @if (auth()->check() && auth()->id() == $permohonan->user_id && $permohonan->status_permohonan == 'diproses')
                <div class="mt-12 bg-gradient-to-br from-gray-50 to-blue-50/30 p-5 md:p-8 rounded-3xl border border-blue-100 shadow-inner">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-600 text-white p-2.5 rounded-xl shadow-lg shadow-blue-200 mr-4">
                            <i class="fas fa-reply-all"></i>
                        </div>
                        <div>
                            <h3 class="text-lg md:text-xl font-black text-gray-800 tracking-tight">Kirim Tanggapan</h3>
                            <p class="text-xs md:text-sm text-gray-500">Berikan pertanyaan atau konfirmasi lanjutan</p>
                        </div>
                    </div>

                    <form action="{{ route('laporan.permohonan.respond', $permohonan) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <textarea id="message" name="message" rows="4" required
                                      class="w-full px-5 py-4 border-2 border-blue-100 rounded-2xl shadow-sm focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 bg-white transition-all text-sm md:text-base"
                                      placeholder="Tulis pesan Anda secara detail di sini..."></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-200 transition-all hover:-translate-y-1 focus:ring-4 focus:ring-blue-500/20">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Tanggapan
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Form Penilaian -->
                @if (auth()->check() && auth()->id() == $permohonan->user_id && $permohonan->responses->isNotEmpty())
                <div class="mt-12">
                    <h3 class="text-base md:text-lg font-bold text-gray-900 mb-6 pb-2 border-b-2 border-blue-100 flex items-center">
                        <span class="bg-yellow-500 text-white p-1.5 rounded-lg mr-3 shadow-sm">
                            <i class="fas fa-star"></i>
                        </span>
                        {{ is_null($permohonan->rating) ? 'Beri Penilaian' : 'Ubah Penilaian Anda' }}
                    </h3>

                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50/30 p-5 md:p-8 rounded-3xl border border-blue-100 shadow-inner">
                        @if(is_null($permohonan->rating))
                        <div class="mb-8 bg-white/80 backdrop-blur-sm p-4 md:p-5 rounded-2xl border-l-4 border-blue-500 shadow-sm">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-blue-500 mt-1 mr-3 text-lg"></i>
                                <p class="text-xs md:text-sm text-gray-700 leading-relaxed font-medium">
                                    **Layanan informasi telah tersedia.** Mohon berikan tanggapan penutup dan penilaian untuk menutup laporan ini secara resmi.
                                </p>
                            </div>
                        </div>
                        @endif

                        <form action="{{ route('laporan.permohonan.rate', $permohonan) }}" method="POST" onsubmit="{{ is_null($permohonan->rating) ? "return confirm('Kirim tanggapan dan penilaian sekarang?');" : "" }}">
                            @csrf

                            @if(is_null($permohonan->rating))
                            <div class="mb-8">
                                <label for="rating_message" class="block text-sm font-black text-gray-700 mb-3 ml-1 uppercase tracking-wider">
                                    Pesan Penutup <span class="text-red-500">*</span>
                                </label>
                                <textarea id="rating_message" name="message" rows="3" required
                                          class="w-full px-5 py-4 border-2 border-blue-100 rounded-2xl shadow-sm focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 bg-white transition-all text-sm md:text-base"
                                          placeholder="Tulis kesan Anda terhadap layanan kami..."></textarea>
                            </div>
                            @endif

                            <div class="mb-8">
                                <label class="block text-sm font-black text-gray-700 mb-4 ml-1 uppercase tracking-wider">
                                    Rating Pelayanan <span class="text-red-500">*</span>
                                </label>
                                <div class="rating flex flex-row-reverse items-center justify-center sm:justify-start gap-1">
                                    @php
                                        $satisfactionLevels = [
                                            1 => 'Tidak Puas',
                                            2 => 'Kurang Puas',
                                            3 => 'Cukup Puas',
                                            4 => 'Puas',
                                            5 => 'Sangat Puas'
                                        ];
                                    @endphp
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden" {{ $permohonan->rating == $i ? 'checked' : '' }} required/>
                                        <label for="star{{ $i }}" title="{{ $satisfactionLevels[$i] }}" class="text-4xl md:text-6xl cursor-pointer text-gray-300 transition-all hover:scale-110 active:scale-95 px-1">★</label>
                                    @endfor
                                </div>

                                <div class="mt-8 p-4 bg-amber-50 border border-amber-100 rounded-2xl flex items-center">
                                    <div class="bg-amber-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-history text-amber-600"></i>
                                    </div>
                                    <span class="text-[10px] md:text-xs font-bold text-amber-800 leading-tight">
                                        Sistem akan menutup otomatis dengan bintang 5 jika tidak ada penilaian dalam 3 hari.
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                        class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-black rounded-2xl hover:from-blue-700 hover:to-indigo-800 shadow-xl shadow-blue-200 transition-all active:scale-95 focus:ring-4 focus:ring-blue-500/20">
                                    <i class="fas fa-check-double mr-2"></i>
                                    {{ is_null($permohonan->rating) ? 'Kirim Tanggapan & Selesaikan' : 'Perbarui Penilaian' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
                </div>
                </div>
                </div>
                </div>

                <style>
                /* Mobile Enhancements */
                @media (max-width: 640px) {
                .breadcrumb-container { overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; }
                .breadcrumb-item { font-size: 0.75rem; }
                }

                /* Rating stars styling */
                .rating input:checked ~ label {
                color: #f59e0b !important;
                text-shadow: 0 0 15px rgba(245, 158, 11, 0.4);
                }
                .rating label:hover,
                .rating label:hover ~ label {
                color: #fbbf24 !important;
                }
                .rating label {
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                }

                .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
                @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
                }
                </style>
                @endsection