@extends('frontend.layouts.app')

@section('title', $pageTitle)

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-6xl">
        {{-- Header Section --}}
        <div class="text-center mb-16">
            <div class="inline-block p-3 bg-blue-100 rounded-2xl mb-4">
                <i class="fas fa-plug text-blue-600 text-3xl"></i>
            </div>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Widget Informasi PPID</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Tampilkan feed data informasi publik secara visual dan interaktif langsung di website Anda.</p>
        </div>

        {{-- Generator Widget --}}
        <section class="bg-white rounded-[3rem] shadow-xl border border-gray-100 p-8 md:p-12 mb-16 relative overflow-hidden">
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
                    get embedUrl() { 
                        let url = '{{ route('extra.widgets.embed') }}?type=' + this.type + '&limit=' + this.limit;
                        if (this.unitId) url += '&unit_id=' + this.unitId;
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

                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Filter Per OPD (Instansi)</label>
                                <select x-model="unitId" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                    <option value="">Semua Instansi</option>
                                    @foreach($organizations as $org)
                                        <option value="{{ $org->unit_id }}">{{ $org->name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-[10px] text-gray-400 mt-2 italic">*Kosongkan jika ingin menampilkan data dari seluruh instansi.</p>
                            </div>

                            <div class="pt-6">
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Salin Kode Embed</label>
                                <div class="relative group">
                                    <textarea readonly x-text="'<iframe src=\'' + embedUrl + '\' width=\'100%\' height=\'450\' frameborder=\'0\'></iframe>'" 
                                        class="w-full bg-gray-900 text-blue-400 font-mono text-xs p-4 rounded-2xl h-24 border-0 focus:ring-0 resize-none"></textarea>
                                    <button @click="$clipboard('<iframe src=\'' + embedUrl + '\' width=\'100%\' height=\'450\' frameborder=\'0\'></iframe>'); alert('Kode disalin!')"
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

        {{-- Additional Content: Guides & FAQ --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-rocket text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Keunggulan Widget</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Widget kami dibangun dengan teknologi asinkron sehingga tidak akan memperlambat loading website Anda. Konten akan terupdate secara otomatis setiap detik tanpa perlu campur tangan manual.</p>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-search-plus text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Manfaat SEO</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Menampilkan informasi publik yang relevan dapat meningkatkan relevansi konten di website Anda, memberikan nilai tambah bagi pengunjung, dan membantu meningkatkan visibilitas di mesin pencari.</p>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-tools text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Mudah Dipasang</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Cukup salin kode iframe di atas dan tempelkan di mana saja. Bisa di sidebar WordPress, footer website custom, atau halaman berita internal perusahaan Anda.</p>
            </div>
        </div>

        {{-- WordPress Section --}}
        <div class="mt-16 bg-gradient-to-r from-blue-600 to-blue-800 rounded-[3rem] p-12 text-white flex flex-col md:flex-row items-center">
            <div class="flex-grow md:pr-12 mb-8 md:mb-0">
                <h2 class="text-3xl font-extrabold mb-4">Integrasi WordPress & Elementor</h2>
                <p class="text-lg opacity-80 leading-relaxed">Gunakan Widget HTML atau block Custom HTML untuk memasang widget ini. Anda dapat menyesuaikan lebar (width) dan tinggi (height) sesuai dengan tata letak tema WordPress Anda.</p>
            </div>
            <div class="flex-shrink-0 flex space-x-4">
                <div class="bg-white/10 p-4 rounded-3xl backdrop-blur-md">
                    <i class="fab fa-wordpress text-5xl"></i>
                </div>
                <div class="bg-white/10 p-4 rounded-3xl backdrop-blur-md">
                    <i class="fab fa-elementor text-5xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
