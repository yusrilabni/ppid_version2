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
            {{-- Main Column (Kiri) --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Penjelasan Singkat RSS --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span>
                        Apa itu RSS Feed?
                    </h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        RSS adalah format data standar untuk mengirimkan informasi yang sering diperbarui. Dengan RSS, website Anda dapat mengambil data terbaru kami secara otomatis tanpa perlu pemantauan manual.
                    </p>
                </section>

                {{-- Detail Struktur Data RSS --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span>
                        Struktur Data RSS
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-blue-600 font-bold text-xs font-mono">&lt;title&gt;</span>
                            <p class="text-[11px] text-gray-500 mt-1">Judul resmi dokumen atau pengumuman.</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-blue-600 font-bold text-xs font-mono">&lt;link&gt;</span>
                            <p class="text-[11px] text-gray-500 mt-1">URL langsung untuk detail atau download.</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-blue-600 font-bold text-xs font-mono">&lt;description&gt;</span>
                            <p class="text-[11px] text-gray-500 mt-1">Ringkasan singkat isi dokumen.</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-blue-600 font-bold text-xs font-mono">&lt;category&gt;</span>
                            <p class="text-[11px] text-gray-500 mt-1">Klasifikasi (Berkala, Setiap Saat, dll).</p>
                        </div>
                    </div>
                </section>

                {{-- Kustomisasi URL --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-orange-500 rounded-full mr-3"></span>
                        Kustomisasi URL Feed
                    </h2>
                    <p class="text-gray-600 mb-6 text-sm">Gunakan parameter berikut untuk filter data yang spesifik:</p>
                    <div class="bg-gray-900 rounded-2xl p-6 text-xs font-mono text-gray-300 space-y-4">
                        <div>
                            <p class="text-blue-400 font-bold mb-1">// Filter per Instansi (Contoh ID 34 = RSUD)</p>
                            <code class="break-all">{{ route('extra.rss.generate') }}?unit_id=34</code>
                        </div>
                        <div>
                            <p class="text-blue-400 font-bold mb-1">// Filter per Tahun (Contoh 2023)</p>
                            <code class="break-all">{{ route('extra.rss.generate') }}?year=2023</code>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Sidebar (Kanan) --}}
            <div class="space-y-8">
                {{-- Sinkronisasi Sosial (Pindah ke Sini) --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-sync-alt text-blue-500 mr-2"></i> Sinkronisasi Sosial
                    </h2>
                    <div class="text-xs text-gray-600 space-y-4 leading-relaxed">
                        <p>Bagikan update otomatis ke akun <strong>Facebook, X, atau Telegram</strong> Anda tanpa mengetik ulang.</p>
                        
                        <div class="space-y-2">
                            <div class="flex items-center p-2 bg-gray-50 rounded-lg">
                                <i class="fas fa-rss text-orange-500 w-5"></i>
                                <span class="ml-2 font-bold">1. Trigger:</span> <span class="ml-1">Data baru di RSS</span>
                            </div>
                            <div class="flex items-center p-2 bg-gray-50 rounded-lg">
                                <i class="fas fa-robot text-blue-500 w-5"></i>
                                <span class="ml-2 font-bold">2. Bridge:</span> <span class="ml-1">IFTTT/Zapier baca</span>
                            </div>
                            <div class="flex items-center p-2 bg-gray-50 rounded-lg">
                                <i class="fab fa-facebook text-blue-700 w-5"></i>
                                <span class="ml-2 font-bold">3. Action:</span> <span class="ml-1">Post otomatis terbit</span>
                            </div>
                        </div>

                        <p class="bg-blue-50 p-3 rounded-xl italic text-[10px] text-blue-700 border border-blue-100">
                            "Setiap kali admin update data, Sosmed Anda akan otomatis memposting judul & link-nya."
                        </p>
                    </div>
                </section>

                {{-- Blogger Guide --}}
                <section class="bg-orange-600 rounded-3xl shadow-lg p-6 text-white relative overflow-hidden">
                    <i class="fab fa-google absolute -bottom-2 -right-2 text-6xl opacity-20"></i>
                    <h3 class="text-lg font-bold mb-3">Panduan Blogger</h3>
                    <div class="space-y-3 text-[11px] opacity-90">
                        <p>1. Dashboard Blogger > Tata Letak.</p>
                        <p>2. Tambah Gadget > Pilih <strong>"Feed"</strong>.</p>
                        <p>3. Tempel URL Feed kami dan simpan.</p>
                    </div>
                </section>

                {{-- Social Sync Tools --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-widest">Alat Autopost</h3>
                    <div class="space-y-3">
                        <a href="https://ifttt.com" target="_blank" class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-black hover:text-white transition-all group border border-gray-100">
                            <div class="w-8 h-8 bg-black text-white rounded flex items-center justify-center mr-3 font-black text-sm">IF</div>
                            <div class="text-[10px] font-bold">IFTTT (Mudah)</div>
                        </a>
                        <a href="https://zapier.com" target="_blank" class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-orange-500 hover:text-white transition-all group border border-gray-100">
                            <div class="w-8 h-8 bg-orange-500 text-white rounded flex items-center justify-center mr-3 font-black text-sm">Z</div>
                            <div class="text-[10px] font-bold">Zapier (Lengkap)</div>
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
                    Contoh Kode Siap Pakai (Copy-Paste)
                </h2>

                <div x-data="{ tab: 'html' }">
                    <div class="flex space-x-2 mb-8 bg-gray-100 p-1 rounded-2xl w-fit">
                        <button @click="tab = 'html'" :class="tab === 'html' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-8 rounded-xl text-sm font-bold transition-all">HTML & JAVASCRIPT</button>
                        <button @click="tab = 'php'" :class="tab === 'php' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-8 rounded-xl text-sm font-bold transition-all">PHP NATIVE</button>
                    </div>

                    <div class="bg-gray-900 rounded-[2rem] p-8 md:p-10 font-mono text-sm leading-relaxed text-gray-300 relative">
                        <template x-if="tab === 'html'">
                            <pre class="whitespace-pre-wrap"><code>@verbatim&lt;!-- 1. Wadah untuk menampilkan daftar berita --&gt;
&lt;div id="ppid-list" style="font-family: sans-serif; max-width: 100%;"&gt;
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
      let html = '&lt;h3&gt;Update Terbaru&lt;/h3&gt;&lt;ul style="padding:0; margin:0; list-style:none;"&gt;';
      
      items.forEach(el => {
        const title = el.querySelector("title").textContent;
        const link = el.querySelector("link").textContent;
        const date = new Date(el.querySelector("pubDate").textContent).toLocaleDateString('id-ID');
        
        html += `&lt;li style="margin-bottom:20px; padding:15px; background:#f9f9f9; border-radius:12px;"&gt;
                   &lt;a href="${link}" target="_blank" style="text-decoration:none; color:#0052FF; font-weight:bold;"&gt;${title}&lt;/a&gt;
                   &lt;div style="color:#888; font-size:12px; margin-top:5px;"&gt;Dipublikasikan: ${date}&lt;/div&gt;
                 &lt;/li&gt;`;
      });
      
      document.getElementById("ppid-list").innerHTML = html + '&lt;/ul&gt;';
    });
&lt;/script&gt;@endverbatim</code></pre>
                        </template>
                        <template x-if="tab === 'php'">
                            <pre class="whitespace-pre-wrap"><code>@verbatim&lt;?php
// 1. Ambil file XML langsung dari URL RSS kami
$url = "@endverbatim{{ route('extra.rss.generate') }}@verbatim";
$rss = simplexml_load_file($url);

echo "&lt;h2&gt;Informasi PPID Sinjai&lt;/h2&gt;";
echo "&lt;ul style='list-style:none; padding:0;'&gt;";

// 2. Loop melalui setiap item berita yang ditemukan
foreach ($rss->channel->item as $info) {
    echo "&lt;li style='margin-bottom:15px; border-bottom:1px solid #eee; padding-bottom:10px;'&gt;";
    echo "&lt;a href='{$info->link}' target='_blank' style='color:#0052FF; font-weight:bold; text-decoration:none;'&gt;{$info->title}&lt;/a&gt;&lt;br&gt;";
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
