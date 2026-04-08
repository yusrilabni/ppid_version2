@extends('frontend.layouts.app')

@section('title', 'Detail Permohonan Informasi')

@section('content')
<div class="container mx-auto my-8 px-4">
    <div class="max-w-6xl mx-auto">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Permohonan Saya', 'url' => route('laporan.permohonan.saya'), 'icon' => 'fas fa-file-alt'],
            ['title' => 'Detail Permohonan Informasi', 'url' => '#', 'icon' => 'fas fa-info-circle']
        ]" />

        <div class="text-center mb-10 mt-6">
            <div
                class="inline-flex items-center justify-center w-36 h-36 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-6 shadow-lg">
                <img src="{{ asset('storage/logo/ppid.webp') }}" alt="Logo PPID" class="w-36 h-36">
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">{{ __('Detail Permohonan Informasi') }}</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                {{ __('Lihat rincian lengkap permohonan informasi Anda, termasuk status dan riwayat tanggapan.') }}
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
            <!-- Header dengan warna biru -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-500">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <h2 class="text-xl font-semibold text-white">
                        <i class="fas fa-info-circle mr-2"></i>
                        Detail Permohonan Informasi
                    </h2>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <a href="{{ route('laporan.permohonan.pdf', ['permohonanInformasi' => $permohonan, 'action' => 'preview']) }}"
                           target="_blank"
                           class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700 shadow-sm">
                            <i class="fas fa-eye mr-2"></i>
                            Preview PDF
                        </a>
                        <a href="{{ route('laporan.permohonan.pdf', $permohonan) }}"
                           target="_blank"
                           class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md bg-green-600 text-white hover:bg-green-700 shadow-sm">
                            <i class="fas fa-file-pdf mr-2"></i>
                            Download PDF
                        </a>
                        <a href="{{ route('laporan.permohonan.index') }}"
                           class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md bg-white text-blue-600 hover:bg-blue-50 shadow-sm">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Status Badges -->
                <div class="mb-6 flex flex-wrap gap-4">
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
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-blue-200">
                        <i class="fas fa-user-circle mr-2 text-blue-500"></i>
                        Informasi Pemohon
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kolom Kiri -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">
                                    <i class="fas fa-user mr-2 text-blue-400"></i>Nama Pemohon
                                </label>
                                <div class="text-gray-900 font-medium">
                                    @if ($permohonan->privacy_status == 'Anonim' && !$isOwner)
                                        <span class="text-gray-600">
                                            <i class="fas fa-user-secret mr-2"></i>
                                            {{ substr($permohonan->nama_pemohon, 0, 1) . '*****' }}
                                        </span>
                                    @else
                                        {{ $permohonan->nama_pemohon }}
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">
                                    <i class="fas fa-briefcase mr-2 text-blue-400"></i>Pekerjaan
                                </label>
                                <div class="text-gray-900">{{ $permohonan->pekerjaan ?? '-' }}</div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">
                                    <i class="fas fa-phone mr-2 text-blue-400"></i>Nomor Telepon
                                </label>
                                <div class="text-gray-900">
                                    @if ($permohonan->privacy_status == 'Anonim' && !$isOwner)
                                        <span class="text-gray-600">
                                            {{ substr($permohonan->nomor_telepon_pemohon, 0, 3) . '*****' }}
                                        </span>
                                    @else
                                        {{ $permohonan->nomor_telepon_pemohon ?? '-' }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">
                                    <i class="fas fa-map-marker-alt mr-2 text-blue-400"></i>Alamat
                                </label>
                                <div class="text-gray-900">{{ $permohonan->alamat_pemohon }}</div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">
                                    <i class="fas fa-envelope mr-2 text-blue-400"></i>Email
                                </label>
                                <div class="text-gray-900">
                                    @if ($permohonan->privacy_status == 'Anonim' && !$isOwner)
                                        <span class="text-gray-600">
                                            {{ substr($permohonan->email_pemohon, 0, 3) . '*****' }}
                                        </span>
                                    @else
                                        {{ $permohonan->email_pemohon ?? '-' }}
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">
                                    <i class="fas fa-user-tie mr-2 text-blue-400"></i>Petugas Penerima
                                </label>
                                <div class="text-gray-900 font-medium">
                                    @php
                                        $lastResponder = $permohonan->responses->last();
                                    @endphp
                                    @if($lastResponder && $lastResponder->user)
                                        {{ $lastResponder->user->name }}
                                    @else
                                        <span class="text-gray-500">Belum ada tanggapan</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Permohonan -->
                <div class="space-y-6">
                    <!-- Informasi yang Dimohon -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                            Informasi yang Dimohon
                        </h3>
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <p class="text-gray-800 leading-relaxed">{{ $permohonan->detail_informasi }}</p>
                        </div>
                    </div>

                    <!-- Tujuan Penggunaan -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">
                            <i class="fas fa-bullseye mr-2 text-blue-500"></i>
                            Tujuan Penggunaan
                        </h3>
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <p class="text-gray-800 leading-relaxed">{{ $permohonan->tujuan_penggunaan_informasi }}</p>
                        </div>
                    </div>

                    <!-- Cara Memperoleh dan Mendapatkan Salinan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">
                                <i class="fas fa-download mr-2 text-blue-500"></i>
                                Cara Memperoleh
                            </h3>
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                @php
                                    $caraMemperoleh = json_decode($permohonan->cara_memperoleh_informasi, true);
                                @endphp
                                @if (!empty($caraMemperoleh))
                                    <ul class="space-y-2">
                                        @foreach ($caraMemperoleh as $cara)
                                            <li class="flex items-start">
                                                <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                                <span class="text-gray-800">{{ $cara }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500">-</p>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">
                                <i class="fas fa-copy mr-2 text-blue-500"></i>
                                Cara Mendapatkan Salinan
                            </h3>
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                @php
                                    $caraSalinan = json_decode($permohonan->cara_mendapatkan_salinan, true);
                                @endphp
                                @if (!empty($caraSalinan))
                                    <ul class="space-y-2">
                                        @foreach ($caraSalinan as $cara)
                                            <li class="flex items-start">
                                                <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                                <span class="text-gray-800">{{ $cara }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500">-</p>
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
                @php
                    function getFileIcon($filePath) {
                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                        switch (strtolower($extension)) {
                            case 'pdf': return 'fas fa-file-pdf';
                            case 'doc':
                            case 'docx': return 'fas fa-file-word';
                            case 'xls':
                            case 'xlsx': return 'fas fa-file-excel';
                            case 'ppt':
                            case 'pptx': return 'fas fa-file-powerpoint';
                            case 'zip':
                            case 'rar': return 'fas fa-file-archive';
                            case 'jpg':
                            case 'jpeg':
                            case 'png':
                            case 'gif':
                            case 'webp': return 'fas fa-file-image';
                            default: return 'fas fa-file-alt';
                        }
                    }
                @endphp
                @if ($permohonan->responses->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-blue-200">
                        <i class="fas fa-history mr-2 text-blue-500"></i>
                        Riwayat Tanggapan
                    </h3>
                    <div class="space-y-4">
                        @foreach ($permohonan->responses as $response)
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <p class="font-medium text-gray-900">
                                        <i class="fas fa-user-circle mr-2 text-blue-400"></i>
                                        {{ $response->user->name ?? 'Admin' }}
                                    </p>
                                    <p class="text-sm text-gray-500 ml-6">{{ $response->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <p class="text-gray-800 mb-3 ml-6">{!! nl2br(e($response->message)) !!}</p>
                            @if ($response->file_path || $response->link)
                            <div class="pt-3 border-t border-blue-100 space-y-2 ml-6">
                                @if ($response->file_path)
                                    @php
                                        $iconClass = getFileIcon($response->file_path);
                                        $fileExtension = pathinfo($response->file_path, PATHINFO_EXTENSION);
                                        $fileName = \Illuminate\Support\Str::limit($permohonan->detail_informasi, 50);
                                        $nonHoverText = e($fileName) . ' (' . $fileExtension . ')';
                                        $hoverText = 'Download (' . $fileExtension . ')';
                                        $longestText = (mb_strlen($nonHoverText) > mb_strlen($hoverText)) ? $nonHoverText : $hoverText;
                                    @endphp
                                    <div class="flex items-center text-sm" x-data="{ hovered: false }">
                                        <a href="{{ \App\Helpers\StorageHelper::getUrl($response->file_path) }}" 
                                           target="_blank"
                                           class="text-blue-600 hover:text-blue-800 hover:underline flex items-center"
                                           @mouseenter="hovered = true" @mouseleave="hovered = false">
                                            <span class="mr-2 text-blue-400 w-4 text-center flex-shrink-0">
                                                <i class="{{ $iconClass }}" x-show="!hovered"></i>
                                                <i class="fas fa-download" x-show="hovered" style="display: none;"></i>
                                            </span>
                                            <div class="relative">
                                                {{-- Text swap using absolute positioning and opacity --}}
                                                <span class="absolute whitespace-nowrap" :class="{ 'opacity-100': !hovered, 'opacity-0': hovered, 'transition-opacity duration-200': true }">{{ $nonHoverText }}</span>
                                                <span class="absolute whitespace-nowrap" :class="{ 'opacity-100': hovered, 'opacity-0': !hovered, 'transition-opacity duration-200': true }">{{ $hoverText }}</span>
                                                
                                                {{-- Invisible spacer to reserve space for the longest text --}}
                                                <span class="invisible" aria-hidden="true">{{ $longestText }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                                @if ($response->link)
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-link text-blue-400 mr-2"></i>
                                    <a href="{{ $response->link }}" 
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 hover:underline truncate">
                                        {{ $response->link }}
                                    </a>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Form Tanggapan Pemohon -->
                @if (auth()->check() && auth()->id() == $permohonan->user_id && $permohonan->status_permohonan == 'diproses')
                <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-lg border border-blue-200 shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-reply mr-2 text-blue-500"></i>
                        Kirim Tanggapan
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Anda dapat memberikan tanggapan atau pertanyaan lanjutan terkait permohonan ini.
                    </p>
                    <form action="{{ route('laporan.permohonan.respond', $permohonan) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-comment-alt mr-2 text-blue-400"></i>
                                Pesan Tanggapan
                            </label>
                            <textarea id="message" name="message" rows="4" 
                                      class="w-full px-3 py-2 border border-blue-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                                      placeholder="Tulis tanggapan atau pertanyaan Anda di sini..."
                                      required></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-md hover:from-blue-700 hover:to-blue-800 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Tanggapan
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Form Penilaian -->
                @if (auth()->check() && auth()->id() == $permohonan->user_id && $permohonan->responses->isNotEmpty())
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-blue-200">
                        <i class="fas fa-star mr-2 text-yellow-500"></i>
                        {{ is_null($permohonan->rating) ? 'Beri Penilaian' : 'Ubah Penilaian Anda' }}
                    </h3>
                    
                    <div class="mt-4 bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-lg border border-blue-200 shadow-sm">
                        @if(is_null($permohonan->rating))
                        <p class="text-sm text-gray-600 mb-4 bg-white p-3 rounded-md border border-blue-100">
                            Layanan untuk permohonan ini telah diberikan. Silakan berikan penilaian Anda. 
                            <span class="font-medium text-blue-600">Dengan mengirimkan penilaian, permohonan akan ditandai sebagai 'selesai'.</span>
                        </p>
                        @endif

                        <form action="{{ route('laporan.permohonan.rate', $permohonan) }}" method="POST" onsubmit="{{ is_null($permohonan->rating) ? "return confirm('Apakah Anda yakin? Dengan mengirimkan penilaian, permohonan ini akan ditandai sebagai \\'selesai\\'.');" : "" }}">
                            @csrf
                            <div class="mb-4">
                                                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                                                Berikan Rating Terhadap Pelayanan Kami
                                                            </label>                                <div class="rating flex flex-row-reverse items-center justify-end">
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
                                        <label for="star{{ $i }}" title="{{ $satisfactionLevels[$i] }}" class="text-5xl cursor-pointer text-gray-300 transition-colors duration-200">★</label>
                                    @endfor
                                </div>
                                <div class="mt-4 p-3 bg-yellow-100 border border-yellow-200 rounded-md text-yellow-800 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-2 text-lg"></i>
                                    <span class="text-sm font-medium">
                                        Mohon diperhatikan: Jika penilaian tidak diberikan dalam waktu 3 hari setelah tanggapan terakhir, sistem akan secara otomatis memberikan penilaian bintang 5.
                                    </span>
                                </div>
                                @if(!is_null($permohonan->rating))
                                    @php
                                        $rating = $permohonan->rating;
                                        $message = '';
                                        if ($rating >= 4) {
                                            $message = 'Terima kasih atas penilaian Anda! Kami akan terus berusaha mempertahankan kualitas layanan kami.';
                                        } else {
                                            $message = 'Terima kasih atas masukan Anda. Kami akan terus berupaya untuk meningkatkan kualitas layanan kami.';
                                        }
                                    @endphp
                                    <div class="text-sm text-gray-600 mt-4 bg-white p-3 rounded-md border border-blue-100">
                                        <p class="font-medium text-blue-700">{{ $message }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="text-right">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-md hover:from-yellow-600 hover:to-yellow-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    {{ is_null($permohonan->rating) ? 'Kirim Penilaian' : 'Perbarui Penilaian' }}
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
    /* Rating stars styling */
    input[name="rating"]:checked ~ label,
    label:hover,
    label:hover ~ label {
        color: #fbbf24 !important;
    }
    input[name="rating"]:checked ~ label {
        color: #f59e0b !important;
    }
    label {
        transition: all 0.2s ease;
    }
</style>
@endsection