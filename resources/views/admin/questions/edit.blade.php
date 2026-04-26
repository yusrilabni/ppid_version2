@extends('admin.layouts.app')

@section('title', 'Edit Pertanyaan: ' . $question->survey->title)

@section('content')
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Edit Pertanyaan</h1>
                    <p class="text-gray-600 mt-1">Survei: {{ $question->survey->title }}</p>
                </div>
                <a href="{{ route('admin.surveys.show', $question->survey) }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>

            <!-- Form Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" 
                 x-data="questionForm(
                    {{ json_encode($errors->get('options.*.text')) }}, 
                    {{ old('options') ? json_encode(old('options')) : json_encode($question->options->map(fn($o) => ['text' => $o->option_text, 'value' => $o->value])) }},
                    '{{ old('question_type', $question->question_type) }}',
                    '{{ old('question_text', $question->question_text) }}'
                 )">
                
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex items-center">
                        <div class="p-2 rounded-lg bg-blue-100 text-blue-600 mr-3">
                            <i class="fas fa-edit text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Ubah Pertanyaan</h2>
                            <p class="text-sm text-gray-600">Perbarui detail, jenis, atau opsi jawaban</p>
                        </div>
                    </div>
                </div>

                <!-- General Validation Errors -->
                @if ($errors->any())
                    <div class="mx-6 mt-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg relative" role="alert">
                        <strong class="font-bold text-sm">Ada kesalahan!</strong>
                        <ul class="mt-1 list-disc list-inside text-xs">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.surveys.questions.update', [$question->survey, $question]) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Question Text -->
                        <div class="form-group">
                            <label for="question_text" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-question-circle text-blue-500 mr-2 text-sm"></i>
                                Teks Pertanyaan *
                            </label>
                            <div class="relative">
                                <textarea name="question_text" id="question_text" rows="3"
                                    class="block w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out @error('question_text') border-red-500 @enderror"
                                    placeholder="Masukkan teks pertanyaan Anda" required x-model="question_text"></textarea>
                                <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                    <i class="fas fa-pen text-gray-400"></i>
                                </div>
                            </div>
                            @error('question_text')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Grid for Section and Type -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Section Selection -->
                            @php
                                $sections = $question->survey->sections;
                                $sectionCount = $sections->count();
                            @endphp
                            
                            @if ($sectionCount > 0)
                                <div class="form-group">
                                    <label for="section_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-layer-group text-blue-500 mr-2 text-sm"></i>
                                        Pilih Bagian
                                    </label>
                                    <div class="relative">
                                        <select name="section_id" id="section_id" class="block w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition duration-150 ease-in-out">
                                            <option value="">-- Tanpa Bagian (Umum) --</option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}" {{ old('section_id', $question->section_id) == $section->id ? 'selected' : '' }}>
                                                    {{ $section->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-folder text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Question Type -->
                            <div class="form-group">
                                <label for="question_type" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-list text-blue-500 mr-2 text-sm"></i>
                                    Jenis Pertanyaan
                                </label>
                                <div class="relative">
                                    <select name="question_type" id="question_type" x-model="question_type"
                                        class="block w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition duration-150 ease-in-out">
                                        <option value="Isian Singkat">Isian Singkat</option>
                                        <option value="Isian Panjang">Isian Panjang</option>
                                        <option value="Pilihan Ganda">Pilihan Ganda (Radio)</option>
                                        <option value="Pilihan Ganda (Berbobot)">Pilihan Ganda (Berbobot)</option>
                                        <option value="Checkbox">Checkbox (Pilihan Ganda Banyak)</option>
                                        <option value="Dropdown">Dropdown</option>
                                        <option value="Skala Kepuasan">Skala Kepuasan (1-5)</option>
                                        <option value="Email">Email</option>
                                        <option value="Numeric">Numeric</option>
                                        <option value="Url">Url</option>
                                    </select>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-tasks text-gray-400"></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Is Required Switch -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="flex items-center cursor-pointer group">
                                <div class="relative flex items-center">
                                    <input type="checkbox" name="is_required" value="1" class="sr-only peer" {{ $question->is_required ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors">Wajib diisi (Responden tidak dapat mengosongkan pertanyaan ini)</span>
                            </label>
                        </div>

                        <!-- Dynamic Options -->
                        <div x-show="requiresOptions()" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform -translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="space-y-4 bg-blue-50/50 p-6 rounded-xl border border-blue-100">
                            
                            <div class="flex justify-between items-center">
                                <h3 class="text-sm font-bold text-blue-800 uppercase tracking-wider flex items-center">
                                    <i class="fas fa-list-ol mr-2"></i>
                                    Opsi Jawaban
                                </h3>
                                <button @click.prevent="addOption()" type="button" 
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition duration-150">
                                    <i class="fas fa-plus mr-1.5"></i> Tambah Opsi
                                </button>
                            </div>

                            <div class="space-y-3">
                                <template x-for="(option, index) in options" :key="index">
                                    <div class="flex flex-col space-y-1">
                                        <div class="flex items-center space-x-2 bg-white p-2 rounded-lg border border-blue-100 shadow-sm">
                                            <span class="text-xs font-bold text-gray-400 w-6 text-center" x-text="index + 1"></span>
                                            
                                            <input type="text" :name="'options[' + index + '][text]'" 
                                                class="flex-1 border-gray-200 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500" 
                                                x-model="option.text" placeholder="Masukkan teks pilihan">
                                            
                                            <template x-if="question_type === 'Pilihan Ganda (Berbobot)'">
                                                <div class="flex items-center space-x-1">
                                                    <span class="text-[10px] font-bold text-gray-500 uppercase">Nilai:</span>
                                                    <input type="number" :name="'options[' + index + '][value]'" 
                                                        class="w-20 border-gray-200 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500" 
                                                        x-model="option.value" placeholder="0">
                                                </div>
                                            </template>

                                            <button @click.prevent="removeOption(index)" type="button" 
                                                class="text-red-400 hover:text-red-600 p-1.5 rounded-md hover:bg-red-50 transition-colors" title="Hapus Opsi">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                        <p class="text-red-500 text-[10px] ml-8" x-show="errors['options.' + index + '.text']" x-text="errors['options.' + index + '.text'][0]"></p>
                                    </div>
                                </template>
                            </div>
                            
                            <p x-show="options.length === 0" class="text-xs text-gray-500 text-center py-4 border-2 border-dashed border-blue-200 rounded-lg bg-white">
                                Belum ada opsi. Klik "Tambah Opsi" untuk memulai.
                            </p>
                            @error('options')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row justify-end items-center gap-3">
                        <a href="{{ route('admin.surveys.show', $question->survey) }}"
                            class="w-full sm:w-auto px-6 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 text-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto px-8 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-bold rounded-lg shadow-md hover:from-blue-700 hover:to-blue-800 transition duration-150 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    function questionForm(errors = {}, initialOptions = null, initialType = '', initialText = '') {
        return {
            question_type: initialType,
            question_text: initialText,
            options: initialOptions && initialOptions.length > 0 ? initialOptions : [{ text: '', value: '' }],
            errors: errors,
            
            requiresOptions() {
                return ['Pilihan Ganda', 'Pilihan Ganda (Berbobot)', 'Checkbox', 'Dropdown'].includes(this.question_type);
            },
            
            addOption() {
                this.options.push({ text: '', value: '' });
            },

            removeOption(index) {
                this.options.splice(index, 1);
            }
        }
    }
</script>

<style>
    /* Smooth transitions */
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        transform: translateY(-1px);
    }

    /* Custom select dropdown styling */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
</style>
@endsection