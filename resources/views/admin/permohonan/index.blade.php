@extends('admin.layouts.app')

@section('title', 'Kelola Permohonan Informasi')

@section('content')
    <!-- Success Notifications -->
    @if (session('success'))
        <div class="mb-8 animate-fade-in">
            <div class="bg-white border-l-4 border-green-500 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-lg font-bold text-gray-900">{{ session('success') }}</p>
                            @if(session('wa_url'))
                                <p class="text-gray-600 mt-1 text-sm">Silakan teruskan balasan ini ke WhatsApp pemohon untuk memberikan notifikasi langsung.</p>
                            @endif
                        </div>
                        @if(session('wa_url'))
                            <div class="ml-6">
                                <a href="{{ session('wa_url') }}" target="_blank"
                                    class="inline-flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-lg hover:shadow-green-200 transform hover:-translate-y-0.5 transition-all duration-300 text-sm">
                                    <i class="fab fa-whatsapp mr-2 text-xl"></i>
                                    Kirim ke WhatsApp
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-8 animate-fade-in">
            <div class="bg-white border-l-4 border-red-500 p-6 rounded-2xl shadow-xl overflow-hidden flex items-center">
                <div class="flex-shrink-0 h-12 w-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-exclamation-circle text-red-600 text-2xl"></i>
                </div>
                <p class="text-red-700 font-bold text-lg">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="mb-8" x-data="{ tab: 'pending' }">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Tracking Permohonan Informasi</h2>
        <div class="bg-white rounded-xl shadow p-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                    <button @click="tab = 'pending'" :class="{ 'border-blue-500 text-blue-600': tab === 'pending', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'pending' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Belum ditindak Lanjuti <span class="bg-yellow-100 text-yellow-800 text-xs font-medium ml-2 px-2.5 py-0.5 rounded-full">{{ $permohonanPending->count() }}</span>
                    </button>
                    <button @click="tab = 'diproses'" :class="{ 'border-blue-500 text-blue-600': tab === 'diproses', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'diproses' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Sedang Di Proses <span class="bg-blue-100 text-blue-800 text-xs font-medium ml-2 px-2.5 py-0.5 rounded-full">{{ $permohonanDiproses->count() }}</span>
                    </button>
                    <button @click="tab = 'selesai'" :class="{ 'border-blue-500 text-blue-600': tab === 'selesai', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'selesai' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Selesai <span class="bg-green-100 text-green-800 text-xs font-medium ml-2 px-2.5 py-0.5 rounded-full">{{ $permohonanSelesai->count() }}</span>
                    </button>
                    <button @click="tab = 'ditolak'" :class="{ 'border-blue-500 text-blue-600': tab === 'ditolak', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'ditolak' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Ditolak <span class="bg-red-100 text-red-800 text-xs font-medium ml-2 px-2.5 py-0.5 rounded-full">{{ $permohonanDitolak->count() }}</span>
                    </button>
                </nav>
            </div>

            <div class="py-6">
                <div x-show="tab === 'pending'" class="space-y-4">
                    @forelse($permohonanPending as $permohonan)
                        @include('admin.permohonan-informasi.partials.card', [
                            'permohonan' => $permohonan,
                            'actions' => 'pending'
                        ])
                    @empty
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-inbox text-4xl"></i>
                            </div>
                            <p class="text-gray-500 text-lg">Tidak ada permohonan yang belum ditindaklanjuti</p>
                            <p class="text-gray-400 text-sm mt-2">Semua permohonan telah diproses</p>
                        </div>
                    @endforelse
                </div>
                <div x-show="tab === 'diproses'" style="display: none;" class="space-y-4">
                    @forelse($permohonanDiproses as $permohonan)
                        @include('admin.permohonan-informasi.partials.card', [
                            'permohonan' => $permohonan,
                            'actions' => 'diproses'
                        ])
                    @empty
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-cogs text-4xl"></i>
                            </div>
                            <p class="text-gray-500 text-lg">Tidak ada permohonan yang sedang diproses</p>
                            <p class="text-gray-400 text-sm mt-2">Semua permohonan telah ditindaklanjuti</p>
                        </div>
                    @endforelse
                </div>
                <div x-show="tab === 'selesai'" style="display: none;" class="space-y-4">
                    <!-- Broadcast Peringatan Button -->
                    @if($permohonanSelesai->count() > 0)
                    <div class="mb-4 flex justify-end" x-data="{ showBroadcastModal: false }">
                        <button @click="showBroadcastModal = true" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow font-medium flex items-center transition-all">
                            <i class="fab fa-whatsapp text-lg mr-2"></i> Broadcast Peringatan Penipuan
                        </button>

                        <!-- Modal Broadcast WA -->
                        <div x-show="showBroadcastModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div x-show="showBroadcastModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showBroadcastModal = false" aria-hidden="true"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div x-show="showBroadcastModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                                    Kirim Pesan Peringatan (WhatsApp Web)
                                                </h3>
                                                <div class="mt-2 text-sm text-gray-500 mb-4">
                                                    Klik tombol <b>"Kirim"</b> pada setiap pemohon di bawah ini untuk membuka WhatsApp Web Anda. Sistem akan mengisi pesan peringatan penipuan secara otomatis.
                                                </div>
                                                
                                                <div class="max-h-60 overflow-y-auto border border-gray-200 rounded-lg">
                                                    <ul class="divide-y divide-gray-200">
                                                        @foreach($permohonanSelesai as $pSelesai)
                                                            @php
                                                                $phone = preg_replace('/[^0-9]/', '', $pSelesai->nomor_telepon_pemohon);
                                                                if(substr($phone, 0, 1) == '0') $phone = '62' . substr($phone, 1);
                                                                
                                                                $waText = "Halo Bapak/Ibu " . trim($pSelesai->nama_pemohon) . ",\n\nKami dari *PPID Kabupaten Sinjai*.\n\nSehubungan dengan Permohonan Informasi Anda yang telah Selesai, kami ingin mengimbau agar *TIDAK MENERIMA* telepon/pesan apapun yang mengatasnamakan PPID terkait tawaran Pinjaman Online (Pinjol), Judi Online, atau tindakan mencurigakan lainnya.\n\nPPID *TIDAK PERNAH* menghubungi pemohon untuk urusan di luar layanan informasi resmi.\nMohon abaikan & blokir nomor tersebut jika ada.\n\nTerima kasih,\n*PPID Kabupaten Sinjai*";
                                                                $waLink = "https://web.whatsapp.com/send?phone={$phone}&text=" . urlencode($waText);
                                                            @endphp
                                                            <li class="p-3 flex justify-between items-center hover:bg-gray-50 transition" x-data="{ sent: false }">
                                                                <div>
                                                                    <p class="text-sm font-semibold text-gray-800">{{ $pSelesai->nama_pemohon }}</p>
                                                                    <p class="text-xs text-gray-500 font-mono">{{ $pSelesai->nomor_telepon_pemohon }}</p>
                                                                </div>
                                                                <a href="{{ $waLink }}" target="_blank" @click="sent = true" :class="sent ? 'bg-gray-200 text-gray-600' : 'bg-green-500 text-white hover:bg-green-600'" class="px-4 py-1.5 rounded-full text-xs font-bold transition flex items-center">
                                                                    <i class="fab fa-whatsapp mr-1"></i> <span x-text="sent ? 'Terkirim ✓' : 'Kirim'"></span>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="button" @click="showBroadcastModal = false" class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @forelse($permohonanSelesai as $permohonan)
                        @include('admin.permohonan-informasi.partials.card', [
                            'permohonan' => $permohonan,
                            'actions' => 'selesai'
                        ])
                    @empty
                        <div class="text-center py-12">
                            <div class="text-green-400 mb-4">
                                <i class="fas fa-check-circle text-4xl"></i>
                            </div>
                            <p class="text-gray-500 text-lg">Tidak ada permohonan yang selesai</p>
                            <p class="text-gray-400 text-sm mt-2">Belum ada permohonan yang diselesaikan</p>
                        </div>
                    @endforelse
                </div>
                <div x-show="tab === 'ditolak'" style="display: none;" class="space-y-4">
                    @forelse($permohonanDitolak as $permohonan)
                        @include('admin.permohonan-informasi.partials.card', [
                            'permohonan' => $permohonan,
                            'actions' => 'ditolak'
                        ])
                    @empty
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-times-circle text-4xl"></i>
                            </div>
                            <p class="text-gray-500 text-lg">Tidak ada permohonan yang ditolak</p>
                            <p class="text-gray-400 text-sm mt-2">Semua permohonan telah diterima</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        function hideNotification(notificationId) {
            const element = document.getElementById(notificationId);
            if (element) {
                element.style.display = 'none';
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const successNotification = document.getElementById('successNotification');
                if (successNotification) {
                    successNotification.style.display = 'none';
                }
            }, 3000);
        });
    </script>
@endsection