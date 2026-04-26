@extends('admin.layouts.app')

@section('title', 'Kelola Survei: ' . $survey->title)

@section('content')
    {{-- Include SortableJS --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <div class="max-w-6xl mx-auto">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelola Survei</h1>
                        <span
                            class="px-3 py-1 text-xs font-semibold rounded-full 
                        @if ($survey->status === 'Aktif') bg-green-100 text-green-800
                        @elseif($survey->status === 'Nonaktif') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                            {{ $survey->status }}
                        </span>
                    </div>
                    <p class="text-lg text-gray-700">{{ $survey->title }}</p>
                </div>
                <a href="{{ route('admin.surveys.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200">
                    <i class="fas fa-arrow-left text-sm"></i>
                    Kembali ke Daftar
                </a>
            </div>

            <!-- Survey Details Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Survei</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                                    Survei</label>
                                <p class="mt-1 text-sm text-gray-900 capitalize">{{ $survey->type }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal
                                    Mulai</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $survey->start_date ? \Carbon\Carbon::parse($survey->start_date)->format('d M Y, H:i') : '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $survey->description ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal
                                    Selesai</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $survey->end_date ? \Carbon\Carbon::parse($survey->end_date)->format('d M Y, H:i') : '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Link
                                    Preview</label>
                                <div class="mt-2">
                                    @if ($survey->type === 'default')
                                        <a href="{{ url('/laporan/survei') }}" target="_blank"
                                            class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 hover:underline">
                                            <i class="fas fa-external-link-alt text-xs"></i>
                                            {{ str_replace(['http://', 'https://'], '', url('/laporan/survei')) }}
                                        </a>
                                    @else
                                        <a href="{{ route('public.surveys.show', $survey) }}" target="_blank"
                                            class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 hover:underline">
                                            <i class="fas fa-external-link-alt text-xs"></i>
                                            Preview Survei
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Statistik</label>
                                <div class="flex items-center gap-4 mt-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-layer-group text-blue-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $survey->sections->count() }}
                                            </p>
                                            <p class="text-xs text-gray-500">Bagian</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-question-circle text-green-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">
                                                {{ $survey->questions->count() }}</p>
                                            <p class="text-xs text-gray-500">Pertanyaan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Questions Management Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Manajemen Pertanyaan & Bagian</h2>
                            <p class="text-sm text-gray-600 mt-1">Kelola struktur survei Anda</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="button"
                                onclick="document.getElementById('createSectionModal').classList.remove('hidden')"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-50 border border-indigo-200 rounded-lg text-sm font-medium text-indigo-700 hover:bg-indigo-100 hover:border-indigo-300 transition-colors duration-200">
                                <i class="fas fa-layer-group text-sm"></i>
                                Tambah Bagian
                            </button>
                            <a href="{{ route('admin.surveys.questions.create', $survey) }}"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 border border-blue-600 rounded-lg text-sm font-medium text-white hover:bg-blue-700 hover:border-blue-700 transition-colors duration-200">
                                <i class="fas fa-plus text-sm"></i>
                                Tambah Pertanyaan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sections and Questions List -->
                <div class="p-6 space-y-6 relative">
                    <div id="savingOrderIndicator" class="hidden absolute top-0 right-0 m-4 px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-full shadow-lg z-50 animate-pulse">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan Urutan...
                    </div>

                    @php
                        $questionsBySection = $survey->questions->groupBy('section_id');
                        $sections = $survey->sections;
                    @endphp

                    <!-- General Questions -->
                    @if (isset($questionsBySection['']) && $questionsBySection['']->count() > 0)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Pertanyaan Umum</h3>
                                        <p class="text-xs text-gray-500 mt-1">Pertanyaan tanpa bagian spesifik</p>
                                    </div>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                                        {{ $questionsBySection['']->count() }} pertanyaan
                                    </span>
                                </div>
                            </div>
                            <div class="divide-y divide-gray-100 sortable-container" data-section-id="">
                                @foreach ($questionsBySection['']->sortBy('order') as $question)
                                    <div class="px-4 py-3 hover:bg-gray-50 transition-colors duration-150 relative bg-white" data-id="{{ $question->id }}">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    {{-- Drag Handle --}}
                                                    <div class="cursor-move p-2 text-gray-300 hover:text-blue-500 drag-handle">
                                                        <i class="fas fa-grip-vertical"></i>
                                                    </div>
                                                    <span
                                                        class="flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">
                                                        {{ $loop->iteration }}
                                                    </span>
                                                    <p class="font-medium text-gray-900">{{ $question->question_text }}</p>
                                                    @if ($question->is_required)
                                                        <span
                                                            class="px-2 py-0.5 text-xs font-medium bg-red-100 text-red-700 rounded">Wajib</span>
                                                    @endif
                                                </div>
                                                <div class="ml-10 flex items-center gap-3">
                                                    <span
                                                        class="text-xs px-2.5 py-1 bg-gray-100 text-gray-700 rounded-full">
                                                        {{ str_replace('_', ' ', $question->question_type) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-1 ml-4">
                                                <a href="{{ route('admin.surveys.questions.edit', [$survey, $question]) }}"
                                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                    title="Edit">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </a>
                                                <form action="{{ route('admin.surveys.questions.destroy', [$survey, $question]) }}"
                                                    method="POST" onsubmit="return confirm('Hapus pertanyaan ini?');"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                                        title="Hapus">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Sections -->
                    @foreach ($sections as $section)
                        <div
                            class="border border-gray-200 rounded-lg overflow-hidden hover:border-gray-300 transition-colors duration-200">
                            <div class="bg-gradient-to-r from-indigo-50 to-white px-4 py-4 border-b border-gray-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-layer-group text-indigo-600"></i>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <h3 class="font-bold text-gray-900">{{ $section->title }}</h3>
                                                    <span
                                                        class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-medium rounded-full">
                                                        {{ isset($questionsBySection[$section->id]) ? $questionsBySection[$section->id]->count() : 0 }}
                                                        pertanyaan
                                                    </span>
                                                </div>
                                                @if ($section->description)
                                                    <p class="text-sm text-gray-600 mt-1">{{ $section->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="button"
                                            onclick="openEditSectionModal('{{ $section->id }}', '{{ $section->title }}', '{{ $section->description }}', '{{ $section->order }}')"
                                            class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200"
                                            title="Edit Bagian">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        <form action="{{ url('/v2/admin/surveys/sections/' . $section->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus bagian ini? Pertanyaan akan tetap ada tanpa bagian.');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                                title="Hapus Bagian">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Questions in Section -->
                            <div class="divide-y divide-gray-100 sortable-container" data-section-id="{{ $section->id }}">
                                @if (isset($questionsBySection[$section->id]) && $questionsBySection[$section->id]->count() > 0)
                                    @foreach ($questionsBySection[$section->id]->sortBy('order') as $question)
                                        <div class="px-4 py-3 hover:bg-gray-50 transition-colors duration-150 relative bg-white" data-id="{{ $question->id }}">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        {{-- Drag Handle --}}
                                                        <div class="cursor-move p-2 text-gray-300 hover:text-blue-500 drag-handle">
                                                            <i class="fas fa-grip-vertical"></i>
                                                        </div>
                                                        <span
                                                            class="flex items-center justify-center w-6 h-6 bg-gray-100 text-gray-700 text-xs font-bold rounded-full">
                                                            {{ $loop->iteration }}
                                                        </span>
                                                        <p class="font-medium text-gray-900">
                                                            {{ $question->question_text }}</p>
                                                        @if ($question->is_required)
                                                            <span
                                                                class="px-2 py-0.5 text-xs font-medium bg-red-100 text-red-700 rounded">Wajib</span>
                                                        @endif
                                                    </div>
                                                    <div class="ml-10 flex items-center gap-3">
                                                        <span
                                                            class="text-xs px-2.5 py-1 bg-gray-100 text-gray-700 rounded-full">
                                                            {{ str_replace('_', ' ', $question->question_type) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-1 ml-4">
                                                    <a href="{{ route('admin.surveys.questions.edit', [$survey, $question]) }}"
                                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                        title="Edit">
                                                        <i class="fas fa-edit text-sm"></i>
                                                    </a>
                                                    <form action="{{ route('admin.surveys.questions.destroy', [$survey, $question]) }}"
                                                        method="POST" onsubmit="return confirm('Hapus pertanyaan ini?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                                            title="Hapus">
                                                            <i class="fas fa-trash text-sm"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="px-4 py-8 text-center bg-white">
                                        <div
                                            class="w-12 h-12 mx-auto mb-3 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-question-circle text-gray-300 text-xl"></i>
                                        </div>
                                        <p class="text-gray-500 text-sm">Belum ada pertanyaan di bagian ini</p>
                                        <a href="{{ route('admin.surveys.questions.create', $survey) }}"
                                            class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                                            <i class="fas fa-plus text-xs"></i>
                                            Tambah Pertanyaan
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <!-- Modals Section -->
    <div id="createSectionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('createSectionModal').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <form action="{{ route('admin.surveys.sections.store', $survey) }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tambah Bagian Baru</h3>
                        <div class="space-y-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Judul Bagian</label><input type="text" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label><textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label><input type="number" name="order" value="{{ $sections->count() + 1 }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-row-reverse gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">Simpan</button>
                        <button type="button" onclick="document.getElementById('createSectionModal').classList.add('hidden')" class="bg-white border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium text-gray-700">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editSectionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('editSectionModal').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <form id="editSectionForm" method="POST">
                    @csrf @method('PUT')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Bagian</h3>
                        <div class="space-y-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Judul Bagian</label><input type="text" name="title" id="edit_section_title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label><textarea name="description" id="edit_section_description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label><input type="number" name="order" id="edit_section_order" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-row-reverse gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">Update</button>
                        <button type="button" onclick="document.getElementById('editSectionModal').classList.add('hidden')" class="bg-white border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium text-gray-700">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const containers = document.querySelectorAll('.sortable-container');
            const indicator = document.getElementById('savingOrderIndicator');

            containers.forEach(container => {
                new Sortable(container, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'bg-blue-50',
                    onEnd: function(evt) {
                        const orders = {};
                        container.querySelectorAll('[data-id]').forEach((el, index) => {
                            orders[el.dataset.id] = index + 1;
                        });

                        indicator.classList.remove('hidden');

                        fetch("{{ route('admin.surveys.questions.reorder', $survey) }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ orders: orders })
                        })
                        .then(response => response.json())
                        .then(data => {
                            setTimeout(() => indicator.classList.add('hidden'), 500);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Gagal menyimpan urutan.');
                            indicator.classList.add('hidden');
                        });
                    }
                });
            });
        });

        function openEditSectionModal(id, title, description, order) {
            document.getElementById('editSectionForm').action = "/v2/admin/surveys/sections/" + id;
            document.getElementById('edit_section_title').value = title;
            document.getElementById('edit_section_description').value = description || '';
            document.getElementById('edit_section_order').value = order;
            document.getElementById('editSectionModal').classList.remove('hidden');
        }
    </script>
@endsection
