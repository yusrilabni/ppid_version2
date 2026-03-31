@extends('frontend.layouts.app')

@section('title', $pageTitle)

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-6xl">
        {{-- Header Section --}}
        <div class="text-center mb-12">
            <div class="inline-block p-3 bg-blue-100 rounded-2xl mb-4">
                <i class="fas fa-plug text-blue-600 text-3xl"></i>
            </div>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Widget Informasi PPID</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Tampilkan feed data informasi publik secara visual dan interaktif langsung di website Anda.</p>
        </div>

        {{-- Generator Widget --}}
        <section class="bg-white rounded-[3rem] shadow-xl border border-gray-100 p-8 md:p-12 mb-12 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full -mr-32 -mt-32 opacity-50"></div>
            
            <div class="relative z-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 flex items-center">
                    <span class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-blue-200">
                        <i class="fas fa-magic"></i>
                    </span>
                    Kustomisasi Widget Anda
                </h2>

                <div x-data="{ 
                    type: 'latest', 
                    limit: 5, 
                    unitId: '', 
                    year: '',
                    get embedUrl() { 
                        let url = '{{ route('extra.widgets.embed') }}?type=' + this.type + '&limit=' + this.limit;
                        if (this.unitId) url += '&unit_id=' + this.unitId;
                        if (this.year) url += '&year=' + this.year;
                        return url;
                    } 
                }">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        {{-- Controls --}}
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Jenis Konten</label>
                                    <select x-model="type" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                        <option value="latest">Informasi Terbaru</option>
                                        <option value="popular">Paling Banyak Dilihat</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Jumlah Data</label>
                                    <select x-model="limit" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                        <option value="3">3 Item</option>
                                        <option value="5">5 Item</option>
                                        <option value="10">10 Item</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Filter Per OPD (Instansi)</label>
                                    <select x-model="unitId" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                        <option value="">Semua Instansi</option>
                                        @foreach($organizations as $org)
                                            <option value="{{ $org->unit_id }}">{{ $org->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Filter Tahun</label>
                                    <select x-model="year" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                        <option value="">Semua Tahun</option>
                                        @foreach($years as $y)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="pt-6">
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Salin Kode Embed</label>
                                <div class="relative group">
                                    <textarea id="embedCode" readonly x-text="'<iframe src=\'' + embedUrl + '\' width=\'100%\' height=\'450\' frameborder=\'0\'></iframe>'" 
                                        class="w-full bg-gray-900 text-blue-400 font-mono text-xs p-4 rounded-2xl h-24 border-0 focus:ring-0 resize-none"></textarea>
                                    <button @click="
                                        const el = document.getElementById('embedCode');
                                        el.select();
                                        document.execCommand('copy');
                                        alert('Kode berhasil disalin ke clipboard!');
                                    "
                                        class="absolute top-2 right-2 bg-white/10 hover:bg-white/20 text-white px-3 py-1 rounded-lg text-[10px] font-bold backdrop-blur-sm transition-all">
                                        SALIN KODE
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Preview --}}
                        <div class="bg-gray-50 rounded-[2rem] p-4 border-4 border-dashed border-gray-200 flex flex-col">
                            <div class="flex justify-between items-center mb-4 px-2">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Live Preview</span>
                                <div class="flex space-x-1">
                                    <div class="w-2 h-2 rounded-full bg-red-300"></div>
                                    <div class="w-2 h-2 rounded-full bg-yellow-300"></div>
                                    <div class="w-2 h-2 rounded-full bg-green-300"></div>
                                </div>
                            </div>
                            <div class="flex-grow bg-white rounded-2xl shadow-inner overflow-hidden min-h-[350px]">
                                <iframe :src="embedUrl" width="100%" height="450" class="border-0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- DETAIL GUIDE SECTION (WordPress & Custom) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            {{-- WordPress Detailed Steps --}}
            <div class="lg:col-span-2 space-y-8">
                <section class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 md:p-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fab fa-wordpress text-blue-500 mr-3 text-3xl"></i>
                        Langkah Detail Pemasangan di WordPress
                    </h2>
                    
                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center font-bold mr-4 flex-shrink-0">1</div>
                            <div>
                                <h4 class="font-bold text-gray-800">Gunakan Block "Custom HTML"</h4>
                                <p class="text-sm text-gray-600 mt-1">Buka editor postingan atau halaman Anda. Klik tombol <strong>(+) Tambah Blok</strong>, cari dan pilih blok bernama <strong>"Custom HTML"</strong> (atau HTML Khusus).</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center font-bold mr-4 flex-shrink-0">2</div>
                            <div>
                                <h4 class="font-bold text-gray-800">Tempelkan Kode Iframe</h4>
                                <p class="text-sm text-gray-600 mt-1">Salin kode dari generator di atas, lalu tempelkan ke dalam kotak input HTML yang muncul di WordPress.</p>
                            </div>
                        </div>

                        <div class="flex items-start border-l-4 border-blue-500 pl-6 bg-blue-50 py-4 rounded-r-2xl">
                            <div>
                                <h4 class="font-bold text-blue-800 flex items-center">
                                    <i class="fas fa-arrows-alt-v mr-2"></i> Mengatur Lebar & Tinggi (PENTING)
                                </h4>
                                <div class="mt-3 space-y-3 text-sm text-blue-900/80">
                                    <p><strong>Lebar (Width):</strong> Selalu biarkan <code>width="100%"</code> agar widget otomatis mengikuti lebar area sidebar atau konten Anda (Responsive).</p>
                                    <p><strong>Tinggi (Height):</strong> Atur nilai <code>height="..."</code> sesuai dengan jumlah item yang Anda pilih agar tidak muncul scrollbar ganda:</p>
                                    <ul class="list-disc ml-5 space-y-1">
                                        <li>3 Item: Gunakan <code>height="300"</code></li>
                                        <li>5 Item: Gunakan <code>height="450"</code></li>
                                        <li>10 Item: Gunakan <code>height="800"</code></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center font-bold mr-4 flex-shrink-0">3</div>
                            <div>
                                <h4 class="font-bold text-gray-800">Pratinjau & Simpan</h4>
                                <p class="text-sm text-gray-600 mt-1">Klik tombol <strong>Preview</strong> di atas blok untuk melihat hasilnya. Jika sudah pas, klik <strong>Publish/Update</strong>.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-code text-purple-500 mr-2"></i> Integrasi Elementor
                    </h2>
                    <p class="text-sm text-gray-600 mb-4">Jika Anda menggunakan Elementor Page Builder, gunakan widget <strong>"HTML"</strong>. Seret widget tersebut ke kolom yang diinginkan, lalu tempel kode iframe yang sudah Anda salin.</p>
                    <div class="bg-gray-50 p-4 rounded-xl text-xs text-purple-800 font-medium">
                        Tips: Gunakan pengaturan "Margin" atau "Padding" pada kolom Elementor untuk merapikan jarak widget dengan elemen lain.
                    </div>
                </section>
            </div>

            {{-- Sidebar Technical Info --}}
            <div class="space-y-8">
                <section class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-[2.5rem] p-8 text-white">
                    <h3 class="text-lg font-bold mb-4 flex items-center text-blue-400">
                        <i class="fas fa-info-circle mr-2"></i> Tips Teknis
                    </h3>
                    <div class="space-y-6 text-sm opacity-90">
                        <div>
                            <h4 class="font-bold text-white">Auto-Update</h4>
                            <p class="mt-1">Konten di dalam widget ini di-cache selama 5 menit. Perubahan di database kami akan muncul otomatis tanpa perlu ganti kode.</p>
                        </div>
                        <hr class="border-white/10">
                        <div>
                            <h4 class="font-bold text-white">SSL (HTTPS)</h4>
                            <p class="mt-1">Widget kami mendukung HTTPS secara penuh, sehingga aman dipasang di website mana pun tanpa peringatan keamanan.</p>
                        </div>
                        <hr class="border-white/10">
                        <div>
                            <h4 class="font-bold text-white">No-Style Conflict</h4>
                            <p class="mt-1">Karena menggunakan Iframe, CSS website Anda tidak akan merusak tampilan widget, dan CSS widget tidak akan merusak website Anda.</p>
                        </div>
                    </div>
                </section>

                <section class="bg-blue-50 border border-blue-100 rounded-[2.5rem] p-8">
                    <h3 class="text-lg font-bold text-blue-800 mb-4">Bantuan Teknis</h3>
                    <p class="text-sm text-blue-700 leading-relaxed">Jika Anda mengalami kendala saat pemasangan widget pada CMS tertentu, tim IT kami siap membantu integrasi secara gratis.</p>
                    <a href="{{ route('home') }}#kontak" class="mt-4 inline-flex items-center text-blue-600 font-bold hover:underline">
                        Hubungi Admin <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </section>
            </div>
        </div>

        {{-- Footer Call to Action --}}
        <div class="bg-blue-600 rounded-[3rem] p-12 text-white text-center shadow-2xl shadow-blue-200">
            <h2 class="text-3xl font-extrabold mb-4">Sudah Siap Memasang Widget?</h2>
            <p class="text-lg opacity-80 mb-8 max-w-2xl mx-auto">Tingkatkan transparansi informasi di portal Anda sekarang juga dengan widget resmi dari PPID Kabupaten Sinjai.</p>
            <div class="flex justify-center space-x-4">
                <a href="#embedCode" class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold shadow-lg hover:bg-gray-100 transition-all">Mulai Kustomisasi</a>
            </div>
        </div>
    </div>
</div>
@endsection
