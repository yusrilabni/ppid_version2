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
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-4 md:py-8 px-2 md:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="px-2 md:px-0">
                <x-breadcrumbs :breadcrumbs="[
                    ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                    [
                        'title' => 'Survei',
                        'url' => route('page.show', ['page' => 'laporan', 'subpage' => 'survei']),
                        'icon' => 'fas fa-chart-bar',
                    ],
                    ['title' => Str::limit($survey->title, 20), 'url' => '#', 'icon' => 'fas fa-clipboard-check'],
                ]" />
            </div>

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

            <div class="mt-6 md:mt-10">
                {{-- Main Header --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 md:p-8 text-white shadow-xl mb-6 md:mb-8">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-white/20 backdrop-blur-sm rounded-full p-3 mb-4 md:mb-6">
                            <i class="fas fa-poll-h text-3xl md:text-4xl"></i>
                        </div>
                        <h1 class="text-2xl md:text-4xl font-bold mb-3 leading-tight">{{ $survey->title }}</h1>
                        <p class="text-base md:text-xl text-blue-100 opacity-90 max-w-3xl">{{ $survey->description }}</p>

                        <div class="mt-4 md:mt-6">
                            <div class="bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 text-sm md:text-base">
                                <i class="fas fa-question-circle mr-2"></i>
                                <span class="font-semibold">{{ $totalQuestions }} Pertanyaan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl" x-data="surveyProgress({{ $survey->id }}, {{ $totalQuestions }}, {{ $pages->count() }})"
                    x-init="init()">

                    {{-- Progress Bar --}}
                    <div class="px-4 md:px-8 pt-6 md:pt-8">
                        <div class="mb-3 flex justify-between items-center">
                            <h2 class="text-lg md:text-2xl font-bold text-gray-800">
                                <i class="fas fa-bars-progress mr-2 text-blue-600"></i>
                                Progress
                            </h2>
                            <span class="text-xl md:text-2xl font-bold text-blue-600" x-text="progress + '%'"></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 md:h-3">
                            <div class="progress-fill h-2 md:h-3 rounded-full bg-gradient-to-r from-green-400 to-blue-500"
                                :style="{ width: progress + '%' }"></div>
                        </div>
                        <div class="flex justify-between items-center mt-2 text-[10px] md:text-sm text-gray-600">
                            <span>Selesai: <span class="font-bold" x-text="answeredQuestions"></span> / {{ $totalQuestions }}</span>
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
                                x-transition:enter-end="opacity-100 transform translate-x-0" class="p-4 md:p-8">

                                {{-- Page Header --}}
                                <div
                                    class="mb-6 md:mb-10 bg-gradient-to-r from-blue-50 to-indigo-50 p-5 md:p-8 rounded-2xl border border-blue-100 shadow-md">
                                    <div class="flex items-center mb-4 md:mb-6">
                                        <div
                                            class="bg-gradient-to-br from-blue-600 to-indigo-700 w-12 h-12 md:w-16 md:h-16 rounded-xl flex items-center justify-center mr-4 md:mr-6 shadow-lg">
                                            <i class="{{ $page['icon'] ?? 'fas fa-list-alt' }} text-white text-xl md:text-2xl"></i>
                                        </div>
                                        <div>
                                            <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-1 leading-tight">
                                                @if ($page['id'] === 'general')
                                                    {{ Str::limit($survey->title, 40) }}
                                                @else
                                                    {{ $page['title'] }}
                                                @endif
                                            </h2>
                                            <div class="flex items-center text-sm md:text-lg text-gray-700 font-medium">
                                                <i class="fas fa-layer-group mr-2"></i>
                                                <span>Bagian {{ $stepNumber }} / {{ $pages->count() }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    @if (($page['id'] === 'general' && $survey->description) || ($page['id'] !== 'general' && $page['description']))
                                        <div class="mt-4 description-box p-4 md:p-6 rounded-xl">
                                            <div class="flex items-start">
                                                <i class="fas fa-info-circle text-blue-500 text-lg md:text-2xl mr-3 mt-1"></i>
                                                <div>
                                                    <p class="text-sm md:text-lg text-gray-700 leading-relaxed">
                                                        {{ $page['id'] === 'general' ? $survey->description : $page['description'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Questions --}}
                                <div class="space-y-6 md:space-y-10">
                                    @forelse ($page['questions'] as $question)
                                        <div
                                            class="question-card bg-white rounded-2xl border border-gray-100 p-5 md:p-8 shadow-md">
                                            <div class="flex flex-col md:flex-row items-start">
                                                <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                                                    <div
                                                        class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center shadow-md">
                                                        <span
                                                            class="text-white font-bold text-lg md:text-xl">{{ $loop->iteration }}</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow w-full">
                                                    <label class="block mb-4 md:mb-6">
                                                        <div
                                                            class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                                                            <span class="text-lg md:text-xl font-bold text-gray-900 leading-snug">
                                                                {{ $question->question_text }}
                                                            </span>
                                                            @if ($question->is_required)
                                                                <span
                                                                    class="bg-red-50 text-red-600 text-xs md:text-sm font-black px-3 py-1 rounded-full border border-red-100 flex items-center justify-center w-max">
                                                                    <i class="fas fa-exclamation-circle mr-1.5"></i>
                                                                    WAJIB
                                                                </span>
                                                            @endif
                                                        </div>
                                                        @if ($question->description)
                                                            <div
                                                                class="mt-3 p-3 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg">
                                                                <div class="flex items-start">
                                                                    <i
                                                                        class="fas fa-lightbulb text-yellow-500 text-base mr-2 mt-0.5"></i>
                                                                    <p class="text-xs md:text-sm text-gray-700 italic">
                                                                        {{ $question->description }}</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </label>

                                                    <div class="mt-4 md:mt-6">
                                                        @if ($question->question_type === 'Isian Singkat')
                                                            <div class="relative">
                                                                <input type="text" name="answers[{{ $question->id }}]"
                                                                    class="text-input w-full px-4 py-3 md:px-5 md:py-4 text-base md:text-lg border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                                                                    placeholder="Tulis jawaban..."
                                                                    {{ $question->is_required ? 'required' : '' }}
                                                                    autocomplete="off"
                                                                    x-on:input="handleInputChange($event)">
                                                            </div>
                                                        @elseif ($question->question_type === 'Email')
                                                            <div class="relative">
                                                                <input type="email" name="answers[{{ $question->id }}]"
                                                                    class="text-input w-full px-4 py-3 md:px-5 md:py-4 text-base md:text-lg border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                                                                    placeholder="Alamat email..."
                                                                    {{ $question->is_required ? 'required' : '' }}
                                                                    autocomplete="email"
                                                                    x-on:input="handleInputChange($event)">
                                                            </div>
                                                        @elseif ($question->question_type === 'Numeric')
                                                            <div class="relative">
                                                                <input type="number" name="answers[{{ $question->id }}]"
                                                                    class="text-input w-full px-4 py-3 md:px-5 md:py-4 text-base md:text-lg border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                                                                    placeholder="Angka..."
                                                                    {{ $question->is_required ? 'required' : '' }}
                                                                    x-on:input="handleInputChange($event)">
                                                            </div>
                                                        @elseif ($question->question_type === 'Url')
                                                            <div class="relative">
                                                                <input type="url" name="answers[{{ $question->id }}]"
                                                                    class="text-input w-full px-4 py-3 md:px-5 md:py-4 text-base md:text-lg border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                                                                    placeholder="https://..."
                                                                    {{ $question->is_required ? 'required' : '' }}
                                                                    autocomplete="url"
                                                                    x-on:input="handleInputChange($event)">
                                                            </div>
                                                        @elseif ($question->question_type === 'Isian Panjang')
                                                            <div class="relative">
                                                                <textarea name="answers[{{ $question->id }}]" rows="4"
                                                                    class="custom-textarea text-input w-full px-4 py-3 md:px-5 md:py-4 text-base md:text-lg border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                                                                    placeholder="Penjelasan detail..." {{ $question->is_required ? 'required' : '' }}
                                                                    x-on:input="handleInputChange($event)"></textarea>
                                                            </div>
                                                        @elseif (in_array($question->question_type, ['Pilihan Ganda', 'Pilihan Ganda (Berbobot)']))
                                                            <div class="grid grid-cols-1 gap-3">
                                                                @foreach ($question->options->sortBy('order') as $option)
                                                                    <label
                                                                        class="option-item flex items-center p-4 md:p-5 rounded-xl border-2 border-gray-50 hover:border-blue-300 hover:bg-blue-50 cursor-pointer transition-all duration-200"
                                                                        onclick="selectRadioOption(this)">
                                                                        <input type="radio"
                                                                            name="answers[{{ $question->id }}]"
                                                                            value="{{ $option->id }}"
                                                                            class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 mr-3 md:mr-4"
                                                                            {{ $question->is_required ? 'required' : '' }}
                                                                            x-on:change="handleInputChange($event)">
                                                                        <span
                                                                            class="text-gray-800 text-base md:text-lg flex-grow">{{ $option->option_text }}</span>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        @elseif ($question->question_type === 'Checkbox')
                                                            <div class="grid grid-cols-1 gap-3">
                                                                @foreach ($question->options->sortBy('order') as $option)
                                                                    <label
                                                                        class="checkbox-item flex items-center p-4 md:p-5 rounded-xl border-2 border-gray-50 hover:border-green-300 hover:bg-green-50 cursor-pointer transition-all duration-200"
                                                                        onclick="toggleCheckboxOption(this)">
                                                                        <input type="checkbox"
                                                                            name="answers[{{ $question->id }}][]"
                                                                            value="{{ $option->id }}"
                                                                            class="h-5 w-5 rounded text-green-600 focus:ring-green-500 border-gray-300 mr-3 md:mr-4"
                                                                            x-on:change="handleInputChange($event)">
                                                                        <span
                                                                            class="text-gray-800 text-base md:text-lg flex-grow">{{ $option->option_text }}</span>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        @elseif ($question->question_type === 'Dropdown')
                                                            <div class="relative">
                                                                @php
                                                                    $options = $question->options->sortBy('order')->map(function($opt) {
                                                                        return ['value' => (string)$opt->id, 'label' => $opt->option_text];
                                                                    })->toArray();
                                                                @endphp
                                                                <x-custom-select 
                                                                    name="answers[{{ $question->id }}]" 
                                                                    :options="$options"
                                                                    placeholder="-- Pilih --"
                                                                    :searchable="true"
                                                                    :required="$question->is_required"
                                                                    @change="handleInputChange({ target: $el.querySelector('input[type=hidden]') })"
                                                                />
                                                            </div>
                                                        @elseif ($question->question_type === 'Skala Kepuasan')
                                                            <div
                                                                class="bg-gradient-to-r from-red-50 via-yellow-50 to-green-50 p-4 md:p-8 rounded-2xl border-2 border-gray-50">
                                                                <div class="grid grid-cols-4 gap-2 md:gap-6 mb-6 md:mb-8">
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
                                                                                class="h-4 w-4 md:h-5 md:w-5 mb-2 md:mb-3"
                                                                                {{ $question->is_required ? 'required' : '' }}
                                                                                x-on:change="handleInputChange($event)">
                                                                            <div
                                                                                class="{{ $colors[$i] }} text-white w-12 h-12 md:w-20 md:h-20 rounded-full flex items-center justify-center mb-2 md:mb-3 shadow-lg transition-all duration-200 hover:scale-110">
                                                                                <span
                                                                                    class="font-bold text-base md:text-2xl">{{ $i + 1 }}</span>
                                                                            </div>
                                                                            <span
                                                                                class="text-[8px] md:text-sm text-center font-bold text-gray-700 uppercase tracking-tighter">
                                                                                {{ $labels[$i] }}
                                                                            </span>
                                                                        </label>
                                                                    @endfor
                                                                </div>
                                                                <div class="flex justify-between text-xs md:text-lg font-black px-2 md:px-4 uppercase tracking-wider">
                                                                    <span class="text-red-600 flex items-center">
                                                                        <i class="fas fa-face-frown-open mr-1.5 md:mr-2"></i>
                                                                        Sangat Kurang
                                                                    </span>
                                                                    <span class="text-green-600 flex items-center">
                                                                        <i class="fas fa-face-grin-stars mr-1.5 md:mr-2"></i>
                                                                        Sangat Baik
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
                                            class="text-center py-10 md:py-16 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                            <p class="text-gray-500 text-lg">Tidak ada pertanyaan</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach

                        {{-- Navigation Buttons --}}
                        <div class="sticky bottom-0 bg-white/95 backdrop-blur-md border-t border-gray-100 px-4 md:px-8 py-4 md:py-6 shadow-2xl z-20">
                            <div class="flex justify-between items-center max-w-5xl mx-auto">
                                <button type="button" x-show="step > 1" x-on:click="prevStep()"
                                    class="group flex items-center px-4 py-3 md:px-8 md:py-4 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-xl transition-all duration-200 transform active:scale-95 shadow-md">
                                    <i class="fas fa-arrow-left mr-2 md:mr-4 text-base md:text-xl"></i>
                                    <span class="text-sm md:text-lg">Kembali</span>
                                </button>
                                <div x-show="step === 1"></div>

                                <div class="text-center">
                                    <div class="text-[10px] md:text-sm text-gray-500 font-black uppercase tracking-[0.2em]">
                                        Bagian <span class="text-blue-600" x-text="step"></span> / {{ $pages->count() }}
                                    </div>
                                </div>

                                <template x-if="step < totalSteps">
                                    <button type="button" x-on:click="nextStep()"
                                        class="group flex items-center px-5 py-3 md:px-10 md:py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transition-all duration-200 transform active:scale-95">
                                        <span class="text-sm md:text-lg">Lanjut</span>
                                        <i class="fas fa-arrow-right ml-2 md:mr-4 text-base md:text-xl"></i>
                                    </button>
                                </template>

                                <button type="submit" x-show="step === totalSteps"
                                    class="group flex items-center px-5 py-3 md:px-10 md:py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow-lg transition-all duration-200 transform active:scale-95">
                                    <i class="fas fa-paper-plane mr-2 md:mr-4 text-base md:text-xl"></i>
                                    <span class="text-sm md:text-lg">Kirim</span>
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
