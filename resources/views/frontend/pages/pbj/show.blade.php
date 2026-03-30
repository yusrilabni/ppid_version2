@extends('frontend.layouts.app')

@section('title', 'Kuesioner PBJ Tahun ' . $year)

@section('content')
<div x-data="{ 
    showModal: @json($show_pedoman_modal ?? false),
    hasReadPanduan: false,
    checkScroll(e) {
        const el = e.target;
        // Jika sisa scroll kurang dari 50px, anggap sudah sampai bawah
        if (el.scrollHeight - el.scrollTop <= el.clientHeight + 50) {
            this.hasReadPanduan = true;
        }
    },
    init() {
        if (this.showModal) {
            this.$nextTick(() => {
                const el = this.$refs.modalBody;
                if (el && el.scrollHeight <= el.clientHeight) {
                    this.hasReadPanduan = true;
                }
            });
        }
        this.$watch('showModal', value => {
            if (value) {
                this.$nextTick(() => {
                    const el = this.$refs.modalBody;
                    if (el && el.scrollHeight <= el.clientHeight) {
                        this.hasReadPanduan = true;
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
        {{-- Modal Panduan --}}
        <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="showModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showModal" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 md:px-8 py-5 md:py-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-white/20 rounded-full p-2.5 md:p-3 mr-3 md:mr-4">
                                <i class="fas fa-file-alt text-white text-xl md:text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl md:text-2xl font-bold text-white leading-tight" id="modal-headline">
                                    PANDUAN KLASIFIKASI PBJ
                                </h3>
                                <p class="text-blue-100 text-[10px] md:text-sm">(Wajib Dibaca Admin PPID sebelum Upload)</p>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 md:px-8 py-6 max-h-[60vh] md:max-h-[65vh] overflow-y-auto" @scroll="checkScroll" x-ref="modalBody">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                            <div class="space-y-4">
                                <h4 class="text-base md:text-lg font-bold text-gray-800 flex items-center border-b pb-2"><i class="fas fa-lightbulb text-yellow-500 mr-2"></i> PRINSIP UTAMA</h4>
                                <ul class="space-y-3 text-sm text-gray-700">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-blue-500 mt-1 mr-2 text-xs"></i>
                                        <span>Klasifikasi ditentukan oleh <span class="font-bold">jenis dokumen</span>, bukan tahun.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-blue-500 mt-1 mr-2 text-xs"></i>
                                        <span><span class="font-bold text-blue-600">Informasi Berkala</span> tidak pernah berubah jadi <span class="font-bold text-green-600">Setiap Saat</span>.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-blue-500 mt-1 mr-2 text-xs"></i>
                                        <span>Dokumen PBJ detail adalah <span class="font-bold text-green-600">Setiap Saat</span> sejak awal.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-blue-500 mt-1 mr-2 text-xs"></i>
                                        <span>Dokumen lama <span class="font-bold text-red-600">tidak dihapus</span>, hanya diarsipkan.</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="bg-red-50 border border-red-100 p-5 rounded-xl">
                                <h4 class="text-base md:text-lg font-bold text-red-800 mb-3 flex items-center"><i class="fas fa-exclamation-triangle mr-2"></i> KESALAHAN FATAL</h4>
                                <ul class="space-y-2 text-sm text-red-700">
                                    <li class="flex items-center"><i class="fas fa-times-circle mr-2 text-xs"></i> Salah menu upload</li>
                                    <li class="flex items-center"><i class="fas fa-times-circle mr-2 text-xs"></i> Mengubah klasifikasi tanpa dasar</li>
                                    <li class="flex items-center"><i class="fas fa-times-circle mr-2 text-xs"></i> Menghapus dokumen PBJ lama</li>
                                    <li class="flex items-center"><i class="fas fa-times-circle mr-2 text-xs"></i> Tidak memberi keterangan tahun/status</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-blue-50 p-5 rounded-xl border border-blue-100">
                                <h4 class="text-sm md:text-base font-bold text-blue-800 mb-3 flex items-center uppercase"><i class="fas fa-calendar-alt mr-2"></i> Informasi Berkala</h4>
                                <p class="text-[10px] md:text-xs text-blue-600 mb-3 font-semibold">(Menu Berkala)</p>
                                <ul class="space-y-1.5 text-[13px] text-gray-700">
                                    <li class="flex items-center"><i class="fas fa-caret-right mr-2 text-blue-400"></i> Rencana Umum Pengadaan (RUP)</li>
                                    <li class="flex items-center"><i class="fas fa-caret-right mr-2 text-blue-400"></i> Link SIRUP</li>
                                    <li class="flex items-center"><i class="fas fa-caret-right mr-2 text-blue-400"></i> Rekap RUP Tahunan / Semesteran</li>
                                    <li class="flex items-center"><i class="fas fa-caret-right mr-2 text-blue-400"></i> Pengumuman / Rekap Paket PBJ</li>
                                </ul>
                            </div>
                            <div class="bg-green-50 p-5 rounded-xl border border-green-100">
                                <h4 class="text-sm md:text-base font-bold text-green-800 mb-3 flex items-center uppercase"><i class="fas fa-clock mr-2"></i> Informasi Setiap Saat</h4>
                                <p class="text-[10px] md:text-xs text-green-600 mb-3 font-semibold">(Menu Setiap Saat)</p>
                                <ul class="space-y-1.5 text-[13px] text-gray-700">
                                    <li class="flex items-center"><i class="fas fa-caret-right mr-2 text-green-400"></i> KAK, HPS, Kontrak, & Addendum</li>
                                    <li class="flex items-center"><i class="fas fa-caret-right mr-2 text-green-400"></i> Dokumen Pemilihan & Kualifikasi</li>
                                    <li class="flex items-center"><i class="fas fa-caret-right mr-2 text-green-400"></i> SPPBJ, SPMK, SPM, SP2D</li>
                                    <li class="flex items-center"><i class="fas fa-caret-right mr-2 text-green-400"></i> Laporan, BAPH, Jaminan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 border-t border-gray-100 px-6 md:px-8 py-4 text-center md:text-right min-h-[80px] flex items-center justify-center md:justify-end">
                        <button type="button" 
                            x-show="hasReadPanduan"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                            @click="showModal = false" 
                            class="w-full md:w-auto inline-flex justify-center rounded-xl px-8 py-2.5 bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 shadow-md transition-all active:scale-[0.98]">
                            Saya Mengerti
                        </button>
                        <p x-show="!hasReadPanduan" class="text-xs text-gray-400 italic">
                            <i class="fas fa-arrow-down mr-1 animate-bounce"></i>
                            Silakan baca panduan sampai bawah untuk melanjutkan
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
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
                                                <select name="answers[{{ $question->id }}][category]" id="answers_{{ $question->id }}_category" 
                                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                                    <option value="">-- Pilih Klasifikasi --</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category }}" {{ (old('answers.' . $question->id . '.category', $answer->informasi->category ?? '') == $category) ? 'selected' : '' }}>
                                                            {{ $category }}
                                                        </option>
                                                    @endforeach
                                                </select>
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
                                                <select name="answers[{{ $question->id }}][category]" id="answers_{{ $question->id }}_file_category" 
                                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                                    <option value="">-- Pilih Klasifikasi --</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category }}" {{ (old('answers.' . $question->id . '.category', $answer->informasi->category ?? '') == $category) ? 'selected' : '' }}>
                                                            {{ $category }}
                                                        </option>
                                                    @endforeach
                                                </select>
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
