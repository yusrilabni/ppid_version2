@extends('frontend.layouts.app')

@section('title', 'Daftar Informasi Publik (DIP) Tahun ' . $year)

@section('meta')
    <meta property="og:title" content="Daftar Informasi Publik (DIP) Tahun {{ $year }} - PPID Kabupaten Sinjai">
    <meta property="og:description" content="Lihat Daftar Informasi Publik (DIP) Kabupaten Sinjai tahun {{ $year }}. Akses informasi publik secara transparan.">
    <meta property="twitter:title" content="Daftar Informasi Publik (DIP) Tahun {{ $year }} - PPID Kabupaten Sinjai">
    <meta property="twitter:description" content="Lihat Daftar Informasi Publik (DIP) Kabupaten Sinjai tahun {{ $year }}. Akses informasi publik secara transparan.">
@endsection

@section('content')
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs Aligned with Content -->
            <div class="mb-4">
                <x-breadcrumbs :breadcrumbs="[
                    ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                    ['title' => 'DIP Tahun ' . $year, 'url' => '#', 'icon' => 'fas fa-calendar-alt'],
                ]" />
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 md:p-8 text-white flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-left">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold">Daftar Informasi Publik (DIP)</h1>
                <p class="text-blue-100 mt-1 text-lg md:text-xl font-medium">Tahun {{ $year }}</p>
            </div>
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
            <div class="flex-shrink-0">
                <a href="{{ route('dip.export', $year) }}" class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-green-200 transform hover:-translate-y-1">
                    <i class="fas fa-file-excel mr-2 text-xl"></i> Export Excel
                </a>
            </div>
            @endif
        </div>

        <div class="p-4 md:p-8">
            {{-- Section for "Penetapan DIP" --}}
            <div id="dip-notification" class="mb-8 p-4 bg-green-50 border border-green-200 rounded-lg shadow-sm">
                <p class="text-green-800 text-sm md:text-base leading-relaxed">
                    <i class="fas fa-check-circle mr-2 text-green-500"></i>
                    Daftar Informasi Publik (DIP) Tahun {{ $year }} ini telah ditetapkan dan disusun secara otomatis berdasarkan metadata informasi yang tersedia di sistem.
                </p>
            </div>

            {{-- Section for "Pencantuman Informasi Berdasarkan Klasifikasi" --}}
            <div class="space-y-10">
                @php
                    $categories = [
                        'Informasi Berkala' => '1. Informasi Berkala',
                        'Informasi Setiap Saat' => '2. Informasi Tersedia Setiap Saat',
                        'Informasi Serta Merta' => '3. Informasi Serta Merta'
                    ];
                @endphp

                @foreach($categories as $key => $label)
                    @if($informasiTahunIni->has($key))
                        <div class="border-l-4 border-blue-500 pl-4 md:pl-6 py-1">
                            <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-6">{{ $label }}</h3>
                            
                            @php $char = 'a'; @endphp
                            <div class="space-y-8">
                                @foreach($informasiTahunIni->get($key) as $jenisDokumen => $informasiList)
                                    <div class="relative">
                                        <h4 class="text-base md:text-lg font-bold text-blue-700 mb-4 flex items-start">
                                            <span class="bg-blue-100 text-blue-700 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 flex-shrink-0 mt-0.5">{{ $char++ }}</span>
                                            {{ $jenisDokumen ?: 'Lainnya' }}
                                        </h4>
                                        <div class="md:pl-9">
                                            @include('frontend.pages.dip._informasi_table', ['informasiList' => $informasiList])
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dipNotification = document.getElementById('dip-notification');
        if (dipNotification) {
            setTimeout(function() {
                // Fade out animation instead of instant hide
                dipNotification.style.transition = 'opacity 0.5s ease-out';
                dipNotification.style.opacity = '0';
                setTimeout(() => dipNotification.style.display = 'none', 500);
            }, 8000); 
        }
    });
</script>
@endpush
