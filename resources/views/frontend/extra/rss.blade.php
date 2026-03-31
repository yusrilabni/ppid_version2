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
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-gray-800">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
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
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-gray-800">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
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
                            <p class="text-blue-400 font-bold mb-1">// Limit Jumlah Data (Contoh: 5 item terbaru)</p>
                            <code class="break-all">{{ route('extra.rss.generate') }}?limit=5</code>
                        </div>
                        <div class="pt-2 border-t border-white/10">
                            <p class="text-orange-400 font-black mb-1 uppercase tracking-widest">// Contoh Gabungan 3 Filter Sekaligus (Diskominfo + 2023 + 5 Data):</p>
                            <code class="break-all text-white">{{ route('extra.rss.generate') }}?unit_id=730714&year=2023&limit=5</code>
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
                    <h2 class="text-lg font-bold mb-4 flex items-center">
                        <i class="fas fa-sync-alt text-blue-500 mr-2"></i> Sinkronisasi Sosial
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
                    <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-widest text-center border-b pb-2">Alat Autopost</h3>
                    <div class="space-y-3">
                        <a href="https://ifttt.com" target="_blank" class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-black hover:text-white transition-all group border border-gray-100 shadow-sm">
                            <div class="w-8 h-8 bg-black text-white rounded flex items-center justify-center mr-3 font-black text-xs transition-colors">IF</div>
                            <div class="text-[10px] font-bold">IFTTT (Mudah)</div>
                        </a>
                        <a href="https://zapier.com" target="_blank" class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-orange-500 hover:text-white transition-all group border border-gray-100 shadow-sm">
                            <div class="w-8 h-8 bg-orange-500 text-white rounded flex items-center justify-center mr-3 font-black text-xs transition-colors">Z</div>
                            <div class="text-[10px] font-bold">Zapier (Lengkap)</div>
                        </a>
                    </div>
                </section>
            </div>
        </div>

        {{-- FULL WIDTH CODE EXAMPLES SECTION --}}
        <div class="mt-12">
            <section class="bg-white rounded-[3rem] shadow-sm border border-gray-100 p-8 md:p-12 overflow-hidden text-gray-800">
                <h2 class="text-3xl font-bold mb-8 flex items-center">
                    <span class="w-12 h-12 bg-purple-600 text-white rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-purple-200">
                        <i class="fas fa-code"></i>
                    </span>
                    Contoh Kode Siap Pakai (Copy-Paste)
                </h2>

                <div x-data="{ tab: 'html' }">
                    <div class="flex flex-wrap gap-2 mb-8 bg-gray-100 p-1 rounded-2xl w-fit">
                        <button @click="tab = 'html'" :class="tab === 'html' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-6 rounded-xl text-xs font-bold transition-all uppercase tracking-widest">HTML & JS</button>
                        <button @click="tab = 'php'" :class="tab === 'php' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-6 rounded-xl text-xs font-bold transition-all uppercase tracking-widest">PHP Native</button>
                        <button @click="tab = 'laravel'" :class="tab === 'laravel' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-6 rounded-xl text-xs font-bold transition-all uppercase tracking-widest">Laravel Blade</button>
                        <button @click="tab = 'ci'" :class="tab === 'ci' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-3 px-6 rounded-xl text-xs font-bold transition-all uppercase tracking-widest">CodeIgniter</button>
                    </div>

                    <div class="bg-gray-900 rounded-[2.5rem] p-8 md:p-12 font-mono text-sm leading-relaxed text-gray-300 shadow-2xl overflow-x-hidden relative group text-left">
                        {{-- Tombol Salin --}}
                        <button @click="
                            let codeText = '';
                            if (tab === 'html') codeText = document.getElementById('code-html').innerText;
                            if (tab === 'php') codeText = document.getElementById('code-php').innerText;
                            if (tab === 'laravel') codeText = document.getElementById('code-laravel').innerText;
                            if (tab === 'ci') codeText = document.getElementById('code-ci').innerText;
                            
                            navigator.clipboard.writeText(codeText).then(() => {
                                alert('Kode ' + tab.toUpperCase() + ' berhasil disalin!');
                            });
                        " class="absolute top-6 right-6 bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl text-xs font-bold backdrop-blur-md transition-all border border-white/10 z-10 flex items-center transition-all">
                            <i class="fas fa-copy mr-2"></i> SALIN KODE
                        </button>

                        <template x-if="tab === 'html'">
                            <div class="space-y-4">
                                <p class="text-blue-400 text-xs italic">// Copy kode ini ke file HTML Anda. Data dikontrol via URL.</p>
                                <pre class="whitespace-pre-wrap"><code id="code-html">&lt;!-- Wadah daftar berita --&gt;
&lt;div id="ppid-list" style="font-family: sans-serif; max-width: 100%; border: 1px solid #eee; padding: 20px; border-radius: 15px;"&gt;
  Memuat data terbaru...
&lt;/div&gt;

