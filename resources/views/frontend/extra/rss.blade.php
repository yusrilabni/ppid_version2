@extends('frontend.layouts.app')

@section('title', $pageTitle)

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-6xl">
        {{-- Header Section --}}
        <div class="text-center mb-12">
            <div class="inline-block p-3 bg-orange-100 rounded-2xl mb-4">
                <i class="fas fa-rss text-orange-600 text-3xl"></i>
            </div>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">RSS Feed Informasi Publik</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Sinkronisasikan seluruh informasi publik Kabupaten Sinjai ke platform Anda secara otomatis menggunakan teknologi RSS standar industri.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- A. Apa itu RSS --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <i class="fas fa-rss text-8xl text-orange-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-orange-500 rounded-full mr-3"></span>
                        Apa itu RSS Feed?
                    </h2>
                    <div class="prose prose-blue text-gray-600 max-w-none space-y-4">
                        <p>RSS (Really Simple Syndication) adalah format data standar XML yang digunakan untuk mengirimkan informasi yang sering diperbarui. Dengan RSS, website lain atau aplikasi pembaca berita (RSS Reader) dapat mengambil data terbaru kami tanpa perlu melakukan pemantauan manual.</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                            <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100">
                                <h4 class="font-bold text-blue-800 mb-1">Manfaat Website</h4>
                                <p class="text-xs">Meningkatkan otoritas konten dan mempermudah sindikasi data ke portal berita nasional.</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-2xl border border-green-100">
                                <h4 class="font-bold text-green-800 mb-1">Manfaat Pengguna</h4>
                                <p class="text-xs">Mendapatkan update langsung tanpa harus membuka browser dan mencari satu per satu.</p>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- B. Filter Per OPD (Fitur Baru) --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span>
                        Filter Berdasarkan OPD
                    </h2>
                    <p class="text-gray-600 mb-6 text-sm">Anda dapat mengambil informasi khusus dari OPD tertentu saja (misal: RSUD atau Perikanan). Cukup tambahkan parameter <code>?unit_id=ID_OPD</code> pada URL RSS kami.</p>
                    
                    <div class="bg-gray-900 rounded-2xl p-6 mb-6">
                        <p class="text-xs text-gray-400 mb-2 uppercase tracking-widest font-bold">Contoh URL RSS RSUD Sinjai:</p>
                        <code class="text-blue-400 break-all text-sm font-mono">
                            {{ route('extra.rss.generate') }}?unit_id=34
                        </code>
                    </div>

                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="text-blue-600 hover:text-blue-800 font-bold text-sm flex items-center">
                            <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-list-ul'"></i> 
                            <span class="ml-2" x-text="open ? 'Sembunyikan Daftar ID OPD' : 'Lihat Daftar ID OPD Semua Instansi'"></span>
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

                {{-- C. Integrasi Kode --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-purple-500 rounded-full mr-3"></span>
                        Integrasi Kode Program
                    </h2>
                    <div x-data="{ tab: 'html' }">
                        <div class="flex space-x-2 mb-6 bg-gray-100 p-1 rounded-xl w-fit">
                            <button @click="tab = 'html'" :class="tab === 'html' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-2 px-4 rounded-lg text-xs font-bold transition-all">HTML/JS</button>
                            <button @click="tab = 'php'" :class="tab === 'php' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-2 px-4 rounded-lg text-xs font-bold transition-all">PHP Native</button>
                            <button @click="tab = 'laravel'" :class="tab === 'laravel' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="py-2 px-4 rounded-lg text-xs font-bold transition-all">Laravel Blade</button>
                        </div>

                        <div class="bg-gray-900 rounded-2xl p-6 font-mono text-sm leading-relaxed overflow-x-auto">
                            <template x-if="tab === 'html'">
                                <pre class="text-green-400"><code>&lt;script&gt;
// Fetch data dari RSS kami
fetch('{{ route('extra.rss.generate') }}')
  .then(res => res.text())
  .then(xml => {
    let data = new DOMParser().parseFromString(xml, "text/xml");
    console.log(data.querySelectorAll("item"));
  });
&lt;/script&gt;</code></pre>
                            </template>
                            <template x-if="tab === 'php'">
                                <pre class="text-blue-300"><code>&lt;?php
$xml = simplexml_load_file('{{ route('extra.rss.generate') }}');
foreach ($xml->channel->item as $info) {
    echo $info->title . "&lt;br&gt;";
}
?&gt;</code></pre>
                            </template>
                            <template x-if="tab === 'laravel'">
                                <pre class="text-orange-300"><code>@verbatim// Di Controller
public function getPpidFeed() {
    $rss = simplexml_load_file('URL_RSS_KAMI');
    return view('page', ['items' => $rss->channel->item]);
}

// Di Blade
@foreach($items as $item)
    <li>{{ $item->title }}</li>
@endforeach @endverbatim</code></pre>
                            </template>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                {{-- WordPress Guide --}}
                <section class="bg-blue-600 rounded-3xl shadow-lg p-8 text-white relative overflow-hidden">
                    <i class="fab fa-wordpress absolute -bottom-4 -right-4 text-8xl opacity-20"></i>
                    <h3 class="text-xl font-bold mb-4">Langkah Detail WordPress</h3>
                    <div class="space-y-6 text-sm">
                        <div class="flex items-start">
                            <span class="bg-white text-blue-600 w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0 font-black">1</span>
                            <p>Gunakan block <strong>"RSS"</strong> di Gutenberg Editor.</p>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-white text-blue-600 w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0 font-black">2</span>
                            <p>Tempel URL Feed kami dan klik <strong>Gunakan URL</strong>.</p>
                        </div>
                        <div class="flex items-start bg-blue-700/50 p-4 rounded-2xl border border-blue-400/30">
                            <div>
                                <p class="font-bold mb-2 underline decoration-yellow-400 underline-offset-4 text-xs uppercase tracking-widest">Pengaturan Wajib:</p>
                                <ul class="space-y-2 text-[11px] opacity-90 italic">
                                    <li>- Ceklis "Tampilkan Ringkasan"</li>
                                    <li>- Ceklis "Tampilkan Penulis"</li>
                                    <li>- Ceklis "Tampilkan Tanggal"</li>
                                    <li>- Set Maksimum Item ke 10</li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-white text-blue-600 w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0 font-black">3</span>
                            <p>Simpan dan Widget akan terupdate otomatis selamanya.</p>
                        </div>
                    </div>
                </section>

                {{-- FAQ Section --}}
                <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Tanya Jawab</h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-bold text-gray-700 mb-1">Seberapa sering update?</h4>
                            <p class="text-xs text-gray-500">Real-time. Begitu admin mengupload informasi, RSS Feed akan otomatis memperbarui datanya.</p>
                        </div>
                        <hr class="border-gray-100">
                        <div>
                            <h4 class="text-sm font-bold text-gray-700 mb-1">Apakah berbayar?</h4>
                            <p class="text-xs text-gray-500">Gratis. Layanan RSS ini disediakan untuk mendukung keterbukaan informasi publik.</p>
                        </div>
                    </div>
                </section>

                {{-- Social Sync --}}
                <section class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-3xl p-8 text-white">
                    <h3 class="text-lg font-bold mb-2">Sinkronisasi Sosial</h3>
                    <p class="text-xs opacity-70 mb-4">Anda bisa menggunakan layanan seperti IFTTT atau Zapier untuk memposting otomatis update kami ke Facebook atau Twitter Anda via RSS.</p>
                    <div class="flex space-x-2">
                        <i class="fab fa-facebook-square text-xl"></i>
                        <i class="fab fa-twitter-square text-xl"></i>
                        <i class="fab fa-telegram text-xl"></i>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
