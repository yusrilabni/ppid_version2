@extends('admin.layouts.app')

@section('title', 'Daftar Survei')

@section('content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Daftar Survei Kepuasan</h1>
                    <p class="mt-2 text-sm text-gray-600">Kelola semua survei kepuasan pelanggan Anda di satu tempat</p>
                </div>
                <a href="{{ route('admin.surveys.create') }}"
                    class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-plus-circle text-lg"></i>
                    <span>Buat Survei Baru</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-700">Total Survei</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $surveys->total() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <i class="fas fa-clipboard-list text-2xl text-blue-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-700">Survei Aktif</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">
                            {{ $surveys->where('status', 'Aktif')->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-xl">
                        <i class="fas fa-check-circle text-2xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-700">Total Respon</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">
                            {{ $surveys->sum(function ($survey) {return $survey->responses->count();}) }}
                        </p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-xl">
                        <i class="fas fa-poll text-2xl text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Surveys Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-heading text-gray-500"></i>
                                    <span>Judul Survei</span>
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-id-card text-gray-500"></i>
                                    <span>ID Publik</span>
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-chart-line text-gray-500"></i>
                                    <span>Status</span>
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-question-circle text-gray-500"></i>
                                    <span>Pertanyaan</span>
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-users text-gray-500"></i>
                                    <span>Respon</span>
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center justify-end gap-2">
                                    <i class="fas fa-cogs text-gray-500"></i>
                                    <span>Aksi</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($surveys as $survey)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-5">
                                    <div>
                                        <div class="flex items-start gap-3">
                                            <div class="p-2 bg-blue-50 rounded-lg">
                                                <i class="fas fa-clipboard-check text-blue-600"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900">{{ $survey->title }}</h4>
                                                <p class="mt-1 text-sm text-gray-500 line-clamp-2">
                                                    {{ $survey->description }}</p>
                                                <div class="mt-2 flex items-center gap-2 text-xs text-gray-400">
                                                    <i class="far fa-calendar"></i>
                                                    <span>Dibuat: {{ $survey->created_at->format('d M Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="inline-flex items-center gap-2 bg-gray-50 px-3 py-1.5 rounded-lg">
                                        <i class="fas fa-hashtag text-gray-400 text-sm"></i>
                                        <code class="text-sm font-mono text-gray-700">{{ $survey->public_id }}</code>
                                        <button onclick="copyToClipboard('{{ $survey->public_id }}')"
                                            class="text-gray-400 hover:text-blue-600 transition-colors" title="Copy ID">
                                            <i class="fas fa-copy text-sm"></i>
                                        </button>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-2">
                                        <div>
                                            @if ($survey->status === 'Aktif')
                                                <span
                                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                                    <i class="fas fa-circle text-[8px]"></i>
                                                    Aktif
                                                </span>
                                            @elseif ($survey->status === 'Nonaktif')
                                                <span
                                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                                    <i class="fas fa-circle text-[8px]"></i>
                                                    Nonaktif
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    <i class="fas fa-circle text-[8px]"></i>
                                                    Draft
                                                </span>
                                            @endif
                                        </div>
                                        @if ($survey->type === 'default')
                                            <div>
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                                    <i class="fas fa-star text-[10px]"></i>
                                                    Default
                                                </span>
                                            </div>
                                        @elseif ($survey->type === 'skm')
                                            <div>
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                    <i class="fas fa-poll text-[10px]"></i>
                                                    SKM
                                                </span>
                                            </div>
                                        @elseif ($survey->type === 'ppid')
                                            <div>
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">
                                                    <i class="fas fa-info-circle text-[10px]"></i>
                                                    Survei PPID
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center">
                                            <span class="font-bold text-indigo-700">{{ $survey->questions->count() }}</span>
                                        </div>
                                        <span class="text-sm text-gray-600">pertanyaan</span>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center">
                                            <span
                                                class="font-bold text-emerald-700">{{ $survey->responses->count() }}</span>
                                        </div>
                                        <span class="text-sm text-gray-600">respon</span>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-end items-center gap-2">
                                        <!-- Preview Button -->
                                        <a href="{{ route('public.surveys.show', $survey) }}" target="_blank"
                                            class="p-2.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 group"
                                            title="Preview Survei">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>

                                        <!-- Manage Questions Button -->
                                        <a href="{{ route('admin.surveys.show', $survey) }}"
                                            class="p-2.5 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200 group"
                                            title="Kelola Pertanyaan">
                                            <i class="fas fa-list-ol"></i>
                                        </a>

                                        <!-- View Responses Button -->
                                        <a href="{{ route('admin.surveys.responses.index', $survey) }}"
                                            class="p-2.5 text-gray-500 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-all duration-200 group"
                                            title="Lihat Respon">
                                            <i class="fas fa-chart-bar"></i>
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.surveys.edit', $survey) }}"
                                            class="p-2.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all duration-200 group"
                                            title="Edit Survei">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.surveys.destroy', $survey) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus survei ini? Tindakan ini tidak dapat dibatalkan.');"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200 group"
                                                title="Hapus Survei">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-24 h-24 mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-clipboard-list text-4xl text-gray-400"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada survei</h3>
                                        <p class="text-gray-500 mb-6">Mulai dengan membuat survei pertama Anda</p>
                                        <a href="{{ route('admin.surveys.create') }}"
                                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-lg transition-colors">
                                            <i class="fas fa-plus"></i>
                                            <span>Buat Survei Pertama</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($surveys->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Menampilkan
                            <span class="font-medium">{{ $surveys->firstItem() }}</span>
                            sampai
                            <span class="font-medium">{{ $surveys->lastItem() }}</span>
                            dari
                            <span class="font-medium">{{ $surveys->total() }}</span>
                            survei
                        </div>
                        <div class="flex items-center space-x-2">
                            {{ $surveys->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    // Show notification or alert
                    alert('ID survei berhasil disalin: ' + text);
                }).catch(err => {
                    console.error('Gagal menyalin: ', err);
                });
            }
        </script>
        <style>
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* Smooth hover transitions */
            .hover-lift:hover {
                transform: translateY(-2px);
                transition: transform 0.2s ease;
            }
        </style>
    @endpush
@endsection
