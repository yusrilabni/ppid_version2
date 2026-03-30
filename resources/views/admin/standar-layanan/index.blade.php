@extends('admin.layouts.app')

@section('title', 'Manajemen File Standar Layanan')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-xl font-bold text-gray-800">File Standar Layanan</h2>
            <p class="text-gray-600">Kelola semua file pendukung untuk standar layanan.</p>
        </div>
        <a href="{{ route('admin.standar-layanan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
            <i class="fas fa-plus mr-2"></i> Tambah File Baru
        </a>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul File</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse ($files as $file)
                                                <tr class="hover:bg-gray-50 transition">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ Str::limit($file->title, 75, '...') }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $file->standarLayanan->title ?? 'N/A' }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        @if ($file->status_tampil == 'aktif')
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                Aktif
                                                            </span>
                                                        @else
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                                Draft
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        <div class="flex space-x-3">                                <a href="{{ route('admin.standar-layanan.edit', $file->id) }}" class="text-blue-600 hover:text-blue-900 transition" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.standar-layanan.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                            Belum ada file yang diunggah.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
