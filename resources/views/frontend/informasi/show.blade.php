@extends('frontend.layouts.app')

@section('title', $informasi->title)

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $informasi->title }}</h1>
        <div class="text-gray-600 mb-4">
            <span class="font-semibold">Kategori:</span> {{ $informasi->category }} |
            <span class="font-semibold">Tahun:</span> {{ $informasi->tahun }} |
            <span class="font-semibold">Tanggal Upload:</span> {{ $informasi->tanggal_upload }}
        </div>
        <hr class="my-4">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Deskripsi Singkat</h2>
            <p>{{ $informasi->deskripsi }}</p>
        </div>
        <hr class="my-4">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Informasi Lengkap</h2>
            <p>{{ $informasi->content }}</p>
        </div>
        @if ($informasi->file)
            <hr class="my-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">File Lampiran</h2>
                <a href="{{ route('frontend.informasi.download', $informasi->id) }}" target="_blank" class="text-blue-500 hover:text-blue-700">Download File</a>
            </div>
        @endif
        <hr class="my-4">
        <a href="{{ url()->previous() }}" class="text-blue-500 hover:text-blue-700">Kembali</a>
    </div>
</div>
@endsection
