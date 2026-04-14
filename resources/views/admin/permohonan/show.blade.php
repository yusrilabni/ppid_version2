@extends('admin.layouts.app')

@section('title', 'Detail Permohonan Informasi')

@section('content')
    <!-- Success Notifications -->
    @if (session('success'))
        <div class="mb-8 animate-fade-in">
            <div class="bg-white border-l-4 border-green-500 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-lg font-bold text-gray-900">{{ session('success') }}</p>
                            @if(session('wa_url'))
                                <p class="text-gray-600 mt-1 text-sm">Silakan teruskan balasan ini ke WhatsApp pemohon untuk memberikan notifikasi langsung.</p>
                            @endif
                        </div>
                        @if(session('wa_url'))
                            <div class="ml-6">
                                <a href="{{ session('wa_url') }}" target="_blank"
                                    class="inline-flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-lg hover:shadow-green-200 transform hover:-translate-y-0.5 transition-all duration-300 text-sm">
                                    <i class="fab fa-whatsapp mr-2 text-xl"></i>
                                    Kirim ke WhatsApp
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-8 animate-fade-in">
            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-2xl shadow-lg flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 text-2xl mr-4"></i>
                <p class="text-red-700 font-semibold">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-file-contract text-blue-500 mr-4 p-3 bg-blue-100 rounded-2xl"></i>
                        <span>Detail Permohonan Informasi</span>
                    </h1>
                    <p class="text-gray-600 mt-3 ml-1 flex items-center">
                        <i class="fas fa-hashtag text-gray-400 mr-2"></i>
                        ID: <span
                            class="font-mono bg-gray-100 px-3 py-1.5 rounded-lg ml-2 border border-gray-200">#{{ $permohonan->unique_code }}</span>
                    </p>
                </div>
                <a href="{{ route('admin.permohonan-informasi.index') }}"
                    class="group inline-flex items-center px-5 py-3.5 bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 border border-blue-200 rounded-xl shadow-lg text-base font-medium text-blue-700 transition-all duration-300 hover:shadow-xl hover:scale-[1.02] active:scale-[0.98]">
                    <i class="fas fa-arrow-left mr-3 group-hover:-translate-x-1 transition-transform duration-300"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Main Content - Single Column -->
        <div class="space-y-6">
            <!-- Status & Info Card -->
            <div
                class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-xl border border-blue-100 overflow-hidden transform transition-all duration-300 hover:shadow-2xl">
                @php
    use App\Helpers\PrivacyHelper;

    $is_anonim_status = $permohonan->privacy_status == 'Anonim';
    $is_owner = Auth::check() && Auth::id() == $permohonan->user_id;

    // Stricter rule: data is masked if status is 'Anonim' and the viewer is NOT the owner.
    $should_anonymize_data = $is_anonim_status && !$is_owner;

    // The info block should always be shown now, with data masked if necessary.
    // So we don't need a variable to hide the block, and the layout fix is no longer needed in the same way.
