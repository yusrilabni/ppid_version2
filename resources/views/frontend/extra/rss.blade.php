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
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">RSS Feed & Integrasi Sistem</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto text-sm">Gunakan feed XML untuk menampilkan update informasi otomatis di platform Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Column --}}
            <div class="lg:col-span-2 space-y-8 text-gray-800">
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-bold mb-4 flex items-center">
                        <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span> Apa itu RSS Feed?
                    </h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        RSS adalah format data standar untuk mengirimkan informasi yang sering diperbarui secara otomatis tanpa perlu pemantauan manual.
                    </p>
                </section>

                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold mb-6 flex items-center text-orange-600">
                        <span class="w-2 h-8 bg-orange-500 rounded-full mr-3"></span> Kustomisasi URL Feed
                    </h2>
                    <div class="bg-gray-900 rounded-2xl p-6 text-[11px] font-mono text-gray-300 space-y-4 border-l-4 border-orange-500 shadow-xl">
                        <div>
                            <p class="text-blue-400 font-bold mb-1">// Filter per Instansi (Diskominfo Sinjai)</p>
                            <code class="break-all text-white">{{ route('extra.rss.generate') }}?unit_id=730714</code>
                        </div>
                        <div>
                            <p class="text-blue-400 font-bold mb-1">// Filter per Tahun (2023)</p>
                            <code class="break-all text-white">{{ route('extra.rss.generate') }}?year=2023</code>
                        </div>
                        <div class="pt-2 border-t border-white/10">
                            <p class="text-orange-400 font-black mb-1 uppercase tracking-widest text-[10px]">// Contoh Gabungan 3 Filter (Limit 6):</p>
                            <code class="break-all text-white">{{ route('extra.rss.generate') }}?unit_id=730714&year=2023&limit=6</code>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="mt-6 text-left">
                        <button @click="open = !open" class="text-blue-600 hover:text-blue-800 font-bold text-xs flex items-center transition-all">
                            <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-list-ul'"></i> 
                            <span class="ml-2" x-text="open ? 'Sembunyikan Daftar ID OPD' : 'Lihat Daftar ID OPD Semua Instansi'"></span>
                        </button>
                        <div x-show="open" x-transition class="mt-4 border-t pt-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-[10px]">
                                @foreach($organizations as $org)
                                    <div class="flex justify-between p-2 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors border border-transparent hover:border-blue-100">
                                        <span class="text-gray-700 font-medium truncate pr-4">{{ $org->name }}</span>
                                        <span class="text-blue-600 font-bold font-mono">ID: {{ $org->unit_id }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 text-gray-800">
                    <h2 class="text-lg font-bold mb-4 flex items-center text-blue-600">
                        <i class="fas fa-sync-alt mr-2"></i> Sinkronisasi Sosial
                    </h2>
                    <div class="text-xs text-gray-600 space-y-4 leading-relaxed">
                        <p>Post otomatis ke <strong>Facebook, X, atau Telegram</strong> Anda.</p>
                        <div class="space-y-2 text-[10px]">
                            <div class="flex items-center p-2.5 bg-gray-50 rounded-xl border border-gray-100">
                                <i class="fas fa-robot text-blue-500 w-6 text-center"></i>
                                <span class="ml-2 font-bold italic">Auto Post IFTTT/Zapier</span>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="bg-orange-600 rounded-3xl shadow-lg p-6 text-white relative overflow-hidden group">
                    <i class="fab fa-google absolute -bottom-2 -right-2 text-7xl opacity-20 group-hover:scale-110 transition-transform"></i>
                    <h3 class="text-lg font-bold mb-3 font-black uppercase tracking-widest text-center">Blogger</h3>
                    <div class="space-y-2 text-[11px] opacity-95 font-medium leading-relaxed">
                        <p>Dashboard > Tata Letak > Tambah Gadget > Feed.</p>
                    </div>
                </section>
            </div>
        </div>

        {{-- MOTHER TABS SECTION --}}
        <div class="mt-12" x-data="rssCodeHandler()">
            <section class="bg-white rounded-[3.5rem] shadow-2xl border border-gray-100 p-8 md:p-14 overflow-hidden text-gray-800">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
                    <h2 class="text-3xl font-black flex items-center mb-6 md:mb-0 tracking-tight">
                        <span class="w-14 h-14 bg-gradient-to-br from-purple-600 to-blue-600 text-white rounded-2xl flex items-center justify-center mr-5 shadow-xl shadow-purple-200">
                            <i class="fas fa-magic"></i>
                        </span>
                        Contoh Kode Siap Pakai
                    </h2>
                    
                    {{-- Action Buttons --}}
                    <div class="flex space-x-3">
                        <button @click="copyCode()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 h-12 rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-200 flex items-center">
                            <i class="fas fa-copy mr-2 text-sm"></i> SALIN KODE
                        </button>
                        <button @click="runPreview()" class="bg-orange-500 hover:bg-orange-600 text-white w-12 h-12 rounded-2xl flex items-center justify-center transition-all shadow-lg shadow-orange-200" title="Live Preview">
                            <i class="fas text-lg" :class="loading ? 'fa-spinner fa-spin' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                {{-- Level 1: Mother Tabs --}}
                <div class="flex space-x-6 mb-10 border-b-2 border-gray-100">
                    <button @click="motherTab = 'card'; showPreview = false" :class="motherTab === 'card' ? 'text-blue-600 border-b-4 border-blue-600 -mb-[2px]' : 'text-gray-400 hover:text-gray-600'" class="pb-4 text-xl font-black uppercase tracking-tighter transition-all">
                        <i class="fas fa-th-large mr-2"></i> Tampilan Kartu
                    </button>
                    <button @click="motherTab = 'list'; showPreview = false" :class="motherTab === 'list' ? 'text-blue-600 border-b-4 border-blue-600 -mb-[2px]' : 'text-gray-400 hover:text-gray-600'" class="pb-4 text-xl font-black uppercase tracking-tighter transition-all">
                        <i class="fas fa-list mr-2"></i> Tampilan Daftar
                    </button>
                </div>

                {{-- Level 2: Sub-Tabs --}}
                <div class="flex flex-wrap gap-2 mb-10 bg-gray-100 p-1.5 rounded-[1.2rem] w-fit">
                    <button @click="codeTab = 'html'; showPreview = false" :class="codeTab === 'html' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="py-3 px-8 rounded-xl text-xs font-black transition-all uppercase tracking-widest">HTML & JS</button>
                    <button @click="codeTab = 'php'; showPreview = false" :class="codeTab === 'php' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="py-3 px-8 rounded-xl text-xs font-black transition-all uppercase tracking-widest">PHP Native</button>
                    <button @click="codeTab = 'laravel'; showPreview = false" :class="codeTab === 'laravel' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="py-3 px-8 rounded-xl text-xs font-black transition-all uppercase tracking-widest">Laravel Blade</button>
                    <button @click="codeTab = 'ci'; showPreview = false" :class="codeTab === 'ci' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="py-3 px-8 rounded-xl text-xs font-black transition-all uppercase tracking-widest">CodeIgniter</button>
                </div>

                {{-- MAIN DISPLAY BOX --}}
                <div class="bg-gray-900 rounded-[3rem] shadow-2xl relative overflow-hidden flex flex-col min-h-[550px] border-8 border-gray-800">
                    {{-- HEADER TOOLS --}}
                    <div class="p-6 border-b border-white/5 flex items-center bg-white/5">
                        <div class="flex space-x-2">
                            <div class="w-3 h-3 rounded-full bg-red-500/40"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500/40"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500/40"></div>
                        </div>
                        <div class="ml-6 flex items-center">
                            <i class="fas fa-terminal text-blue-500/50 mr-3"></i>
                            <span class="text-[10px] font-black text-gray-500 uppercase tracking-[0.3em]" x-text="showPreview ? 'Live Preview Area' : codeTab + ' source code'"></span>
                        </div>
                    </div>

                    {{-- DISPLAY AREA --}}
                    <div class="relative flex-grow flex flex-col">
                        {{-- PREVIEW AREA --}}
                        <div x-show="showPreview" class="bg-[#fcfcfc] p-8 md:p-14 h-full min-h-[450px] overflow-y-auto">
                            <div class="flex justify-between items-center mb-8 border-b-2 border-gray-100 pb-5">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-3"></div>
                                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Live Result (Aktual)</h3>
                                </div>
                                <button @click="showPreview = false" class="text-[10px] font-black text-red-400 hover:text-red-600 uppercase tracking-widest border border-red-100 px-3 py-1.5 rounded-lg transition-colors">Tutup Preview [X]</button>
                            </div>
                            <div id="preview-area" class="w-full"></div>
                        </div>

                        {{-- CODE AREA --}}
                        <div x-show="!showPreview" class="p-8 md:p-12 font-mono text-[13px] leading-relaxed text-blue-100/80 overflow-x-auto flex-grow">
                            <div x-show="motherTab === 'card'">
                                <template x-if="codeTab === 'html'">
                                    <pre class="whitespace-pre-wrap"><code id="code-card-html">&lt;style&gt;
  /* CATATAN: CSS di bawah ini bisa Anda hapus atau custom sesuka hati */
  .ppid-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; }
  .ppid-card { background: #fff; border-radius: 20px; padding: 20px; border: 1px solid #eee; box-shadow: 0 5px 15px rgba(0,0,0,0.05); font-family: sans-serif; }
  .ppid-title { font-weight: 800; color: #1a1a1a; text-decoration: none; font-size: 15px; display: block; margin: 10px 0; }
  @media (max-width: 768px) { .ppid-grid { grid-template-columns: 1fr; } }
&lt;/style&gt;

&lt;div id="ppid-grid" class="ppid-grid"&gt;Memuat data...&lt;/div&gt;

&lt;script&gt;
  fetch('{{ route('extra.rss.generate') }}?unit_id=730714&limit=6').then(res => res.text()).then(xmlString => {
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
                                <template x-if="codeTab === 'laravel'"><pre class="whitespace-pre-wrap"><code id="code-card-laravel">// Di Controller
$rss = simplexml_load_file("{{ route('extra.rss.generate') }}?limit=6");
return view('view', ['feeds' => $rss->channel->item]);

// Di Blade
&lt;div class="grid grid-cols-3 gap-6"&gt;
    &commat;foreach($feeds as $item)
        &lt;div class="card"&gt;
            &lt;h4&gt;{{ $item->title }}&lt;/h4&gt;
        &lt;/div&gt;
    &commat;endforeach
&lt;/div&gt;</code></pre></template>
                                <template x-if="codeTab === 'ci'"><pre class="whitespace-pre-wrap"><code id="code-card-ci">// Di Controller
$url = "{{ route('extra.rss.generate') }}?limit=6";
$data['feeds'] = simplexml_load_file($url);
$this->load->view('rss_view', $data);

// Di View (rss_view.php)
&lt;div class="grid"&gt;
    &lt;?php foreach ($feeds->channel->item as $item): ?&gt;
        &lt;div class="card"&gt;&lt;?= $item->title ?&gt;&lt;/div&gt;
    &lt;?php endforeach; ?&gt;
&lt;/div&gt;</code></pre></template>
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
                                <template x-if="codeTab === 'php'"><pre class="whitespace-pre-wrap"><code id="code-list-php">&lt;?php
$url = "{{ route('extra.rss.generate') }}?limit=10";
$rss = simplexml_load_file($url);
foreach ($rss->channel->item as $info) {
    echo "&lt;div&gt;{$info->title}&lt;/div&gt;";
}
?&gt;</code></pre></template>
                                <template x-if="codeTab === 'laravel'"><pre class="whitespace-pre-wrap"><code id="code-list-laravel">&commat;foreach($feeds as $item)
    &lt;div&gt;{{ $item->title }}&lt;/div&gt;
&commat;endforeach</code></pre></template>
                                <template x-if="codeTab === 'ci'"><pre class="whitespace-pre-wrap"><code id="code-list-ci">&lt;?php foreach ($feeds->channel->item as $item): ?&gt;
    &lt;p&gt;&lt;?= $item->title ?&gt;&lt;/p&gt;
&lt;?php endforeach; ?&gt;</code></pre></template>
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
            motherTab: 'card',
            codeTab: 'html',
            showPreview: false,
            loading: false,
            get currentUrl() {
                return '{{ route('extra.rss.generate') }}?unit_id=730714&limit=' + (this.motherTab === 'card' ? '6' : '10');
            },
            copyCode() {
                const elId = `code-${this.motherTab}-${this.codeTab}`;
                const el = document.getElementById(elId);
                if(!el) { alert('Kode belum siap.'); return; }
                navigator.clipboard.writeText(el.innerText).then(() => alert('Kode Berhasil Disalin!'));
            },
            runPreview() {
                this.loading = true;
                this.showPreview = true;
                const target = document.getElementById('preview-area');
                target.innerHTML = '<div style="padding:100px; text-align:center; color:#9ca3af; font-weight:800; text-transform:uppercase; font-family:sans-serif;">Merender...</div>';
                
                fetch(this.currentUrl).then(res => res.text()).then(xmlString => {
                    const xml = new DOMParser().parseFromString(xmlString, "text/xml");
                    const items = xml.querySelectorAll("item");
                    let html = '';
                    
                    if(this.motherTab === 'card') {
                        html = '<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:30px; font-family:sans-serif;">';
                        items.forEach(el => {
                            const status = el.querySelector('status').textContent;
                            const color = (status === 'BERLAKU' || status === 'AKTIF') ? '#10b981' : '#ef4444';
                            html += `<div style="background:#fff; border-radius:24px; padding:30px; border:1px solid #f0f0f0; box-shadow:0 20px 25px -5px rgba(0,0,0,0.05); display:flex; flex-direction:column;">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                                    <span style="font-size:10px; font-weight:900; color:#0052FF; text-transform:uppercase; letter-spacing:1px;">🏛️ ${el.querySelector('organization').textContent}</span>
                                    <span style="font-size:9px; font-weight:900; padding:4px 12px; border-radius:8px; background:${color}10; color:${color}; border:1.5px solid ${color}20;">${status}</span>
                                </div>
                                <h4 style="font-weight:800; color:#111827; margin:0 0 15px 0; line-height:1.4; font-size:16px;">${el.querySelector('title').textContent}</h4>
                                <div style="margin-top:auto; font-size:11px; color:#9ca3af; font-weight:600;">📅 ${new Date(el.querySelector('pubDate').textContent).toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'})}</div>
                            </div>`;
                        });
                        html += '</div>';
                    } else {
                        html = '<div style="background:#fff; border-radius:24px; border:1px solid #f0f0f0; overflow:hidden; box-shadow:0 10px 15px -3px rgba(0,0,0,0.05); font-family:sans-serif;">';
                        items.forEach((el, index) => {
                            const status = el.querySelector('status').textContent;
                            const color = (status === 'BERLAKU' || status === 'AKTIF') ? '#10b981' : '#ef4444';
                            html += `<div style="padding:25px 35px; border-bottom:${index === items.length-1 ? 'none' : '1.5px solid #f9f9f9'}; display:flex; align-items:center; justify-content:space-between;">
                                <div style="max-width:70%;">
                                    <div style="font-size:10px; font-weight:900; color:#9ca3af; text-transform:uppercase; margin-bottom:6px;">🏛️ ${el.querySelector('organization').textContent}</div>
                                    <h5 style="margin:0; font-weight:800; color:#1f2937; font-size:15px; line-height:1.4;">${el.querySelector('title').textContent}</h5>
                                </div>
                                <span style="font-size:9px; font-weight:900; padding:5px 15px; border-radius:30px; background:${color}10; color:${color}; border:1px solid ${color}30;">${status}</span>
                            </div>`;
                        });
                        html += '</div>';
                    }
                    target.innerHTML = html;
                    this.loading = false;
                }).catch(() => {
                    target.innerHTML = '<div style="padding:50px; text-align:center; color:red; font-weight:bold;">Gagal memuat pratinjau.</div>';
                    this.loading = false;
                });
            }
        };
    }
</script>
@endsection
