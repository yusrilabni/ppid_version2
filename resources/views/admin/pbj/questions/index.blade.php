@extends('admin.layouts.app')

@section('title', 'Kelola Pertanyaan PBJ')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Kelola Pertanyaan PBJ</h1>
            <p class="text-gray-600">Buat, atur, dan susun pertanyaan untuk kuesioner PBJ per tahun.</p>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.pbj-questions.create') }}"
                class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 whitespace-nowrap">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pertanyaan
            </a>

            <div x-data="{ duplicateModalOpen: false }">
                <button @click="duplicateModalOpen = true" class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 whitespace-nowrap">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8l4-4 4 4V7m0 3V9a2 2 0 00-2-2h-4a2 2 0 00-2 2v10a2 2 0 002 2h4a2 2 0 002-2v-1M8 10H5a2 2 0 00-2 2v5a2 2 0 002 2h2m0-7H5"></path></svg>
                    Duplikasi Pertanyaan
                </button>

                <template x-if="duplicateModalOpen">
                    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div @click="duplicateModalOpen = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Duplikasi Pertanyaan
                                    </h3>
                                    <div class="mt-2">
                                        <form action="{{ route('admin.pbj-questions.duplicate') }}" method="POST">
                                            @csrf
                                            <div class="space-y-4">
                                                <div>
                                                    <label for="source_year" class="block text-sm font-medium text-gray-700">Duplikasi dari Tahun:</label>
                                                    <select name="source_year" id="source_year" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                                        @foreach($questionsByYear->keys() as $year)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="destination_year" class="block text-sm font-medium text-gray-700">Ke Tahun:</label>
                                                    <input type="number" name="destination_year" id="destination_year" value="{{ ($questionsByYear->keys()->max() ?? date('Y')) + 1 }}" min="2000" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                            </div>
                                            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:col-start-2 sm:text-sm">
                                                    Duplikasi
                                                </button>
                                                <button type="button" @click="duplicateModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="space-y-8">
    @forelse ($questionsByYear as $year => $questions)
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Tahun {{ $year }}</h2>
                <form action="{{ route('admin.pbj-questions.delete-year', $year) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua pertanyaan untuk tahun {{ $year }} ini? Tindakan ini tidak dapat dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus Tahun {{ $year }}
                    </button>
                </form>
            </div>

            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-600">No.</span>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-600">Pertanyaan</span>
                            </th>
                            <th class="py-4 px-6 text-left w-48">
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php $number = 1; @endphp
                        @foreach ($questions as $question)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-4 px-6 font-bold" style="width: 150px;">{{ $number++ }}.</td>
                                <td class="py-4 px-6 text-gray-800 {{ $question->is_category ? 'font-bold' : '' }}">{{ $question->question }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.pbj-questions.edit', $question->id) }}" class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.pbj-questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Yakin hapus? Ini akan menghapus semua pertanyaan anak di dalamnya.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @if ($question->children->isNotEmpty())
                                @include('admin.pbj.questions._question_children', ['children' => $question->children, 'level' => 1])
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada pertanyaan</h3>
            <p class="mt-2 text-gray-500">Mulai dengan membuat pertanyaan pertama Anda.</p>
            <a href="{{ route('admin.pbj-questions.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                Buat Pertanyaan
            </a>
        </div>
    @endforelse
    </div>
</div>
@endsection
