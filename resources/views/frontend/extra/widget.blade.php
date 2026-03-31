@extends('frontend.layouts.app')

@section('title', $pageTitle)

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-6xl">
        {{-- Header Section --}}
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Widget Informasi PPID</h1>
            <p class="text-lg text-gray-600">Tampilkan informasi publik PPID Kabupaten Sinjai langsung di website atau portal berita Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- Left Column: Explanation --}}
            <div class="lg:col-span-1 space-y-8">
                <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-plug text-blue-600 mr-2"></i> Apa itu Widget?
                    </h2>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Widget adalah komponen antarmuka kecil yang bisa Anda "tanam" di website lain. Dengan memasang widget kami, website Anda akan selalu menampilkan informasi publik terbaru dari Kabupaten Sinjai secara otomatis (Real-time).
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Meningkatkan SEO website Anda</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Konten update otomatis</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Pemasangan sangat mudah</li>
                    </ul>
                </section>

                <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fab fa-wordpress text-blue-500 mr-2"></i> Panduan WordPress
                    </h2>
                    <div class="text-sm text-gray-600 space-y-3">
                        <p>1. Di editor WordPress, pilih block <strong>"Custom HTML"</strong>.</p>
                        <p>2. Salin dan tempel kode iframe dari pratinjau di samping.</p>
                        <p>3. Jika menggunakan Elementor, gunakan widget <strong>"HTML"</strong>.</p>
                    </div>
                </section>
            </div>

            {{-- Right Column: Widget Previews --}}
            <div class="lg:col-span-2 space-y-12">
                
                {{-- 1. Widget Terbaru --}}
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-white font-bold">Preview: Widget Informasi Terbaru</h3>
                        <span class="bg-blue-500 text-xs text-white px-2 py-1 rounded">Live Preview</span>
                    </div>
                    <div class="p-6">
                        <iframe src="{{ route('extra.widgets.embed', ['type' => 'latest', 'limit' => 3]) }}" width="100%" height="350" class="border-0 rounded-xl mb-6 shadow-inner bg-gray-50"></iframe>
                        
                        <div class="space-y-4">
                            <label class="block text-sm font-bold text-gray-700">Kode Embed (Iframe):</label>
                            <div class="relative">
                                <pre class="bg-gray-900 text-gray-300 p-4 rounded-lg text-xs overflow-x-auto"><code>&lt;iframe src="{{ route('extra.widgets.embed', ['type' => 'latest', 'limit' => 5]) }}" width="100%" height="450" frameborder="0"&gt;&lt;/iframe&gt;</code></pre>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Widget Populer --}}
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="bg-purple-600 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-white font-bold">Preview: Widget Paling Dicari</h3>
                        <span class="bg-purple-500 text-xs text-white px-2 py-1 rounded">Popular</span>
                    </div>
                    <div class="p-6">
                        <iframe src="{{ route('extra.widgets.embed', ['type' => 'popular', 'limit' => 3]) }}" width="100%" height="350" class="border-0 rounded-xl mb-6 shadow-inner bg-gray-50"></iframe>
                        
                        <div class="space-y-4">
                            <label class="block text-sm font-bold text-gray-700">Kode Embed (Iframe):</label>
                            <div class="relative">
                                <pre class="bg-gray-900 text-gray-300 p-4 rounded-lg text-xs overflow-x-auto"><code>&lt;iframe src="{{ route('extra.widgets.embed', ['type' => 'popular', 'limit' => 5]) }}" width="100%" height="450" frameborder="0"&gt;&lt;/iframe&gt;</code></pre>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
