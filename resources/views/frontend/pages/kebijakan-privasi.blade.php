@extends('frontend.layouts.app')
@section('title', 'Kebijakan Privasi')

@push('styles')
<style>
    .privacy-section:hover .section-icon {
        transform: scale(1.1) rotate(5deg);
    }
    .section-icon {
        transition: all 0.3s ease-in-out;
    }
</style>
@endpush

@section('content')
@php
    $profilPpid = \App\Models\ProfilPpid::where('status', true)->first();
    $contactAddress = ($profilPpid ? $profilPpid->address : null) ?? config('ppid.contact_info.address') ?? 'Kabupaten Sinjai';
    $contactEmail = ($profilPpid ? $profilPpid->email : null) ?? config('ppid.contact_info.email') ?? 'ppid@sinjaikab.go.id';
    $contactPhone = ($profilPpid ? $profilPpid->phone : null) ?? config('ppid.contact_info.phone') ?? '-';
@endphp

<!-- Header / Hero Section -->
<div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-600 overflow-hidden">
    <!-- Decorative Shapes -->
    <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
        <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="absolute w-full h-full">
            <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
        </svg>
    </div>
    
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 rounded-full mb-6 backdrop-blur-sm border border-white/20 shadow-2xl">
            <i class="fas fa-user-shield text-4xl text-white"></i>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6 leading-tight tracking-tight">
            Kebijakan Privasi & <br class="hidden md:block"> Pemberitahuan Pelindungan Data
        </h1>
        <div class="inline-block bg-white/20 px-6 py-2 rounded-full backdrop-blur-md border border-white/30">
            <p class="text-white font-semibold text-lg flex items-center justify-center gap-2">
                <i class="fas fa-university text-yellow-300"></i> PPID Kabupaten Sinjai
            </p>
        </div>
        <p class="text-blue-100 mt-6 text-sm font-medium opacity-90">
            <i class="far fa-clock mr-1"></i> Diperbarui pada: 22 Juli 2026
        </p>
    </div>
    
    <!-- Wave Bottom -->
    <div class="absolute bottom-0 w-full leading-none">
        <svg class="block w-full h-12 md:h-20 text-gray-50" viewBox="0 0 1440 320" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,256L48,245.3C96,235,192,213,288,213.3C384,213,480,235,576,224C672,213,768,171,864,165.3C960,160,1056,192,1152,202.7C1248,213,1344,203,1392,197.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</div>

