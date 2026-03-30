@extends('frontend.layouts.app')

@section('title', 'Daftar Informasi Publik Tidak Tersedia')

@section('content')
<div class="container mx-auto py-16 px-4 text-center">
    <div class="max-w-2xl mx-auto">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fa-home'],
            ['title' => 'DIP', 'url' => '#', 'icon' => 'fa-book'],
            ['title' => 'Data Tidak Ditemukan', 'url' => '', 'icon' => 'fa-exclamation-triangle'],
        ]" />
        
        <div class="bg-white p-12 rounded-xl shadow-lg">
            <div class="mx-auto mb-6 h-24 w-24 flex items-center justify-center rounded-full bg-yellow-100">
                <i class="fas fa-exclamation-triangle text-5xl text-yellow-500"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Data Informasi Publik Belum Tersedia</h1>
            <p class="text-gray-600 text-lg">
                Saat ini belum ada Daftar Informasi Publik (DIP) yang dapat ditampilkan. Silakan periksa kembali nanti.
            </p>
            <a href="{{ route('home') }}" class="mt-8 inline-block px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
