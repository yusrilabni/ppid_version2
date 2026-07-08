@extends('frontend.layouts.app')

@section('title', 'Terima Kasih!')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-green-50 p-4 sm:p-6 lg:p-8">
        <div class="max-w-lg w-full mx-auto">
            <!-- Kartu Utama -->
            <div
                class="bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:shadow-3xl">
                <!-- Header dengan gradien -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 text-center">
                    <div class="relative w-24 h-24 mx-auto mb-4">
                        <!-- Lingkaran animasi -->
                        <div class="absolute inset-0 bg-green-400 rounded-full animate-ping opacity-20"></div>
                        <!-- Ikon dengan animasi -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i
                                class="fas fa-check-circle text-white text-5xl transform transition-all duration-500 animate-scale"></i>
                        </div>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2 animate-fade-in-down">Terima Kasih!</h1>
                    <p class="text-green-100 text-lg font-medium">Partisipasi Anda sangat berharga</p>
                </div>

                <!-- Konten -->
                <div class="p-8 text-center">
                    <!-- Pesan konfirmasi -->
                    <div class="mb-8">
                        @if(session('message'))
                            <div class="bg-blue-50 rounded-2xl p-5 mb-6 border border-blue-100 text-blue-800 flex items-center justify-center">
                                <p class="font-bold text-base"><i class="fas fa-info-circle text-lg mr-2 text-blue-500"></i>{{ session('message') }}</p>
                            </div>
                        @endif
                        <p class="text-gray-700 text-lg mb-4 leading-relaxed">
                            <i class="fas fa-clipboard-check text-green-500 mr-2"></i>
                            Jawaban Anda telah berhasil kami rekam dan akan kami proses dengan seksama.
                        </p>
                        <p class="text-gray-600 mb-6">
                            Kontribusi Anda membantu kami dalam meningkatkan kualitas layanan dan penelitian kami.
                        </p>

                        <!-- Info tambahan -->
                        <div class="bg-blue-50 rounded-xl p-4 mb-8 border border-blue-100">
                            <div class="flex items-center justify-center text-blue-700">
                                <i class="fas fa-lock text-xl mr-3"></i>
                                <p class="font-medium">Data Anda aman dan rahasia</p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik atau elemen visual -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                            <i class="fas fa-check text-blue-500 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="text-lg font-bold text-gray-800">Selesai</p>
                        </div>
                        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                            <i class="fas fa-shield-alt text-green-500 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Keamanan</p>
                            <p class="text-lg font-bold text-gray-800">Terjamin</p>
                        </div>
                    </div>

                    <!-- Tombol aksi -->
                    <div class="space-y-4">
                        <a href="{{ route('home') }}"
                            class="w-full inline-flex items-center justify-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <i class="fas fa-home mr-3"></i>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan animasi CSS -->
    <style>
        @keyframes scale {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-scale {
            animation: scale 1s ease-in-out;
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.8s ease-out;
        }

        .shadow-3xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bersihkan semua data kuesioner dari localStorage setelah sukses terkirim
            for (let i = localStorage.length - 1; i >= 0; i--) {
                const key = localStorage.key(i);
                if (key && key.startsWith('survey_')) {
                    localStorage.removeItem(key);
                }
            }
        });
    </script>
@endpush
