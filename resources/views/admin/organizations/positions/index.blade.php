@extends('admin.layouts.app')

@section('title', 'Tentang OPD')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Tentang OPD - {{ $organization->name }}</h2>
                <p class="text-gray-600">Informasi detail dan link website untuk OPD ini.</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.organizations.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <a href="{{ route('admin.organizations.structure.manage', $organization) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                    <i class="fas fa-edit mr-2"></i> Kelola OPD
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @elseif(session('deleted'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-trash mr-2"></i>
                <span>{{ session('deleted') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Link Website Resmi</h3>
            @if($organization->website_url)
                <p class="text-blue-600 text-lg break-all">
                    <i class="fas fa-link mr-2"></i> <a href="{{ $organization->website_url }}" target="_blank" class="hover:underline">{{ $organization->website_url }}</a>
                </p>
            @else
                <p class="text-gray-600">Link website belum ditambahkan. Silakan tambahkan melalui tombol "Kelola OPD".</p>
            @endif
        </div>

        <!-- Tampilan Gambar Struktur Organisasi -->
        <div class="bg-white rounded-xl shadow p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Gambar Tentang OPD</h3>
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 overflow-x-auto text-center">
                @if($struktur && $struktur->image_path)
                    <img src="{{ asset('storage/' . $struktur->image_path) }}" alt="Tentang OPD {{ $organization->name }}" class="max-w-full h-auto mx-auto rounded-lg">
                @else
                    <p class="text-gray-600">Belum ada gambar Tentang OPD yang diunggah untuk organisasi ini. Silakan unggah melalui tombol "Kelola OPD".</p>
                @endif
            </div>
        </div>
    </div>
@endsection