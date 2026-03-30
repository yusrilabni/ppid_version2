@extends('frontend.layouts.app')

@section('title', 'Laporan Survei')

@section('content')
<div class="container mx-auto my-8 px-4 md:px-0">
    <div class="max-w-7xl mx-auto">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Survei', 'url' => '#', 'icon' => 'fas fa-poll']
        ]" />

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
            <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-poll"></i>
                    Laporan Survei Kepuasan Masyarakat
                </h1>
                <p class="text-blue-100 mt-2">Dinas Komunikasi Informatika dan Persandian Kabupaten Sinjai</p>
            </div>
            
            <div class="p-6 sm:p-8">
                @if(isset($surveys) && $surveys->count() > 0)
                    @foreach($surveys as $survey)
                        <div class="border-b border-gray-200 pb-6 mb-6 last:border-0 last:mb-0 last:pb-0">
                            <div class="flex items-center gap-2 mb-2">
                                <h2 class="text-2xl font-bold text-gray-800">{{ $survey->title }}</h2>
                                @if($survey->type === 'skm')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full uppercase">SKM</span>
                                @elseif($survey->type === 'ppid')
                                    <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full uppercase">Survei PPID</span>
                                @endif
                            </div>
                            <div class="prose max-w-none text-gray-600 mb-6">
                                {{ $survey->description }}
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('public.surveys.show', $survey) }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:text-lg transition duration-150 ease-in-out">
                                    <i class="fas fa-poll-h mr-2"></i>
                                    Isi Survei Sekarang
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-clipboard-list text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-xl font-medium text-gray-900">Belum Ada Survei Aktif</h3>
                        <p class="text-gray-500 mt-2">Saat ini belum ada survei yang sedang aktif.</p>
                    </div>
                @endif
                
                {{-- Additional Info / Static Content about Survey Reports --}}
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Tentang Survei Kepuasan Masyarakat</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        Survei Kepuasan Masyarakat (SKM) adalah kegiatan pengukuran secara komprehensif tentang tingkat kepuasan masyarakat terhadap kualitas layanan yang diberikan oleh penyelenggara pelayanan publik.
                    </p>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Tujuannya adalah untuk mengetahui kelemahan atau kekurangan dari masing-masing unsur dalam penyelenggara pelayanan publik dan sebagai bahan penetapan kebijakan yang perlu diambil dan upaya tindak lanjut yang perlu dilakukan demi peningkatan kualitas pelayanan publik.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection