@extends('admin.layouts.app')

@section('title', 'Tambah Pertanyaan PBJ')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Tambah Pertanyaan Baru</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Buat pertanyaan untuk kuesioner PBJ. Anda dapat membuat kategori, pertanyaan utama, atau
                            pertanyaan turunan.
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Formulir Pertanyaan Baru</h2>
                            <p class="text-sm text-gray-600 mt-1">Isi detail pertanyaan untuk kuesioner PBJ</p>
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
                <form action="{{ route('admin.pbj-questions.store') }}" method="POST" class="p-6"
                    x-data="questionForm()" x-init="initForm()">
                    @csrf

                    <!-- Common Fields -->
                    <div class="space-y-6 bg-gray-50 p-6 rounded-lg border border-gray-200 mb-8">
                        <div class="flex items-center mb-4">
                            <div class="h-8 w-1 bg-blue-600 rounded-full mr-3"></div>
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Umum</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <label for="parent_id" class="block text-sm font-medium text-gray-800">
                                    <span class="flex items-center">
                                        Induk Pertanyaan
                                        <span class="ml-1 text-xs text-gray-500 font-normal">(Opsional)</span>
                                    </span>
                                </label>
                                <div class="relative">
                                    <select name="parent_id" id="parent_id" x-ref="parent_id" @change="parentChanged"
                                        onfocus="handleParentFocus(this)"
                                        onblur="handleParentBlur(this)"
                                        class="w-full pl-4 pr-10 py-3.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 bg-white">
                                        <option value="">-- Pilih Induk Pertanyaan --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                title="{{ $category->full_question }}"
                                                data-full="{!! $category->question !!} ({{ $category->year }})"
                                                {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                                {!! $category->question !!} ({{ $category->year }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    Pilih jika pertanyaan ini merupakan bagian dari pertanyaan lain. Kosongkan untuk
                                    pertanyaan utama.
                                </p>
                            </div>

                            <div class="space-y-3">
                                <label for="year" class="block text-sm font-medium text-gray-800">
                                    <span class="flex items-center">
                                        Tahun
                                        <span class="text-red-500 ml-1">*</span>
                                    </span>
                                </label>
                                <input type="number" name="year" id="year" x-model="year" required min="2000"
                                    max="2100" step="1"
                                    class="w-full px-4 py-3.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    :class="{ 'bg-gray-100': isParentSelected }" :readonly="isParentSelected">
                                <p class="text-xs text-gray-500 mt-1">
                                    Tahun kuesioner. Akan otomatis terisi jika memilih induk pertanyaan.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="flex items-start space-x-3 p-4 bg-white border border-gray-200 rounded-lg">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="is_category" value="1" id="is_category"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </div>
                                <div class="flex-1">
                                    <label for="is_category" class="text-sm font-medium text-gray-800 cursor-pointer">
                                        Jadikan sebagai Kategori
                                    </label>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Centang jika pertanyaan ini hanya sebagai judul kategori (tidak untuk dijawab
                                        langsung).
                                        Kategori digunakan untuk mengelompokkan beberapa pertanyaan terkait.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Questions List -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <div class="flex items-center mb-2">
                                    <div class="h-8 w-1 bg-blue-600 rounded-full mr-3"></div>
                                    <h3 class="text-lg font-semibold text-gray-900">Daftar Pertanyaan</h3>
                                </div>
                                <p class="text-sm text-gray-600 ml-4">
                                    Tambahkan satu atau beberapa pertanyaan sekaligus
                                </p>
                            </div>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                <span x-text="questions.length"></span> pertanyaan
                            </span>
                        </div>

                        <div class="space-y-4" x-show="questions.length > 0">
                            <template x-for="(question, index) in questions" :key="index">
                                <div
                                    class="relative p-6 bg-white rounded-xl border border-gray-200 shadow-sm hover:border-blue-300 transition-colors duration-200">
                                    <!-- Question Header -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <div
                                                class="flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-700 rounded-full font-semibold">
                                                <span x-text="index + 1"></span>
                                            </div>
                                            <span class="ml-3 text-sm font-medium text-gray-700">
                                                Pertanyaan #<span x-text="index + 1"></span>
                                            </span>
                                        </div>
                                        <button type="button" @click="removeQuestion(index)"
                                            class="text-gray-400 hover:text-red-500 p-1 transition-colors"
                                            x-show="questions.length > 1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Question Content -->
                                    <div class="space-y-5">
                                        <div>
                                            <label :for="'question_text_' + index"
                                                class="block text-sm font-medium text-gray-800 mb-2">
                                                <span class="flex items-center">
                                                    Teks Pertanyaan
                                                    <span class="text-red-500 ml-1">*</span>
                                                </span>
                                            </label>
                                            <textarea :name="'questions[' + index + '][question]'" :id="'question_text_' + index" rows="3"
                                                x-model="question.question" required placeholder="Masukkan teks pertanyaan di sini..."
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 resize-none"></textarea>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label :for="'question_order_' + index"
                                                    class="block text-sm font-medium text-gray-800 mb-2">
                                                    <span class="flex items-center">
                                                        Urutan Tampilan
                                                        <span class="text-red-500 ml-1">*</span>
                                                    </span>
                                                </label>
                                                <div class="relative">
                                                    <input type="number" :name="'questions[' + index + '][order]'"
                                                        :id="'question_order_' + index" x-model="question.order" required
                                                        min="1"
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Urutan pertanyaan dalam kuesioner
                                                </p>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-800 mb-3">
                                                    Tipe Pengumpulan Jawaban
                                                </label>
                                                <div class="grid grid-cols-3 gap-2">
                                                    <div>
                                                        <input type="radio"
                                                            :name="'questions[' + index + '][submission_type]'"
                                                            :id="'submission_type_none_' + index" value="none"
                                                            x-model="question.submission_type" class="sr-only peer">
                                                        <label :for="'submission_type_none_' + index"
                                                            class="flex flex-col items-center p-3 border border-gray-300 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-colors">
                                                            <svg class="w-5 h-5 text-gray-600 mb-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <span class="text-xs font-medium">Tanpa</span>
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input type="radio"
                                                            :name="'questions[' + index + '][submission_type]'"
                                                            :id="'submission_type_link_' + index" value="link"
                                                            x-model="question.submission_type" class="sr-only peer">
                                                        <label :for="'submission_type_link_' + index"
                                                            class="flex flex-col items-center p-3 border border-gray-300 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-colors">
                                                            <svg class="w-5 h-5 text-gray-600 mb-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                            </svg>
                                                            <span class="text-xs font-medium">Link</span>
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input type="radio"
                                                            :name="'questions[' + index + '][submission_type]'"
                                                            :id="'submission_type_file_' + index" value="file"
                                                            x-model="question.submission_type" class="sr-only peer">
                                                        <label :for="'submission_type_file_' + index"
                                                            class="flex flex-col items-center p-3 border border-gray-300 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-colors">
                                                            <svg class="w-5 h-5 text-gray-600 mb-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            <span class="text-xs font-medium">File</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Empty State -->
                        <div x-show="questions.length === 0"
                            class="text-center py-12 border-2 border-dashed border-gray-300 rounded-xl">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pertanyaan</h3>
                            <p class="text-gray-600 mb-4">Tambahkan pertanyaan pertama Anda menggunakan tombol di bawah</p>
                            <button type="button" @click="addQuestion()"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah Pertanyaan
                            </button>
                        </div>

                        <!-- Add Question Button -->
                        <div class="pt-4" x-show="questions.length > 0">
                            <button type="button" @click="addQuestion()"
                                class="inline-flex items-center px-4 py-3 bg-white border-2 border-dashed border-blue-300 text-blue-600 rounded-lg hover:bg-blue-50 hover:border-blue-400 transition-colors duration-200 w-full justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah Pertanyaan Lain
                            </button>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="pt-8 border-t border-gray-200 mt-8">
                        <div class="flex flex-col sm:flex-row justify-end gap-3">
                            <a href="{{ route('admin.pbj-questions.index') }}"
                                class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors text-center">
                                Batalkan
                            </a>
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-sm transition-all hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Simpan Semua Pertanyaan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                questions: [{
                    question: '',
                    order: 1,
                    submission_type: 'none'
                }],
                year: '{{ old('year', date('Y')) }}',
                categories: @json($categories),
                all_questions: @json($all_questions),
                isParentSelected: false,

                initForm() {
                    // Set initial state
                    const parentSelect = this.$refs.parent_id;
                    this.isParentSelected = parentSelect.value !== '';

                    // If there's old input for questions, use it
                    @if (old('questions'))
                        this.questions = @json(old('questions'));
                    @endif
                },

                parentChanged() {
                    const selectedId = this.$refs.parent_id.value;
                    this.isParentSelected = selectedId !== '';

                    if (selectedId) {
                        const category = this.categories.find(c => c.id == selectedId);
                        if (category) {
                            this.year = category.year;
                        }

                        const children = this.all_questions.filter(q => q.parent_id == selectedId);
                        let lastOrder = 0;
                        if (children.length > 0) {
                            lastOrder = Math.max(...children.map(c => c.order));
                        }

                        this.questions.forEach((question, index) => {
                            question.order = lastOrder + 1 + index;
                        });
                    } else {
                        // Reset order if no parent is selected
                        this.questions.forEach((question, index) => {
                            question.order = index + 1;
                        });
                    }
                },

                addQuestion() {
                    let nextOrder = 1;
                    if (this.questions.length > 0) {
                        nextOrder = this.questions[this.questions.length - 1].order + 1;
                    } else {
                        const selectedId = this.$refs.parent_id.value;
                        if (selectedId) {
                            const children = this.all_questions.filter(q => q.parent_id == selectedId);
                            if (children.length > 0) {
                                nextOrder = Math.max(...children.map(c => c.order)) + 1;
                            }
                        }
                    }
                    this.questions.push({
                        question: '',
                        order: nextOrder,
                        submission_type: 'none'
                    });

                    // Scroll to new question
                    this.$nextTick(() => {
                        const newQuestion = document.querySelector(`[x-for]`).lastElementChild;
                        newQuestion.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    });
                },

                removeQuestion(index) {
                    if (this.questions.length > 1) {
                        this.questions.splice(index, 1);
                        // Re-order remaining questions
                        this.parentChanged();
                    } else {
                        // If only one question left, just clear it
                        this.questions[0] = {
                            question: '',
                            order: 1,
                            submission_type: 'none'
                        };
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom scrollbar for select */
        select::-webkit-scrollbar {
            width: 8px;
        }

        select::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        select::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        select::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Smooth transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }
    </style>
@endsection
