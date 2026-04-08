@extends('frontend.layouts.app')

@section('title', 'Akses Dibatasi')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="max-w-lg w-full text-center">
        <div class="mb-8 relative">
            <div class="absolute inset-0 flex items-center justify-center blur-2xl opacity-20">
                <div class="w-32 h-32 bg-red-500 rounded-full"></div>
            </div>
            <i class="fas fa-user-shield text-8xl text-red-500 relative animate-bounce-slow"></i>
        </div>

        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">
            {{ $exception->getMessage() && str_contains($exception->getMessage(), 'Sinkron') ? 'Akun Tidak Sinkron' : 'Akses Dibatasi' }}
        </h1>
        
        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100 mb-8 transform transition-all hover:scale-[1.02]">
            <p class="text-gray-600 leading-relaxed mb-6">
                {{ $exception->getMessage() ?: 'Mohon maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Pastikan Anda masuk dengan akun yang memiliki hak akses yang sesuai.' }}
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-200">
                    <i class="fas fa-home mr-2"></i>
                    Halaman Utama
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Ganti Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 3s ease-in-out infinite;
    }
</style>
@endsection
