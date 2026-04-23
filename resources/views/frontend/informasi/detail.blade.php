@extends('frontend.layouts.app')

@section('title', $informasi->title)

@section('content')
<div class="bg-gray-50 min-h-screen" x-data="{ sideMenuOpen: false }">
    <div class="container mx-auto py-4 pb-24 lg:pb-8 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Breadcrumbs - Compact on Mobile & Aligned with Body -->
            <div class="mb-4">
                @php
                    $categoryIcon = 'fas fa-info-circle';
                    if (str_contains($informasi->category, 'Berkala')) $categoryIcon = 'fas fa-calendar-alt';
                    elseif (str_contains($informasi->category, 'Setiap Saat')) $categoryIcon = 'fas fa-clock';
                    elseif (str_contains($informasi->category, 'Serta Merta')) $categoryIcon = 'fas fa-exclamation-triangle';
                    elseif (str_contains($informasi->category, 'Dikecualikan')) $categoryIcon = 'fas fa-ban';
                @endphp
                <x-breadcrumbs :breadcrumbs="[
                    ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                    ['title' => $informasi->category, 'url' => route('frontend.informasi.category', ['category' => $informasi->category_slug]), 'icon' => $categoryIcon],
                    ['title' => Str::limit($informasi->title, 25), 'url' => '#', 'icon' => 'fas fa-file-alt']
                ]" />
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- MAIN CONTENT AREA -->
                <div class="flex-1 min-w-0">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        
                        <!-- Premium Header -->
                        <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-6 sm:p-10 text-white relative">
                            <div class="relative z-10">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="bg-white/20 backdrop-blur-sm text-[10px] font-black px-2 py-1 rounded uppercase tracking-widest border border-white/20">
                                        {{ $informasi->category }}
                                    </span>
                                    @if($informasi->status == 'ARSIP')
                                    <span class="bg-red-500 text-[10px] font-black px-2 py-1 rounded uppercase tracking-widest">ARSIP</span>
                                    @endif
                                </div>
                                <h1 class="text-2xl sm:text-4xl font-black leading-tight">{{ $informasi->title }}</h1>
                            </div>
                            <!-- Abstract decoration -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full -mr-16 -mt-16 blur-3xl text-blue-500"></div>
                        </div>

                        <!-- Content Body -->
                        <div class="p-6 sm:p-10">
                            
                            <!-- Quick Info Mobile Only Bar -->
                            <div class="lg:hidden flex items-center justify-between p-4 bg-gray-50 rounded-2xl mb-8 border border-gray-100">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm mr-3">
                                        <i class="fas fa-building text-blue-600 text-xs"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Unit Kerja</p>
                                        <p class="text-xs font-bold text-gray-700 truncate w-32">{{ $unitName }}</p>
                                    </div>
                                </div>
                                <button @click="sideMenuOpen = true" class="bg-blue-600 text-white text-[10px] font-bold px-4 py-2 rounded-lg shadow-lg shadow-blue-100">
                                    INFO <i class="fas fa-chevron-right ml-1"></i>
                                </button>
                            </div>

                            <!-- Description -->
                            <div class="mb-12">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                        <span class="w-1 h-6 bg-blue-600 rounded-full mr-3"></span>
                                        Ringkasan
                                    </h2>
                                </div>
                                <div id="doc-description" class="text-gray-600 leading-relaxed text-base sm:text-lg bg-slate-50 p-6 rounded-3xl border border-slate-100 italic">
                                    {{ $informasi->deskripsi ?: 'Tidak ada deskripsi tersedia.' }}
                                </div>
                            </div>

                            <!-- Full Content -->
                            @if($informasi->content)
                            <div class="mb-12">
                                <h2 class="text-xl font-bold text-gray-900 flex items-center mb-6">
                                    <span class="w-1 h-6 bg-indigo-600 rounded-full mr-3"></span>
                                    Informasi Lengkap
                                </h2>
                                <div id="doc-full-content" class="prose prose-slate max-w-none text-gray-700">
                                    {!! $informasi->content !!}
                                </div>
                            </div>
                            @endif

                            <!-- Attachment -->
                            <div class="mb-6">
                                <h2 class="text-xl font-bold text-gray-900 flex items-center mb-6">
                                    <span class="w-1 h-6 bg-orange-600 rounded-full mr-3"></span>
                                    Dokumen Lampiran
                                </h2>
                                
                                @php
                                    $fileUrl = $informasi->url ?: ($informasi->file ? asset('storage/' . $informasi->file) : null);
                                    $filePath = $informasi->url ?: $informasi->file;
                                    $fileExtension = null;
                                    if ($filePath) {
                                        $pathOnly = parse_url($filePath, PHP_URL_PATH);
                                        $fileExtension = strtolower(pathinfo($pathOnly, PATHINFO_EXTENSION));
                                    }

                                    $isPdf = $fileUrl && $fileExtension === 'pdf';
                                    $isImage = $fileUrl && in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                                    $isOffice = $fileUrl && in_array($fileExtension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']);
                                    $isGoogleDrive = $fileUrl && str_contains($fileUrl, 'drive.google.com');
                                    
                                    // Handle Google Drive Preview Link
                                    $previewUrl = $fileUrl;
                                    if ($isGoogleDrive) {
                                        if (str_contains($fileUrl, '/view')) {
                                            $previewUrl = str_replace('/view', '/preview', $fileUrl);
                                        }
                                    }
                                @endphp

                                @if($fileUrl)
                                    <div class="mb-8">
                                        @if($isPdf)
                                            <div class="rounded-3xl overflow-hidden border border-gray-100 shadow-2xl bg-gray-100 h-[500px] sm:h-[800px] relative group/preview">
                                                <iframe src="{{ $fileUrl }}#toolbar=0" class="w-full h-full border-0"></iframe>
                                                <div class="absolute top-4 right-4 opacity-0 group-hover/preview:opacity-100 transition-opacity">
                                                    <a href="{{ $fileUrl }}" target="_blank" class="bg-white/90 backdrop-blur px-4 py-2 rounded-xl shadow-lg text-xs font-bold text-blue-600 flex items-center">
                                                        <i class="fas fa-expand mr-2"></i> LAYAR PENUH
                                                    </a>
                                                </div>
                                            </div>
                                        @elseif($isImage)
                                            <div class="rounded-3xl overflow-hidden border border-gray-100 p-2 sm:p-4 bg-gray-50 flex justify-center shadow-inner">
                                                <img src="{{ $fileUrl }}" alt="Preview" class="max-w-full h-auto rounded-2xl shadow-2xl border-4 border-white">
                                            </div>
                                        @elseif($isGoogleDrive)
                                            <div class="rounded-3xl overflow-hidden border border-gray-100 shadow-2xl bg-gray-100 h-[500px] sm:h-[800px] relative">
                                                <iframe src="{{ $previewUrl }}" class="w-full h-full border-0" allow="autoplay"></iframe>
                                            </div>
                                        @elseif($isOffice)
                                            <div class="rounded-3xl overflow-hidden border border-gray-100 shadow-2xl bg-gray-100 h-[500px] sm:h-[800px] relative">
                                                <iframe src="https://docs.google.com/viewer?url={{ urlencode($fileUrl) }}&embedded=true" class="w-full h-full border-0"></iframe>
                                            </div>
                                        @else
                                            <div class="p-10 sm:p-16 bg-gradient-to-br from-gray-50 to-slate-100 border-2 border-dashed border-gray-200 rounded-[2.5rem] text-center">
                                                <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-slate-200">
                                                    <i class="fas fa-link text-3xl text-blue-500"></i>
                                                </div>
                                                <h3 class="text-xl font-black text-slate-800 mb-2">Pratinjau Tidak Tersedia</h3>
                                                <p class="text-sm text-slate-500 max-w-xs mx-auto leading-relaxed">Dokumen ini merupakan tautan eksternal yang memerlukan akses langsung ke situs penyedia.</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                                        @if($informasi->url)
                                            <a href="{{ route('frontend.informasi.visit-url', $informasi->id) }}" target="_blank" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-black py-4 px-8 rounded-2xl text-center shadow-xl shadow-blue-200 transition-all active:scale-95">
                                                BUKA TAUTAN <i class="fas fa-external-link-alt ml-2"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('frontend.informasi.download', $informasi->id) }}" target="_blank" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-black py-4 px-8 rounded-2xl text-center shadow-xl shadow-green-200 transition-all active:scale-95">
                                                UNDUH DOKUMEN <i class="fas fa-download ml-2"></i>
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <div class="p-12 bg-gray-50 border-2 border-dashed border-gray-200 rounded-[2rem] text-center">
                                        <i class="fas fa-file-excel text-4xl text-gray-300 mb-4"></i>
                                        <p class="font-bold text-gray-400">Belum ada lampiran tersedia</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Related Documents from Same Unit -->
                            @if($relatedInformasis->isNotEmpty())
                            <div class="mt-16 pt-12 border-t border-gray-100">
                                <h2 class="text-xl font-bold text-gray-900 flex items-center mb-8">
                                    <span class="w-1 h-6 bg-blue-600 rounded-full mr-3"></span>
                                    Dokumen Terkait dari Unit Ini
                                </h2>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($relatedInformasis as $related)
                                        <a href="{{ route('frontend.informasi.detail', $related->slug) }}" class="group flex items-center p-4 bg-gray-50 hover:bg-white border border-transparent hover:border-blue-100 rounded-2xl transition-all duration-300 shadow-sm hover:shadow-md">
                                            <div class="w-10 h-10 bg-white group-hover:bg-blue-600 text-blue-600 group-hover:text-white rounded-xl flex items-center justify-center shrink-0 transition-colors duration-300">
                                                <i class="fas fa-file-alt text-sm"></i>
                                            </div>
                                            <div class="ml-4 min-w-0">
                                                <p class="text-sm font-bold text-gray-800 truncate group-hover:text-blue-600 transition-colors">{{ $related->title }}</p>
                                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">{{ \Carbon\Carbon::parse($related->tanggal_upload)->format('d M Y') }}</p>
                                            </div>
                                            <i class="fas fa-chevron-right ml-auto text-gray-300 group-hover:text-blue-600 text-[10px] transition-all group-hover:translate-x-1"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>

                <!-- DESKTOP SIDEBAR -->
                <aside class="hidden lg:block w-80 shrink-0">
                    <div class="sticky top-24 space-y-6">
                        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-8">Metadata Dokumen</h3>
                            
                            <div class="space-y-8">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                                        <i class="fas fa-building text-blue-600 text-sm"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Unit Kerja</p>
                                        <p class="text-sm font-bold text-gray-800 leading-tight">{{ $unitName }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center shrink-0">
                                        <i class="fas fa-file-signature text-orange-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Jenis Dokumen</p>
                                        <p class="text-sm font-bold text-gray-800 leading-tight">{{ $informasi->jenis_dokumen ?: 'Informasi Publik' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center shrink-0">
                                        <i class="fas fa-user-check text-emerald-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Pengunggah</p>
                                        <p class="text-sm font-bold text-gray-800 leading-tight">{{ $uploaderName }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center shrink-0">
                                        <i class="fas fa-calendar-alt text-purple-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Tanggal</p>
                                        <p class="text-sm font-bold text-gray-800 leading-tight">{{ \Carbon\Carbon::parse($informasi->tanggal_upload)->format('d/m/Y') }}</p>
                                    </div>
                                </div>

                                <div class="pt-8 border-t border-gray-50">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="bg-gray-50 rounded-2xl p-4 text-center">
                                            <p class="text-[9px] font-black text-gray-400 uppercase mb-1">Dilihat</p>
                                            <p class="text-xl font-black text-slate-800">{{ $informasi->views_count ?? 0 }}</p>
                                        </div>
                                        <div class="bg-gray-50 rounded-2xl p-4 text-center">
                                            <p class="text-[9px] font-black text-gray-400 uppercase mb-1">Unduh</p>
                                            <p class="text-xl font-black text-slate-800">{{ $informasi->download_count ?? 0 }}</p>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('frontend.informasi.category', $informasi->category_slug) }}" class="flex items-center justify-center w-full py-4 bg-slate-900 text-white font-bold rounded-2xl text-xs hover:bg-black transition-all">
                                    <i class="fas fa-arrow-left mr-2"></i> KEMBALI
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </div>

    <!-- MOBILE FLOATING INFO BUTTON (Hides when Side Menu is Open) -->
    <button 
        x-show="!sideMenuOpen"
        x-transition.scale
        @click="sideMenuOpen = true" 
        class="lg:hidden fixed bottom-6 right-6 w-16 h-16 bg-blue-600 text-white rounded-full shadow-2xl flex items-center justify-center z-40 transition-transform active:scale-90 border-4 border-white"
    >
        <i class="fas fa-info-circle text-2xl"></i>
    </button>

    <!-- MOBILE DRAWER (SIDE MENU FROM LEFT like UserWay) -->
    <div x-cloak x-show="sideMenuOpen" class="fixed inset-0 z-50 lg:hidden overflow-hidden">
        <!-- Overlay -->
        <div @click="sideMenuOpen = false" x-show="sideMenuOpen" x-transition.opacity class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        
        <!-- Drawer Panel (Sliding from LEFT) -->
        <div 
            x-show="sideMenuOpen" 
            x-transition:enter="transition ease-out duration-300 transform" 
            x-transition:enter-start="-translate-x-full" 
            x-transition:enter-end="translate-x-0" 
            x-transition:leave="transition ease-in duration-200 transform" 
            x-transition:leave-start="translate-x-0" 
            x-transition:leave-end="-translate-x-full" 
            class="absolute inset-y-0 left-0 max-w-full w-[80%] max-w-xs bg-white shadow-2xl flex flex-col border-r border-gray-100"
        >
            <!-- Close Button Header -->
            <div class="p-6 bg-slate-900 text-white flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-black uppercase tracking-tighter">Widget Info</h2>
                    <p class="text-[10px] text-slate-400 font-bold">Detail Dokumen PPID</p>
                </div>
                <button @click="sideMenuOpen = false" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-8">
                <!-- Unit Kerja -->
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-blue-100">
                        <i class="fas fa-building text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Unit Kerja</p>
                        <p class="text-sm font-bold text-slate-800 leading-tight break-words">{{ $unitName }}</p>
                    </div>
                </div>

                <!-- Jenis Dokumen -->
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <div class="w-10 h-10 bg-orange-500 text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-orange-100">
                        <i class="fas fa-file-signature text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jenis Dokumen</p>
                        <p class="text-sm font-bold text-slate-800 leading-tight">{{ $informasi->jenis_dokumen ?: 'Informasi Publik' }}</p>
                    </div>
                </div>

                <!-- Pengunggah -->
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <div class="w-10 h-10 bg-emerald-600 text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-emerald-100">
                        <i class="fas fa-user-shield text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pengunggah</p>
                        <p class="text-sm font-bold text-slate-800 leading-tight">{{ $uploaderName }}</p>
                    </div>
                </div>

                <!-- Tanggal -->
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <div class="w-10 h-10 bg-purple-600 text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-purple-100">
                        <i class="fas fa-calendar-day text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tanggal</p>
                        <p class="text-sm font-bold text-slate-800 leading-tight">{{ \Carbon\Carbon::parse($informasi->tanggal_upload)->format('d F Y') }}</p>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-4 rounded-2xl text-center border border-blue-100">
                        <p class="text-[10px] font-black text-blue-400 uppercase mb-1">Dilihat</p>
                        <p class="text-xl font-black text-blue-700">{{ $informasi->views_count ?? 0 }}</p>
                    </div>
                    <div class="bg-emerald-50 p-4 rounded-2xl text-center border border-emerald-100">
                        <p class="text-[10px] font-black text-emerald-400 uppercase mb-1">Unduhan</p>
                        <p class="text-xl font-black text-emerald-700">{{ $informasi->download_count ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="p-6 space-y-3">
                <button @click="sideMenuOpen = false" class="w-full py-4 bg-slate-900 text-white font-black rounded-2xl text-[10px] tracking-widest shadow-xl">
                    KEMBALI KE BACAAN
                </button>
            </div>
        </div>
    </div>
</div>
@endsection