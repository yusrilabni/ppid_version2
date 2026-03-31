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
            {{-- Main Column --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Penjelasan Singkat RSS --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-gray-800">
                    <h2 class="text-2xl font-bold mb-4 flex items-center">
                        <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span>
                        Apa itu RSS Feed?
                    </h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        RSS adalah format data standar untuk mengirimkan informasi yang sering diperbarui. Dengan RSS, website Anda dapat mengambil data terbaru kami secara otomatis tanpa perlu pemantauan manual.
                    </p>
                </section>

                {{-- Detail Struktur Data RSS --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-gray-800 text-sm">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
                        <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span>
                        Struktur Data RSS
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-blue-600 font-bold font-mono">&lt;title&gt;</span>
                            <p class="text-xs text-gray-500 mt-1">Judul resmi dokumen atau pengumuman.</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-blue-600 font-bold font-mono">&lt;organization&gt;</span>
                            <p class="text-xs text-gray-500 mt-1">Nama Dinas / Instansi pemilik data.</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-blue-600 font-bold font-mono">&lt;status&gt;</span>
                            <p class="text-xs text-gray-500 mt-1">Kondisi dokumen (BERLAKU / ARSIP).</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-blue-600 font-bold font-mono">&lt;category&gt;</span>
                            <p class="text-xs text-gray-500 mt-1">Klasifikasi (Berkala, Setiap Saat, dll).</p>
                        </div>
                    </div>
                </section>

                {{-- Kustomisasi URL --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-gray-800">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
                        <span class="w-2 h-8 bg-orange-500 rounded-full mr-3"></span>
                        Kustomisasi URL Feed
                    </h2>
                    <p class="text-gray-600 mb-6 text-sm">Gunakan parameter berikut untuk filter data yang spesifik:</p>
                    <div class="bg-gray-900 rounded-2xl p-6 text-xs font-mono text-gray-300 space-y-4 border-l-4 border-orange-500">
                        <div>
                            <p class="text-blue-400 font-bold mb-1">// Filter per Instansi (Contoh: Diskominfo Sinjai)</p>
                            <code class="break-all">{{ route('extra.rss.generate') }}?unit_id=730714</code>
                        </div>
                        <div>
                            <p class="text-blue-400 font-bold mb-1">// Filter per Tahun (Contoh: 2023)</p>
                            <code class="break-all">{{ route('extra.rss.generate') }}?year=2023</code>
                        </div>
                        <div>
                            <p class="text-blue-400 font-bold mb-1">// Limit Jumlah Data (Contoh: 6 item)</p>
                            <code class="break-all">{{ route('extra.rss.generate') }}?limit=6</code>
                        </div>
                        <div class="pt-2 border-t border-white/10 text-[10px]">
                            <p class="text-orange-400 font-black mb-1 uppercase tracking-widest">// Contoh Gabungan 3 Filter Sekaligus:</p>
                            <code class="break-all text-white">{{ route('extra.rss.generate') }}?unit_id=730714&year=2023&limit=6</code>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="mt-6">
                        <button @click="open = !open" class="text-blue-600 hover:text-blue-800 font-bold text-sm flex items-center transition-colors">
                            <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-list-ul'"></i> 
                            <span class="ml-2" x-text="open ? 'Sembunyikan Daftar ID OPD' : 'Lihat Daftar ID OPD Semua Instansi'"></span>
                        </button>
                        <div x-show="open" x-transition class="mt-4 border-t pt-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-[11px]">
                                @foreach($organizations as $org)
                                    <div class="flex justify-between p-2 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors">
                                        <span class="text-gray-700 font-medium truncate pr-4">{{ $org->name }}</span>
                                        <span class="text-blue-600 font-bold font-mono uppercase">ID: {{ $org->unit_id }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                {{-- Sinkronisasi Sosial --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 text-gray-800">
                    <h2 class="text-lg font-bold mb-4 flex items-center text-blue-600">
                        <i class="fas fa-sync-alt mr-2"></i> Sinkronisasi Sosial
                    </h2>
                    <div class="text-xs text-gray-600 space-y-4 leading-relaxed">
                        <p>Bagikan update otomatis ke akun <strong>Facebook, X, atau Telegram</strong> Anda tanpa mengetik ulang.</p>
                        <div class="space-y-2 text-[10px]">
                            <div class="flex items-center p-2 bg-gray-50 rounded-lg">
                                <i class="fas fa-rss text-orange-500 w-5 text-center"></i>
                                <span class="ml-2 font-bold">1. Trigger:</span> <span class="ml-1">Data baru di RSS</span>
                            </div>
                            <div class="flex items-center p-2 bg-gray-50 rounded-lg">
                                <i class="fas fa-robot text-blue-500 w-5 text-center"></i>
                                <span class="ml-2 font-bold">2. Bridge:</span> <span class="ml-1">IFTTT/Zapier baca</span>
                            </div>
                            <div class="flex items-center p-2 bg-gray-50 rounded-lg">
                                <i class="fab fa-facebook text-blue-700 w-5 text-center"></i>
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
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 text-gray-800">
                    <h3 class="text-sm font-bold mb-4 uppercase tracking-widest text-center border-b pb-2">Alat Autopost</h3>
                    <div class="space-y-3">
                        <a href="https://ifttt.com" target="_blank" class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-black hover:text-white transition-all group border border-gray-100 shadow-sm">
                            <div class="w-8 h-8 bg-black text-white rounded flex items-center justify-center mr-3 font-black text-xs transition-colors">IF</div>
                            <div class="text-[10px] font-bold uppercase tracking-widest">IFTTT</div>
                        </a>
                        <a href="https://zapier.com" target="_blank" class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-orange-500 hover:text-white transition-all group border border-gray-100 shadow-sm">
                            <div class="w-8 h-8 bg-orange-500 text-white rounded flex items-center justify-center mr-3 font-black text-xs transition-colors">Z</div>
                            <div class="text-[10px] font-bold uppercase tracking-widest">Zapier</div>
                        </a>
                    </div>
                </section>
            </div>
        </div>

        {{-- MOTHER TABS SECTION --}}
        <div class="mt-12" x-data="{ 
            motherTab: 'card', 
            codeTab: 'html', 
            showPreview: false,
            loading: false,
            get currentUrl() {
                return '{{ route('extra.rss.generate') }}?unit_id=730714&limit=' + (this.motherTab === 'card' ? '6' : '10');
            },
            runPreview() {
                this.loading = true;
                this.showPreview = true;
                const target = document.getElementById('preview-area');
                target.innerHTML = '<div class=\'py-12 text-center text-gray-400\'>Memproses data...</div>';
                
                fetch(this.currentUrl).then(res => res.text()).then(xml => {
                    const data = new DOMParser().parseFromString(xml, 'text/xml');
                    const items = data.querySelectorAll('item');
                    let html = '';
                    
                    if(this.motherTab === 'card') {
                        html = '<div style=\'display:grid; grid-template-columns:repeat(auto-fit, minmax(250px, 1fr)); gap:20px;\'>';
                        items.forEach(el => {
                            const status = el.querySelector('status').textContent;
                            const color = (status === 'BERLAKU' || status === 'AKTIF') ? '#10b981' : '#ef4444';
                            html += `<div style='background:#fff; border-radius:15px; padding:20px; border:1px solid #eee; box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);'>
                                <div style='display:flex; justify-content:space-between; margin-bottom:10px;'>
                                    <span style='font-size:10px; font-weight:800; color:#666; text-transform:uppercase;'>🏛️ ${el.querySelector('organization').textContent}</span>
                                    <span style='font-size:9px; font-weight:800; padding:2px 8px; border-radius:5px; background:${color}15; color:${color}; border:1px solid ${color}30;'>${status}</span>
                                </div>
                                <h4 style='font-weight:800; color:#1a1a1a; margin:0 0 10px 0; line-height:1.3; font-size:15px;'>${el.querySelector('title').textContent}</h4>
                                <small style='color:#999; font-size:11px;'>📅 ${new Date(el.querySelector('pubDate').textContent).toLocaleDateString('id-ID')}</small>
                            </div>`;
                        });
                        html += '</div>';
                    } else {
                        html = '<div style=\'background:#fff; border-radius:15px; border:1px solid #eee; overflow:hidden;\">';
                        items.forEach((el, index) => {
                            const status = el.querySelector('status').textContent;
                            const color = (status === 'BERLAKU' || status === 'AKTIF') ? '#10b981' : '#ef4444';
                            html += `<div style='padding:15px 20px; border-bottom:${index === items.length-1 ? 'none' : '1px solid #f5f5f5'}; display:flex; align-items:center; justify-content:space-between;'>
                                <div style='display:flex; flex-direction:column; max-width:70%;'>
                                    <h5 style='margin:0; font-weight:700; color:#333; font-size:14px;'>${el.querySelector('title').textContent}</h5>
                                    <small style='color:#888; font-size:11px; margin-top:4px;'>🏛️ ${el.querySelector('organization').textContent} • 📅 ${new Date(el.querySelector('pubDate').textContent).toLocaleDateString('id-ID')}</small>
                                </div>
                                <span style='font-size:9px; font-weight:800; padding:2px 10px; border-radius:20px; background:${color}15; color:${color}; border:1px solid ${color}30;'>${status}</span>
                            </div>`;
                        });
                        html += '</div>';
                    }
                    target.innerHTML = html;
                    this.loading = false;
                }).catch(() => {
                    target.innerHTML = '<div class=\'py-12 text-center text-red-500\'>Gagal memuat data.</div>';
                    this.loading = false;
                });
            }
        }">
            <section class="bg-white rounded-[3rem] shadow-sm border border-gray-100 p-8 md:p-12 overflow-hidden text-gray-800">
                <h2 class="text-3xl font-bold mb-8 flex items-center">
                    <span class="w-12 h-12 bg-purple-600 text-white rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-purple-200">
                        <i class="fas fa-code"></i>
                    </span>
                    Contoh Kode Siap Pakai
                </h2>

                {{-- Level 1: Mother Tabs --}}
                <div class="flex space-x-4 mb-8 border-b pb-4">
                    <button @click="motherTab = 'card'; showPreview = false" :class="motherTab === 'card' ? 'text-blue-600 border-b-4 border-blue-600' : 'text-gray-400'" class="pb-2 text-lg font-black uppercase tracking-tighter transition-all">
                        <i class="fas fa-th-large mr-2"></i> Tampilan Kartu
                    </button>
                    <button @click="motherTab = 'list'; showPreview = false" :class="motherTab === 'list' ? 'text-blue-600 border-b-4 border-blue-600' : 'text-gray-400'" class="pb-2 text-lg font-black uppercase tracking-tighter transition-all">
                        <i class="fas fa-list mr-2"></i> Tampilan Daftar
                    </button>
                </div>

                {{-- Level 2: Sub-Tabs --}}
                <div class="flex flex-wrap gap-2 mb-8 bg-gray-100 p-1 rounded-2xl w-fit">
                    <button @click="codeTab = 'html'; showPreview = false" :class="codeTab === 'html' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-6 rounded-xl text-xs font-bold transition-all uppercase tracking-widest">HTML & JS</button>
                    <button @click="codeTab = 'php'; showPreview = false" :class="codeTab === 'php' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-6 rounded-xl text-xs font-bold transition-all uppercase tracking-widest">PHP Native</button>
                    <button @click="codeTab = 'laravel'; showPreview = false" :class="codeTab === 'laravel' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-6 rounded-xl text-xs font-bold transition-all uppercase tracking-widest">Laravel Blade</button>
                    <button @click="codeTab = 'ci'; showPreview = false" :class="codeTab === 'ci' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-6 rounded-xl text-xs font-bold transition-all uppercase tracking-widest">CodeIgniter</button>
                </div>

                {{-- DARK CONTAINER FOR CODE & PREVIEW --}}
                <div class="bg-gray-900 rounded-[2.5rem] shadow-2xl relative overflow-hidden flex flex-col">
                    
                    {{-- HEADER TOOLS (INSIDE SHAPE) --}}
                    <div class="p-6 border-b border-white/5 flex items-center justify-between bg-white/5">
                        <div class="flex space-x-2">
                            <div class="w-3 h-3 rounded-full bg-red-500/50"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500/50"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500/50"></div>
                        </div>
                        <div class="flex space-x-2">
                            <button @click="runPreview()" class="bg-white/10 hover:bg-white/20 text-white w-10 h-10 rounded-xl flex items-center justify-center transition-all border border-white/10" title="Live Preview">
                                <i class="fas" :class="loading ? 'fa-spinner fa-spin' : 'fa-eye'"></i>
                            </button>
                            <button @click="
                                const elId = `code-${motherTab}-${codeTab}`;
                                const codeText = document.getElementById(elId).innerText;
                                navigator.clipboard.writeText(codeText).then(() => alert('Kode Berhasil Disalin!'));
                            " class="bg-blue-600 hover:bg-blue-700 text-white px-4 h-10 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg flex items-center">
                                <i class="fas fa-copy mr-2"></i> SALIN KODE
                            </button>
                        </div>
                    </div>

                    {{-- PREVIEW AREA --}}
                    <div x-show="showPreview" class="bg-white p-8 md:p-12 min-h-[400px]">
                        <div class="flex justify-between items-center mb-6 border-b pb-4">
                            <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight">Hasil Preview</h3>
                            <button @click="showPreview = false" class="text-xs font-bold text-gray-400 hover:text-red-500">TUTUP [X]</button>
                        </div>
                        <div id="preview-area"></div>
                    </div>

                    {{-- CODE AREA --}}
                    <div x-show="!showPreview" class="p-8 md:p-12 font-mono text-sm leading-relaxed text-gray-300 overflow-x-auto">
                        
                        {{-- CARD VIEW CODES --}}
                        <div x-show="motherTab === 'card'">
                            <template x-if="codeTab === 'html'">
                                <pre class="whitespace-pre-wrap"><code id="code-card-html">&lt;!-- Wadah Grid Kartu --&gt;
&lt;div id="ppid-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; font-family: sans-serif;"&gt;
  Memuat data...
&lt;/div&gt;

&lt;script&gt;
  const RSS_URL = '{{ route('extra.rss.generate') }}?unit_id=730714&limit=6';

  fetch(RSS_URL)
    .then(res => res.text())
    .then(xmlString => {
      const xml = new DOMParser().parseFromString(xmlString, "text/xml");
      const items = xml.querySelectorAll("item");
      let html = '';
      
      items.forEach(el => {
        const title = el.querySelector("title").textContent;
        const link = el.querySelector("link").textContent;
        const date = new Date(el.querySelector("pubDate").textContent).toLocaleDateString('id-ID');
        const org = el.querySelector("organization").textContent;
        const status = el.querySelector("status").textContent;
        const color = (status === 'BERLAKU' || status === 'AKTIF') ? '#10b981' : '#ef4444';

        html += `&lt;div style="background:#fff; border-radius:15px; border:1px solid #eee; box-shadow:0 10px 20px rgba(0,0,0,0.05); padding:20px; display:flex; flex-direction:column;"&gt;
                   &lt;div style="display:flex; justify-content:space-between; margin-bottom:12px;"&gt;
                     &lt;span style="font-size:10px; font-weight:800; color:#666;"&gt;🏛️ ${org}&lt;/span&gt;
                     &lt;span style="font-size:9px; font-weight:bold; padding:2px 8px; border-radius:6px; background:${color}15; color:${color};"&gt;${status}&lt;/span&gt;
                   &lt;/div&gt;
                   &lt;a href="${link}" target="_blank" style="text-decoration:none; color:#1a1a1a; font-weight:800; font-size:15px;"&gt;${title}&lt;/a&gt;
                   &lt;div style="margin-top:auto; padding-top:15px; font-size:11px; color:#999;"&gt;📅 ${date}&lt;/div&gt;
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
    echo "&lt;div style='background:#fff; padding:20px; border-radius:15px; border:1px solid #eee;'&gt;";
    echo "&lt;strong&gt;{$info->title}&lt;/strong&gt;&lt;br&gt;";
    echo "&lt;small&gt;{$info->organization}&lt;/small&gt;";
    echo "&lt;/div&gt;";
}
echo "&lt;/div&gt;";
?&gt;</code></pre></template>
                            <template x-if="codeTab === 'laravel'"><pre class="whitespace-pre-wrap"><code id="code-card-laravel">&lt;!-- 1. Di Controller --&gt;
$url = "{{ route('extra.rss.generate') }}?limit=6";
$xml = simplexml_load_file($url);
return view('view', ['feeds' => $xml->channel->item]);

&lt;!-- 2. Di Blade --&gt;
&lt;div class="grid grid-cols-3 gap-6"&gt;
    &commat;foreach($feeds as $item)
        &lt;div class="bg-white p-6 rounded-2xl shadow-sm border"&gt;
            &lt;h4 class="font-bold"&gt;@{{ $item->title }}&lt;/h4&gt;
            &lt;p class="text-xs"&gt;@{{ $item->organization }}&lt;/p&gt;
        &lt;/div&gt;
    &commat;endforeach
&lt;/div&gt;</code></pre></template>
                            <template x-if="codeTab === 'ci'"><pre class="whitespace-pre-wrap"><code id="code-card-ci">&lt;!-- 1. Di Controller --&gt;
$url = "{{ route('extra.rss.generate') }}?limit=6";
$data['feeds'] = simplexml_load_file($url);
$this->load->view('rss_view', $data);

&lt;!-- 2. Di View --&gt;
&lt;div style="display:grid; grid-template-columns:repeat(3, 1fr);"&gt;
    &lt;?php foreach ($feeds->channel->item as $item): ?&gt;
        &lt;div class="card"&gt;
            &lt;h5&gt;&lt;?= $item->title ?&gt;&lt;/h5&gt;
        &lt;/div&gt;
    &lt;?php endforeach; ?&gt;
&lt;/div&gt;</code></pre></template>
                        </div>

                        {{-- LIST VIEW CODES --}}
                        <div x-show="motherTab === 'list'">
                            <template x-if="codeTab === 'html'">
                                <pre class="whitespace-pre-wrap"><code id="code-list-html">&lt;!-- Wadah Daftar Horizontal --&gt;
&lt;div id="ppid-list" style="background:#fff; border-radius:15px; border:1px solid #eee; overflow:hidden; font-family: sans-serif;"&gt;
  Memuat...
&lt;/div&gt;

&lt;script&gt;
  fetch('{{ route('extra.rss.generate') }}?limit=10')
    .then(res => res.text())
    .then(xmlString => {
      const xml = new DOMParser().parseFromString(xmlString, "text/xml");
      const items = xml.querySelectorAll("item");
      let html = '';
      
      items.forEach((el, index) => {
        const title = el.querySelector("title").textContent;
        const link = el.querySelector("link").textContent;
        const org = el.querySelector("organization").textContent;
        const status = el.querySelector("status").textContent;
        const color = (status === 'BERLAKU' || status === 'AKTIF') ? '#10b981' : '#ef4444';
        
        html += `&lt;div style="padding:15px 20px; border-bottom:${index === items.length-1 ? 'none' : '1px solid #f5f5f5'}; display:flex; align-items:center; justify-content:space-between;"&gt;
                   &lt;div&gt;
                     &lt;a href="${link}" target="_blank" style="text-decoration:none; color:#333; font-weight:700; font-size:14px;"&gt;${title}&lt;/a&gt;
                     &lt;div style="color:#888; font-size:11px; margin-top:4px;"&gt;🏛️ ${org}&lt;/div&gt;
                   &lt;/div&gt;
                   &lt;span style="font-size:9px; font-weight:800; padding:2px 10px; border-radius:20px; background:${color}15; color:${color};"&gt;${status}&lt;/span&gt;
                 &lt;/div&gt;`;
      });
      document.getElementById("ppid-list").innerHTML = html;
    });
&lt;/script&gt;</code></pre>
                            </template>
                            <template x-if="codeTab === 'php'"><pre class="whitespace-pre-wrap"><code id="code-list-php">&lt;?php
$url = "{{ route('extra.rss.generate') }}?limit=10";
$xml = simplexml_load_file($url);
foreach ($xml->channel->item as $info) {
    echo "&lt;div&gt;{$info->title} ({$info->status})&lt;/div&gt;";
}
?&gt;</code></pre></template>
                            <template x-if="codeTab === 'laravel'"><pre class="whitespace-pre-wrap"><code id="code-list-laravel">&commat;foreach($feeds as $item)
    &lt;div class="py-2 border-b flex justify-between"&gt;
        &lt;span&gt;@{{ $item->title }}&lt;/span&gt;
        &lt;span&gt;@{{ $item->status }}&lt;/span&gt;
    &lt;/div&gt;
&commat;endforeach</code></pre></template>
                            <template x-if="codeTab === 'ci'"><pre class="whitespace-pre-wrap"><code id="code-list-ci">&lt;?php foreach ($feeds->channel->item as $item): ?&gt;
    &lt;p&gt;&lt;?= $item->title ?&gt;&lt;/p&gt;
&lt;?php endforeach; ?&gt;</code></pre></template>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
