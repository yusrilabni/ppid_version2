{{-- Footer --}}
<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8"> {{-- Reverted to 4 columns --}}
            <div class="flex flex-col items-center text-center md:items-start md:text-left">
                <div class="-mt-8 mb-[-35px]">
                    <img src="{{ asset('storage/logo/favicon_io/android-chrome-512x512.png') }}" alt="Logo PPID"
                        class="h-[160px] w-auto">
                </div>
                <p class="text-gray-400 text-sm mb-4">
                    Pejabat Pengelola Informasi dan Dokumentasi
                </p>
                {{-- Social Media Icons --}}
                <div class="flex flex-wrap justify-center md:justify-start gap-3">
                    @if($socialMedia['instagram'])
                        <a href="{{ $socialMedia['instagram'] }}" target="_blank" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gradient-to-tr hover:from-[#f09433] hover:via-[#dc2743] hover:to-[#bc1888] transition-all duration-300" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                    @if($socialMedia['facebook'])
                        <a href="{{ $socialMedia['facebook'] }}" target="_blank" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#1877F2] transition-all duration-300" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                    @if($socialMedia['twitter'])
                        <a href="{{ $socialMedia['twitter'] }}" target="_blank" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#1DA1F2] transition-all duration-300" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                    @endif
                    @if($socialMedia['tiktok'])
                        <a href="{{ $socialMedia['tiktok'] }}" target="_blank" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-black transition-all duration-300" title="TikTok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    @endif
                    @if($socialMedia['youtube'])
                        <a href="{{ $socialMedia['youtube'] }}" target="_blank" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#FF0000] transition-all duration-300" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif
                    @if($socialMedia['website'])
                        <a href="{{ $socialMedia['website'] }}" target="_blank" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-blue-600 transition-all duration-300" title="Website Pemda">
                            <i class="fas fa-globe"></i>
                        </a>
                    @endif
                </div>
            </div>
            <div id="footer-nav-section">
                <h4 class="font-semibold mb-4">Navigasi</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    @foreach ($navLinks as $link)
                        <li><a href="{{ $link['url'] }}" class="hover:text-white">{{ $link['title'] }}</a></li>
                    @endforeach
                    <li class="pt-2 border-t border-gray-800"></li>
                    <li><a href="{{ route('extra.rss') }}" class="hover:text-white flex items-center"><i class="fas fa-rss text-orange-500 mr-2 text-[10px]"></i> RSS Feed</a></li>
                    <li><a href="{{ route('extra.widget') }}" class="hover:text-white flex items-center"><i class="fas fa-plug text-blue-500 mr-2 text-[10px]"></i> Widget Informasi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Kontak</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>Email: {{ $contactInfo['email'] }}</li>
                    <li>Telepon: {{ $contactInfo['phone'] }}</li>
                    <li>Alamat: {{ $contactInfo['address'] }}</li>
                </ul>
            </div>
            <div class="md:col-span-1 text-center"> {{-- Reverted to span 1 column --}}
                <h4 class="font-semibold mb-4">Pengaduan</h4>
                <a href="https://www.lapor.go.id/" target="_blank"
                    class="group px-[21px] py-5 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-lg flex flex-col items-center space-y-4 border border-gray-700 w-full hover:border-gray-500 transition duration-300 block">
                    {{-- Added group class and block --}}
                    <img src="{{ asset('storage/logo/lapor.png') }}" alt="Lapor.go.id"
                        class="h-16 w-auto group-hover:scale-105 transition duration-300"> {{-- Changed hover to group-hover --}}
                    <p class="text-sm font-semibold text-gray-200 leading-relaxed whitespace-nowrap uppercase italic">
                        <span class="text-yellow-400 font-bold">Sampaikan Laporan</span> & Aspirasi Anda
                    </p>
                </a>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
            <p>&copy; 2026 PPID Kabupaten Sinjai – Dikelola oleh Dinas Komunikasi, Informatika dan Persandian
                Kabupaten Sinjai.</p>
        </div>
    </div>
</footer>
