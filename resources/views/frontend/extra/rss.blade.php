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
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">RSS Feed & Integrasi Sistem</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Gunakan feed XML untuk menampilkan update informasi otomatis di Website, Aplikasi Mobile, hingga Posting Otomatis ke Media Sosial.</p>
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
                                <i class="fas fa-rss text-orange-500 mb-2 text-xl"></i>
                                <p class="text-xs font-bold uppercase">1. Trigger</p>
                                <p class="text-[10px]">Data baru muncul di RSS kami</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-2xl">
                                <i class="fas fa-robot text-blue-500 mb-2 text-xl"></i>
                                <p class="text-xs font-bold uppercase">2. Bridge</p>
                                <p class="text-[10px]">Layanan IFTTT/Zapier membaca data</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-2xl">
                                <i class="fab fa-facebook text-blue-700 mb-2 text-xl"></i>
                                <p class="text-xs font-bold uppercase">3. Action</p>
                                <p class="text-[10px]">Post otomatis terbit di Sosmed Anda</p>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-blue-600 bg-blue-50 p-4 rounded-xl italic">
                            "Artinya, setiap kali admin PPID Sinjai mengupload informasi, akun Facebook portal berita Anda akan otomatis membuat postingan yang berisi judul dan link informasi tersebut."
                        </p>
                    </div>
                </section>

                {{-- Detail Struktur Data RSS --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span>
                        Apa yang Ada di Dalam RSS Kami?
                    </h2>
                    <p class="text-gray-600 mb-6 text-sm">Setiap unit informasi dalam RSS kami memuat data detail berikut yang bisa Anda olah:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-blue-200 transition-colors">
                            <span class="text-blue-600 font-bold text-xs font-mono">&lt;title&gt;</span>
                            <p class="text-[11px] text-gray-500 mt-1">Judul resmi dokumen atau pengumuman yang dipublikasikan.</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-blue-200 transition-colors">
                            <span class="text-blue-600 font-bold text-xs font-mono">&lt;link&gt;</span>
                            <p class="text-[11px] text-gray-500 mt-1">Alamat URL langsung untuk melihat detail atau mendownload file.</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-blue-200 transition-colors">
                            <span class="text-blue-600 font-bold text-xs font-mono">&lt;description&gt;</span>
                            <p class="text-[11px] text-gray-500 mt-1">Ringkasan isi dokumen (potongan teks awal) untuk gambaran singkat.</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-blue-200 transition-colors">
                            <span class="text-blue-600 font-bold text-xs font-mono">&lt;category&gt;</span>
                            <p class="text-[11px] text-gray-500 mt-1">Klasifikasi informasi (Informasi Berkala, Setiap Saat, dll).</p>
                        </div>
                    </div>
                </section>

                {{-- Kustomisasi URL --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span>
                        Kustomisasi URL Feed
                    </h2>
                    <p class="text-gray-600 mb-6 text-sm">Gunakan parameter di bawah ini untuk mendapatkan data yang spesifik (Filter):</p>
                    <div class="bg-gray-900 rounded-2xl p-6 text-xs font-mono text-gray-300 space-y-4">
                        <div>
                            <p class="text-blue-400 font-bold mb-1">// Ambil data hanya dari instansi tertentu (Misal ID 34 = RSUD)</p>
                            <code class="break-all">{{ route('extra.rss.generate') }}?unit_id=34</code>
                        </div>
                        <div>
                            <p class="text-blue-400 font-bold mb-1">// Ambil data khusus tahun tertentu (Misal 2023)</p>
                            <code class="break-all">{{ route('extra.rss.generate') }}?year=2023</code>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                {{-- Blogger Guide --}}
                <section class="bg-orange-600 rounded-3xl shadow-lg p-8 text-white relative overflow-hidden">
                    <i class="fab fa-google absolute -bottom-4 -right-4 text-8xl opacity-20"></i>
                    <h3 class="text-xl font-bold mb-4">Panduan Blogspot</h3>
                    <div class="space-y-6 text-sm">
                        <div class="flex items-start">
                            <span class="bg-white text-orange-600 w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0 font-black">1</span>
                            <p>Di Dashboard <strong>Blogger</strong>, pilih menu <strong>Tata Letak</strong>.</p>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-white text-orange-600 w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0 font-black">2</span>
                            <p>Klik <strong>Tambahkan Gadget</strong> dan pilih <strong>"Feed"</strong>.</p>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-white text-orange-600 w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0 font-black">3</span>
                            <p>Tempel URL Feed kami dan simpan.</p>
                        </div>
                    </div>
                </section>

                {{-- Social Sync Tools (RESTORED LOGOS) --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Alat Autopost Sosmed</h3>
                    <div class="space-y-4">
                        <a href="https://ifttt.com" target="_blank" class="flex items-center p-4 bg-gray-50 rounded-2xl hover:bg-black hover:text-white transition-all group border border-gray-100">
                            <div class="w-10 h-10 bg-black text-white rounded-xl flex items-center justify-center mr-4 text-xl font-black">IF</div>
                            <div>
                                <p class="text-xs font-bold">IFTTT</p>
                                <p class="text-[10px] opacity-60">Gratis & Mudah</p>
                            </div>
                        </a>
                        <a href="https://zapier.com" target="_blank" class="flex items-center p-4 bg-gray-50 rounded-2xl hover:bg-orange-500 hover:text-white transition-all group border border-gray-100">
                            <div class="w-10 h-10 bg-orange-500 text-white rounded-xl flex items-center justify-center mr-4 text-xl font-black">Z</div>
                            <div>
                                <p class="text-xs font-bold">Zapier</p>
                                <p class="text-[10px] opacity-60">Sangat Powerfull</p>
                            </div>
                        </a>
                    </div>
                </section>
            </div>
        </div>

        {{-- FULL WIDTH CODE EXAMPLES SECTION --}}
        <div class="mt-12">
            <section class="bg-white rounded-[3rem] shadow-sm border border-gray-100 p-8 md:p-12 overflow-hidden">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 flex items-center">
                    <span class="w-10 h-10 bg-purple-600 text-white rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-purple-200">
                        <i class="fas fa-code"></i>
                    </span>
                    Contoh Kode Siap Pakai (Full Width)
                </h2>

                <div x-data="{ tab: 'html' }">
                    <div class="flex space-x-2 mb-8 bg-gray-100 p-1 rounded-2xl w-fit">
                        <button @click="tab = 'html'" :class="tab === 'html' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-8 rounded-xl text-sm font-bold transition-all">HTML & JAVASCRIPT</button>
                        <button @click="tab = 'php'" :class="tab === 'php' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-8 rounded-xl text-sm font-bold transition-all">PHP NATIVE</button>
                    </div>

                    <div class="bg-gray-900 rounded-[2rem] p-8 md:p-10 font-mono text-sm leading-relaxed text-gray-300 relative">
                        <template x-if="tab === 'html'">
                            <pre class="whitespace-pre-wrap overflow-hidden"><code>@verbatim&lt;!-- 1. Wadah untuk menampilkan daftar berita --&gt;
&lt;div id="ppid-list" style="font-family: 'Inter', sans-serif; max-width: 100%;"&gt;
  Memuat data terbaru...
&lt;/div&gt;

&lt;script&gt;
  // 2. Gunakan URL RSS kami langsung
  const RSS_URL = '@endverbatim{{ route('extra.rss.generate') }}@verbatim';

  fetch(RSS_URL)
    .then(res => res.text())
    .then(xmlString => {
      const xml = new DOMParser().parseFromString(xmlString, "text/xml");
      const items = xml.querySelectorAll("item");
      let html = '&lt;ul style="padding:0; margin:0; list-style:none;"&gt;';
      
      items.forEach(el => {
        const title = el.querySelector("title").textContent;
        const link = el.querySelector("link").textContent;
        const date = new Date(el.querySelector("pubDate").textContent).toLocaleDateString('id-ID');
        
        html += `&lt;li style="margin-bottom:20px; padding:15px; background:#f9f9f9; border-radius:12px;"&gt;
                   &lt;a href="${link}" target="_blank" style="text-decoration:none; color:#0052FF; font-weight:bold; font-size:16px;"&gt;${title}&lt;/a&gt;
                   &lt;div style="color:#888; font-size:12px; margin-top:5px;"&gt;Dipublikasikan: ${date}&lt;/div&gt;
                 &lt;/li&gt;`;
      });
      
      document.getElementById("ppid-list").innerHTML = html + '&lt;/ul&gt;';
    });
&lt;/script&gt;@endverbatim</code></pre>
                        </template>
                        <template x-if="tab === 'php'">
                            <pre class="whitespace-pre-wrap overflow-hidden"><code>@verbatim&lt;?php
// 1. Ambil file XML langsung dari URL RSS kami
$url = "@endverbatim{{ route('extra.rss.generate') }}@verbatim";
$rss = simplexml_load_file($url);

echo "&lt;h2&gt;Update Informasi PPID Sinjai&lt;/h2&gt;";
echo "&lt;ul style='list-style:none; padding:0;'&gt;";

// 2. Lakukan pengulangan untuk setiap item berita yang ditemukan
foreach ($rss->channel->item as $info) {
    echo "&lt;li style='margin-bottom:15px;'&gt;";
    echo "&lt;a href='{$info->link}' target='_blank' style='color:#0052FF; font-weight:bold;'&gt;{$info->title}&lt;/a&gt;&lt;br&gt;";
    echo "&lt;small style='color:#666;'&gt;Kategori: {$info->category} | Tanggal: {$info->pubDate}&lt;/small&gt;";
    echo "&lt;/li&gt;";
}

echo "&lt;/ul&gt;";
?&gt;@endverbatim</code></pre>
                        </template>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
