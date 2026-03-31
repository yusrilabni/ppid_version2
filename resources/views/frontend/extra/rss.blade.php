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
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Dokumentasi lengkap penggunaan Feed XML untuk sindikasi konten otomatis.</p>
        </div>

        <div class="space-y-8 text-gray-800">
            {{-- 1. Apa itu RSS --}}
            <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 relative overflow-hidden text-left">
                <div class="absolute top-0 right-0 p-4 opacity-5">
                    <i class="fas fa-rss text-9xl"></i>
                </div>
                <h2 class="text-2xl font-bold mb-4 flex items-center text-blue-600">
                    <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span> Apa itu RSS Feed?
                </h2>
                <p class="text-gray-600 text-sm leading-relaxed relative z-10">
                    RSS (Really Simple Syndication) adalah teknologi standar yang memungkinkan Anda berlangganan konten dari website kami secara otomatis. Setiap kali admin PPID melakukan pembaruan informasi, URL RSS ini akan langsung memperbarui datanya sehingga platform Anda selalu mendapatkan konten terkini tanpa perlu pemantauan manual.
                </p>
            </section>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- A. Panduan WordPress (Detail Panjang & Lebar) --}}
                <section class="bg-blue-600 rounded-[2rem] shadow-lg p-8 text-white relative overflow-hidden group text-left h-full">
                    <i class="fab fa-wordpress absolute -bottom-4 -right-4 text-9xl opacity-10 group-hover:scale-110 transition-transform duration-700"></i>
                    <h3 class="text-xl font-black mb-6 uppercase tracking-widest flex items-center border-b border-white/20 pb-4">
                        <i class="fab fa-wordpress mr-3 text-2xl"></i> Panduan WordPress
                    </h3>
                    <div class="space-y-6 text-sm opacity-95 leading-relaxed font-medium">
                        <div class="flex items-start">
                            <span class="bg-white text-blue-600 w-6 h-6 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 font-black">1</span>
                            <p>Masuk ke Editor Halaman/Postingan WordPress Anda (Gutenberg/Classic Editor).</p>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-white text-blue-600 w-6 h-6 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 font-black">2</span>
                            <p>Klik tombol <strong>(+) Tambah Blok</strong> dan cari blok bernama <strong>"RSS"</strong>.</p>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-white text-blue-600 w-6 h-6 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 font-black">3</span>
                            <p>Tempelkan <strong>URL Feed</strong> yang sudah Anda kustomisasi (pilih dari daftar filter di bawah).</p>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-white text-blue-600 w-6 h-6 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 font-black">4</span>
                            <p>Klik tombol <strong>"Gunakan URL"</strong> untuk memuat data secara real-time.</p>
                        </div>
                        
                        <div class="bg-black/20 p-5 rounded-2xl border border-white/10 mt-4 shadow-inner">
                            <p class="font-black mb-3 text-[10px] uppercase tracking-widest text-blue-200">Pengaturan Tampilan Wajib:</p>
                            <ul class="space-y-3 text-[11px] opacity-90">
                                <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-green-400"></i> Aktifkan "Tampilkan Ringkasan" untuk deskripsi singkat.</li>
                                <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-green-400"></i> Aktifkan "Tampilkan Penulis" (OPD terkait).</li>
                                <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-green-400"></i> Aktifkan "Tampilkan Tanggal" publikasi.</li>
                                <li class="flex items-center"><i class="fas fa-list-ol mr-2 text-green-400"></i> Atur "Jumlah Item" (Disarankan 5-10 item).</li>
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- B. Blogger (Detail Panjang & Lebar) --}}
                <section class="bg-orange-600 rounded-[2rem] shadow-lg p-8 text-white relative overflow-hidden group text-left h-full">
                    <i class="fab fa-google absolute -bottom-4 -right-4 text-9xl opacity-10 group-hover:scale-110 transition-transform duration-700"></i>
                    <h3 class="text-xl font-black mb-6 uppercase tracking-widest flex items-center border-b border-white/20 pb-4">
                        <i class="fab fa-google mr-3 text-xl"></i> Panduan Blogger
                    </h3>
                    <div class="space-y-6 text-sm opacity-95 leading-relaxed font-medium">
                        <div class="flex items-start">
                            <span class="bg-white text-orange-600 w-6 h-6 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 font-black">1</span>
                            <p>Masuk ke Dashboard <strong>Blogger.com</strong> dan pilih blog Anda.</p>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-white text-orange-600 w-6 h-6 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 font-black">2</span>
                            <p>Pilih menu <strong>Tata Letak (Layout)</strong> di panel navigasi kiri.</p>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-white text-orange-600 w-6 h-6 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 font-black">3</span>
                            <p>Klik <strong>Tambahkan Gadget</strong> pada lokasi yang diinginkan (Sidebar/Footer).</p>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-white text-orange-600 w-6 h-6 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 font-black">4</span>
                            <p>Cari gadget <strong>"Feed"</strong>, tempel URL RSS kami, lalu simpan.</p>
                        </div>
                        
                        <div class="bg-black/20 p-5 rounded-2xl border border-white/10 mt-4 shadow-inner">
                            <p class="font-black mb-2 text-[10px] uppercase tracking-widest text-orange-200">Keuntungan Integrasi:</p>
                            <p class="text-[11px] italic">Setiap kali ada informasi publik baru di portal PPID, blog Anda akan otomatis menampilkan judul dan link tersebut tanpa perlu update manual. Sangat efektif untuk sinkronisasi data antar platform.</p>
                        </div>
                    </div>
                </section>
            </div>

            {{-- 2. Kustomisasi URL --}}
            <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-left">
                <h2 class="text-2xl font-bold mb-6 flex items-center text-orange-600">
                    <span class="w-2 h-8 bg-orange-500 rounded-full mr-3"></span> Kustomisasi URL Feed (Filter)
                </h2>
                <p class="text-sm text-gray-600 mb-6">Gunakan parameter di bawah ini untuk mendapatkan data yang sangat spesifik melalui URL:</p>
                <div class="bg-gray-900 rounded-2xl p-6 text-[11px] font-mono text-gray-300 space-y-4 border-l-4 border-orange-500 shadow-xl">
                    <div>
                        <p class="text-blue-400 font-bold mb-1">// Filter per Instansi (Contoh: Diskominfo Sinjai)</p>
                        <code class="break-all text-white">{{ route('extra.rss.generate') }}?unit_id=730714</code>
                    </div>
                    <div>
                        <p class="text-blue-400 font-bold mb-1">// Filter per Tahun (Contoh: 2023)</p>
                        <code class="break-all text-white">{{ route('extra.rss.generate') }}?year=2023</code>
                    </div>
                    <div class="pt-2 border-t border-white/10">
                        <p class="text-orange-400 font-black mb-1 uppercase tracking-widest text-[10px]">// Gabungan Filter (Limit 10):</p>
                        <code class="break-all text-white">{{ route('extra.rss.generate') }}?unit_id=730714&year=2024&limit=10</code>
                    </div>
                </div>

                <div x-data="{ open: false }" class="mt-6">
                    <button @click="open = !open" class="text-blue-600 hover:text-blue-800 font-bold text-xs flex items-center">
                        <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-list-ul'"></i> 
                        <span class="ml-2" x-text="open ? 'Sembunyikan Daftar ID OPD' : 'Lihat Daftar ID OPD Semua Instansi'"></span>
                    </button>
                    <div x-show="open" x-transition class="mt-4 border-t pt-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 text-[10px]">
                            @foreach($organizations as $org)
                                <div class="flex justify-between p-2 bg-gray-50 rounded-lg hover:bg-blue-50 transition-all">
                                    <span class="text-gray-700 font-medium truncate pr-4">{{ $org->name }}</span>
                                    <span class="text-blue-600 font-bold font-mono">ID: {{ $org->unit_id }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            {{-- 3. Struktur Data Detail --}}
            <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-left">
                <h2 class="text-2xl font-bold mb-6 flex items-center text-green-600">
                    <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span> Struktur Data Detail
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-blue-600 font-bold font-mono">&lt;title&gt;</p>
                        <p class="text-gray-500 mt-1">Judul resmi dokumen.</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-blue-600 font-bold font-mono">&lt;organization&gt;</p>
                        <p class="text-gray-500 mt-1">Nama Instansi pemilik data.</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-blue-600 font-bold font-mono">&lt;status&gt;</p>
                        <p class="text-gray-500 mt-1">Kondisi dokumen (BERLAKU/ARSIP).</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-blue-600 font-bold font-mono">&lt;category&gt;</p>
                        <p class="text-gray-500 mt-1">Klasifikasi data informasi.</p>
                    </div>
                </div>
            </section>
        </div>

        {{-- MOTHER TABS SECTION --}}
        <div class="mt-12" x-data="rssCodeHandler()">
            <section class="bg-white rounded-[3.5rem] shadow-2xl border border-gray-100 p-8 md:p-14 overflow-hidden text-gray-800 text-left">
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
                    <button @click="motherTab = 'card'; showPreview = false" :class="motherTab === 'card' ? 'text-blue-600 border-b-4 border-blue-600 -mb-[2px]' : 'text-gray-400'" class="pb-4 text-xl font-black uppercase tracking-tighter">Kartu (Grid)</button>
                    <button @click="motherTab = 'list'; showPreview = false" :class="motherTab === 'list' ? 'text-blue-600 border-b-4 border-blue-600 -mb-[2px]' : 'text-gray-400'" class="pb-4 text-xl font-black uppercase tracking-tighter">Daftar (List)</button>
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

                        {{-- CODE AREA --}}
                        <div x-show="!showPreview" class="p-8 md:p-12 font-mono text-[13px] leading-relaxed text-blue-100/80 overflow-x-auto">
                            <div x-show="motherTab === 'card'">
                                <template x-if="codeTab === 'html'">
                                    <pre class="whitespace-pre-wrap"><code id="code-card-html">&lt;style&gt;
  .ppid-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; font-family: sans-serif; }
  .ppid-card { background: #fff; border-radius: 20px; padding: 25px; border: 1px solid #eee; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
  .ppid-title { font-weight: 800; color: #1a1a1a; text-decoration: none; font-size: 15px; display: block; margin: 10px 0; }
  @media (max-width: 768px) { .ppid-grid { grid-template-columns: 1fr; } }
&lt;/style&gt;
&lt;div id="ppid-grid" class="ppid-grid"&gt;Memuat data...&lt;/div&gt;
&lt;script&gt;
  const RSS_URL = '{{ route('extra.rss.generate') }}?limit=6';
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
$url = "{{ route('extra.rss.generate') }}?limit=6";
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
    &lt;div class="card"&gt;
        &lt;h5&gt;&lt;?= $item->title ?&gt;&lt;/h5&gt;
    &lt;/div&gt;
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
            get currentUrl() { return '{{ route('extra.rss.generate') }}?limit=' + (this.motherTab === 'card' ? '6' : '10'); },
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
                        html = '<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:20px; font-family:sans-serif;">';
                        items.forEach(el => {
                            const status = el.querySelector('status').textContent;
                            const color = (status === 'BERLAKU' || status === 'AKTIF') ? '#10b981' : '#ef4444';
                            html += `<div style="background:#fff; border-radius:20px; padding:25px; border:1px solid #eee; box-shadow:0 10px 15px rgba(0,0,0,0.05); display:flex; flex-direction:column;">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                                    <span style="font-size:10px; font-weight:900; color:#0052FF; text-transform:uppercase; letter-spacing:1px;">🏛️ ${el.querySelector('organization').textContent}</span>
                                    <span style="font-size:9px; font-weight:900; padding:4px 12px; border-radius:8px; background:${color}10; color:${color}; border:1.5px solid ${color}20;">${status}</span>
                                </div>
                                <h4 style="font-weight:800; color:#111827; margin:0 0 10px 0; line-height:1.4; font-size:16px;">${el.querySelector('title').textContent}</h4>
                                <div style="margin-top:auto; font-size:11px; color:#9ca3af; font-weight:600;">📅 ${new Date(el.querySelector('pubDate').textContent).toLocaleDateString('id-ID')}</div>
                            </div>`;
                        });
                        html += '</div>';
                    } else {
                        html = '<div style="background:#fff; border-radius:15px; border:1px solid #eee; overflow:hidden; font-family:sans-serif;">';
                        items.forEach((el, index) => {
                            const status = el.querySelector('status').textContent;
                            const color = (status === 'BERLAKU' || status === 'AKTIF') ? '#10b981' : '#ef4444';
                            html += `<div style="padding:20px 30px; border-bottom:${index === items.length-1 ? 'none' : '1px solid #f5f5f5'}; display:flex; align-items:center; justify-content:space-between;">
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
