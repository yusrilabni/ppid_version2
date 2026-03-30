@extends('frontend.layouts.app')

@section('title', 'Survei: ' . $survey->title)

@push('styles')
    <style>
        .question-card {
            transition: all 0.3s ease;
        }

        .question-card:hover {
            transform: translateY(-5px);
        }

        .progress-fill {
            transition: width 0.5s ease-in-out;
        }

        .custom-textarea {
            resize: vertical;
            min-height: 150px;
            font-family: inherit;
            line-height: 1.6;
        }

        .text-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .description-box {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-left: 4px solid #3b82f6;
        }

        /* Style untuk radio dan checkbox yang dipilih */
        .option-item.selected {
            border-color: #3b82f6 !important;
            background-color: #eff6ff !important;
        }

        .checkbox-item.selected {
            border-color: #10b981 !important;
            background-color: #ecfdf5 !important;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <x-breadcrumbs :breadcrumbs="[
                ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                [
                    'title' => 'Survei',
                    'url' => route('page.show', ['page' => 'laporan', 'subpage' => 'survei']),
                    'icon' => 'fas fa-chart-bar',
                ],
                ['title' => $survey->title, 'url' => '#', 'icon' => 'fas fa-clipboard-check'],
            ]" />

            @php
                $pages = collect();
                $totalQuestions = 0;

                // 1. General Questions (No Section)
                $generalQuestions = $survey->questions->whereNull('section_id')->sortBy('order');
                if ($generalQuestions->isNotEmpty()) {
                    $totalQuestions += $generalQuestions->count();
                    $pages->push([
                        'id' => 'general',
                        'title' => 'Umum',
                        'description' => null,
                        'questions' => $generalQuestions,
                        'icon' => 'fas fa-list-alt',
                    ]);
                }

                // 2. Sections
                foreach ($survey->sections->sortBy('order') as $section) {
                    $sectionQuestions = $survey->questions->where('section_id', $section->id)->sortBy('order');
                    $totalQuestions += $sectionQuestions->count();
                    $pages->push([
                        'id' => 'section_' . $section->id,
                        'title' => $section->title,
                        'description' => $section->description,
                        'questions' => $sectionQuestions,
                        'icon' => 'fas fa-folder',
                    ]);
                }

                if ($pages->isEmpty()) {
                    $pages->push([
                        'id' => 'empty',
                        'title' => $survey->title,
                        'description' => $survey->description,
                        'questions' => collect(),
                        'icon' => 'fas fa-poll',
                    ]);
                }
            @endphp

            <div class="mt-10">
                {{-- Main Header --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-2xl mb-8">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-white/20 backdrop-blur-sm rounded-full p-4 mb-6">
                            <i class="fas fa-poll-h text-4xl"></i>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $survey->title }}</h1>
                        <p class="text-xl text-blue-100 opacity-90 max-w-3xl">{{ $survey->description }}</p>

                        <div class="mt-6">
                            <div class="bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
                                <i class="fas fa-question-circle mr-2"></i>
                                <span class="font-semibold">{{ $totalQuestions }} Pertanyaan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden" x-data="surveyProgress({{ $survey->id }}, {{ $totalQuestions }}, {{ $pages->count() }})"
                    x-init="init()">

                    {{-- Progress Bar --}}
                    <div class="px-8 pt-8">
                        <div class="mb-4 flex justify-between items-center">
                            <h2 class="text-2xl font-bold text-gray-800">
                                <i class="fas fa-bars-progress mr-3 text-blue-600"></i>
                                Progress Survei
                            </h2>
                            <span class="text-2xl font-bold text-blue-600" x-text="progress + '%'"></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="progress-fill h-3 rounded-full bg-gradient-to-r from-green-400 to-blue-500"
                                :style="{ width: progress + '%' }"></div>
                        </div>
                        <div class="flex justify-between items-center mt-2 text-sm text-gray-600">
                            <span>Telah dijawab: <span class="font-bold" x-text="answeredQuestions"></span> dari
                                {{ $totalQuestions }}</span>
                            <span x-text="progress + '% selesai'"></span>
                        </div>
                    </div>

                    <form action="{{ route('public.surveys.store', $survey) }}" method="POST" class="relative"
                        x-ref="surveyForm" @change="handleInputChange($event)">
                        @csrf

                        {{-- Loop Pages --}}
                        @foreach ($pages as $index => $page)
                            @php $stepNumber = $index + 1; @endphp

                            <div x-show="step === {{ $stepNumber }}" data-step="{{ $stepNumber }}"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-x-4"
                                x-transition:enter-end="opacity-100 transform translate-x-0" class="p-8">

                                {{-- Page Header --}}
                                <div
                                    class="mb-10 bg-gradient-to-r from-blue-50 to-indigo-50 p-8 rounded-2xl border border-blue-100 shadow-lg">
                                    <div class="flex items-center mb-6">
                                        <div
                                            class="bg-gradient-to-br from-blue-600 to-indigo-700 w-16 h-16 rounded-xl flex items-center justify-center mr-6 shadow-lg">
                                            <i class="{{ $page['icon'] ?? 'fas fa-list-alt' }} text-white text-2xl"></i>
                                        </div>
                                        <div>
                                            <h2 class="text-3xl font-bold text-gray-900 mb-2">
                                                @if ($page['id'] === 'general')
                                                    {{ $survey->title }}
                                                @else
                                                    {{ $page['title'] }}
                                                @endif
                                            </h2>
                                            <div class="flex items-center text-lg text-gray-700">
                                                <i class="fas fa-layer-group mr-3"></i>
                                                <span>Bagian {{ $stepNumber }} dari {{ $pages->count() }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    @if (($page['id'] === 'general' && $survey->description) || ($page['id'] !== 'general' && $page['description']))
                                        <div class="mt-6 description-box p-6 rounded-xl">
                                            <div class="flex items-start">
                                                <i class="fas fa-info-circle text-blue-500 text-2xl mr-4 mt-1"></i>
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi Bagian:
                                                    </h3>
                                                    <p class="text-gray-700 text-lg leading-relaxed">
                                                        {{ $page['id'] === 'general' ? $survey->description : $page['description'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Questions --}}
                                <div class="space-y-10">
                                    @forelse ($page['questions'] as $question)
                                        <div
                                            class="question-card bg-white rounded-2xl border-2 border-gray-100 p-8 shadow-lg">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 mr-6">
                                                    <div
                                                        class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center shadow-md">
                                                        <span
                                                            class="text-white font-bold text-xl">{{ $loop->iteration }}</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow">
                                                    <label class="block mb-6">
                                                        <div
                                                            class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                                                            <span class="text-xl font-bold text-gray-900">
                                                                {{ $question->question_text }}
                                                            </span>
                                                            @if ($question->is_required)
                                                                <span
                                                                    class="bg-gradient-to-r from-red-500 to-pink-600 text-white text-lg font-bold px-5 py-2 rounded-full shadow-md flex items-center justify-center min-w-max">
                                                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                                                    WAJIB DIISI
                                                                </span>
                                                            @endif
                                                        </div>
                                                        @if ($question->description)
                                                            <div
                                                                class="mt-4 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg">
                                                                <div class="flex items-start">
                                                                    <i
                                                                        class="fas fa-lightbulb text-yellow-500 text-xl mr-3 mt-1"></i>
                                                                    <div>
                                                                        <h4 class="font-semibold text-gray-800 mb-1">
                                                                            Petunjuk:</h4>
                                                                        <p class="text-gray-700">
                                                                            {{ $question->description }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </label>

                                                    <div class="mt-6">
                                                        @if ($question->question_type === 'Isian Singkat')
                                                            <div class="relative">
                                                                <input type="text" name="answers[{{ $question->id }}]"
                                                                    class="text-input w-full px-5 py-4 text-lg border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                                                                    placeholder="Tulis jawaban Anda di sini..."
                                                                    {{ $question->is_required ? 'required' : '' }}
                                                                    autocomplete="off"
                                                                    x-on:input="handleInputChange($event)">
                                                            </div>
                                                        @elseif ($question->question_type === 'Email')
                                                            <div class="relative">
                                                                <input type="email" name="answers[{{ $question->id }}]"
                                                                    class="text-input w-full px-5 py-4 text-lg border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                                                                    placeholder="Tulis alamat email Anda di sini..."
                                                                    {{ $question->is_required ? 'required' : '' }}
                                                                    autocomplete="email"
                                                                    x-on:input="handleInputChange($event)">
                                                            </div>
                                                        @elseif ($question->question_type === 'Numeric')
                                                            <div class="relative">
                                                                <input type="number" name="answers[{{ $question->id }}]"
                                                                    class="text-input w-full px-5 py-4 text-lg border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                                                                    placeholder="Masukkan angka..."
                                                                    {{ $question->is_required ? 'required' : '' }}
                                                                    x-on:input="handleInputChange($event)">
                                                            </div>
                                                        @elseif ($question->question_type === 'Url')
                                                            <div class="relative">
                                                                <input type="url" name="answers[{{ $question->id }}]"
                                                                    class="text-input w-full px-5 py-4 text-lg border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                                                                    placeholder="https://example.com"
                                                                    {{ $question->is_required ? 'required' : '' }}
                                                                    autocomplete="url"
                                                                    x-on:input="handleInputChange($event)">
                                                            </div>
                                                        @elseif ($question->question_type === 'Isian Panjang')
                                                            <div class="relative">
                                                                <textarea name="answers[{{ $question->id }}]" rows="6"
                                                                    class="custom-textarea text-input w-full px-5 py-4 text-lg border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                                                                    placeholder="Jelaskan jawaban Anda secara detail..." {{ $question->is_required ? 'required' : '' }}
                                                                    x-on:input="handleInputChange($event)"></textarea>
                                                            </div>
                                                        @elseif (in_array($question->question_type, ['Pilihan Ganda', 'Pilihan Ganda (Berbobot)']))
                                                            <div class="space-y-3">
                                                                @foreach ($question->options->sortBy('order') as $option)
                                                                    <label
                                                                        class="option-item flex items-center p-5 rounded-xl border-2 border-gray-100 hover:border-blue-300 hover:bg-blue-50 cursor-pointer transition-all duration-200"
                                                                        onclick="selectRadioOption(this)">
                                                                        <input type="radio"
                                                                            name="answers[{{ $question->id }}]"
                                                                            value="{{ $option->id }}"
                                                                            class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 mr-4"
                                                                            {{ $question->is_required ? 'required' : '' }}
                                                                            x-on:change="handleInputChange($event)">
                                                                        <span
                                                                            class="text-gray-800 text-lg flex-grow">{{ $option->option_text }}</span>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        @elseif ($question->question_type === 'Checkbox')
                                                            <div class="space-y-3">
                                                                @foreach ($question->options->sortBy('order') as $option)
                                                                    <label
                                                                        class="checkbox-item flex items-center p-5 rounded-xl border-2 border-gray-100 hover:border-green-300 hover:bg-green-50 cursor-pointer transition-all duration-200"
                                                                        onclick="toggleCheckboxOption(this)">
                                                                        <input type="checkbox"
                                                                            name="answers[{{ $question->id }}][]"
                                                                            value="{{ $option->id }}"
                                                                            class="h-5 w-5 rounded text-green-600 focus:ring-green-500 border-gray-300 mr-4"
                                                                            x-on:change="handleInputChange($event)">
                                                                        <span
                                                                            class="text-gray-800 text-lg flex-grow">{{ $option->option_text }}</span>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        @elseif ($question->question_type === 'Dropdown')
                                                            <div class="relative">
                                                                <select name="answers[{{ $question->id }}]"
                                                                    class="text-input w-full px-5 py-4 text-lg border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 appearance-none bg-white transition-all duration-200 pr-12"
                                                                    {{ $question->is_required ? 'required' : '' }}
                                                                    x-on:change="handleInputChange($event)">
                                                                    <option value="" class="text-gray-400">-- Pilih
                                                                        salah satu opsi --</option>
                                                                    @foreach ($question->options->sortBy('order') as $option)
                                                                        <option value="{{ $option->id }}"
                                                                            class="text-gray-800">
                                                                            {{ $option->option_text }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div
                                                                    class="absolute inset-y-0 right-0 flex items-center px-5 pointer-events-none">
                                                                    <i
                                                                        class="fas fa-chevron-down text-gray-500 text-xl"></i>
                                                                </div>
                                                            </div>
                                                        @elseif ($question->question_type === 'Skala Kepuasan')
                                                            <div
                                                                class="bg-gradient-to-r from-red-50 via-yellow-50 to-green-50 p-8 rounded-2xl border-2 border-gray-100">
                                                                <div class="grid grid-cols-4 gap-6 mb-8">
                                                                    @php
                                                                        $labels = [
                                                                            'Tidak Puas',
                                                                            'Kurang Puas',
                                                                            'Puas',
                                                                            'Sangat Puas',
                                                                        ];
                                                                        $colors = [
                                                                            'bg-red-500',
                                                                            'bg-orange-500',
                                                                            'bg-lime-500',
                                                                            'bg-green-500',
                                                                        ];
                                                                    @endphp
                                                                    @for ($i = 0; $i < 4; $i++)
                                                                        <label
                                                                            class="flex flex-col items-center cursor-pointer">
                                                                            <input type="radio"
                                                                                name="answers[{{ $question->id }}]"
                                                                                value="{{ $i + 1 }}"
                                                                                class="h-5 w-5 mb-3"
                                                                                {{ $question->is_required ? 'required' : '' }}
                                                                                x-on:change="handleInputChange($event)">
                                                                            <div
                                                                                class="{{ $colors[$i] }} text-white w-20 h-20 rounded-full flex items-center justify-center mb-3 shadow-lg transition-all duration-200 hover:scale-110">
                                                                                <span
                                                                                    class="font-bold text-2xl">{{ $i + 1 }}</span>
                                                                            </div>
                                                                            <span
                                                                                class="mt-2 text-center font-medium text-gray-700">
                                                                                {{ $labels[$i] }}
                                                                            </span>
                                                                        </label>
                                                                    @endfor
                                                                </div>
                                                                <div class="flex justify-between text-lg font-bold px-4">
                                                                    <span class="text-red-600 flex items-center">
                                                                        <i class="fas fa-face-frown-open mr-2"></i>
                                                                        Tidak Puas
                                                                    </span>
                                                                    <span class="text-green-600 flex items-center">
                                                                        <i class="fas fa-face-grin-stars mr-2"></i>
                                                                        Sangat Puas
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div
                                            class="text-center py-16 bg-gradient-to-r from-gray-50 to-white rounded-2xl border-3 border-dashed border-gray-300">
                                            <i class="fas fa-inbox text-6xl text-gray-300 mb-6"></i>
                                            <p class="text-gray-500 text-2xl mb-4">Tidak ada pertanyaan di bagian ini</p>
                                            <p class="text-gray-400 text-xl">Silakan lanjutkan ke bagian berikutnya</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach

                        {{-- Navigation Buttons --}}
                        <div class="sticky bottom-0 bg-white border-t-2 border-gray-200 px-8 py-6 shadow-2xl mt-10">
                            <div class="flex justify-between items-center">
                                <button type="button" x-show="step > 1" x-on:click="prevStep()"
                                    class="group flex items-center px-8 py-4 bg-gradient-to-r from-gray-100 to-gray-50 hover:from-gray-200 hover:to-gray-100 text-gray-800 font-bold rounded-2xl transition-all duration-200 transform hover:-translate-x-2 shadow-lg hover:shadow-xl">
                                    <i
                                        class="fas fa-arrow-left mr-4 text-xl group-hover:-translate-x-2 transition-transform"></i>
                                    <span class="text-lg">Kembali</span>
                                </button>
                                <div x-show="step === 1"></div>

                                <div class="text-center">
                                    <div class="text-gray-700 font-medium">
                                        <span class="text-blue-600 font-bold" x-text="step"></span> dari
                                        {{ $pages->count() }} Bagian
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        <span class="text-green-600 font-bold" x-text="answeredQuestions"></span> dari
                                        {{ $totalQuestions }} pertanyaan terjawab
                                    </div>
                                </div>

                                <template x-if="step < totalSteps">
                                    <button type="button" x-on:click="nextStep()"
                                        class="group flex items-center px-10 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:translate-x-2">
                                        <span class="text-lg">Lanjutkan</span>
                                        <i
                                            class="fas fa-arrow-right ml-4 text-xl group-hover:translate-x-2 transition-transform"></i>
                                    </button>
                                </template>

                                <button type="submit" x-show="step === totalSteps"
                                    class="group flex items-center px-10 py-4 bg-gradient-to-r from-green-600 to-emerald-700 hover:from-green-700 hover:to-emerald-800 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:scale-105">
                                    <i
                                        class="fas fa-paper-plane mr-4 text-xl group-hover:rotate-12 transition-transform"></i>
                                    <span class="text-lg">Kirim Survei</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Fungsi sederhana untuk mengatur tampilan radio button
        function selectRadioOption(label) {
            // Hapus class selected dari semua opsi dalam grup yang sama
            const radioName = label.querySelector('input[type="radio"]').name;
            document.querySelectorAll(`input[name="${radioName}"]`).forEach(input => {
                input.closest('.option-item').classList.remove('selected');
            });

            // Tambah class selected pada opsi yang dipilih
            label.classList.add('selected');

            // Trigger change event pada radio input
            const radio = label.querySelector('input[type="radio"]');
            radio.checked = true;
            radio.dispatchEvent(new Event('change'));
        }

        // Fungsi sederhana untuk mengatur tampilan checkbox
        function toggleCheckboxOption(label) {
            const checkbox = label.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;

            if (checkbox.checked) {
                label.classList.add('selected');
            } else {
                label.classList.remove('selected');
            }

            checkbox.dispatchEvent(new Event('change'));
        }

        // Initialize radio and checkbox states from saved answers
        function initializeOptions() {
            // Initialize radio buttons
            document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
                const label = radio.closest('.option-item');
                if (label) {
                    label.classList.add('selected');
                }
            });

            // Initialize checkboxes
            document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                const label = checkbox.closest('.checkbox-item');
                if (label) {
                    label.classList.add('selected');
                }
            });
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', initializeOptions);

        // Alpine.js data component untuk survei
        function surveyProgress(surveyId, totalQuestions, totalSteps) {
            return {
                step: 1,
                totalSteps: totalSteps,
                progress: 0,
                totalQuestions: totalQuestions,
                answeredQuestions: 0,

                init() {
                    // Load saved step
                    const savedStep = localStorage.getItem(`survey_${surveyId}_current_step`);
                    if (savedStep) {
                        this.step = parseInt(savedStep);
                    }

                    // Load saved answers
                    this.loadSavedAnswers();
                    this.calculateProgress();
                    // Initialize options UI
                    setTimeout(() => initializeOptions(), 100);
                },

                nextStep() {
                    if (this.validateCurrentStep()) {
                        this.step++;
                        if (this.step > this.totalSteps) this.step = this.totalSteps;
                        this.saveCurrentStep();
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                },

                prevStep() {
                    if (this.step > 1) {
                        this.step--;
                        this.saveCurrentStep();
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                },

                validateCurrentStep() {
                    const container = document.querySelector(`[data-step='${this.step}']`);
                    if (!container) return true;

                    const requiredInputs = container.querySelectorAll('[required]');
                    let isValid = true;

                    for (let input of requiredInputs) {
                        if (input.type === 'checkbox') {
                            // Validasi group checkbox
                            const checkboxes = container.querySelectorAll(`input[name="${input.name}"]`);
                            const checked = Array.from(checkboxes).some(cb => cb.checked);
                            if (!checked) {
                                isValid = false;
                                // Highlight all checkboxes in group
                                checkboxes.forEach(cb => {
                                    const label = cb.closest('.checkbox-item');
                                    if (label) {
                                        label.classList.add('border-red-500');
                                    }
                                });
                            }
                        } else if (!input.checkValidity()) {
                            input.reportValidity();
                            input.classList.add('border-red-500', 'ring-2', 'ring-red-100');
                            isValid = false;
                        }
                    }

                    return isValid;
                },

                calculateProgress() {
                    let answered = 0;
                    const form = this.$refs.surveyForm;

                    if (!form) return;

                    // Hitung semua pertanyaan yang memiliki jawaban
                    const inputs = form.querySelectorAll('input, textarea, select');

                    // Track questions that have been answered
                    const answeredQuestions = new Set();

                    inputs.forEach(input => {
                        if (input.type === 'checkbox') {
                            const name = input.name;
                            const questionId = this.extractQuestionId(name);

                            if (questionId && input.checked && !answeredQuestions.has(questionId)) {
                                answered++;
                                answeredQuestions.add(questionId);
                            }
                        } else if (input.type === 'radio') {
                            const name = input.name;
                            const questionId = this.extractQuestionId(name);

                            // Check if any radio in this group is checked
                            if (questionId && !answeredQuestions.has(questionId)) {
                                const radioGroup = form.querySelectorAll(`input[name="${name}"]`);
                                const isAnyChecked = Array.from(radioGroup).some(radio => radio.checked);

                                if (isAnyChecked) {
                                    answered++;
                                    answeredQuestions.add(questionId);
                                }
                            }
                        } else if (input.type === 'select-one') {
                            const questionId = this.extractQuestionId(input.name);

                            if (questionId && input.value && !answeredQuestions.has(questionId)) {
                                answered++;
                                answeredQuestions.add(questionId);
                            }
                        } else {
                            const questionId = this.extractQuestionId(input.name);

                            if (questionId && input.value.trim() !== '' && !answeredQuestions.has(questionId)) {
                                answered++;
                                answeredQuestions.add(questionId);
                            }
                        }
                    });

                    this.answeredQuestions = answered;
                    this.progress = Math.round((answered / this.totalQuestions) * 100);
                },

                handleInputChange(event) {
                    const input = event.target;

                    // Remove error styling
                    input.classList.remove('border-red-500', 'ring-2', 'ring-red-100');
                    const parent = input.closest('.option-item, .checkbox-item');
                    if (parent) {
                        parent.classList.remove('border-red-500');
                    }

                    this.saveAnswer(input);
                    this.calculateProgress();
                },

                extractQuestionId(name) {
                    const match = name.match(/\[(\d+)\]/);
                    return match ? match[1] : null;
                },

                saveAnswer(input) {
                    const questionId = this.extractQuestionId(input.name);
                    if (!questionId) return;

                    let value;

                    if (input.type === 'checkbox') {
                        const checkboxes = document.querySelectorAll(`input[name="${input.name}"]:checked`);
                        value = Array.from(checkboxes).map(cb => cb.value);
                    } else if (input.type === 'radio') {
                        const selected = document.querySelector(`input[name="${input.name}"]:checked`);
                        value = selected ? selected.value : null;
                    } else {
                        value = input.value;
                    }

                    localStorage.setItem(`survey_${surveyId}_${questionId}`, JSON.stringify(value));
                },

                loadSavedAnswers() {
                    // Load semua jawaban yang tersimpan
                    for (let i = 0; i < localStorage.length; i++) {
                        const key = localStorage.key(i);

                        if (key.startsWith(`survey_${surveyId}_`) && !key.endsWith('_current_step')) {
                            const questionId = key.replace(`survey_${surveyId}_`, '');
                            const savedValue = localStorage.getItem(key);

                            try {
                                const value = JSON.parse(savedValue);

                                if (Array.isArray(value)) {
                                    // Ini adalah checkbox group
                                    const checkboxes = document.querySelectorAll(`input[name="answers[${questionId}][]"]`);
                                    checkboxes.forEach(checkbox => {
                                        if (value.includes(checkbox.value)) {
                                            checkbox.checked = true;
                                            // Update UI
                                            const label = checkbox.closest('.checkbox-item');
                                            if (label) {
                                                label.classList.add('selected');
                                            }
                                        }
                                    });
                                } else {
                                    // Ini input lainnya
                                    const input = document.querySelector(`[name="answers[${questionId}]"]`);
                                    if (input) {
                                        if (input.type === 'radio') {
                                            const radio = document.querySelector(
                                                `input[name="answers[${questionId}]"][value="${value}"]`);
                                            if (radio) {
                                                radio.checked = true;
                                                // Update UI
                                                const label = radio.closest('.option-item');
                                                if (label) {
                                                    label.classList.add('selected');
                                                }
                                            }
                                        } else {
                                            input.value = value;
                                        }
                                    }
                                }
                            } catch (e) {
                                console.error('Error loading saved answer:', e);
                            }
                        }
                    }
                },

                saveCurrentStep() {
                    localStorage.setItem(`survey_${surveyId}_current_step`, this.step);
                }
            };
        }
    </script>
@endpush
