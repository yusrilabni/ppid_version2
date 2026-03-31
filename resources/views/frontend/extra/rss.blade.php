@extends('frontend.layouts.app')

@section('title', $pageTitle)

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-6xl">
        {{-- Header --}}
        <div class="text-center mb-12">
            <div class="inline-block p-3 bg-orange-100 rounded-2xl mb-4">
                <i class="fas fa-rss text-orange-600 text-3xl"></i>
            </div>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">RSS Feed & Autopost</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Gunakan feed data XML untuk integrasi website atau publikasi otomatis ke Media Sosial.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Penjelasan Sinkronisasi Sosial --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span>
                        Apa itu Sinkronisasi Sosial?
                    </h2>
                    <div class="prose prose-blue text-gray-600 max-w-none space-y-4">
                        <p>Sinkronisasi Sosial adalah proses membagikan update informasi secara otomatis dari website kami ke akun Media Sosial Anda (Facebook, Twitter/X, Telegram) tanpa perlu mengetik ulang. Sistem ini bekerja dengan metode <strong>Trigger & Action</strong>:</p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                            <div class="p-4 bg-gray-50 rounded-2xl">
                                <i class="fas fa-rss text-orange-500 mb-2"></i>
                                <p class="text-xs font-bold uppercase">1. Trigger</p>
                                <p class="text-[10px]">Data baru muncul di RSS kami</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-2xl">
                                <i class="fas fa-robot text-blue-500 mb-2"></i>
                                <p class="text-xs font-bold uppercase">2. Bridge</p>
                                <p class="text-[10px]">Layanan IFTTT/Zapier membaca data</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-2xl">
                                <i class="fab fa-facebook text-blue-700 mb-2"></i>
                                <p class="text-xs font-bold uppercase">3. Action</p>
                                <p class="text-[10px]">Post otomatis terbit di Sosmed Anda</p>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-blue-600 bg-blue-50 p-4 rounded-xl italic">
                            "Artinya, setiap kali admin PPID Sinjai mengupload informasi, akun Facebook portal berita Anda akan otomatis membuat postingan yang berisi judul dan link informasi tersebut."
                        </p>
                    </div>
                </section>

                {{-- Integrasi Kode dengan Penjelasan Baris --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-purple-500 rounded-full mr-3"></span>
                        Panduan Kustomisasi URL Feed
                    </h2>
                    <p class="text-gray-600 mb-6 text-sm">Anda dapat memodifikasi URL RSS kami untuk mendapatkan data yang sangat spesifik menggunakan parameter berikut:</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <code class="text-blue-600 font-bold">unit_id</code>
                            <p class="text-[10px] text-gray-500 mt-1">Filter berdasarkan ID Instansi (lihat daftar di bawah).</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <code class="text-blue-600 font-bold">year</code>
                            <p class="text-[10px] text-gray-500 mt-1">Filter berdasarkan tahun (Contoh: 2023, 2024).</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <code class="text-blue-600 font-bold">limit</code>
                            <p class="text-[10px] text-gray-500 mt-1">Jumlah data yang ditampilkan (Default: 50).</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="p-5 bg-gray-900 rounded-2xl">
                            <p class="text-[10px] text-gray-400 uppercase font-black mb-2 tracking-widest">Contoh URL Kombinasi (RSUD + 2023 + 10 Data):</p>
                            <code class="text-green-400 break-all text-xs font-mono">
                                {{ route('extra.rss.generate') }}?unit_id=34&year=2023&limit=10
                            </code>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="mt-6">
                        <button @click="open = !open" class="text-blue-600 hover:text-blue-800 font-bold text-sm flex items-center">
                            <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-list-ul'"></i> 
                            <span class="ml-2" x-text="open ? 'Sembunyikan Daftar ID OPD' : 'Lihat Daftar ID OPD untuk Filter RSS'"></span>
                        </button>
                        <div x-show="open" x-transition class="mt-4 border-t pt-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-[11px]">
                                @foreach($organizations as $org)
                                    <div class="flex justify-between p-2 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors">
                                        <span class="text-gray-700 font-medium truncate pr-4">{{ $org->name }}</span>
                                        <span class="text-blue-600 font-bold font-mono">ID: {{ $org->unit_id }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Integrasi Kode dengan Penjelasan Baris --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-purple-500 rounded-full mr-3"></span>
                        Penjelasan Detail Kode Program
                    </h2>
                    <div x-data="{ tab: 'html' }">
                        <div class="flex space-x-2 mb-6 bg-gray-100 p-1 rounded-xl w-fit">
                            <button @click="tab = 'html'" :class="tab === 'html' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-2 px-4 rounded-lg text-xs font-bold transition-all">HTML/JS (Universal)</button>
                            <button @click="tab = 'php'" :class="tab === 'php' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-2 px-4 rounded-lg text-xs font-bold transition-all">PHP (Server-Side)</button>
                        </div>

                        <div class="bg-gray-900 rounded-2xl p-6 font-mono text-[11px] md:text-sm leading-relaxed overflow-x-auto text-gray-300">
                            <template x-if="tab === 'html'">
                                <pre><code>@verbatim// 1. Ambil data dari URL RSS kami
fetch('URL_RSS_KAMI')
  .then(response => response.text()) // Ubah response menjadi teks mentah
  .then(xmlString => {
    // 2. Ubah teks XML menjadi objek DOM yang bisa dibaca JS
    const parser = new DOMParser();
    const xml = parser.parseFromString(xmlString, "text/xml");
    
    // 3. Cari semua tag <item> (daftar berita)
    const items = xml.querySelectorAll("item");
    
    // 4. Lakukan pengulangan (loop) untuk setiap berita
    items.forEach(el => {
      const title = el.querySelector("title").textContent; // Ambil Judul
      const link = el.querySelector("link").textContent;   // Ambil Link
      
      console.log("Judul: " + title);
      console.log("Link: " + link);
    });
  });@endverbatim</code></pre>
                            </template>
                            <template x-if="tab === 'php'">
                                <pre><code>@verbatim// 1. Load file XML langsung dari server kami
$rss = simplexml_load_file('URL_RSS_KAMI');

// 2. Ambil data berita di dalam channel -> item
foreach ($rss->channel->item as $info) {
    // 3. Tampilkan judul sebagai link
    echo "<a href='{$info->link}'>{$info->title}</a><br>";
    
    // 4. Tampilkan deskripsi singkat (jika perlu)
    echo "<p>{$info->description}</p>";
} @endverbatim</code></pre>
                            </template>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                {{-- Blogger Guide --}}
                <section class="bg-orange-600 rounded-3xl shadow-lg p-8 text-white relative overflow-hidden">
                    <i class="fab fa-google absolute -bottom-4 -right-4 text-8xl opacity-20"></i>
                    <h3 class="text-xl font-bold mb-4">Panduan Blogspot (Blogger)</h3>
                    <div class="space-y-6 text-sm">
                        <div class="flex items-start">
                            <span class="bg-white text-orange-600 w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0 font-black">1</span>
                            <p>Masuk ke Dashboard <strong>Blogger</strong>, pilih menu <strong>Tata Letak (Layout)</strong>.</p>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-white text-orange-600 w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0 font-black">2</span>
                            <p>Klik <strong>Tambahkan Gadget</strong> dan cari gadget bernama <strong>"Feed"</strong>.</p>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-white text-orange-600 w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0 font-black">3</span>
                            <p>Tempel URL Feed kami, lalu atur berapa banyak informasi yang tampil.</p>
                        </div>
                    </div>
                </section>

                {{-- Social Sync Tools --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Alat Autopost Sosmed</h3>
                    <div class="space-y-4">
                        <a href="https://ifttt.com" target="_blank" class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="w-8 h-8 bg-black text-white rounded flex items-center justify-center mr-3">IF</div>
                            <div class="text-xs font-bold text-gray-700">IFTTT (Gratis & Mudah)</div>
                        </a>
                        <a href="https://zapier.com" target="_blank" class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="w-8 h-8 bg-orange-500 text-white rounded flex items-center justify-center mr-3">Z</div>
                            <div class="text-xs font-bold text-gray-700">Zapier (Sangat Powerfull)</div>
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
