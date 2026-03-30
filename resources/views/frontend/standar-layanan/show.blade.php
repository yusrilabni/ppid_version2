<?php use Illuminate\Support\Str; ?>
@extends('frontend.layouts.app')

@section('title', $standarLayanan->title)

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-7xl mx-auto">
        
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => $standarLayanan->title, 'url' => '#', 'icon' => $categoryIcon]
        ]" />

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 md:p-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">{{ $standarLayanan->title }}</h1>
                
                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">No.</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Judul Dokumen</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Aktivitas</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($standarLayanan->subStandarLayanans as $index => $file)
                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-normal text-sm font-semibold text-gray-900">{{ $file->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div class="flex flex-col space-y-1">
                                            <div class="flex items-center">
                                                <i class="fas fa-eye text-purple-500 mr-2 text-xs"></i>
                                                <span class="text-xs">Lihat: {{ $file->views_count }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-download text-blue-500 mr-2 text-xs"></i>
                                                <span class="text-xs">Unduh: {{ $file->download_count }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('frontend.standar-layanan.file-detail', $file->slug) }}"
                                               class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded transition duration-150"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($file->file_type === 'url')
                                                <a href="{{ route('frontend.standar-layanan.visit-url', $file) }}"
                                                   target="_blank"
                                                   class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 p-2 rounded transition duration-150"
                                                   title="Buka File Eksternal">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            @elseif($file->file)
                                                <a href="{{ route('frontend.standar-layanan.download', $file) }}"
                                                   target="_blank"
                                                   class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 p-2 rounded transition duration-150"
                                                   title="Download File">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">Tidak ada dokumen</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-4">
                    @forelse($standarLayanan->subStandarLayanans as $index => $file)
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                            <h3 class="text-sm font-bold text-gray-900 leading-tight mb-3">{{ $file->title }}</h3>

                            <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                                <div class="flex items-center gap-4 text-[10px] text-gray-500">
                                    <span class="flex items-center"><i class="far fa-eye mr-1"></i> {{ $file->views_count }}</span>
                                    <span class="flex items-center"><i class="far fa-arrow-alt-circle-down mr-1"></i> {{ $file->download_count }}</span>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('frontend.standar-layanan.file-detail', $file->slug) }}" class="p-2 text-blue-600 bg-white border border-blue-100 rounded-md shadow-sm">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    @if($file->file_type === 'url')
                                        <a href="{{ route('frontend.standar-layanan.visit-url', $file) }}" target="_blank" class="p-2 text-green-600 bg-white border border-green-100 rounded-md shadow-sm">
                                            <i class="fas fa-external-link-alt text-sm"></i>
                                        </a>
                                    @elseif($file->file)
                                        <a href="{{ route('frontend.standar-layanan.download', $file) }}" target="_blank" class="p-2 text-green-600 bg-white border border-green-100 rounded-md shadow-sm">
                                            <i class="fas fa-download text-sm"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500 text-sm">
                            Tidak ada dokumen ditemukan
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>
@endsection