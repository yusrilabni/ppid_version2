@extends('frontend.layouts.app')

@section('content')
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs Aligned with Content -->
            <div class="mb-4">
                <x-breadcrumbs :breadcrumbs="[
                    ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                    ['title' => ucwords(str_replace('-', ' ', $slug)), 'url' => '#', 'icon' => 'fas fa-user-slash']
                ]" />
            </div>
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-12 text-center">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-user-slash text-4xl text-gray-400"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Profil Tidak Ditemukan</h1>
                    <p class="text-gray-600 mb-6">
                        @if(isset($organization))
                            Belum ada Kepala OPD aktif untuk {{ $organization->name }}.
                        @else
                            Belum ada pejabat aktif untuk posisi ini.
                        @endif
                    </p>
                    <a href="{{ url('/profil') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                        Kembali ke Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection