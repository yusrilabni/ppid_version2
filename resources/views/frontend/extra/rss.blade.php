@extends('frontend.layouts.app')

@section('title', $pageTitle)

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-6xl">
        {{-- Header --}}
        <div class="text-center mb-12">
            <div class="inline-block p-3 bg-orange-100 rounded-2xl mb-4 text-orange-600 shadow-sm">
                <i class="fas fa-rss text-3xl"></i>
            </div>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight uppercase">RSS FEED & INTEGRASI SISTEM</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Dokumentasi lengkap penggunaan Feed XML untuk sindikasi konten dan publikasi otomatis.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Column (Kiri) --}}
            <div class="lg:col-span-2 space-y-8 text-gray-800">
                
                {{-- 1. Apa itu RSS --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5">
                        <i class="fas fa-rss text-9xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold mb-4 flex items-center">
                        <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span> Apa itu RSS Feed?
                    </h2>
                    <p class="text-gray-600 text-sm leading-relaxed relative z-10">
                        RSS (Really Simple Syndication) adalah teknologi standar yang memungkinkan Anda berlangganan konten dari website kami secara otomatis. Setiap kali admin PPID melakukan pembaruan informasi, URL RSS ini akan langsung memperbarui datanya sehingga platform Anda selalu mendapatkan konten terkini tanpa perlu pemantauan manual.
                    </p>
                </section>

                {{-- 2. Kustomisasi URL --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold mb-6 flex items-center text-orange-600">
                        <span class="w-2 h-8 bg-orange-500 rounded-full mr-3"></span> Kustomisasi URL Feed (Filter)
                    </h2>
                    <p class="text-sm text-gray-600 mb-6">Gunakan parameter di bawah ini untuk mendapatkan data yang sangat spesifik melalui URL:</p>
                    <div class="bg-gray-900 rounded-2xl p-6 text-[11px] font-mono text-gray-300 space-y-4 border-l-4 border-orange-500 shadow-xl">
                        <div>
                            <p class="text-blue-400 font-bold mb-1">// Filter per Instansi (Diskominfo Sinjai)</p>
                            <code class="break-all text-white">{{ route('extra.rss.generate') }}?unit_id=730714</code>
                        </div>
                        <div>
                            <p class="text-blue-400 font-bold mb-1">// Filter per Tahun (Contoh: 2023)</p>
                            <code class="break-all text-white">{{ route('extra.rss.generate') }}?year=2023</code>
                        </div>
                        <div class="pt-2 border-t border-white/10 text-[10px]">
                            <p class="text-orange-400 font-black mb-1 uppercase tracking-widest">// Gabungan 3 Filter (Limit 6):</p>
                            <code class="break-all text-white">{{ route('extra.rss.generate') }}?unit_id=730714&year=2023&limit=6</code>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="mt-6">
                        <button @click="open = !open" class="text-blue-600 hover:text-blue-800 font-bold text-xs flex items-center">
                            <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-list-ul'"></i> 
                            <span class="ml-2" x-text="open ? 'Sembunyikan Daftar ID OPD' : 'Lihat Daftar ID OPD Semua Instansi'"></span>
                        </button>
                        <div x-show="open" x-transition class="mt-4 border-t pt-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-[10px]">
                                @foreach($organizations as $org)
                                    <div class="flex justify-between p-2 bg-gray-50 rounded-lg border border-transparent hover:border-blue-100 transition-all">
                                        <span class="text-gray-700 font-medium truncate pr-4">{{ $org->name }}</span>
                                        <span class="text-blue-600 font-bold font-mono">ID: {{ $org->unit_id }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                {{-- 3. Struktur Data Detail --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold mb-6 flex items-center text-green-600">
                        <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span> Struktur Data Detail
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-blue-600 font-bold font-mono">&lt;title&gt;</p>
                            <p class="text-gray-500 mt-1">Judul resmi dokumen atau pengumuman.</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-blue-600 font-bold font-mono">&lt;organization&gt;</p>
                            <p class="text-gray-500 mt-1">Nama Dinas / Instansi pemilik data.</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-blue-600 font-bold font-mono">&lt;status&gt;</p>
                            <p class="text-gray-500 mt-1">Kondisi dokumen (BERLAKU / ARSIP).</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-blue-600 font-bold font-mono">&lt;category&gt;</p>
                            <p class="text-gray-500 mt-1">Klasifikasi data informasi.</p>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Sidebar (Kanan) --}}
            <div class="space-y-8">
                
                {{-- A. Panduan WordPress (Pindah ke Sini) --}}
                <section class="bg-blue-600 rounded-3xl shadow-lg p-6 text-white relative overflow-hidden group">
                    <i class="fab fa-wordpress absolute -bottom-2 -right-2 text-7xl opacity-20 group-hover:scale-110 transition-transform duration-500"></i>
                    <h3 class="text-lg font-bold mb-4 uppercase tracking-widest flex items-center">
                        <i class="fab fa-wordpress mr-2"></i> WordPress
                    </h3>
                    <div class="space-y-4 text-[11px] opacity-95 leading-relaxed font-medium">
                        <div class="space-y-2">
                            <p>1. Tambah blok <strong>"RSS"</strong> di editor.</p>
                            <p>2. Tempel URL Feed yang sudah difilter.</p>
                            <p>3. Klik <strong>"Gunakan URL"</strong>.</p>
                        </div>
                        <div class="bg-white/10 p-3 rounded-xl border border-white/20">
                            <p class="font-bold mb-1 text-[9px] uppercase">Wajib Diaktifkan:</p>
                            <ul class="space-y-1 opacity-80 italic">
                                <li>- Tampilkan Ringkasan</li>
                                <li>- Tampilkan Penulis & Tanggal</li>
                                <li>- Atur Jumlah Item (Sesuai Link)</li>
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- B. Blogger --}}
                <section class="bg-orange-600 rounded-3xl shadow-lg p-6 text-white relative overflow-hidden group">
                    <i class="fab fa-google absolute -bottom-2 -right-2 text-7xl opacity-20 group-hover:scale-110 transition-transform duration-500"></i>
                    <h3 class="text-lg font-bold mb-3 uppercase tracking-widest flex items-center">
                        <i class="fab fa-google mr-2 text-sm"></i> Blogger
                    </h3>
                    <div class="space-y-2 text-[11px] opacity-95 leading-relaxed font-medium">
                        <p>1. Dashboard Blogger > Tata Letak.</p>
                        <p>2. Tambah Gadget > Pilih <strong>"Feed"</strong>.</p>
                        <p>3. Tempel URL Feed kami dan simpan.</p>
                    </div>
                </section>

                {{-- C. Sinkronisasi Sosial --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 text-gray-800">
                    <h2 class="text-lg font-bold mb-4 flex items-center text-blue-600 uppercase tracking-tighter">
                        <i class="fas fa-sync-alt mr-2 text-sm"></i> Auto Post Sosial
                    </h2>
                    <div class="text-xs text-gray-600 space-y-4 leading-relaxed">
                        <div class="space-y-2">
                            <div class="flex items-center p-2 bg-gray-50 rounded-lg border border-gray-100 font-bold italic text-[10px]">
                                <i class="fas fa-rss text-orange-500 w-6 text-center mr-2"></i> 1. RSS Trigger
                            </div>
                            <div class="flex items-center p-2 bg-gray-50 rounded-lg border border-gray-100 font-bold italic text-[10px]">
                                <i class="fas fa-robot text-blue-500 w-6 text-center mr-2"></i> 2. Bridge
                            </div>
                            <div class="flex items-center p-2 bg-gray-50 rounded-lg border border-gray-100 font-bold italic text-[10px]">
                                <i class="fab fa-facebook text-blue-700 w-6 text-center mr-2"></i> 3. Auto Post
                            </div>
                        </div>
                        <p class="text-[10px] text-gray-400">Gunakan IFTTT/Zapier untuk posting otomatis judul & link berita ke Sosmed.</p>
                    </div>
                </section>

                {{-- D. FAQ --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 text-gray-800">
                    <h3 class="text-sm font-black mb-4 uppercase tracking-widest text-center border-b pb-2 text-gray-400">Info Teknis</h3>
                    <div class="space-y-4 text-[11px]">
                        <div>
                            <p class="font-bold text-gray-700 underline decoration-blue-200">Update Real-time</p>
                            <p class="text-gray-500 mt-1">Data diperbarui seketika saat admin menyimpan informasi baru.</p>
                        </div>
                        <div>
                            <p class="font-bold text-gray-700 underline decoration-blue-200">Biaya Layanan</p>
                            <p class="text-gray-500 mt-1">100% Gratis untuk mendukung keterbukaan informasi publik.</p>
                        </div>
                    </div>
                </section>

                {{-- E. Alat Autopost --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <div class="grid grid-cols-2 gap-2">
                        <a href="https://ifttt.com" target="_blank" class="flex flex-col items-center p-3 bg-gray-50 rounded-2xl hover:bg-black hover:text-white transition-all group border border-gray-100">
                            <span class="font-black text-xs mb-1">IFTTT</span>
                            <span class="text-[8px] uppercase opacity-60">Mudah</span>
                        </a>
                        <a href="https://zapier.com" target="_blank" class="flex flex-col items-center p-3 bg-gray-50 rounded-2xl hover:bg-orange-500 hover:text-white transition-all group border border-gray-100">
                            <span class="font-black text-xs mb-1">ZAPIER</span>
                            <span class="text-[8px] uppercase opacity-60">Lengkap</span>
                        </a>
                    </div>
                </section>
            </div>
        </div>

        {{-- MOTHER TABS SECTION --}}
        <div class="mt-12" x-data="rssCodeHandler()">
            <section class="bg-white rounded-[3.5rem] shadow-2xl border border-gray-100 p-8 md:p-14 overflow-hidden text-gray-800">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
                    <h2 class="text-3xl font-black flex items-center mb-6 md:mb-0 tracking-tight">
                        <span class="w-14 h-14 bg-gradient-to-br from-purple-600 to-blue-600 text-white rounded-2xl flex items-center justify-center mr-5 shadow-xl">
                            <i class="fas fa-magic"></i>
                        </span>
                        Contoh Kode Siap Pakai
                    </h2>
                    
                    <div class="flex space-x-3">
                        <button @click="copyCode()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 h-12 rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg flex items-center">
                            <i class="fas fa-copy mr-2"></i> SALIN KODE
                        </button>
                        <button @click="runPreview()" class="bg-orange-500 hover:bg-orange-600 text-white w-12 h-12 rounded-2xl flex items-center justify-center transition-all shadow-lg shadow-orange-200" title="Live Preview">
                            <i class="fas text-lg" :class="loading ? 'fa-spinner fa-spin' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                {{-- Tab Selection --}}
                <div class="flex space-x-6 mb-10 border-b-2 border-gray-100">
                    <button @click="motherTab = 'card'; showPreview = false" :class="motherTab === 'card' ? 'text-blue-600 border-b-4 border-blue-600 -mb-[2px]' : 'text-gray-400'" class="pb-4 text-xl font-black uppercase tracking-tighter transition-all">Kartu (Grid)</button>
                    <button @click="motherTab = 'list'; showPreview = false" :class="motherTab === 'list' ? 'text-blue-600 border-b-4 border-blue-600 -mb-[2px]' : 'text-gray-400'" class="pb-4 text-xl font-black uppercase tracking-tighter transition-all">Daftar (List)</button>
                </div>

                <div class="flex flex-wrap gap-2 mb-10 bg-gray-100 p-1.5 rounded-2xl w-fit">
                    <button @click="codeTab = 'html'; showPreview = false" :class="codeTab === 'html' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-8 rounded-xl text-xs font-black uppercase tracking-widest transition-all">HTML & JS</button>
                    <button @click="codeTab = 'php'; showPreview = false" :class="codeTab === 'php' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-8 rounded-xl text-xs font-black uppercase tracking-widest transition-all">PHP Native</button>
                    <button @click="codeTab = 'laravel'; showPreview = false" :class="codeTab === 'laravel' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-8 rounded-xl text-xs font-black uppercase tracking-widest transition-all">Laravel Blade</button>
                    <button @click="codeTab = 'ci'; showPreview = false" :class="codeTab === 'ci' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-8 rounded-xl text-xs font-black uppercase tracking-widest transition-all">CodeIgniter</button>
                </div>

                {{-- CODE BOX --}}
                <div class="bg-gray-900 rounded-[3rem] shadow-2xl relative overflow-hidden flex flex-col min-h-[550px] border-8 border-gray-800">
                    <div class="p-6 border-b border-white/5 flex items-center bg-white/5">
                        <div class="flex space-x-2">
                            <div class="w-3 h-3 rounded-full bg-red-500/40"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500/40"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500/40"></div>
                        </div>
                    </div>

                    <div class="relative flex-grow">
                        {{-- PREVIEW AREA --}}
                        <div x-show="showPreview" class="bg-[#fcfcfc] p-8 md:p-14 h-full min-h-[450px] overflow-y-auto text-sans">
                            <div id="preview-area" class="w-full"></div>
                        </div>

                        {{-- CODE AREA (PURE TEXT - ESCAPED FOR SAFETY) --}}
                        <div x-show="!showPreview" class="p-8 md:p-12 font-mono text-[13px] leading-relaxed text-blue-100/80 overflow-x-auto">
                            <div x-show="motherTab === 'card'">
                                <template x-if="codeTab === 'html'">
                                    <pre class="whitespace-pre-wrap"><code id="code-card-html">&lt;style&gt;
  /* KUSTOMISASI: CSS di bawah ini bisa Anda hapus atau custom sesuka hati */
  .ppid-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; }
  .ppid-card { background: #fff; border-radius: 20px; padding: 25px; border: 1px solid #eee; box-shadow: 0 5px 15px rgba(0,0,0,0.05); display: flex; flex-direction: column; transition: all 0.3s; }
  .ppid-title { font-weight: 800; color: #1a1a1a; text-decoration: none; font-size: 15px; display: block; margin: 10px 0; }
  @media (max-width: 768px) { .ppid-grid { grid-template-columns: 1fr; } }
&lt;/style&gt;
&lt;div id="ppid-grid" class="ppid-grid"&gt;Memuat data...&lt;/div&gt;
&lt;script&gt;
  const RSS_URL = '{{ route('extra.rss.generate') }}?unit_id=730714&limit=6';
  fetch(RSS_URL).then(res => res.text()).then(xmlString => {
    const xml = new DOMParser().parseFromString(xmlString, "text/xml");
    const items = xml.querySelectorAll("item");
    let html = '';
    items.forEach(el => {
      html += `&lt;div class="ppid-card"&gt;
                 &lt;small style="color:#0052FF; font-weight:bold;"&gt;🏛️ ${el.querySelector("organization").textContent}&lt;/small&gt;
                 &lt;a href="${el.querySelector("link").textContent}" target="_blank" class="ppid-title"&gt;${el.querySelector("title").textContent}&lt;/a&gt;
                 &lt;small style="color:#999"&gt;📅 ${new Date(el.querySelector("pubDate").textContent).toLocaleDateString('id-ID')}&lt;/small&gt;
               &lt;/div&gt;`;
    });
    document.getElementById("ppid-grid").innerHTML = html;
  });
&lt;/script&gt;</code></pre>
                                </template>
                                <template x-if="codeTab === 'php'"><pre class="whitespace-pre-wrap"><code id="code-card-php">&lt;?php
$url = "{{ route('extra.rss.generate') }}?unit_id=730714&limit=6";
$rss = simplexml_load_file($url);
echo "&lt;div style='display:grid; grid-template-columns:repeat(3, 1fr); gap:20px;'&gt;";
foreach ($rss->channel->item as $info) {
    echo "&lt;div style='background:#fff; padding:20px; border-radius:15px; border:1px solid #eee;'&gt;
            &lt;strong&gt;{$info->title}&lt;/strong&gt;
          &lt;/div&gt;";
}
echo "&lt;/div&gt;";
?&gt;</code></pre></template>
                                <template x-if="codeTab === 'laravel'"><pre class="whitespace-pre-wrap"><code id="code-card-laravel">// 1. Controller
$xml = simplexml_load_file("{{ route('extra.rss.generate') }}?limit=6");
return view('your_view', ['feeds' => $xml->channel->item]);

// 2. View (.blade.php)
&lt;div class="grid grid-cols-3 gap-6"&gt;
    &commat;foreach($feeds as $item)
        &lt;div class="card"&gt;
            &lt;h4&gt;&lbrace;&lbrace; $item->title &rbrace;&rbrace;&lt;/h4&gt;
            &lt;p&gt;&lbrace;&lbrace; $item->organization &rbrace;&rbrace;&lt;/p&gt;
        &lt;/div&gt;
    &commat;endforeach
&lt;/div&gt;</code></pre></template>
                                <template x-if="codeTab === 'ci'"><pre class="whitespace-pre-wrap"><code id="code-card-ci">// 1. Controller
$url = "{{ route('extra.rss.generate') }}?limit=6";
$data['feeds'] = simplexml_load_file($url);
$this->load->view('rss_view', $data);

// 2. View (rss_view.php)
&lt;?php foreach ($feeds->channel->item as $item): ?&gt;
    &lt;div class="card"&gt;&lt;?= $item->title ?&gt;&lt;/div&gt;
&lt;?php endforeach; ?&gt;</code></pre></template>
                            </div>

                            <div x-show="motherTab === 'list'">
                                <template x-if="codeTab === 'html'">
                                    <pre class="whitespace-pre-wrap"><code id="code-list-html">&lt;div id="ppid-list" style="background:#fff; border-radius:15px; border:1px solid #eee; overflow:hidden;"&gt;Memuat...&lt;/div&gt;
&lt;script&gt;
  fetch('{{ route('extra.rss.generate') }}?limit=10').then(res => res.text()).then(xml => {
    const data = new DOMParser().parseFromString(xml, "text/xml");
    const items = data.querySelectorAll("item");
    let html = '';
    items.forEach((el, index) => {
      html += `&lt;div style="padding:15px 20px; border-bottom:1px solid #f5f5f5; display:flex; align-items:center; justify-content:space-between; font-family:sans-serif;"&gt;
                 &lt;a href="${el.querySelector("link").textContent}" target="_blank" style="text-decoration:none; color:#333; font-weight:700;"&gt;${el.querySelector("title").textContent}&lt;/a&gt;
                 &lt;span style="font-size:9px; font-weight:bold; padding:2px 10px; border-radius:20px; background:#eee;"&gt;${el.querySelector("status").textContent}&lt;/span&gt;
               &lt;/div&gt;`;
    });
    document.getElementById("ppid-list").innerHTML = html;
  });
&lt;/script&gt;</code></pre>
                                </template>
                                <template x-if="codeTab === 'php'"><pre class="whitespace-pre-wrap"><code id="code-list-php">// PHP List Code...</code></pre></template>
                                <template x-if="codeTab === 'laravel'"><pre class="whitespace-pre-wrap"><code id="code-list-laravel">// Laravel List Code...</code></pre></template>
                                <template x-if="codeTab === 'ci'"><pre class="whitespace-pre-wrap"><code id="code-list-ci">// CI List Code...</code></pre></template>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    function rssCodeHandler() {
        return {
            motherTab: 'card', codeTab: 'html', showPreview: false, loading: false,
            get currentUrl() { return '{{ route('extra.rss.generate') }}?unit_id=730714&limit=' + (this.motherTab === 'card' ? '6' : '10'); },
            copyCode() {
                const elId = `code-${this.motherTab}-${this.codeTab}`;
                const el = document.getElementById(elId);
                navigator.clipboard.writeText(el.innerText).then(() => alert('Kode Berhasil Disalin!'));
            },
            runPreview() {
                this.loading = true; this.showPreview = true;
                const target = document.getElementById('preview-area');
                target.innerHTML = '<div style="padding:100px; text-align:center; color:#999; font-family:sans-serif;">Merender Pratinjau...</div>';
                fetch(this.currentUrl).then(res => res.text()).then(xmlString => {
                    const xml = new DOMParser().parseFromString(xmlString, "text/xml");
                    const items = xml.querySelectorAll("item");
                    let html = '';
                    if(this.motherTab === 'card') {
                        html = '<div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:20px; font-family:sans-serif;">';
                        items.forEach(el => {
                            const status = el.querySelector('status').textContent;
                            const color = (status === 'BERLAKU' || status === 'AKTIF') ? '#10b981' : '#ef4444';
                            html += `<div style="background:#fff; border-radius:20px; padding:25px; border:1px solid #eee; box-shadow:0 10px 15px rgba(0,0,0,0.05); display:flex; flex-direction:column;">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                    <span style="font-size:10px; font-weight:900; color:#0052FF; text-transform:uppercase;">🏛️ ${el.querySelector('organization').textContent}</span>
                                    <span style="font-size:9px; font-weight:900; padding:4px 12px; border-radius:8px; background:${color}10; color:${color}; border:1.5px solid ${color}20;">${status}</span>
                                </div>
                                <h4 style="font-weight:800; color:#111827; margin:0 0 10px 0; line-height:1.4; font-size:15px;">${el.querySelector('title').textContent}</h4>
                                <div style="margin-top:auto; font-size:11px; color:#9ca3af; font-weight:600;">📅 ${new Date(el.querySelector('pubDate').textContent).toLocaleDateString('id-ID')}</div>
                            </div>`;
                        });
                        html += '</div>';
                    } else {
                        html = '<div style="background:#fff; border-radius:15px; border:1px solid #eee; overflow:hidden; font-family:sans-serif;">';
                        items.forEach((el, index) => {
                            const status = el.querySelector('status').textContent;
                            const color = (status === 'BERLAKU' || status === 'AKTIF') ? '#10b981' : '#ef4444';
                            html += `<div style="padding:15px 20px; border-bottom:${index === items.length-1 ? 'none' : '1px solid #f5f5f5'}; display:flex; align-items:center; justify-content:space-between;">
                                <div style="max-width:75%;">
                                    <div style="font-size:10px; font-weight:900; color:#9ca3af; text-transform:uppercase; margin-bottom:6px;">🏛️ ${el.querySelector('organization').textContent}</div>
                                    <h5 style="margin:0; font-weight:800; color:#333; font-size:14px; line-height:1.4;">${el.querySelector('title').textContent}</h5>
                                </div>
                                <span style="font-size:9px; font-weight:800; padding:2px 10px; border-radius:20px; background:${color}10; color:${color}; border:1.5px solid ${color}30;">${status}</span>
                            </div>`;
                        });
                        html += '</div>';
                    }
                    target.innerHTML = html; this.loading = false;
                });
            }
        };
    }
</script>
@endsection
