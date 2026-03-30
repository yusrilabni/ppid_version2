@extends('frontend.layouts.app')

@section('title', $standarLayanan->title)

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-7xl mx-auto">
        
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => Str::limit($standarLayanan->title, 30), 'url' => '#', 'icon' => $categoryIcon]
        ]" />

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 md:p-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">{{ $standarLayanan->title }}</h1>
                
                <div class="flex flex-col space-y-6">
                    @forelse($subLayanans as $subLayanan)
                        <div class="rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                            {{-- <a href="{{ asset('storage/' . $subLayanan->file) }}" data-fancybox="gallery" data-caption="{{ $subLayanan->title }}"> --}}
                                <img src="{{ asset('storage/' . $subLayanan->file) }}" alt="{{ $subLayanan->title }}" class="w-full h-auto object-contain">
                            {{-- </a> --}}
                            <div class="p-4 bg-gray-50">
                                <h3 class="font-semibold text-gray-800 text-center">{{ $subLayanan->title }}</h3>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <i class="fas fa-info-circle text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada dokumen</h3>
                            <p class="text-gray-500">Belum ada dokumen gambar yang aktif untuk kategori ini.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

{{-- @push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Fancybox.bind("[data-fancybox]", {
            // Your options
        });
    });
</script>
@endpush --}}
