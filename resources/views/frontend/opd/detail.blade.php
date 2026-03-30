@extends('frontend.layouts.app')

@section('title', 'Tentang OPD ' . $organization->name)

@section('content')
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs Aligned with Content -->
            <div class="mb-4">
                <x-breadcrumbs :breadcrumbs="[
                    ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                    ['title' => 'Tentang OPD', 'url' => route('opd.list'), 'icon' => 'fas fa-building'],
                    ['title' => Str::limit($organization->name, 25), 'url' => '#', 'icon' => 'fas fa-info-circle']
                ]" />
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 text-center">
                Tentang OPD {{ $organization->name }}
            </h1>

            @if ($informasi && $informasi->file)
                <div class="flex justify-center">
                    <img src="{{ asset('storage/' . $informasi->file) }}" alt="Tentang OPD {{ $organization->name }}" class="rounded-lg shadow-md max-w-full h-auto">
                </div>
            @else
                <div class="text-center py-12">
                    <div class="flex flex-col items-center">
                        <i class="fas fa-image text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tentang OPD Tidak Ditemukan</h3>
                        <p class="text-gray-500">Belum ada gambar tentang OPD yang diunggah untuk OPD ini.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
