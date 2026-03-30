@extends('frontend.layouts.app')

@section('title', 'Survei Tidak Tersedia')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <div class="max-w-xl mx-auto text-center">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <i class="fas fa-exclamation-circle text-yellow-400 text-6xl mb-4"></i>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Survei Tidak Tersedia</h1>
            <p class="text-gray-600">
                Mohon maaf, survei yang Anda tuju saat ini tidak aktif atau berada di luar periode waktu yang telah ditentukan.
            </p>
            <div class="mt-8">
                <a href="{{ route('home') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
