@extends('frontend.layouts.app')

@section('title', $pageTitle)

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-5xl">
        {{-- Header Section --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">RSS Feed Informasi Publik</h1>
            <p class="text-lg text-gray-600">Integrasikan update otomatis informasi PPID Kabupaten Sinjai ke website Anda.</p>
            <div class="mt-6">
                <code class="bg-white border border-blue-200 text-blue-600 px-4 py-2 rounded-lg shadow-sm font-mono text-sm break-all">
                    {{ $rssUrl }}
                </code>
                <a href="{{ $rssUrl }}" target="_blank" class="ml-2 inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                    <i class="fas fa-external-link-alt mr-1"></i> Buka Feed
                </a>
            </div>
        </div>

        {{-- Content Sections --}}
        <div class="space-y-12">
            
            {{-- A. Apa itu RSS --}}
            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-start">
                    <div class="bg-orange-100 p-3 rounded-xl mr-6">
                        <i class="fas fa-rss text-orange-600 text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Apa itu RSS Feed?</h2>
                        <div class="prose prose-blue text-gray-600 max-w-none">
                            <p>RSS (Really Simple Syndication) adalah teknologi yang memungkinkan Anda untuk berlangganan konten dari website secara otomatis. Tanpa harus mengunjungi website berulang kali, Anda akan mendapatkan notifikasi atau pembaruan setiap ada informasi baru yang dipublikasikan.</p>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 list-none p-0">
                                <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i> Update informasi real-time</li>
                                <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i> Hemat waktu pencarian data</li>
                                <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i> Sinkronisasi antar website otomatis</li>
                                <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i> Format standar XML universal</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            {{-- B. Cara menggunakan di WordPress --}}
            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fab fa-wordpress text-blue-500 mr-3"></i> Panduan WordPress
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-600">
                    <div>
                        <h3 class="font-bold text-gray-800 mb-2">Menggunakan Gutenberg Block</h3>
                        <ol class="list-decimal ml-5 space-y-2">
                            <li>Buka Editor Postingan/Halaman WordPress Anda.</li>
                            <li>Klik tombol <span class="bg-gray-100 px-1 rounded font-bold">+</span> dan cari block <strong>"RSS"</strong>.</li>
                            <li>Masukkan URL feed di atas ke kolom yang tersedia.</li>
                            <li>Klik "Gunakan URL" dan sesuaikan tampilan (jumlah item, tanggal, dll).</li>
                        </ol>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 mb-2">Menggunakan Sidebar Widget</h3>
                        <ol class="list-decimal ml-5 space-y-2">
                            <li>Buka menu <strong>Appearance > Widgets</strong> di Dashboard.</li>
                            <li>Tambahkan widget <strong>"RSS"</strong> ke area Sidebar atau Footer.</li>
                            <li>Tempelkan URL feed kami dan beri judul (misal: Update PPID).</li>
                            <li>Klik Simpan.</li>
                        </ol>
                    </div>
                </div>
            </section>

            {{-- C & D. Cara Integrasi Kode --}}
            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Integrasi Kode Website</h2>
                <div x-data="{ tab: 'html' }">
                    {{-- Tabs --}}
                    <div class="flex border-b border-gray-200 mb-6">
                        <button @click="tab = 'html'" :class="tab === 'html' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500'" class="py-2 px-4 border-b-2 font-medium">HTML/JS</button>
                        <button @click="tab = 'php'" :class="tab === 'php' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500'" class="py-2 px-4 border-b-2 font-medium">PHP</button>
                        <button @click="tab = 'laravel'" :class="tab === 'php' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500'" class="py-2 px-4 border-b-2 font-medium">Laravel/CI</button>
                    </div>

                    {{-- Tab Content --}}
                    <div class="bg-gray-900 rounded-xl p-6 text-sm overflow-x-auto font-mono text-gray-300">
                        <template x-if="tab === 'html'">
                            <pre><code>&lt;!-- HTML Container --&gt;
&lt;div id="ppid-feed"&gt;&lt;/div&gt;

&lt;!-- JavaScript Fetch --&gt;
&lt;script&gt;
fetch('{{ $rssUrl }}')
  .then(response => response.text())
  .then(str => new window.DOMParser().parseFromString(str, "text/xml"))
  .then(data => {
    const items = data.querySelectorAll("item");
    let html = "&lt;ul&gt;";
    items.forEach(el => {
      html += `&lt;li&gt;&lt;a href="${el.querySelector("link").innerHTML}"&gt;
               ${el.querySelector("title").innerHTML}&lt;/a&gt;&lt;/li&gt;`;
    });
    document.getElementById("ppid-feed").innerHTML = html + "&lt;/ul&gt;";
  });
&lt;/script&gt;</code></pre>
                        </template>
                        <template x-if="tab === 'php'">
                            <pre><code>&lt;?php
$rss = simplexml_load_file('{{ $rssUrl }}');
echo "&lt;ul&gt;";
foreach ($rss->channel->item as $item) {
    echo "&lt;li&gt;&lt;a href='{$item->link}'&gt;{$item->title}&lt;/a&gt;&lt;/li&gt;";
}
echo "&lt;/ul&gt;";
?&gt;</code></pre>
                        </template>
                        <template x-if="tab === 'laravel'">
                            <pre><code>// Di Controller
public function getFeed() {
    $xml = simplexml_load_file('{{ $rssUrl }}');
    return view('your-view', ['items' => $xml->channel->item]);
}

// Di Blade
@@foreach($items as $item)
    &lt;li&gt;&lt;a href="{!! $item->link !!}"&gt;{{ $item->title }}&lt;/a&gt;&lt;/li&gt;
@@endforeach</code></pre>
                        </template>
                    </div>
                </div>
            </section>

            {{-- E. Auto Update Info --}}
            <section class="bg-blue-600 rounded-2xl shadow-lg p-8 text-white">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-6 md:mb-0 md:mr-8 text-center md:text-left">
                        <h2 class="text-2xl font-bold mb-2">Informasi Selalu Terkini</h2>
                        <p class="opacity-90">RSS Feed ini mencakup seluruh Informasi Berkala, Setiap Saat, Serta Merta, hingga update Berita Terbaru secara otomatis tanpa perlu input manual ulang.</p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="bg-white text-blue-600 px-6 py-3 rounded-full font-bold shadow-md inline-block">
                            Auto Update System
                        </span>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection
