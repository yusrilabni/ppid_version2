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