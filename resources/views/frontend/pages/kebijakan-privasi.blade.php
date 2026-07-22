@extends('frontend.layouts.app')
@section('title', 'Kebijakan Privasi')

@section('content')
@php
    $profilPpid = \App\Models\ProfilPpid::where('status', true)->first();
    $contactAddress = ($profilPpid ? $profilPpid->address : null) ?? config('ppid.contact_info.address') ?? 'Kabupaten Sinjai';
    $contactEmail = ($profilPpid ? $profilPpid->email : null) ?? config('ppid.contact_info.email') ?? 'ppid@sinjaikab.go.id';
    $contactPhone = ($profilPpid ? $profilPpid->phone : null) ?? config('ppid.contact_info.phone') ?? '-';
@endphp
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
            <div class="p-8 sm:p-12 text-gray-800">
                
                <div class="text-center mb-10 pb-8 border-b border-gray-200">
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-4 leading-tight">
                        KEBIJAKAN PRIVASI / PEMBERITAHUAN PELINDUNGAN DATA PRIBADI<br>
                        LAYANAN DIGITAL PEMERINTAH KABUPATEN SINJAI
                    </h1>
                    <div class="inline-block bg-blue-50 px-4 py-2 rounded-full mt-4">
                        <p class="text-blue-700 font-semibold text-lg">PPID Kabupaten Sinjai</p>
                    </div>
                    <p class="text-gray-500 mt-4 text-sm font-medium">Diperbarui pada: 22 Juli 2026</p>
                </div>

                <div class="space-y-8 text-gray-700 leading-relaxed text-lg">
                    
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-4">Pendahuluan</h2>
                        <p>
                            Pemerintah Daerah Kabupaten Sinjai berkomitmen untuk melindungi dan menghormati privasi data pribadi Anda selaku pengguna ("Anda" atau "Pengguna") seluruh layanan digital yang Kami kelola, baik berbasis situs web maupun aplikasi seluler. Kebijakan Privasi ini menjelaskan bagaimana Kami mengumpulkan, menggunakan, menyimpan, membagikan, dan melindungi Data Pribadi Anda saat Anda menggunakan Layanan Digital Kami.
                        </p>
                        <p class="mt-4">
                            Dengan mengakses dan/atau menggunakan Layanan Digital Kami, Anda mengakui bahwa Anda telah membaca, memahami, dan menyetujui ketentuan dalam Kebijakan Privasi ini.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-4">1. Data Pribadi yang Kami Kumpulkan</h2>
                        <p class="mb-4">Kami hanya mengumpulkan data yang relevan dan diperlukan untuk penyelenggaraan layanan publik. Data yang dikumpulkan meliputi:</p>
                        
                        <h3 class="font-bold text-gray-800 mt-4 mb-2">Data yang Anda berikan secara langsung:</h3>
                        <ul class="list-disc pl-6 space-y-2 marker:text-blue-500">
                            <li>Identitas pribadi (Nama Lengkap, Nomor Induk Kependudukan (NIK), Tempat/Tanggal Lahir, Jenis Kelamin).</li>
                            <li>Informasi kontak (Alamat email, Nomor telepon, Alamat domisili).</li>
                            <li>Dokumen pendukung administrasi (seperti foto KTP, Kartu Keluarga, swafoto/liveness check) yang diunggah sesuai kebutuhan layanan spesifik.</li>
                            <li>Informasi kredensial login (Kata sandi/password yang dienkripsi).</li>
                        </ul>

                        <h3 class="font-bold text-gray-800 mt-6 mb-2">Data yang terkumpul secara otomatis:</h3>
                        <p>Alamat IP (Internet Protocol), jenis perangkat, sistem operasi, jenis peramban (browser), waktu akses, dan log aktivitas saat menggunakan layanan Kami untuk keperluan evaluasi dan keamanan sistem.</p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-4">2. Tujuan Pemrosesan Data Pribadi</h2>
                        <p class="mb-4">Kami memproses Data Pribadi Anda untuk tujuan berikut:</p>
                        <ul class="list-disc pl-6 space-y-2 marker:text-blue-500">
                            <li>Pendaftaran, verifikasi, dan autentikasi akun Pengguna.</li>
                            <li>Pemrosesan dan pemenuhan permohonan layanan administrasi atau layanan publik yang Anda ajukan.</li>
                            <li>Penyediaan informasi, notifikasi, atau pembaruan terkait status layanan yang Anda ajukan.</li>
                            <li>Penyelesaian kendala teknis atau pengaduan (helpdesk).</li>
                            <li>Analisis dan evaluasi untuk peningkatan kualitas dan keamanan Layanan Digital Kami.</li>
                            <li>Kepatuhan terhadap kewajiban hukum atau peraturan perundang-undangan yang berlaku.</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-4">3. Dasar Hukum Pemrosesan</h2>
                        <p class="mb-4">Kami memproses Data Pribadi Anda berdasarkan:</p>
                        <ul class="list-disc pl-6 space-y-2 marker:text-blue-500">
                            <li>Persetujuan yang sah dan eksplisit dari Anda.</li>
                            <li>Pelaksanaan kewenangan, tugas, dan fungsi Kami sebagai instansi pemerintah dalam penyelenggaraan pelayanan publik.</li>
                            <li>Pemenuhan kewajiban hukum yang mengikat Kami.</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-4">4. Pembagian dan Pengungkapan Data Pribadi</h2>
                        <p class="mb-4">Kami tidak akan menjual, menyewakan, atau menukar Data Pribadi Anda kepada pihak ketiga untuk tujuan komersial. Data Pribadi Anda hanya dapat dibagikan kepada:</p>
                        <ul class="list-disc pl-6 space-y-2 marker:text-blue-500">
                            <li>Instansi pemerintah lain (Kementerian/Lembaga/Daerah) dalam rangka integrasi layanan publik dan pengecekan silang data (misalnya: integrasi NIK dengan Ditjen Dukcapil).</li>
                            <li>Aparat penegak hukum, pengadilan, atau otoritas terkait lainnya apabila diwajibkan oleh hukum dan peraturan perundang-undangan.</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-4">5. Penyimpanan dan Keamanan Data Pribadi</h2>
                        <ul class="space-y-4">
                            <li class="bg-gray-50 p-4 rounded-lg border border-gray-100"><strong class="text-gray-900 block mb-1">Keamanan:</strong> Kami menerapkan standar keamanan teknis dan organisasi yang wajar, termasuk enkripsi, pembatasan hak akses, dan pemantauan sistem, untuk melindungi Data Pribadi Anda dari akses, perusakan, atau kebocoran yang tidak sah.</li>
                            <li class="bg-gray-50 p-4 rounded-lg border border-gray-100"><strong class="text-gray-900 block mb-1">Lokasi Penyimpanan:</strong> Data Anda disimpan di Pusat Data Nasional (PDN) atau infrastruktur peladen (server) yang berlokasi di wilayah hukum Republik Indonesia.</li>
                            <li class="bg-gray-50 p-4 rounded-lg border border-gray-100"><strong class="text-gray-900 block mb-1">Retensi:</strong> Data Pribadi akan disimpan selama Anda masih aktif menggunakan layanan, dan/atau sesuai dengan jangka waktu retensi arsip elektronik yang diatur dalam peraturan perundang-undangan, setelah itu data akan dihapus atau dimusnahkan.</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-4">6. Hak-Hak Subjek Data Pribadi</h2>
                        <p class="mb-4">Sesuai dengan Undang-Undang Pelindungan Data Pribadi, Anda memiliki hak atas Data Pribadi Anda, antara lain:</p>
                        <ul class="list-disc pl-6 space-y-2 marker:text-blue-500">
                            <li>Mendapatkan informasi mengenai kejelasan identitas, dasar kepentingan hukum, tujuan permintaan dan penggunaan Data Pribadi.</li>
                            <li>Mengakses, meminta salinan, dan/atau memperbaiki kesalahan/ketidakakuratan Data Pribadi Anda.</li>
                            <li>Mengakhiri pemrosesan, menghapus, atau memusnahkan Data Pribadi Anda (dengan catatan hal ini dapat memengaruhi kemampuan Kami untuk menyediakan layanan kepada Anda).</li>
                            <li>Menarik persetujuan pemrosesan Data Pribadi yang telah diberikan sebelumnya.</li>
                        </ul>
                        <div class="mt-4 p-4 bg-yellow-50 text-yellow-800 rounded-lg text-sm italic">
                            Catatan: Untuk menggunakan hak-hak di atas, Anda dapat menghubungi kami melalui detail kontak di bawah ini. Kami berhak melakukan verifikasi identitas Anda sebelum memenuhi permintaan tersebut.
                        </div>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-4">7. Penggunaan Tuki (Cookies)</h2>
                        <p>Layanan web Kami mungkin menggunakan cookies untuk mengingat preferensi Anda dan menganalisis arus lalu lintas situs untuk meningkatkan pengalaman pengguna. Anda dapat mengatur peramban Anda untuk menolak cookies, namun hal tersebut mungkin membatasi fungsionalitas fitur tertentu pada situs Kami.</p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-4">8. Perubahan Kebijakan Privasi</h2>
                        <p>Kami berhak untuk meninjau dan mengubah Kebijakan Privasi ini dari waktu ke waktu agar tetap sejalan dengan perkembangan regulasi, teknologi, atau proses bisnis. Setiap perubahan akan Kami beritahukan melalui situs web atau aplikasi Kami.</p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-4">9. Kontak Kami</h2>
                        <p class="mb-4">Jika Anda memiliki pertanyaan, keluhan, atau ingin melaksanakan hak Anda terkait pelindungan Data Pribadi, silakan hubungi kami melalui:</p>
                        
                        <div class="bg-gray-800 text-white rounded-xl p-6 shadow-inner">
                            <ul class="space-y-4">
                                <li class="flex items-start">
                                    <i class="fas fa-building mt-1.5 mr-4 text-blue-400 w-5 text-center"></i>
                                    <div>
                                        <span class="block text-gray-400 text-sm">Nama Unit/Pejabat Pengelola</span>
                                        <span class="font-semibold">PPID Kabupaten Sinjai / Dinas Komunikasi Informatika dan Persandian</span>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-map-marker-alt mt-1.5 mr-4 text-blue-400 w-5 text-center"></i>
                                    <div>
                                        <span class="block text-gray-400 text-sm">Alamat Kantor</span>
                                        <span class="font-semibold">{{ $contactAddress }}</span>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-envelope mt-1.5 mr-4 text-blue-400 w-5 text-center"></i>
                                    <div>
                                        <span class="block text-gray-400 text-sm">Email</span>
                                        <a href="mailto:{{ $contactEmail }}" class="font-semibold hover:text-blue-300 transition">{{ $contactEmail }}</a>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-phone-alt mt-1.5 mr-4 text-blue-400 w-5 text-center"></i>
                                    <div>
                                        <span class="block text-gray-400 text-sm">Nomor Telepon / WhatsApp Helpdesk</span>
                                        <a href="tel:{{ $contactPhone }}" class="font-semibold hover:text-blue-300 transition">{{ $contactPhone }}</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