@endphp
                <div class="p-8">
                    <div class="flex flex-col lg:flex-row gap-8">
                        <!-- Pemohon Info -->
                        <div class="lg:w-1/2">
                            <div class="bg-gradient-to-r from-blue-50/80 to-indigo-50/80 rounded-2xl border border-blue-200 p-6">
                                <div class="flex items-center mb-6">
                                    <div class="relative">
                                        @if($permohonan->user && $permohonan->user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $permohonan->user->profile_photo_path) }}" 
                                                    alt="{{ $permohonan->user->name }}" 
                                                    class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-xl ring-4 ring-blue-100">
                                        @else
                                            <div class="h-20 w-20 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 border-4 border-white shadow-xl ring-4 ring-blue-100 flex items-center justify-center">
                                                <i class="fas fa-user text-white text-3xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-6">
                                        <h3 class="font-bold text-gray-900 text-2xl mb-1">{{ PrivacyHelper::maskName($permohonan->user->name ?? $permohonan->nama_pemohon, $should_anonymize_data) }}</h3>
                                        <p class="text-gray-600 text-base flex items-center">
                                            <i class="fas fa-user-tag text-blue-500 mr-2 text-sm"></i>
                                            {{ PrivacyHelper::maskName($permohonan->pekerjaan ?? '-', $should_anonymize_data) }}
                                        </p>
                                        <p class="text-gray-500 text-sm mt-3 flex items-center">
                                            <i class="fas fa-calendar-alt mr-2"></i>
                                            Meminta pada: <span class="font-semibold ml-2">{{ $permohonan->created_at->format('d M Y, H:i') }}</span>
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Contact Information Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Email -->
                                    <div class="bg-white p-4 rounded-xl border border-blue-100 hover:border-blue-300 hover:shadow-sm transition-all duration-300">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-lg bg-gradient-to-r from-blue-100 to-indigo-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-envelope text-blue-600"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs text-gray-500 font-medium mb-1">Email</p>
                                                <p class="text-gray-800 font-medium truncate">{{ PrivacyHelper::maskEmail($permohonan->email_pemohon, $should_anonymize_data) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Phone -->
                                    <div class="bg-white p-4 rounded-xl border border-blue-100 hover:border-blue-300 hover:shadow-sm transition-all duration-300">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-lg bg-gradient-to-r from-green-100 to-emerald-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-phone text-green-600"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs text-gray-500 font-medium mb-1">Telepon</p>
                                                <p class="text-gray-800 font-medium">{{ PrivacyHelper::maskFull($permohonan->nomor_telepon_pemohon, $should_anonymize_data) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Address -->
                                    <div class="md:col-span-2 bg-white p-4 rounded-xl border border-blue-100 hover:border-blue-300 hover:shadow-sm transition-all duration-300">
                                        <div class="flex items-start">
                                            <div class="h-10 w-10 rounded-lg bg-gradient-to-r from-purple-100 to-violet-100 flex items-center justify-center mr-3 flex-shrink-0">
                                                <i class="fas fa-map-marker-alt text-purple-600"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs text-gray-500 font-medium mb-1">Alamat</p>
                                                <p class="text-gray-800 font-medium">{{ PrivacyHelper::maskFull($permohonan->alamat_pemohon, $should_anonymize_data) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Badges & Progress -->
                        <div class="lg:w-1/2">
                            <!-- Status Cards Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                @php
                                    $statusConfig = [
                                        'pending' => [
                                            'color' => 'yellow',
                                            'gradient' => 'from-yellow-400 to-yellow-500',
                                            'icon' => 'fas fa-clock',
                                            'text' => 'Menunggu',
                                        ],
                                        'diproses' => [
                                            'color' => 'blue',
                                            'gradient' => 'from-blue-500 to-blue-600',
                                            'icon' => 'fas fa-cogs',
                                            'text' => 'Diproses',
                                        ],
                                        'selesai' => [
                                            'color' => 'green',
                                            'gradient' => 'from-emerald-500 to-green-600',
                                            'icon' => 'fas fa-check-circle',
                                            'text' => 'Selesai',
                                        ],
                                        'ditolak' => [
                                            'color' => 'red',
                                            'gradient' => 'from-red-500 to-red-600',
                                            'icon' => 'fas fa-times-circle',
                                            'text' => 'Ditolak',
                                        ],
                                    ];
                                    $status = $statusConfig[$permohonan->status_permohonan] ?? [
                                        'color' => 'gray',
                                        'gradient' => 'from-gray-400 to-gray-600',
                                        'icon' => 'fas fa-question-circle',
                                        'text' => 'Unknown',
                                    ];

                                    $privacyConfig = [
                                        'Publik' => [
                                            'color' => 'blue',
                                            'gradient' => 'from-blue-400 to-indigo-500',
                                            'icon' => 'fas fa-globe-asia',
                                        ],
                                        'Anonim' => [
                                            'color' => 'yellow',
                                            'gradient' => 'from-yellow-400 to-amber-500',
                                            'icon' => 'fas fa-user-secret',
                                        ],
                                        'Rahasia' => [
                                            'color' => 'red',
                                            'gradient' => 'from-red-400 to-red-600',
                                            'icon' => 'fas fa-lock',
                                        ],
                                    ];
                                    $privacy = $privacyConfig[$permohonan->privacy_status] ?? [
                                        'color' => 'gray',
                                        'gradient' => 'from-gray-400 to-gray-600',
                                        'icon' => 'fas fa-question-circle',
                                    ];
                                @endphp

                                <!-- Status Permohonan -->
                                <div
                                    class="bg-gradient-to-r {{ $status['gradient'] }} text-white rounded-xl shadow-lg p-5 transform hover:scale-[1.02] transition-transform duration-300">
                                    <div class="flex items-center">
                                        <div class="h-12 w-12 rounded-lg bg-white/20 flex items-center justify-center mr-4">
                                            <i class="{{ $status['icon'] }} text-xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium opacity-90 mb-1">Status Permohonan</p>
                                            <p class="font-bold text-xl">{{ $status['text'] }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Privasi -->
                                <div
                                    class="bg-gradient-to-r {{ $privacy['gradient'] }} text-white rounded-xl shadow-lg p-5 transform hover:scale-[1.02] transition-transform duration-300">
                                    <div class="flex items-center">
                                        <div class="h-12 w-12 rounded-lg bg-white/20 flex items-center justify-center mr-4">
                                            <i class="{{ $privacy['icon'] }} text-xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium opacity-90 mb-1">Status Privasi</p>
                                            <p class="font-bold text-xl">{{ $permohonan->privacy_status }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="bg-gradient-to-r from-white to-gray-50/80 p-6 rounded-2xl border border-gray-200">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-lg font-semibold text-gray-800 flex items-center">
                                        <i class="fas fa-chart-line text-blue-500 mr-3"></i>
                                        Progress Permohonan
                                    </span>
                                    <span
                                        class="text-2xl font-bold progress-percentage 
                                    @switch($permohonan->status_permohonan)
                                        @case('pending') text-yellow-600 @break
                                        @case('diproses') text-blue-600 @break
                                        @case('selesai') text-green-600 @break
                                        @case('ditolak') text-red-600 @break
                                        @default text-gray-600
                                    @endswitch">
                                        @php
                                            $progressPercentage = match ($permohonan->status_permohonan) {
                                                'pending' => 25,
                                                'diproses' => 65,
                                                'selesai' => 100,
                                                'ditolak' => 100,
                                                default => 0,
                                            };
                                        @endphp
                                        {{ $progressPercentage }}%
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3 shadow-inner">
                                    <div class="h-3 rounded-full transition-all duration-1000 ease-out shadow-lg progress-indicator 
                                    @switch($permohonan->status_permohonan)
                                        @case('pending') bg-gradient-to-r from-yellow-400 to-yellow-500 @break
                                        @case('diproses') bg-gradient-to-r from-blue-500 to-blue-600 @break
                                        @case('selesai') bg-gradient-to-r from-green-500 to-green-600 @break
                                        @case('ditolak') bg-gradient-to-r from-red-500 to-red-600 @break
                                        @default bg-gradient-to-r from-gray-400 to-gray-600
                                    @endswitch"
                                        style="width: {{ $progressPercentage }}%">
                                    </div>
                                </div>
                                <div class="grid grid-cols-4 gap-2 mt-4 text-xs text-gray-600">
                                    <span class="flex flex-col items-center text-center">
                                        <div class="h-3 w-3 rounded-full bg-yellow-400 mb-1"></div>
                                        <span class="font-medium">Pending</span>
                                        <span class="text-gray-500">25%</span>
                                    </span>
                                    <span class="flex flex-col items-center text-center">
                                        <div class="h-3 w-3 rounded-full bg-blue-500 mb-1"></div>
                                        <span class="font-medium">Diproses</span>
                                        <span class="text-gray-500">65%</span>
                                    </span>
                                    <span class="flex flex-col items-center text-center">
                                        <div class="h-3 w-3 rounded-full bg-green-500 mb-1"></div>
                                        <span class="font-medium">Selesai</span>
                                        <span class="text-gray-500">100%</span>
                                    </span>
                                    <span class="flex flex-col items-center text-center">
                                        <div class="h-3 w-3 rounded-full bg-red-500 mb-1"></div>
                                        <span class="font-medium">Ditolak</span>
                                        <span class="text-gray-500">100%</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Permohonan Card -->
            <div
                class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-xl border border-blue-100 overflow-hidden transform transition-all duration-300 hover:shadow-2xl">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-6">
                    <div class="flex items-center">
                        <div class="h-14 w-14 rounded-xl bg-white/20 flex items-center justify-center mr-4">
                            <i class="fas fa-info-circle text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Detail Permohonan</h3>
                            <p class="text-white/90 text-sm mt-1">Informasi lengkap yang diminta oleh pemohon</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="relative">
                        <div
                            class="absolute -left-2 top-0 bottom-0 w-1.5 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full">
                        </div>
                        <div class="ml-4">
                            <div
                                class="bg-gradient-to-r from-white to-blue-50 p-6 rounded-xl border-2 border-blue-200 shadow-inner">
                                <div class="flex items-start mb-6">
                                    <div
                                        class="h-12 w-12 rounded-lg bg-gradient-to-r from-blue-100 to-indigo-100 flex items-center justify-center mr-4">
                                        <i class="fas fa-clipboard-list text-blue-600 text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-xl font-bold text-gray-900 mb-3">Deskripsi Permintaan</h4>
                                        <p
                                            class="text-gray-800 text-lg leading-relaxed whitespace-normal bg-white/50 p-4 rounded-lg border border-blue-100 text-left">
                                            {{ $permohonan->detail_informasi }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start mb-6 pt-6 border-t border-blue-200">
                                    <div
                                        class="h-12 w-12 rounded-lg bg-gradient-to-r from-green-100 to-emerald-100 flex items-center justify-center mr-4">
                                        <i class="fas fa-bullseye text-green-600 text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-xl font-bold text-gray-900 mb-3">Tujuan Penggunaan Informasi</h4>
                                        <p
                                            class="text-gray-800 text-lg leading-relaxed whitespace-normal bg-white/50 p-4 rounded-lg border border-blue-100 text-left">
                                            {{ $permohonan->tujuan_penggunaan_informasi }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start mb-6 pt-6 border-t border-blue-200">
                                    <div
                                        class="h-12 w-12 rounded-lg bg-gradient-to-r from-yellow-100 to-amber-100 flex items-center justify-center mr-4">
                                        <i class="fas fa-hand-holding text-yellow-600 text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-xl font-bold text-gray-900 mb-3">Cara Memperoleh & Mendapatkan
                                            Informasi</h4>
                                        <div class="bg-white/50 p-6 rounded-xl border border-blue-100 shadow-sm">
                                            <!-- Container utama dengan layout yang lebih baik -->
                                            <div class="space-y-8">

                                                <!-- Bagian Cara Memperoleh Informasi -->
                                                <div
                                                    class="bg-gradient-to-r from-blue-50/80 to-indigo-50/80 p-5 rounded-xl border border-blue-200 shadow-sm">
                                                    <div class="flex items-center mb-4">
                                                        <div
                                                            class="h-10 w-10 rounded-lg bg-gradient-to-r from-blue-100 to-indigo-100 flex items-center justify-center mr-3">
                                                            <i class="fas fa-search text-blue-600"></i>
                                                        </div>
                                                        <div>
                                                            <p class="font-bold text-gray-800 text-lg">Cara Memperoleh
                                                                Informasi</p>
                                                            <p class="text-gray-600 text-sm mt-1">Metode yang diinginkan
                                                                untuk mengakses informasi</p>
                                                        </div>
                                                    </div>
                                                    <div class="ml-13">
                                                        <div class="flex flex-wrap gap-3">
                                                            @foreach (json_decode($permohonan->cara_memperoleh_informasi) as $cara)
                                                                <span
                                                                    class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-white to-blue-50 border border-blue-200 rounded-lg text-gray-800 font-medium hover:from-blue-50 hover:to-blue-100 hover:border-blue-300 transition-all duration-300 shadow-sm hover:shadow-md">
                                                                    <i
                                                                        class="fas fa-check-circle text-blue-500 mr-2.5 text-sm"></i>
                                                                    {{ $cara }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Bagian Cara Mendapatkan Salinan (jika ada) -->
                                                @if ($permohonan->cara_mendapatkan_salinan)
                                                    <div
                                                        class="bg-gradient-to-r from-green-50/80 to-emerald-50/80 p-5 rounded-xl border border-green-200 shadow-sm">
                                                        <div class="flex items-center mb-4">
                                                            <div
                                                                class="h-10 w-10 rounded-lg bg-gradient-to-r from-green-100 to-emerald-100 flex items-center justify-center mr-3">
                                                                <i class="fas fa-copy text-green-600"></i>
                                                            </div>
                                                            <div>
                                                                <p class="font-bold text-gray-800 text-lg">Cara Mendapatkan
                                                                    Salinan</p>
                                                                <p class="text-gray-600 text-sm mt-1">Metode untuk
                                                                    mendapatkan salinan fisik/digital</p>
                                                            </div>
                                                        </div>
                                                        <div class="ml-13">
                                                            <div class="flex flex-wrap gap-3">
                                                                @foreach (json_decode($permohonan->cara_mendapatkan_salinan) as $salinan)
                                                                    <span
                                                                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-white to-green-50 border border-green-200 rounded-lg text-gray-800 font-medium hover:from-green-50 hover:to-green-100 hover:border-green-300 transition-all duration-300 shadow-sm hover:shadow-md">
                                                                        <i
                                                                            class="fas fa-file-download text-green-500 mr-2.5 text-sm"></i>
                                                                        {{ $salinan }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Bagian Tempat Mendapatkan Salinan (jika ada) -->
                                                @if ($permohonan->tempat_mendapatkan_salinan)
                                                    <div
                                                        class="bg-gradient-to-r from-purple-50/80 to-violet-50/80 p-5 rounded-xl border border-purple-200 shadow-sm">
                                                        <div class="flex items-center mb-4">
                                                            <div
                                                                class="h-10 w-10 rounded-lg bg-gradient-to-r from-purple-100 to-violet-100 flex items-center justify-center mr-3">
                                                                <i class="fas fa-map-marker-alt text-purple-600"></i>
                                                            </div>
                                                            <div>
                                                                <p class="font-bold text-gray-800 text-lg">Tempat
                                                                    Mendapatkan Salinan</p>
                                                                <p class="text-gray-600 text-sm mt-1">Lokasi pengambilan
                                                                    salinan</p>
                                                            </div>
                                                        </div>
                                                        <div class="ml-13">
                                                            <div
                                                                class="bg-gradient-to-r from-white to-purple-50/50 border border-purple-200 rounded-xl p-4 hover:shadow-md transition-shadow duration-300">
                                                                <div class="flex items-start">
                                                                    <div
                                                                        class="h-8 w-8 rounded-lg bg-gradient-to-r from-purple-100 to-violet-100 flex items-center justify-center mr-3 mt-0.5">
                                                                        <i
                                                                            class="fas fa-location-dot text-purple-500 text-sm"></i>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-gray-800 font-medium text-lg">
                                                                            {{ PrivacyHelper::getUnitName($permohonan->tempat_mendapatkan_salinan) }}
                                                                        </p>
                                                                        <div
                                                                            class="flex items-center mt-2 text-sm text-gray-600">
                                                                            <i
                                                                                class="fas fa-clock text-gray-400 mr-2 text-xs"></i>
                                                                            <span>Lokasi tersedia untuk pengambilan selama
                                                                                jam kerja</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-blue-200">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 rounded-lg bg-purple-100 flex items-center justify-center mr-4">
                                            <i class="fas fa-calendar-plus text-purple-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Dibuat</p>
                                            <p class="font-semibold text-gray-900">
                                                {{ $permohonan->created_at->format('d F Y, H:i') }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center mr-4">
                                            <i class="fas fa-sync-alt text-indigo-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Terakhir Diperbarui</p>
                                            <p class="font-semibold text-gray-900">
                                                {{ $permohonan->updated_at->format('d F Y, H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat/Response Section -->
            <div
                class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-xl border border-gray-200 overflow-hidden transform transition-all duration-300 hover:shadow-2xl">
                <div class="bg-gradient-to-r from-gray-900 to-gray-800 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="h-14 w-14 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center mr-4">
                                <i class="fas fa-comments text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white">Diskusi & Tindak Lanjut</h3>
                                <p class="text-white/90 text-sm mt-1">Riwayat komunikasi dan balasan untuk permohonan ini
                                </p>
                            </div>
                        </div>

                        @if ($permohonan->responses->count() > 0)
                            <div
                                class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-2.5 rounded-full shadow-lg">
                                <span class="font-bold text-lg">{{ $permohonan->responses->count() }}</span>
                                <span class="ml-2">Pesan</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Chat History -->
                <div class="px-8 py-6 chat-scroll" style="max-height: 450px; overflow-y: auto;">
                    @forelse ($permohonan->responses as $response)
                        @if ($response->message || $response->file_path || $response->link)
                            <div class="mb-6 animate-fade-in">
                                <div
                                    class="flex items-start space-x-3 @if ($response->user_id === Auth::id()) flex-row-reverse space-x-reverse @endif">
                                    <!-- Avatar -->
                                    <div class="relative flex-shrink-0">
                                        @if ($response->user && $response->user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $response->user->profile_photo_path) }}"
                                                alt="{{ $response->user->name }}"
                                                class="h-10 w-10 rounded-full border-2 @if ($response->user_id === Auth::id()) border-blue-400 @else border-gray-300 @endif shadow-md hover:scale-105 transition-transform duration-200">
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-full bg-gradient-to-r @if ($response->user_id === Auth::id()) from-blue-500 to-indigo-600 @else from-gray-500 to-gray-700 @endif border-2 @if ($response->user_id === Auth::id()) border-blue-400 @else border-gray-300 @endif shadow-md hover:scale-105 transition-transform duration-200 flex items-center justify-center">
                                                <i class="fas fa-user text-white text-sm"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Message Content -->
                                    <div
                                        class="flex-1 @if ($response->user_id === Auth::id()) items-end @else items-start @endif flex flex-col justify-start">
                                        <!-- Header -->
                                        <div
                                            class="mb-1 flex items-center @if ($response->user_id === Auth::id()) justify-end @endif space-x-2">
                                            <span
                                                class="font-semibold text-gray-900 text-sm">{{ $response->user->name ?? 'User' }}</span>
                                            <span class="text-gray-400 text-xs">•</span>
                                            <span
                                                class="text-gray-500 text-xs">{{ $response->created_at->format('H:i') }}</span>
                                        </div>

                                        <!-- Message Bubble - DIPERBAIKI: Lebar 100% dengan konten yang proporsional -->
                                        <div class="relative group/bubble @if($response->user_id === Auth::id()) bg-gradient-to-r from-blue-500 to-indigo-600 text-white w-fit max-w-lg @else bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 w-fit max-w-lg @endif rounded-xl @if($response->user_id === Auth::id()) rounded-tr-none @else rounded-tl-none @endif py-2 px-4 shadow-lg hover:shadow-xl transition-shadow duration-200">
                                            
                                            <!-- Resend Button (Only for Admin messages) -->
                                            @if($response->user && in_array($response->user->role, ['admin', 'superadmin']))
                                            <div class="absolute -left-12 top-1/2 -translate-y-1/2 opacity-0 group-hover/bubble:opacity-100 transition-opacity duration-200">
                                                <form action="{{ route('admin.permohonan-response.resend', $response) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" title="Kirim Ulang ke WA & Telegram" class="h-9 w-9 rounded-full bg-white shadow-md border border-blue-200 text-blue-600 hover:bg-blue-50 flex items-center justify-center transition-colors">
                                                        <i class="fas fa-share-square"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @endif

                                            <!-- Response Type -->
                                            @if ($response->response_type)
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold @if($response->user_id === Auth::id()) bg-white/20 text-white @else bg-gray-300 text-gray-700 @endif">
                                                                                                    <i class="fas @if($response->response_type === 'Respon Awal') fa-reply @else fa-sync-alt @endif mr-1.5 text-xs"></i>
                                                                                                    {{ $response->response_type }}
                                                                                                </span>
                                            @endif

                                            <!-- Message Text -->
                                            @if ($response->message)
                                                <p class="text-gray-700 whitespace-pre-line break-words mt-0 text-lg">{{ $response->message }}</p>
                                            @endif

                                            <!-- File Attachments -->
                                            @if ($response->file_path)
                                                @php
                                                    $filePath = $response->file_path;
                                                    $fileUrl = asset('storage/' . $filePath);
                                                    $fileInfo = pathinfo($filePath);
                                                    $extension = strtolower($fileInfo['extension'] ?? '');
                                                    $filename = $fileInfo['basename'];
                                                    $imageExtensions = [
                                                        'jpg',
                                                        'jpeg',
                                                        'png',
                                                        'gif',
                                                        'bmp',
                                                        'webp',
                                                        'svg',
                                                    ];
                                                    $pdfExtensions = ['pdf'];
                                                    $wordExtensions = ['doc', 'docx'];
                                                    $excelExtensions = ['xls', 'xlsx'];
                                                @endphp

                                                <div
                                                    class="mt-4 pt-4 border-t @if ($response->user_id === Auth::id()) border-white/20 @else border-gray-300/30 @endif">
                                                    <div class="flex items-center p-3 rounded-lg @if ($response->user_id === Auth::id()) bg-white/10 hover:bg-white/20 @else bg-gray-200/80 hover:bg-gray-300/80 @endif transition-colors duration-200 cursor-pointer"
                                                        onclick="window.open('{{ \App\Helpers\StorageHelper::getUrl($filePath) }}', '_blank')">
                                                        @if (in_array($extension, $imageExtensions))
                                                            <div
                                                                class="h-10 w-10 rounded-lg bg-gradient-to-r from-green-100 to-emerald-100 flex items-center justify-center mr-3">
                                                                <i class="fas fa-image text-green-500 text-sm"></i>
                                                            </div>
                                                        @elseif(in_array($extension, $pdfExtensions))
                                                            <div
                                                                class="h-10 w-10 rounded-lg bg-gradient-to-r from-red-100 to-red-200 flex items-center justify-center mr-3">
                                                                <i class="fas fa-file-pdf text-red-500 text-sm"></i>
                                                            </div>
                                                        @elseif(in_array($extension, $wordExtensions))
                                                            <div
                                                                class="h-10 w-10 rounded-lg bg-gradient-to-r from-blue-100 to-blue-200 flex items-center justify-center mr-3">
                                                                <i class="fas fa-file-word text-blue-500 text-sm"></i>
                                                            </div>
                                                        @elseif(in_array($extension, $excelExtensions))
                                                            <div
                                                                class="h-10 w-10 rounded-lg bg-gradient-to-r from-green-100 to-emerald-200 flex items-center justify-center mr-3">
                                                                <i class="fas fa-file-excel text-green-600 text-sm"></i>
                                                            </div>
                                                        @else
                                                            <div
                                                                class="h-10 w-10 rounded-lg bg-gradient-to-r from-gray-100 to-gray-200 flex items-center justify-center mr-3">
                                                                <i class="fas fa-file text-gray-500 text-sm"></i>
                                                            </div>
                                                        @endif

                                                        <div class="flex-1 min-w-0">
                                                            <p class="font-medium text-sm truncate">{{ $filename }}
                                                            </p>
                                                            <p class="text-xs opacity-75 mt-1">
                                                                {{ strtoupper($extension) }} •
                                                                @if (Storage::exists($filePath))
                                                                    {{ round(Storage::size($filePath) / 1024, 1) }} KB
                                                                @endif
                                                            </p>
                                                        </div>

                                                        <button type="button"
                                                            class="ml-3 px-3 py-1.5 text-xs font-medium rounded-lg @if ($response->user_id === Auth::id()) bg-white/20 hover:bg-white/30 text-white @else bg-gray-300 hover:bg-gray-400 text-gray-700 @endif transition-colors flex items-center">
                                                            <i class="fas fa-download mr-1.5"></i>Unduh
                                                        </button>
                                                    </div>

                                                    @if (in_array($extension, $imageExtensions))
                                                        <div class="mt-3">
                                                            <a href="{{ \App\Helpers\StorageHelper::getUrl($filePath) }}" target="_blank"
                                                                class="inline-block">
                                                                <img src="{{ \App\Helpers\StorageHelper::getUrl($filePath) }}" alt="Preview"
                                                                    class="max-w-full max-h-48 rounded-lg border @if ($response->user_id === Auth::id()) border-white/20 @else border-gray-300 @endif hover:scale-105 transition-transform duration-200">
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            <!-- Link -->
                                            @if ($response->link)
                                                <div
                                                    class="mt-4 pt-4 border-t @if ($response->user_id === Auth::id()) border-white/20 @else border-gray-300/30 @endif">
                                                    <a href="{{ $response->link }}" target="_blank"
                                                        class="flex items-center p-3 rounded-lg @if ($response->user_id === Auth::id()) bg-white/10 hover:bg-white/20 @else bg-gray-200/80 hover:bg-gray-300/80 @endif transition-colors duration-200 group w-full">
                                                        <div
                                                            class="h-8 w-8 rounded-md bg-gradient-to-r from-blue-100 to-indigo-100 flex items-center justify-center mr-3 flex-shrink-0">
                                                            <i class="fas fa-link text-blue-500 text-sm"></i>
                                                        </div>
                                                        <div class="flex-1 min-w-0 overflow-hidden">
                                                            <p class="text-sm break-all leading-tight">{{ $response->link }}</p>
                                                            <p class="text-xs opacity-75 mt-1">Klik untuk membuka tautan
                                                            </p>
                                                        </div>
                                                        <i
                                                            class="fas fa-external-link-alt text-blue-400 text-sm ml-3 group-hover:translate-x-1 transition-transform flex-shrink-0"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Timestamp -->
                                        <div
                                            class="mt-2 text-xs text-gray-500 @if ($response->user_id === Auth::id()) text-right @endif flex items-center @if ($response->user_id !== Auth::id()) justify-start @else justify-end @endif">
                                            <i class="fas fa-clock mr-1.5 text-xs"></i>
                                            {{ $response->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-12 animate-fade-in">
                            <div class="text-gray-300 mb-4 transform hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-comment-slash text-5xl"></i>
                            </div>
                            <p class="text-gray-500 text-xl font-semibold mb-2">Belum ada diskusi</p>
                            <p class="text-gray-400 text-base">Mulai percakapan dengan mengirim balasan pertama di bawah
                            </p>
                        </div>
                    @endforelse
                </div>

                <!-- Response Form -->
                <div class="border-t border-gray-200 bg-gradient-to-r from-gray-50 to-white px-8 py-8">
                    <div
                        class="bg-gradient-to-br from-white to-blue-50 rounded-2xl border-2 border-blue-200 shadow-xl p-6">
                        <h4 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-reply text-blue-500 mr-3"></i>
                            Kirim Balasan
                        </h4>

                        <form action="{{ route('admin.permohonan-informasi.store') }}" method="POST"
                            enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <input type="hidden" name="permohonan_informasi_id" value="{{ $permohonan->id }}">

                            <!-- Message Input -->
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <label for="message" class="text-lg font-semibold text-gray-800 flex items-center">
                                        <i class="fas fa-comment-dots text-blue-500 mr-2"></i>Pesan Balasan
                                    </label>
                                    <div class="text-sm text-gray-500 font-medium character-counter">
                                        <span id="charCount" class="text-blue-600 font-bold">0</span>/2000 karakter
                                    </div>
                                </div>
                                <div class="relative">
                                    <textarea id="message" name="message" rows="4"
                                        class="w-full px-6 py-4 text-base border-2 border-gray-300 rounded-2xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500 transition-all duration-300 resize-none shadow-inner focus:shadow-lg placeholder-gray-400"
                                        placeholder="Tulis pesan balasan di sini..." maxlength="2000" required></textarea>
                                    <div class="absolute right-4 bottom-4 text-gray-400">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <i class="fas fa-info-circle mr-2 text-blue-400"></i>
                                    <span>Pastikan pesan jelas dan informatif</span>
                                </div>
                            </div>

                            <!-- Attachment and Link -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label for="file_upload"
                                        class="block text-lg font-semibold text-gray-800 mb-3 group-hover:text-blue-600 transition-colors duration-200">
                                        <i class="fas fa-paperclip text-blue-500 mr-2"></i>Lampirkan File
                                    </label>
                                    <div class="relative">
                                        <input type="file" id="file_upload" name="file"
                                            class="block w-full text-base text-gray-500 file:mr-6 file:py-4 file:px-5 file:rounded-xl file:border-0 file:text-base file:font-semibold file:bg-gradient-to-r file:from-blue-100 file:to-indigo-100 file:text-blue-700 hover:file:from-blue-200 hover:file:to-indigo-200 transition-all duration-300 file:cursor-pointer shadow-sm"
                                            onchange="validateFileSize(this)">
                                        <div class="text-sm text-gray-500 mt-3 flex items-center">
                                            <i class="fas fa-info-circle mr-2 text-blue-400"></i>
                                            <span>Maksimal 2MB. Format: PDF, DOC, JPG, PNG, ZIP</span>
                                        </div>
                                        <div id="fileError"
                                            class="text-sm text-red-600 mt-2 hidden flex items-center bg-red-50 p-3 rounded-lg border border-red-200">
                                            <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>
                                            <span>File terlalu besar! Maksimal 2MB. Gunakan tautan untuk file besar.</span>
                                        </div>
                                        <div id="fileSuccess"
                                            class="text-sm text-green-600 mt-2 hidden flex items-center bg-green-50 p-3 rounded-lg border border-green-200">
                                            <i class="fas fa-check-circle mr-2 text-green-500"></i>
                                            <span>File siap diunggah</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="group">
                                    <label for="link"
                                        class="block text-lg font-semibold text-gray-800 mb-3 group-hover:text-blue-600 transition-colors duration-200">
                                        <i class="fas fa-link text-blue-500 mr-2"></i>Tautan Eksternal
                                    </label>
                                    <div class="relative">
                                        <input type="url" id="link" name="link"
                                            class="w-full px-6 py-4 text-base border-2 border-gray-300 rounded-2xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500 transition-all duration-300 shadow-sm"
                                            placeholder="https://example.com">
                                        <div class="absolute right-4 top-4 text-gray-400">
                                            <i class="fas fa-external-link-alt"></i>
                                        </div>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        <i class="fas fa-info-circle mr-2 text-blue-400"></i>
                                        <span>Gunakan untuk file besar atau referensi eksternal</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Response Type Radio Buttons - Conditionally Shown -->
                            @php
                                $hasResponses = $permohonan->responses->isNotEmpty();
                                $lastResponseType = $hasResponses ? $permohonan->responses->last()->response_type : null;
                                $showRadioButtons = !$hasResponses || ($hasResponses && $lastResponseType === 'Respon Awal');
                                $defaultInitialChecked = true; // Default for no responses
                                if ($hasResponses && $lastResponseType === 'Respon Awal') {
                                    $defaultInitialChecked = false; // Default to Tindaklanjut if last was Respon Awal
                                }
                            @endphp

                            @if ($showRadioButtons)
                                <div class="pt-6 border-t border-gray-300">
                                    <label class="block text-lg font-semibold text-gray-800 mb-4">
                                        <i class="fas fa-tag text-purple-500 mr-2"></i>Jenis Balasan
                                    </label>
                                    <div class="flex space-x-8">
                                        <label for="response_type_initial" class="flex items-center cursor-pointer">
                                            <div class="relative">
                                                <input type="radio" id="response_type_initial" name="response_type"
                                                    value="Respon Awal" class="sr-only peer" @if ($defaultInitialChecked) checked @endif>
                                                <div
                                                    class="h-6 w-6 rounded-full border-2 border-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center transition-all duration-200">
                                                    <div class="h-2.5 w-2.5 rounded-full bg-white hidden peer-checked:block"></div>
                                                </div>
                                            </div>
                                            <div class="ml-3 text-gray-700 font-medium flex items-center group-hover:text-blue-600 transition-colors">
                                                <div
                                                    class="h-8 w-8 rounded-lg bg-gradient-to-r from-blue-100 to-indigo-100 flex items-center justify-center mr-2 group-hover:from-blue-200 group-hover:to-indigo-200 transition-all">
                                                    <i class="fas fa-reply text-blue-500 text-sm"></i>
                                                </div>
                                                <span>Respon Awal</span>
                                            </div>
                                        </label>

                                        <label for="response_type_followup" class="flex items-center cursor-pointer">
                                            <div class="relative">
                                                <input type="radio" id="response_type_followup" name="response_type"
                                                    value="Tindaklanjut" class="sr-only peer" @if (!$defaultInitialChecked) checked @endif>
                                                <div
                                                    class="h-6 w-6 rounded-full border-2 border-gray-300 peer-checked:border-purple-500 peer-checked:bg-purple-500 flex items-center justify-center transition-all duration-200">
                                                    <div class="h-2.5 w-2.5 rounded-full bg-white hidden peer-checked:block"></div>
                                                </div>
                                            </div>
                                            <div class="ml-3 text-gray-700 font-medium flex items-center group-hover:text-purple-600 transition-colors">
                                                <div
                                                    class="h-8 w-8 rounded-lg bg-gradient-to-r from-purple-100 to-purple-200 flex items-center justify-center mr-2 group-hover:from-purple-200 group-hover:to-purple-300 transition-all">
                                                    <i class="fas fa-sync-alt text-purple-500 text-sm"></i>
                                                </div>
                                                <span>Tindaklanjut</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="response_type" value="Tindaklanjut">
                            @endif

                            <!-- Submit Button -->
                            <div class="pt-6 border-t border-gray-300">
                                <button type="submit"
                                    class="group w-full px-10 py-5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold text-lg rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center justify-center">
                                    <i
                                        class="fas fa-paper-plane mr-3 text-xl group-hover:rotate-12 transition-transform"></i>
                                    Kirim Balasan
                                    <i
                                        class="fas fa-arrow-right ml-3 text-xl group-hover:translate-x-2 transition-transform"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .chat-scroll {
            scrollbar-width: thin;
            scrollbar-color: #6366f1 #f1f5f9;
        }

        .chat-scroll::-webkit-scrollbar {
            width: 10px;
        }

        .chat-scroll::-webkit-scrollbar-track {
            background: linear-gradient(to bottom, #f1f5f9, #e2e8f0);
            border-radius: 5px;
            margin: 4px;
        }

        .chat-scroll::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #6366f1, #4f46e5);
            border-radius: 5px;
            border: 2px solid #f1f5f9;
        }

        .chat-scroll::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #4f46e5, #4338ca);
        }

        /* Efek hover untuk card */
        .bg-gradient-to-br.from-white.to-blue-50:hover {
            transform: translateY(-4px);
        }

        /* Animasi fade in */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Character counter styles */
        .character-counter {
            background: linear-gradient(to right, #f3f4f6, #e5e7eb);
            padding: 6px 12px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
        }

        /* Radio button yang benar */
        input[type="radio"]:checked+div {
            border-color: #3b82f6;
            background-color: #3b82f6;
        }

        input[type="radio"]:checked+div .bg-white {
            display: block;
        }

        /* Progress bar animation */
        .progress-indicator {
            transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Chat bubble styling */
        .w-full {
            width: 100%;
        }
    </style>

    <script>
        function validateFileSize(input) {
            const fileError = document.getElementById('fileError');
            const fileSuccess = document.getElementById('fileSuccess');
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes

            if (input.files[0]) {
                const fileName = input.files[0].name;
                const fileSize = input.files[0].size;
                const fileSizeMB = (fileSize / (1024 * 1024)).toFixed(2);

                if (fileSize > maxSize) {
                    fileError.classList.remove('hidden');
                    fileSuccess.classList.add('hidden');
                    input.value = '';

                    // Suggest using link
                    const linkInput = document.getElementById('link');
                    if (linkInput) {
                        linkInput.focus();
                        linkInput.placeholder = `File "${fileName}" (${fileSizeMB}MB) terlalu besar. Gunakan tautan...`;
                        linkInput.classList.add('border-red-300', 'bg-red-50');
                    }
                } else {
                    fileError.classList.add('hidden');
                    fileSuccess.classList.remove('hidden');
                    fileSuccess.innerHTML = `
                <i class="fas fa-check-circle mr-2 text-green-500"></i>
                <span>File "${fileName}" (${fileSizeMB}MB) siap diunggah</span>
            `;

                    // Reset link input if it was marked
                    const linkInput = document.getElementById('link');
                    if (linkInput) {
                        linkInput.classList.remove('border-red-300', 'bg-red-50');
                        linkInput.placeholder = "https://example.com";
                    }
                }
            } else {
                fileError.classList.add('hidden');
                fileSuccess.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Auto-scroll chat to bottom
            const chatContainer = document.querySelector('.chat-scroll');
            if (chatContainer) {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }

            // Character counter for message textarea
            const textarea = document.getElementById('message');
            const charCount = document.getElementById('charCount');

            if (textarea && charCount) {
                // Update character count on input
                textarea.addEventListener('input', function() {
                    const length = this.value.length;
                    charCount.textContent = length;

                    // Update counter color based on length
                    if (length > 1800) {
                        charCount.classList.add('text-yellow-600');
                        charCount.classList.remove('text-blue-600');
                    } else if (length > 1900) {
                        charCount.classList.add('text-red-600');
                        charCount.classList.remove('text-yellow-600');
                    } else {
                        charCount.classList.remove('text-yellow-600', 'text-red-600');
                        charCount.classList.add('text-blue-600');
                    }

                    // Auto-resize textarea
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });

                // Focus effect
                textarea.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-blue-200', 'rounded-2xl');
                });

                textarea.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-blue-200', 'rounded-2xl');
                });

                // Trigger input event to set initial count
                textarea.dispatchEvent(new Event('input'));
            }

            // Add hover effect to chat bubbles
            const chatBubbles = document.querySelectorAll('.rounded-xl.p-4.shadow-lg');
            chatBubbles.forEach(bubble => {
                bubble.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });

                bubble.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Initialize radio buttons
            const radioButtons = document.querySelectorAll('input[type="radio"]');
            radioButtons.forEach(radio => {
                // Add change event listener
                radio.addEventListener('change', function() {
                    // Update all radio button visuals
                    radioButtons.forEach(rb => {
                        const radioDiv = rb.nextElementSibling;
                        if (radioDiv) {
                            if (rb.checked) {
                                if (rb.value === 'Respon Awal') {
                                    radioDiv.classList.add('border-blue-500',
                                    'bg-blue-500');
                                    radioDiv.classList.remove('border-gray-300',
                                        'border-purple-500', 'bg-purple-500');
                                } else {
                                    radioDiv.classList.add('border-purple-500',
                                        'bg-purple-500');
                                    radioDiv.classList.remove('border-gray-300',
                                        'border-blue-500', 'bg-blue-500');
                                }
                            } else {
                                radioDiv.classList.remove('border-blue-500', 'bg-blue-500',
                                    'border-purple-500', 'bg-purple-500');
                                radioDiv.classList.add('border-gray-300');
                            }
                        }
                    });
                });

                // Set initial state
                if (radio.checked) {
                    radio.dispatchEvent(new Event('change'));
                }
            });

            // Add animation to new chat messages
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length) {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1 && node.classList && node.classList
                                .contains('mb-6')) {
                                node.classList.add('animate-fade-in');
                            }
                        });
                    }
                });
            });

            if (chatContainer) {
                observer.observe(chatContainer, {
                    childList: true
                });
            }

            // Add smooth scrolling to chat
            window.scrollToChat = function() {
                const lastMessage = document.querySelector('.chat-scroll .mb-6:last-child');
                if (lastMessage) {
                    lastMessage.scrollIntoView({
                        behavior: 'smooth',
                        block: 'end'
                    });
                }
            };

            // Auto-open WhatsApp link if exists in session
            @if(session('wa_url'))
                setTimeout(function() {
                    window.open("{{ session('wa_url') }}", '_blank');
                }, 1000);
            @endif
        });
    </script>
@endsection
