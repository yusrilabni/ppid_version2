@extends('admin.layouts.app')

@section('title', 'Daftar Laporan Tahunan')

@section('content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Daftar Laporan Tahunan</h1>
                <p class="text-gray-600">Kelola laporan tahunan perusahaan</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.laporan.create') }}"
                    class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Upload Laporan Baru
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-blue-500 bg-opacity-10">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Laporan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $laporans->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-500 bg-opacity-10">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Published</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $laporans->where('published', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-gray-500 bg-opacity-10">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Draft</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $laporans->where('published', false)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Semua Laporan</h2>
                </div>
            </div>

            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-600">Cover</span>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-600">Judul
                                    Laporan</span>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-600">Tahun</span>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-600">Status</span>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($laporans as $laporan)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-4 px-6">
                                    <div class="relative">
                                        @if ($laporan->cover)
                                            <img src="{{ asset('storage/' . $laporan->cover) }}"
                                                alt="Cover {{ $laporan->title }}"
                                                class="w-16 h-20 object-cover rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                                        @else
                                            <div
                                                class="w-16 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div>
                                        <h3 class="font-medium text-gray-900 group-hover:text-blue-600 transition-colors">
                                            {{ $laporan->title }}
                                        </h3>
                                        <div class="flex items-center mt-2 space-x-4">
                                            <a href="{{ asset('storage/' . $laporan->file) }}" target="_blank"
                                                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 hover:underline">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                                Lihat PDF
                                            </a>
                                            <span class="text-sm text-gray-500">
                                                {{ $laporan->created_at->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span
                                        class="inline-flex items-center justify-center px-3 py-1.5 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        {{ $laporan->tahun }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    @if ($laporan->published)
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Published
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.laporan.edit', $laporan) }}"
                                            class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.laporan.destroy', $laporan) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                                title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 px-6">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada laporan</h3>
                                        <p class="mt-2 text-gray-500">Mulai dengan mengupload laporan tahunan pertama Anda.
                                        </p>
                                        <a href="{{ route('admin.laporan.create') }}"
                                            class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                                            Upload Laporan Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden">
                @forelse ($laporans as $laporan)
                    <div class="border-b border-gray-200 last:border-b-0">
                        <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex space-x-4">
                                <!-- Cover -->
                                <div class="flex-shrink-0">
                                    @if ($laporan->cover)
                                        <img src="{{ asset('storage/' . $laporan->cover) }}"
                                            alt="Cover {{ $laporan->title }}" class="w-16 h-20 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-medium text-gray-900 truncate">
                                                {{ $laporan->title }}
                                            </h3>
                                            <div class="flex items-center mt-1 space-x-3">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs">
                                                    {{ $laporan->tahun }}
                                                </span>
                                                @if ($laporan->published)
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 bg-green-100 text-green-800 rounded-full text-xs">
                                                        Published
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 bg-gray-100 text-gray-800 rounded-full text-xs">
                                                        Draft
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.laporan.edit', $laporan) }}"
                                                class="p-1 text-gray-400 hover:text-blue-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.laporan.destroy', $laporan) }}" method="POST"
                                                onsubmit="return confirm('Hapus laporan?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 text-gray-400 hover:text-red-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ asset('storage/' . $laporan->file) }}" target="_blank"
                                            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            Lihat PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada laporan</h3>
                        <p class="mt-2 text-gray-500">Mulai dengan mengupload laporan tahunan pertama Anda.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($laporans->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Menampilkan
                            <span class="font-medium">{{ $laporans->firstItem() }}</span>
                            sampai
                            <span class="font-medium">{{ $laporans->lastItem() }}</span>
                            dari
                            <span class="font-medium">{{ $laporans->total() }}</span> data
                        </div>
                        <div class="flex space-x-2">
                            {{ $laporans->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Optional: Add confirmation for delete
        function confirmDelete(event) {
            if (!confirm('Apakah Anda yakin ingin menghapus laporan ini?')) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>

    <style>
        /* Custom pagination styling */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 2px;
        }

        .pagination li a,
        .pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination li a {
            color: #4b5563;
            border: 1px solid #e5e7eb;
            background-color: white;
        }

        .pagination li a:hover {
            background-color: #f9fafb;
            border-color: #d1d5db;
        }

        .pagination li.active span {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .pagination li.disabled span {
            color: #9ca3af;
            background-color: #f3f4f6;
            border-color: #e5e7eb;
        }
    </style>
@endsection
