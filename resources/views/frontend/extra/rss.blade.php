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
                
                {{-- Detail Struktur Data RSS --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span>
                        Apa yang Ada di Dalam RSS Kami?
                    </h2>
                    <p class="text-gray-600 mb-6 text-sm">Setiap unit informasi dalam RSS kami memuat data detail berikut yang bisa Anda olah:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-blue-600 font-bold text-xs font-mono">&lt;title&gt;</span>
                            <p class="text-[11px] text-gray-500 mt-1">Judul resmi dokumen atau pengumuman yang dipublikasikan.</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-blue-600 font-bold text-xs font-mono">&lt;link&gt;</span>
                            <p class="text-[11px] text-gray-500 mt-1">Alamat URL langsung untuk melihat detail atau mendownload file.</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-blue-600 font-bold text-xs font-mono">&lt;description&gt;</span>
                            <p class="text-[11px] text-gray-500 mt-1">Ringkasan isi dokumen (potongan teks awal) untuk gambaran singkat.</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-blue-600 font-bold text-xs font-mono">&lt;category&gt;</span>
                            <p class="text-[11px] text-gray-500 mt-1">Klasifikasi informasi (Informasi Berkala, Setiap Saat, dll).</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-blue-600 font-bold text-xs font-mono">&lt;pubDate&gt;</span>
                            <p class="text-[11px] text-gray-500 mt-1">Tanggal dan waktu kapan informasi tersebut diupload ke sistem.</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-blue-600 font-bold text-xs font-mono">&lt;dc:creator&gt;</span>
                            <p class="text-[11px] text-gray-500 mt-1">Pihak pengunggah atau instansi terkait yang bertanggung jawab.</p>
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
                        <div>
                            <p class="text-blue-400 font-bold mb-1">// Batasi jumlah data yang tampil (Misal hanya 5 item)</p>
                            <code class="break-all">{{ route('extra.rss.generate') }}?limit=5</code>
                        </div>
                    </div>
                </section>

                {{-- Contoh Kode Siap Pakai --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-purple-500 rounded-full mr-3"></span>
                        Contoh Kode Siap Pakai (Copy-Paste)
                    </h2>
                    <div x-data="{ tab: 'html' }">
                        <div class="flex space-x-2 mb-6 bg-gray-100 p-1 rounded-xl w-fit">
                            <button @click="tab = 'html'" :class="tab === 'html' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-2 px-4 rounded-lg text-xs font-bold transition-all">HTML & JS (Browser)</button>
                            <button @click="tab = 'php'" :class="tab === 'php' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-2 px-4 rounded-lg text-xs font-bold transition-all">PHP (Server)</button>
                        </div>

                        <div class="bg-gray-900 rounded-2xl p-6 font-mono text-[11px] md:text-sm leading-relaxed overflow-x-auto text-gray-300">
                            <template x-if="tab === 'html'">
                                <pre><code>@verbatim&lt;!-- Wadah untuk menampilkan daftar berita --&gt;
&lt;div id="ppid-list" style="font-family: sans-serif; max-width: 400px;"&gt;
  Memuat data...
&lt;/div&gt;

&lt;script&gt;
  const RSS_URL = 'URL_RSS_KAMI';

  fetch(RSS_URL)
    .then(res => res.text())
    .then(xmlString => {
      const xml = new DOMParser().parseFromString(xmlString, "text/xml");
      const items = xml.querySelectorAll("item");
      let html = '&lt;h3&gt;Update Terbaru&lt;/h3&gt;&lt;ul style="padding:0; list-style:none;"&gt;';
      
      items.forEach(el => {
        const title = el.querySelector("title").textContent;
        const link = el.querySelector("link").textContent;
        const date = new Date(el.querySelector("pubDate").textContent).toLocaleDateString('id-ID');
        
        html += `&lt;li style="margin-bottom:15px; border-bottom:1px solid #eee; padding-bottom:5px;"&gt;
                   &lt;a href="${link}" target="_blank" style="text-decoration:none; color:#0052FF; font-weight:bold;"&gt;${title}&lt;/a&gt;
                   &lt;br&gt;&lt;small style="color:#999"&gt;Terbit: ${date}&lt;/small&gt;
                 &lt;/li&gt;`;
      });
      
      document.getElementById("ppid-list").innerHTML = html + '&lt;/ul&gt;';
    });
&lt;/script&gt;@endverbatim</code></pre>
                            </template>
                            <template x-if="tab === 'php'">
                                <pre><code>@verbatim&lt;?php
// 1. Ambil file XML
$rss = simplexml_load_file('URL_RSS_KAMI');

echo "&lt;h2&gt;Informasi PPID Sinjai&lt;/h2&gt;";
echo "&lt;ul&gt;";

// 2. Loop melalui setiap item berita
foreach ($rss->channel->item as $info) {
    echo "&lt;li&gt;";
    echo "&lt;strong&gt;&lt;a href='{$info->link}'&gt;{$info->title}&lt;/a&gt;&lt;/strong&gt;&lt;br&gt;";
    echo "&lt;small&gt;Kategori: {$info->category}&lt;/small&gt;&lt;br&gt;";
    echo "&lt;p&gt;{$info->description}&lt;/p&gt;";
    echo "&lt;/li&gt;";
}

echo "&lt;/ul&gt;";
?&gt;@endverbatim</code></pre>
                            </template>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                {{-- Autopost Explanation --}}
                <section class="bg-blue-600 rounded-3xl shadow-lg p-8 text-white relative overflow-hidden">
                    <i class="fas fa-robot absolute -bottom-4 -right-4 text-8xl opacity-20"></i>
                    <h3 class="text-xl font-bold mb-4">Apa itu Auto-Post?</h3>
                    <div class="text-sm opacity-90 space-y-4">
                        <p><strong>Auto-Post</strong> adalah sistem otomatis yang "mengintip" RSS kami setiap saat. Jika ada berita baru, sistem ini akan langsung mengambilnya dan mengirimkannya ke akun Sosmed Anda.</p>
                        <p><strong>Fungsinya:</strong> Anda tidak perlu lagi menyalin link website ke Facebook secara manual. Semuanya dikerjakan oleh robot (IFTTT/Zapier).</p>
                        <p><strong>Penerapan:</strong> Sangat cocok untuk akun Facebook Page Pemerintah Desa, Twitter Portal Berita, atau Channel Telegram komunitas.</p>
                    </div>
                </section>

                {{-- Platform Penerapan --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Dapat Digunakan Di:</h3>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i> Website WordPress / Blogger</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i> Aplikasi Mobile (Android/iOS)</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i> TV Digital / Digital Signage</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i> Bot Auto-Post Media Sosial</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i> Email Newsletter Otomatis</li>
                    </ul>
                </section>

                {{-- Social Tools --}}
                <section class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-3xl p-8 text-white">
                    <h3 class="text-lg font-bold mb-4">Alat Populer</h3>
                    <div class="space-y-3">
                        <a href="https://ifttt.com" target="_blank" class="block p-3 bg-white/10 rounded-xl hover:bg-white/20 transition-all text-xs">
                            <strong>IFTTT:</strong> Paling mudah untuk pemula. Hubungkan RSS ke Facebook/Twitter.
                        </a>
                        <a href="https://zapier.com" target="_blank" class="block p-3 bg-white/10 rounded-xl hover:bg-white/20 transition-all text-xs">
                            <strong>Zapier:</strong> Lebih teknis, bisa menghubungkan ke ribuan aplikasi lain.
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