&lt;script&gt;
  // Gunakan filter ?unit_id=730714 (Diskominfo) & limit=5
  const RSS_URL = '{{ route('extra.rss.generate') }}?unit_id=730714&limit=5';

  fetch(RSS_URL)
    .then(res => res.text())
    .then(xmlString => {
      const xml = new DOMParser().parseFromString(xmlString, "text/xml");
      const items = xml.querySelectorAll("item");
      let html = '&lt;h3 style="margin-top:0;"&gt;Update Informasi Diskominfo&lt;/h3&gt;&lt;ul style="padding:0; margin:0; list-style:none;"&gt;';
      
      items.forEach(el => {
        const title = el.querySelector("title").textContent;
        const link = el.querySelector("link").textContent;
        const date = new Date(el.querySelector("pubDate").textContent).toLocaleDateString('id-ID');
        const organization = el.querySelector("organization").textContent;
        
        html += `&lt;li style="margin-bottom:20px; padding:15px; background:#f9f9f9; border-radius:12px; border-left: 5px solid #0052FF;"&gt;
                   &lt;span style="font-size:10px; font-weight:bold; color:#666;"&gt;🏛️ ${organization}&lt;/span&gt;&lt;br&gt;
                   &lt;a href="${link}" target="_blank" style="text-decoration:none; color:#0052FF; font-weight:bold; font-size:15px;"&gt;${title}&lt;/a&gt;
                   &lt;div style="color:#888; font-size:12px; margin-top:5px;"&gt;📅 Dipublikasikan: ${date}&lt;/div&gt;
                 &lt;/li&gt;`;
      });
      document.getElementById("ppid-list").innerHTML = html + '&lt;/ul&gt;';
    })
    .catch(err => {
      document.getElementById("ppid-list").innerHTML = "Gagal memuat data.";
    });
&lt;/script&gt;</code></pre>
                            </div>
                        </template>
                        
                        <template x-if="tab === 'php'">
                            <div class="space-y-4">
                                <p class="text-blue-400 text-xs italic">// Gunakan kode PHP ini di server Anda. Mendukung filter gabungan.</p>
                                <pre class="whitespace-pre-wrap"><code id="code-php">&lt;?php
// Contoh URL: Diskominfo (730714) + Tahun 2023 + 5 Data
$url = "{{ route('extra.rss.generate') }}?unit_id=730714&year=2023&limit=5";
$rss = simplexml_load_file($url);

echo "&lt;h2&gt;Update Informasi Diskominfo&lt;/h2&gt;";
echo "&lt;ul style='list-style:none; padding:0;'&gt;";

foreach ($rss->channel->item as $info) {
    echo "&lt;li style='margin-bottom:20px; padding:10px; border-bottom:1px solid #eee;'&gt;";
    echo "&lt;a href='{$info->link}' target='_blank' style='color:#0052FF; font-weight:bold; text-decoration:none;'&gt;{$info->title}&lt;/a&gt;&lt;br&gt;";
    echo "&lt;small style='color:#666;'&gt;🏛️ {$info->organization} | ✅ {$info->status}&lt;/small&gt;&lt;br&gt;";
    echo "&lt;/small&gt;";
    echo "&lt;/li&gt;";
}

echo "&lt;/ul&gt;";
?&gt;</code></pre>
                            </div>
                        </template>

                        <template x-if="tab === 'laravel'">
                            <div class="space-y-4">
                                <p class="text-blue-400 text-xs italic">// Implementasi di Laravel (Blade + Controller).</p>
                                <pre class="whitespace-pre-wrap"><code id="code-laravel">// 1. Di Controller Anda
public function showFeed() {
    // Ambil 10 data terbaru dari Diskominfo (730714)
    $url = "{{ route('extra.rss.generate') }}?unit_id=730714&limit=10";
    $xml = simplexml_load_file($url);
    return view('your_view', ['feeds' => $xml->channel->item]);
}

// 2. Di File .blade.php
&lt;ul&gt;
    @@foreach($feeds as $item)
        &lt;li&gt;
            &lt;a href="@{{ $item->link }}"&gt;@{{ $item->title }}&lt;/a&gt;
            &lt;p&gt;Dinas: @{{ $item->organization }}&lt;/p&gt;
        &lt;/li&gt;
    @@endforeach
&lt;/ul&gt;</code></pre>
                            </div>
                        </template>

                        <template x-if="tab === 'ci'">
                            <div class="space-y-4">
                                <p class="text-blue-400 text-xs italic">// Implementasi di CodeIgniter (Controller + View).</p>
                                <pre class="whitespace-pre-wrap"><code id="code-ci">// 1. Di Controller
public function index() {
    // Ambil 5 data terbaru dari Diskominfo (730714)
    $url = "{{ route('extra.rss.generate') }}?unit_id=730714&limit=5";
    $data['feeds'] = simplexml_load_file($url);
    $this->load->view('rss_view', $data);
}

// 2. Di View (rss_view.php)
&lt;ul&gt;
    &lt;?php foreach ($feeds->channel->item as $item): ?&gt;
        &lt;li&gt;
            &lt;a href="&lt;?= $item->link ?&gt;"&gt;&lt;?= $item->title ?&gt;&lt;/a&gt;
            &lt;small&gt;&lt;?= $item->organization ?&gt; (&lt;?= $item->status ?&gt;)&lt;/small&gt;
        &lt;/li&gt;
    &lt;?php endforeach; ?&gt;
&lt;/ul&gt;</code></pre>
                            </div>
                        </template>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
