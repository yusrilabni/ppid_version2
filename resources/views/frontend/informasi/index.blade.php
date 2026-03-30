@extends('frontend.layouts.app')

@section('title', $pageTitle ?? 'Informasi')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6 px-4">
        <h1 class="text-3xl font-bold text-gray-800">I{{ $pageTitle }}</h1>
        @can('create', App\Models\Informasi::class)
            <a href="{{ route('informasi-crud.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i> Create New Informasi
            </a>
        @endcan
    </div>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Judul</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Deskripsi</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Tahun</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">File</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($informasis as $informasi)
                        <tr class="border-b">
                            <td class="text-left py-3 px-4"><a href="{{ route('frontend.informasi.show', $informasi) }}" class="text-blue-500 hover:text-blue-700">{{ $informasi->title }}</a></td>
                            <td class="text-left py-3 px-4">{{ $informasi->deskripsi }}</td>
                            <td class="text-left py-3 px-4">{{ $informasi->tahun }}</td>
                            <td class="text-left py-3 px-4">
                                @if ($informasi->file)
                                    <a href="{{ route('frontend.informasi.download', $informasi->id) }}" target="_blank" class="text-blue-500 hover:text-blue-700">Download</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="text-left py-3 px-4">
                                @can('update', $informasi)
                                    <a href="{{ route('informasi-crud.edit', $informasi) }}" class="text-blue-500 hover:text-blue-700 mr-4">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                @can('delete', $informasi)
                                    <form action="{{ route('informasi-crud.destroy', $informasi) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this item?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No informasi found for this category.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
