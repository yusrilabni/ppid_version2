@extends('admin.layouts.app')

@section('title', 'Edit Pertanyaan PBJ')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Edit Pertanyaan</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Perbarui detail pertanyaan untuk kuesioner PBJ.
                    </p>
                </div>
                <a href="{{ route('admin.pbj-questions.index') }}"
                    class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Card Header -->
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Formulir Edit Pertanyaan</h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui detail pertanyaan yang sudah ada.</p>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="mx-6 mt-4 rounded-lg bg-red-50 p-4 border border-red-200" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Terdapat {{ $errors->count() }} kesalahan dalam pengisian formulir
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.pbj-questions.update', $pbj_question->id) }}" method="POST" class="p-6" x-data="questionForm()">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Pertanyaan -->
                    <div>
                        <label for="question" class="block text-sm font-medium text-gray-800 mb-2">
                            Teks Pertanyaan / Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <textarea name="question" id="question" rows="4" required placeholder="Contoh: Apakah RUP diumumkan?" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 placeholder-gray-400">{{ old('question', $pbj_question->question) }}</textarea>
                    </div>

                    <!-- Parent, Order, and Year Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="parent_id" class="block text-sm font-medium text-gray-800">Induk Pertanyaan</label>
                             <div class="relative">
                                <select name="parent_id" id="parent_id" x-ref="parent_id" @change="updateYear" 
                                    onfocus="handleParentFocus(this)"
                                    onblur="handleParentBlur(this)"
                                    class="w-full pl-4 pr-10 py-3.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 bg-white">
                                    <option value="">-- Jadikan Kategori / Pertanyaan Langsung --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            title="{{ $category->full_question }}"
                                            data-full="{!! $category->question !!} ({{ $category->year }})"
                                            @if(old('parent_id', $pbj_question->parent_id) == $category->id) selected @endif>
                                            {!! $category->question !!} ({{ $category->year }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="text-xs text-gray-500">Pilih induk jika ini adalah anak pertanyaan.</p>
                        </div>
                        <div class="space-y-2">
                            <label for="year" class="block text-sm font-medium text-gray-800">
                                Tahun <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="year" id="year" x-model="year" required min="2000" max="2100" step="1"
                                class="w-full px-4 py-3.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <p class="text-xs text-gray-500">Tahun kuesioner pertanyaan ini.</p>
                        </div>
                    </div>
                     <div class="space-y-2">
                            <label for="order" class="block text-sm font-medium text-gray-800">
                                Urutan <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="order" id="order" value="{{ old('order', $pbj_question->order) }}" required min="1" class="w-full px-4 py-3.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <p class="text-xs text-gray-500">Nomor urut untuk menampilkan pertanyaan.</p>
                        </div>

                    <!-- Is Category -->
                    <div class="mt-6">
                        <div class="flex items-start space-x-3 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="is_category" value="1" id="is_category" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" @if(old('is_category', $pbj_question->is_category)) checked @endif>
                            </div>
                            <div class="flex-1">
                                <label for="is_category" class="text-sm font-medium text-gray-800 cursor-pointer">
                                    Jadikan sebagai Kategori
                                </label>
                                <p class="text-xs text-gray-500 mt-1">
                                    Centang jika pertanyaan ini hanya sebagai judul kategori (tidak untuk dijawab langsung).
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    @php
                        $submission_type = old('submission_type', $pbj_question->requires_link_submission ? 'link' : ($pbj_question->requires_file_submission ? 'file' : 'none'));
                    @endphp
                    <!-- Dokumen Pendukung Section -->
                    <div class="pt-6 border-t border-gray-200">
                        <label class="block text-sm font-medium text-gray-800 mb-3">
                            Tipe Pengumpulan Jawaban
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <input type="radio" name="submission_type" value="none" id="submission_type_none" class="sr-only peer" @if($submission_type == 'none') checked @endif>
                                <label for="submission_type_none" class="flex flex-col items-center justify-center p-4 border border-gray-300 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-colors">
                                    <svg class="w-6 h-6 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span class="text-sm font-medium">Tanpa Jawaban</span>
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="submission_type" value="link" id="submission_type_link" class="sr-only peer" @if($submission_type == 'link') checked @endif>
                                <label for="submission_type_link" class="flex flex-col items-center justify-center p-4 border border-gray-300 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-colors">
                                    <svg class="w-6 h-6 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                    <span class="text-sm font-medium">Minta Link</span>
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="submission_type" value="file" id="submission_type_file" class="sr-only peer" @if($submission_type == 'file') checked @endif>
                                <label for="submission_type_file" class="flex flex-col items-center justify-center p-4 border border-gray-300 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-colors">
                                    <svg class="w-6 h-6 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    <span class="text-sm font-medium">Minta File</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="pt-8 border-t border-gray-200 mt-8">
                    <div class="flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('admin.pbj-questions.index') }}"
                            class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors text-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-sm transition-all hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function handleParentFocus(select) {
        Array.from(select.options).forEach(opt => {
            if (opt.value && opt.dataset.full) {
                opt.text = opt.dataset.full;
            }
        });
    }

    function handleParentBlur(select) {
        Array.from(select.options).forEach(opt => {
            if (opt.selected && opt.value !== '') {
                let text = opt.dataset.full || opt.text;
                if (text.length > 70) {
                    opt.text = text.substring(0, 70) + '...';
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const parentSelect = document.getElementById('parent_id');
        if (parentSelect) {
            handleParentBlur(parentSelect);
        }
    });

    function questionForm() {
        return {
            year: '{{ old('year', $pbj_question->year) }}',
            categories: @json($categories),
            updateYear() {
                const selectedId = this.$refs.parent_id.value;
                if (selectedId) {
                    const category = this.categories.find(c => c.id == selectedId);
                    if (category) {
                        this.year = category.year;
                    }
                }
            }
        }
    }
</script>
@endpush