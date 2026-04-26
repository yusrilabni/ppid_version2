@extends('frontend.layouts.app')

@section('title', 'Kuesioner PBJ Tahun ' . $year)

@section('content')
<div x-data="{ 
    showModal: @json($show_pedoman_modal ?? false),
    hasReadPanduan: false,
    scrollProgress: 0,
    updateProgress(el) {
        const scrolled = el.scrollTop;
        const totalHeight = el.scrollHeight - el.clientHeight;
        if (totalHeight <= 10) {
            this.scrollProgress = 100;
        } else {
            this.scrollProgress = Math.round((scrolled / totalHeight) * 100);
        }
        
        if (this.scrollProgress >= 95) {
            this.hasReadPanduan = true;
        }
    },
    init() {
        if (this.showModal) {
            this.$nextTick(() => {
                const el = this.$refs.modalBody;
                if (el) this.updateProgress(el);
            });
        }
        this.$watch('showModal', value => {
            if (value) {
                this.$nextTick(() => {
                    const el = this.$refs.modalBody;
                    if (el) {
                        el.scrollTop = 0;
                        this.updateProgress(el);
                    }
                });
            }
        });
    }
}">
    <div class="container mx-auto py-6 md:py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Kuesioner PBJ', 'url' => route('pbj.index'), 'icon' => 'fas fa-file-signature'],
            ['title' => 'Tahun ' . $year, 'url' => '#', 'icon' => 'fas fa-calendar-alt']
        ]" />

        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="mb-4 rounded-xl bg-green-50 border border-green-200 p-4 text-green-800 relative shadow-sm" role="alert">
                <div class="flex items-center pr-8">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-400 hover:text-green-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 8000)" x-show="show" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="mb-4 rounded-xl bg-red-50 border border-red-200 p-4 text-red-800 relative shadow-sm" role="alert">
                <div class="flex flex-col pr-8">
                    <div class="flex items-center font-bold text-sm mb-1">
                        <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                        Oops! Ada masalah.
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 ml-7">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-400 hover:text-red-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if($canEdit)
        {{-- Modal Panduan PBJ (Premium Design) --}}
        <div x-show="showModal" 
             class="fixed inset-0 z-[100] bg-slate-900/90 flex items-center justify-center p-2 md:p-6" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             style="display: none;">
            
            <div class="bg-white w-full max-w-5xl max-h-[95vh] rounded-3xl shadow-2xl flex flex-col overflow-hidden border border-slate-200 font-sans">
                
                <!-- Header Premium -->
                <div class="bg-gradient-to-r from-blue-800 to-indigo-900 px-6 py-5 flex-shrink-0 border-b border-white/10 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/5 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="bg-white/10 p-2.5 rounded-xl text-white">
                                <i class="fas fa-file-contract text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl md:text-2xl font-black text-white leading-none uppercase tracking-tight">Panduan Klasifikasi PBJ</h3>
                                <p class="text-blue-200 text-[10px] md:text-xs mt-1 font-medium">Wajib dipatuhi oleh Admin PPID sebelum melakukan input data</p>
                            </div>
                        </div>
                        <button x-show="hasReadPanduan" 
                                @click="showModal = false" 
                                class="text-white/60 hover:text-white transition-all p-2 rounded-xl hover:bg-white/10"
                                x-transition>
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="w-full h-1 bg-slate-100 flex-shrink-0">
                    <div class="h-full bg-blue-500 transition-all duration-300" 
                         :style="`width: ${scrollProgress}%` shadow-sm"></div>
                </div>

                <!-- Content Area -->
                <div class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50/50"
                     @scroll="updateProgress($el)" x-ref="modalBody">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <h4 class="text-sm font-black text-blue-600 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <i class="fas fa-lightbulb text-yellow-400"></i> PRINSIP UTAMA
                            </h4>
                            <ul class="space-y-3 text-xs text-slate-700 font-medium">
                                <li class="flex items-start gap-3 p-2 hover:bg-blue-50 rounded-lg transition-colors">
                                    <i class="fas fa-check-circle text-blue-500 mt-0.5"></i>
                                    <span>Klasifikasi ditentukan oleh <span class="text-blue-600 font-bold">jenis dokumen</span>, bukan tahun anggaran.</span>
                                </li>
                                <li class="flex items-start gap-3 p-2 hover:bg-blue-50 rounded-lg transition-colors">
                                    <i class="fas fa-check-circle text-blue-500 mt-0.5"></i>
                                    <span><span class="font-bold text-blue-700">Info Berkala</span> tidak pernah berubah menjadi <span class="font-bold text-green-700">Setiap Saat</span>.</span>
                                </li>
                                <li class="flex items-start gap-3 p-2 hover:bg-blue-50 rounded-lg transition-colors">
                                    <i class="fas fa-check-circle text-blue-500 mt-0.5"></i>
                                    <span>Dokumen lama <span class="text-red-600 font-bold">dilarang dihapus</span>, hanya boleh diarsipkan.</span>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-red-50 p-6 rounded-2xl border border-red-100 shadow-sm relative overflow-hidden">
                            <div class="absolute -right-4 -bottom-4 text-red-200/30 rotate-12"><i class="fas fa-exclamation-triangle fa-5x"></i></div>
                            <h4 class="text-sm font-black text-red-600 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <i class="fas fa-ban"></i> KESALAHAN FATAL
                            </h4>
                            <ul class="space-y-2 text-[11px] text-red-700 font-bold">
                                <li class="flex items-center gap-2"><i class="fas fa-times-circle"></i> Salah masuk menu kategori upload</li>
                                <li class="flex items-center gap-2"><i class="fas fa-times-circle"></i> Mengubah klasifikasi tanpa dasar hukum</li>
                                <li class="flex items-center gap-2"><i class="fas fa-times-circle"></i> Mengunggah file PDF yang korup/tidak terbaca</li>
                            </ul>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- KATEGORI BERKALA -->
                        <div class="flex flex-col">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center shadow-md"><i class="fas fa-calendar-alt text-sm"></i></div>
                                <h4 class="font-black text-slate-800 text-sm uppercase tracking-tight">A. INFORMASI BERKALA</h4>
                            </div>
                            <div class="bg-white p-5 rounded-2xl border border-blue-100 shadow-sm flex-1">
                                <p class="text-[10px] font-bold text-blue-600 mb-3 uppercase tracking-widest border-b pb-2 italic">Diumumkan rutin (Menu Berkala)</p>
                                <ul class="space-y-2 text-xs text-slate-700">
                                    <li class="flex items-center gap-3"><i class="fas fa-caret-right text-blue-400"></i> Rencana Umum Pengadaan (RUP)</li>
                                    <li class="flex items-center gap-3"><i class="fas fa-caret-right text-blue-400"></i> Link Aplikasi SIRUP LKPP</li>
                                    <li class="flex items-center gap-3"><i class="fas fa-caret-right text-blue-400"></i> Rekap RUP Tahunan / Semesteran</li>
                                    <li class="flex items-center gap-3"><i class="fas fa-caret-right text-blue-400"></i> Pengumuman / Rekap Paket PBJ</li>
                                </ul>
                            </div>
                        </div>

                        <!-- KATEGORI SETIAP SAAT -->
                        <div class="flex flex-col">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-8 h-8 bg-green-600 text-white rounded-lg flex items-center justify-center shadow-md"><i class="fas fa-clock text-sm"></i></div>
                                <h4 class="font-black text-slate-800 text-sm uppercase tracking-tight">B. INFORMASI SETIAP SAAT</h4>
                            </div>
                            <div class="bg-white p-5 rounded-2xl border border-green-100 shadow-sm flex-1">
                                <p class="text-[10px] font-bold text-green-600 mb-3 uppercase tracking-widest border-b pb-2 italic">Via Permohonan (Menu Setiap Saat)</p>
                                <ul class="space-y-2 text-xs text-slate-700">
                                    <li class="flex items-center gap-3"><i class="fas fa-caret-right text-green-400"></i> KAK, HPS, Kontrak, & Addendum</li>
                                    <li class="flex items-center gap-3"><i class="fas fa-caret-right text-green-400"></i> Dokumen Pemilihan & Kualifikasi</li>
                                    <li class="flex items-center gap-3"><i class="fas fa-caret-right text-green-400"></i> SPPBJ, SPMK, SPM, SP2D Lengkap</li>
                                    <li class="flex items-center gap-3"><i class="fas fa-caret-right text-green-400"></i> Laporan Akhir, BAPH, & Jaminan</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 p-5 bg-blue-50 border border-blue-100 rounded-2xl">
                        <div class="flex items-start gap-4">
                            <span class="text-xl">📝</span>
                            <div>
                                <h5 class="text-xs font-black text-blue-900 uppercase mb-1">Catatan Penting: Sinkronisasi DIP</h5>
                                <p class="text-[11px] text-blue-800 leading-relaxed italic">
                                    Pastikan setiap dokumen yang diinput di sini juga tercatat judulnya dalam <strong>Daftar Informasi Publik (DIP)</strong> yang diunggah di menu berkala, guna memudahkan warga mencari referensi dokumen sebelum mengajukan permohonan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Scroll Indicator -->
                    <div x-show="!hasReadPanduan" class="mt-12 flex flex-col items-center animate-bounce text-slate-300">
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] mb-1">Scroll Hingga Bawah</p>
                        <i class="fas fa-chevron-down text-lg"></i>
                    </div>
                    
                    <div class="h-10"></div>
                </div>

                <!-- Footer -->
                <div class="bg-white p-5 border-t border-slate-100 flex flex-col md:flex-row gap-4 items-center justify-between flex-shrink-0 relative z-[110]">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl text-xs">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-slate-400 text-[10px] font-bold tracking-widest uppercase leading-tight">Standar Kepatuhan</span>
                            <span class="text-slate-600 text-[10px] font-medium leading-tight">UU No. 14 Tahun 2008 & Perki 1/2021</span>
                        </div>
                    </div>
                    
                    <div class="flex gap-3 w-full md:w-auto">
                        <button @click="showModal = false" 
                                class="flex-1 md:flex-none px-12 py-3 bg-blue-700 text-white font-black rounded-2xl shadow-xl shadow-blue-700/20 disabled:opacity-30 text-xs transition-all uppercase tracking-widest"
                                :disabled="!hasReadPanduan">
                            <span x-text="hasReadPanduan ? 'SAYA MENGERTI & LANJUT' : `BACA DAHULU (${scrollProgress}%)` "></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl border border-gray-100">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 md:p-8 text-white">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-extrabold leading-tight">Kuesioner PBJ {{ $year }}</h1>
                        @if($canEdit)
                            <p class="text-blue-100 mt-2 text-sm opacity-90">Lengkapi formulir pengadaan barang dan jasa dengan dokumen yang valid.</p>
                        @else
                            <p class="text-blue-100 mt-2 text-sm opacity-90">Daftar kelengkapan dokumen pengadaan barang dan jasa.</p>
                        @endif
                    </div>
                    <button type="button" @click="showModal = true" class="inline-flex items-center justify-center px-5 py-2.5 bg-white/10 hover:bg-white/20 border border-white/30 backdrop-blur-md text-white rounded-xl transition-all font-bold text-sm">
                        <i class="fas fa-book-reader mr-2"></i>
                        Panduan Upload
                    </button>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-4 md:p-8">

                @if($canEdit)
                    {{-- EDITABLE FORM --}}
                    <form action="{{ route('pbj.store', $year) }}" method="POST" enctype="multipart/form-data" class="space-y-6 md:space-y-10" id="pbjForm">
                        @csrf
                        @php $number = 1; @endphp
                        @forelse ($questions as $question)
                            <div class="p-5 md:p-8 border border-gray-100 rounded-2xl shadow-sm bg-white hover:border-blue-200 transition-colors">
                                <div class="flex items-start">
                                    <span class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-sm md:text-lg mr-4">{{ $number++ }}</span>
                                    <h3 class="font-bold text-base md:text-xl text-gray-800 pt-1 leading-snug">{{ $question->question }}</h3>
                                </div>
                                
                                @if ($question->children->isNotEmpty())
                                    <div class="mt-6">
                                        @include('frontend.pages.pbj._editable_question_children', ['children' => $question->children, 'level' => 1, 'existingAnswers' => $existingAnswers, 'canEdit' => $canEdit, 'categories' => $categories])
                                    </div>
                                @else
                                    @php $answer = $existingAnswers->get($question->id); @endphp
                                    <div class="mt-6 space-y-5 ml-0 md:ml-14">
                                        @if($question->requires_link_submission)
                                        <div class="grid grid-cols-1 gap-4">
                                            <div class="space-y-1.5">
                                                <label for="answers_{{ $question->id }}_url" class="text-xs md:text-sm font-bold text-gray-700 ml-1">Link Dokumen (URL)</label>
                                                <input type="url" name="answers[{{ $question->id }}][url]" id="answers_{{ $question->id }}_url" 
                                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all url-input" 
                                                    placeholder="https://sirup.lkpp.go.id/..." value="{{ old('answers.' . $question->id . '.url', $answer->document_url ?? '') }}" data-question-id="{{ $question->id }}">
                                            </div>
                                            @if($canEdit)
                                            <div class="space-y-1.5">
                                                <label for="answers_{{ $question->id }}_category" class="text-xs md:text-sm font-bold text-gray-700 ml-1">Klafikasi PPID</label>
                                                @php
                                                    $currentVal = old('answers.' . $question->id . '.category', $answer->informasi->category ?? '');
                                                    $optList = collect($categories)->map(fn($c) => ['value' => $c, 'label' => $c])->toArray();
                                                @endphp
                                                <x-custom-select 
                                                    name="answers[{{ $question->id }}][category]" 
                                                    id="answers_{{ $question->id }}_category"
                                                    :options="$optList" 
                                                    :value="$currentVal"
                                                    placeholder="-- Pilih Klasifikasi --"
                                                    @change="handleInputChange({ target: $el.querySelector('input[type=hidden]') })"
                                                />
                                            </div>
                                            @endif
                                        </div>
                                        @endif

                                        @if($question->requires_file_submission)
                                        <div class="grid grid-cols-1 gap-4">
                                            <div class="space-y-2">
                                                <label for="answers_{{ $question->id }}_file" class="text-xs md:text-sm font-bold text-gray-700 ml-1">Upload Berkas</label>
                                                @if($answer && $answer->document_file_path)
                                                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 flex items-center justify-between mb-2">
                                                        <span class="text-[10px] md:text-xs text-blue-700 font-medium truncate max-w-[200px] md:max-w-xs">
                                                            <i class="fas fa-file-pdf mr-2"></i>{{ basename($answer->document_file_path) }}
                                                        </span>
                                                        <a href="{{ asset('storage/' . $answer->document_file_path) }}" target="_blank" class="text-[10px] md:text-xs font-bold text-blue-600 hover:text-blue-800 uppercase tracking-wider">Buka</a>
                                                    </div>
                                                @endif
                                                <input type="file" name="answers[{{ $question->id }}][file]" id="answers_{{ $question->id }}_file" 
                                                    class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition-all">
                                            </div>
                                            @if($canEdit)
                                            <div class="space-y-1.5">
                                                <label for="answers_{{ $question->id }}_file_category" class="text-xs md:text-sm font-bold text-gray-700 ml-1">Klafikasi PPID</label>
                                                @php
                                                    $currentFileVal = old('answers.' . $question->id . '.category', $answer->informasi->category ?? '');
                                                    $optFileList = collect($categories)->map(fn($c) => ['value' => $c, 'label' => $c])->toArray();
                                                @endphp
                                                <x-custom-select 
                                                    name="answers[{{ $question->id }}][category]" 
                                                    id="answers_{{ $question->id }}_file_category"
                                                    :options="$optFileList" 
                                                    :value="$currentFileVal"
                                                    placeholder="-- Pilih Klasifikasi --"
                                                    @change="handleInputChange({ target: $el.querySelector('input[type=hidden]') })"
                                                />
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-16 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                                <i class="fas fa-folder-open text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500 font-medium">Tidak ada pertanyaan kuesioner ditemukan.</p>
                            </div>
                        @endforelse

                        @if($questions->isNotEmpty())
                        <div class="sticky bottom-6 left-0 right-0 px-4 md:px-0 mt-8">
                            <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-xl hover:shadow-blue-500/20 transition-all active:scale-[0.98]">
                                <i class="fas fa-save mr-3 text-lg"></i>
                                SIMPAN SEMUA JAWABAN
                            </button>
                        </div>
                        @endif
                    </form>
                @else
                    {{-- READ-ONLY VIEW --}}
                    <div class="space-y-6 md:space-y-8">
                        @php $number = 1; @endphp
                        @forelse ($questions as $question)
                            <div class="p-5 md:p-8 border border-gray-100 rounded-2xl shadow-sm bg-white hover:border-blue-100 transition-colors">
                                @php $answer = $existingAnswers->get($question->id); @endphp
                                <div class="flex items-start">
                                    <span class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 rounded-xl bg-gray-50 text-gray-400 flex items-center justify-center font-bold text-sm md:text-lg mr-4">{{ $number++ }}</span>
                                    <div class="flex-1 pt-1">
                                        @if($answer && $answer->informasi)
                                            <a href="{{ route('frontend.informasi.detail', $answer->informasi->slug) }}" class="text-base md:text-xl font-bold text-blue-600 hover:text-blue-800 leading-tight block">
                                                {{ $question->question }}
                                                <i class="fas fa-external-link-alt ml-2 text-xs opacity-50"></i>
                                            </a>
                                        @else
                                            <h3 class="text-base md:text-xl font-bold text-gray-800 leading-tight">{{ $question->question }}</h3>
                                        @endif
                                    </div>
                                </div>

                                @if ($question->children->isNotEmpty())
                                    <div class="mt-6">
                                        @include('frontend.pages.pbj._readonly_question_children', ['children' => $question->children, 'level' => 1, 'existingAnswers' => $existingAnswers])
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-16 bg-gray-50 rounded-2xl border border-dashed">
                                <p class="text-gray-500 font-medium">Data kuesioner belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlInputs = document.querySelectorAll('.url-input');
        urlInputs.forEach(input => {
            input.addEventListener('input', function () {
                const questionId = this.dataset.questionId;
                const categorySelect = document.getElementById(`answers_${questionId}_category`);
                if (categorySelect) {
                    if (this.value) {
                        categorySelect.required = true;
                    } else {
                        categorySelect.required = false;
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection
