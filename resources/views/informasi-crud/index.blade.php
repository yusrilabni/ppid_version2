@extends('admin.layouts.app')

@section('title', 'Kelola Informasi')

@section('content')
<div class="w-full">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 border-b border-gray-200">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Informasi</h1>
            </div>
            <a href="{{ route('informasi-crud.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i> Tambah Informasi
            </a>
        </div>


        <!-- Tabel Informasi -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">No.</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Jenis Dokumen</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Tgl. Upload</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($informasis as $index => $informasi)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-normal text-sm font-semibold text-gray-900 max-w-xs">{{ $informasi->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-sm">{{ Str::limit($informasi->deskripsi, 80) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $informasi->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $informasi->jenis_dokumen ?: '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($informasi->status == 'BERLAKU')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> BERLAKU
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-archive mr-1"></i> ARSIP
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar text-blue-500 mr-2"></i>
                                    {{ \Carbon\Carbon::parse($informasi->tanggal_upload)->format('d M Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-col space-y-2">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('frontend.informasi.detail', $informasi->slug) }}"
                                           class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded transition duration-150"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if ($informasi->url)
                                            <a href="{{ $informasi->url }}" target="_blank"
                                               class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 p-2 rounded transition duration-150"
                                               title="Buka File Eksternal">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @elseif ($informasi->file)
                                            <a href="{{ route('frontend.informasi.download', $informasi->id) }}"
                                               class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 p-2 rounded transition duration-150"
                                               title="Download File">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('informasi-crud.edit', $informasi) }}"
                                           class="text-yellow-600 hover:text-yellow-900 bg-yellow-50 hover:bg-yellow-100 p-2 rounded transition duration-150"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('informasi-crud.destroy', $informasi) }}"
                                              method="POST"
                                              class="inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded transition duration-150"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus?')"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-info-circle text-gray-400 text-5xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada informasi</h3>
                                    <p class="text-gray-500">Belum ada informasi yang dibuat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