<div class="py-12 bg-gray-50 pb-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Intro Card -->
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 md:p-10 mb-10 transform -translate-y-12 relative z-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                <i class="fas fa-info-circle text-blue-600 text-3xl"></i> Pendahuluan
            </h2>
            <div class="text-gray-600 leading-relaxed text-lg space-y-4">
                <p>
                    Pemerintah Daerah Kabupaten Sinjai berkomitmen penuh untuk melindungi dan menghormati privasi data pribadi Anda selaku pengguna ("Anda" atau "Pengguna") seluruh layanan digital yang Kami kelola, baik berbasis situs web maupun aplikasi seluler. 
                </p>
                <p>
                    Kebijakan Privasi ini menjelaskan bagaimana Kami mengumpulkan, menggunakan, menyimpan, membagikan, dan melindungi Data Pribadi Anda saat Anda menggunakan Layanan Digital Kami. Dengan mengakses dan/atau menggunakan Layanan Digital Kami, Anda mengakui bahwa Anda telah membaca, memahami, dan menyetujui seluruh ketentuan yang tertuang di dalamnya.
                </p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Section 1 -->
            <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100 p-8 privacy-section">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 text-2xl section-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">1. Data yang Dikumpulkan</h2>
                </div>
                <p class="text-gray-600 mb-4 font-medium">Kami mengumpulkan data yang relevan dan diperlukan:</p>
                
                <h3 class="font-bold text-gray-800 mt-4 mb-3 flex items-center gap-2"><i class="fas fa-pen-nib text-blue-500"></i> Diberikan Langsung:</h3>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mt-1.5 mr-3"></i> <span><strong>Identitas:</strong> Nama Lengkap, NIK, TTL, Jenis Kelamin.</span></li>
                    <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mt-1.5 mr-3"></i> <span><strong>Kontak:</strong> Alamat email, Nomor telepon, Domisili.</span></li>
                    <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mt-1.5 mr-3"></i> <span><strong>Dokumen:</strong> Foto KTP, KK, swafoto (sesuai layanan).</span></li>
                    <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mt-1.5 mr-3"></i> <span><strong>Kredensial:</strong> Kata sandi/password yang dienkripsi.</span></li>
                </ul>

                <h3 class="font-bold text-gray-800 mt-6 mb-3 flex items-center gap-2"><i class="fas fa-robot text-blue-500"></i> Terkumpul Otomatis:</h3>
                <p class="text-gray-600 bg-gray-50 p-4 rounded-xl border border-gray-100">Alamat IP, jenis perangkat, sistem operasi, peramban (browser), waktu akses, dan log aktivitas sistem.</p>
            </div>

            <!-- Section 2 -->
            <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100 p-8 privacy-section">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 text-2xl section-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">2. Tujuan Pemrosesan</h2>
                </div>
                <p class="text-gray-600 mb-4 font-medium">Data Anda digunakan secara spesifik untuk:</p>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-center p-3 bg-gray-50 rounded-lg"><i class="fas fa-angle-right text-indigo-500 mr-3"></i> Pendaftaran dan autentikasi akun Pengguna.</li>
                    <li class="flex items-center p-3 bg-gray-50 rounded-lg"><i class="fas fa-angle-right text-indigo-500 mr-3"></i> Pemrosesan permohonan layanan publik.</li>
                    <li class="flex items-center p-3 bg-gray-50 rounded-lg"><i class="fas fa-angle-right text-indigo-500 mr-3"></i> Penyediaan notifikasi status layanan.</li>
                    <li class="flex items-center p-3 bg-gray-50 rounded-lg"><i class="fas fa-angle-right text-indigo-500 mr-3"></i> Penyelesaian kendala teknis/helpdesk.</li>
                    <li class="flex items-center p-3 bg-gray-50 rounded-lg"><i class="fas fa-angle-right text-indigo-500 mr-3"></i> Evaluasi kualitas dan keamanan Layanan.</li>
                    <li class="flex items-center p-3 bg-gray-50 rounded-lg"><i class="fas fa-angle-right text-indigo-500 mr-3"></i> Kepatuhan terhadap peraturan perundangan.</li>
                </ul>
            </div>

            <!-- Section 3 & 4 (Combined vertically) -->
            <div class="space-y-8">
                <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100 p-8 privacy-section">
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-600 text-2xl section-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">3. Dasar Hukum</h2>
                    </div>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start"><i class="far fa-check-square text-teal-500 mt-1 mr-3"></i> Persetujuan yang sah dan eksplisit dari Anda.</li>
                        <li class="flex items-start"><i class="far fa-check-square text-teal-500 mt-1 mr-3"></i> Pelaksanaan kewenangan sebagai instansi pemerintah.</li>
                        <li class="flex items-start"><i class="far fa-check-square text-teal-500 mt-1 mr-3"></i> Pemenuhan kewajiban hukum yang mengikat.</li>
                    </ul>
                </div>

                <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100 p-8 privacy-section">
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600 text-2xl section-icon">
                            <i class="fas fa-share-alt"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">4. Berbagi Data Pribadi</h2>
                    </div>
                    <p class="text-gray-600 mb-4">Data Anda <span class="font-bold text-red-500">TIDAK AKAN</span> dijual untuk tujuan komersial. Data hanya dibagikan kepada:</p>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start p-3 bg-orange-50/30 rounded-lg"><i class="fas fa-building text-orange-400 mt-1 mr-3"></i> <span>Instansi pemerintah lain untuk integrasi layanan (misal: Ditjen Dukcapil).</span></li>
                        <li class="flex items-start p-3 bg-orange-50/30 rounded-lg"><i class="fas fa-gavel text-orange-400 mt-1 mr-3"></i> <span>Aparat penegak hukum jika diwajibkan oleh peraturan perundang-undangan.</span></li>
                    </ul>
                </div>
            </div>

            <!-- Section 5 -->
            <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100 p-8 privacy-section">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-14 h-14 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 text-2xl section-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">5. Penyimpanan & Keamanan</h2>
                </div>
                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4 items-start p-4 bg-purple-50/40 rounded-2xl border border-purple-100">
                        <div class="bg-white p-3 rounded-full shadow-sm text-purple-500"><i class="fas fa-lock"></i></div>
                        <div>
                            <strong class="text-gray-900 block mb-1">Standar Keamanan Tinggi</strong> 
                            <span class="text-gray-600 text-sm">Penerapan enkripsi, pembatasan hak akses, dan pemantauan sistem untuk mencegah kebocoran data.</span>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 items-start p-4 bg-purple-50/40 rounded-2xl border border-purple-100">
                        <div class="bg-white p-3 rounded-full shadow-sm text-purple-500"><i class="fas fa-server"></i></div>
                        <div>
                            <strong class="text-gray-900 block mb-1">Lokasi Server Nasional</strong> 
                            <span class="text-gray-600 text-sm">Disimpan di Pusat Data Nasional (PDN) atau infrastruktur dalam wilayah Republik Indonesia.</span>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 items-start p-4 bg-purple-50/40 rounded-2xl border border-purple-100">
                        <div class="bg-white p-3 rounded-full shadow-sm text-purple-500"><i class="fas fa-history"></i></div>
                        <div>
                            <strong class="text-gray-900 block mb-1">Retensi Data</strong> 
                            <span class="text-gray-600 text-sm">Disimpan selama Anda aktif dan sesuai aturan retensi arsip elektronik sebelum dimusnahkan.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 6 -->
            <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100 p-8 privacy-section">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center text-green-600 text-2xl section-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">6. Hak-Hak Anda</h2>
                </div>
                <p class="text-gray-600 mb-4">Anda memiliki kendali penuh atas data Anda:</p>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-600">
                    <li class="bg-gray-50 p-3 rounded-xl border border-gray-100 flex gap-3"><i class="fas fa-info-circle text-green-500 mt-1"></i> Hak mendapat informasi penggunaan data.</li>
                    <li class="bg-gray-50 p-3 rounded-xl border border-gray-100 flex gap-3"><i class="fas fa-edit text-green-500 mt-1"></i> Hak mengakses dan memperbaiki data.</li>
                    <li class="bg-gray-50 p-3 rounded-xl border border-gray-100 flex gap-3"><i class="fas fa-trash-alt text-green-500 mt-1"></i> Hak menghapus/memusnahkan data.</li>
                    <li class="bg-gray-50 p-3 rounded-xl border border-gray-100 flex gap-3"><i class="fas fa-ban text-green-500 mt-1"></i> Hak menarik persetujuan pemrosesan.</li>
                </ul>
                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl text-sm flex items-start gap-3">
                    <i class="fas fa-exclamation-triangle mt-1 text-yellow-600"></i>
                    <span><strong>Catatan:</strong> Kami berhak memverifikasi identitas Anda terlebih dahulu sebelum memenuhi permintaan pelaksanaan hak-hak tersebut.</span>
                </div>
            </div>

            <!-- Section 7 & 8 (Combined vertically) -->
            <div class="space-y-8">
                <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100 p-8 privacy-section">
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                            <div class="w-14 h-14 rounded-2xl bg-yellow-50 flex items-center justify-center text-yellow-600 text-2xl section-icon">
                            <i class="fas fa-cookie-bite"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">7. Cookies (Tuki)</h2>
                    </div>
                    <p class="text-gray-600">
                        Kami menggunakan cookies untuk mengingat preferensi Anda dan menganalisis lalu lintas situs. Anda dapat mengatur peramban untuk menolak cookies, namun hal tersebut mungkin membatasi fitur tertentu.
                    </p>
                </div>

                <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100 p-8 privacy-section">
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                            <div class="w-14 h-14 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 text-2xl section-icon">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">8. Perubahan Kebijakan</h2>
                    </div>
                    <p class="text-gray-600">
                        Kami berhak meninjau dan mengubah Kebijakan Privasi ini agar tetap sejalan dengan regulasi atau teknologi terbaru. Setiap perubahan akan diberitahukan melalui situs web Kami.
                    </p>
                </div>
            </div>

        </div>

        <!-- Section 9 - Full Width Contact -->
        <div class="mt-8 bg-gray-900 rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-5 h-full">
                <div class="lg:col-span-2 bg-gradient-to-br from-blue-600 to-indigo-700 p-10 text-white flex flex-col justify-center">
                    <h2 class="text-3xl font-bold mb-4">9. Hubungi Kami</h2>
                    <p class="text-blue-100 text-lg opacity-90 mb-8">
                        Jika Anda memiliki pertanyaan, keluhan, atau ingin melaksanakan hak Anda terkait pelindungan Data Pribadi, silakan hubungi tim Helpdesk kami.
                    </p>
                    <div class="mt-auto">
                        <i class="fas fa-headset text-7xl opacity-20 transform translate-y-4 translate-x-4"></i>
                    </div>
                </div>
                <div class="lg:col-span-3 p-10 sm:p-12 text-gray-300 flex flex-col justify-center">
                    <ul class="space-y-6">
                        <li class="flex items-start group">
                            <div class="w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center mr-5 shrink-0 group-hover:bg-blue-600 transition-colors">
                                <i class="fas fa-building text-xl"></i>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-sm font-semibold uppercase tracking-wider mb-1">Pengelola Data</span>
                                <span class="text-white text-lg font-medium">PPID Kabupaten Sinjai / Dinas Komunikasi Informatika dan Persandian</span>
                            </div>
                        </li>
                        <li class="flex items-start group">
                            <div class="w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center mr-5 shrink-0 group-hover:bg-blue-600 transition-colors">
                                <i class="fas fa-map-marker-alt text-xl"></i>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-sm font-semibold uppercase tracking-wider mb-1">Alamat Kantor</span>
                                <span class="text-white font-medium">{{ $contactAddress }}</span>
                            </div>
                        </li>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                            <li class="flex items-start group">
                                <div class="w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center mr-4 shrink-0 group-hover:bg-blue-600 transition-colors">
                                    <i class="fas fa-envelope text-xl"></i>
                                </div>
                                <div>
                                    <span class="block text-gray-500 text-sm font-semibold uppercase tracking-wider mb-1">Email</span>
                                    <a href="mailto:{{ $contactEmail }}" class="text-white font-medium hover:text-blue-400 transition-colors">{{ $contactEmail }}</a>
                                </div>
                            </li>
                            <li class="flex items-start group">
                                <div class="w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center mr-4 shrink-0 group-hover:bg-blue-600 transition-colors">
                                    <i class="fas fa-phone-alt text-xl"></i>
                                </div>
                                <div>
                                    <span class="block text-gray-500 text-sm font-semibold uppercase tracking-wider mb-1">Telepon</span>
                                    <a href="tel:0482-21432" class="text-white font-medium hover:text-blue-400 transition-colors">0482-21432</a>
                                </div>
                            </li>
                        </div>
                        <li class="flex items-start group pt-2 border-t border-gray-800 mt-4">
                            <div class="w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center mr-5 shrink-0 group-hover:bg-green-500 transition-colors">
                                <i class="fab fa-whatsapp text-xl"></i>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-sm font-semibold uppercase tracking-wider mb-1">WhatsApp Helpdesk</span>
                                <a href="https://wa.me/6285156878911" target="_blank" class="text-white text-xl font-bold hover:text-green-400 transition-colors flex items-center gap-2">
                                    0851-5687-8911 <i class="fas fa-external-link-alt text-sm opacity-50"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
