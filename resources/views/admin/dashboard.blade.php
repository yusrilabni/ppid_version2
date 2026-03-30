@extends('admin.layouts.app')

@section('title', 'Dasboard')

@section('content')
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}</h1>
        <p class="text-gray-600 mt-2">Berikut adalah ringkasan aktivitas terbaru di sistem PPID</p>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-8 gap-4 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-3 text-white transform transition hover:scale-105">
            <div class="flex items-center">
                <div class="p-1 rounded-lg bg-blue-400 bg-opacity-30">
                    <i class="fas fa-chart-line text-base"></i>
                </div>
                <div class="ml-2">
                    <p class="text-xs opacity-80">Pengunjung Baru</p>
                    <p class="text-lg font-bold">{{ $stats['activity']['latest_visitors'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-3 text-white transform transition hover:scale-105">
            <div class="flex items-center">
                <div class="p-1 rounded-lg bg-orange-400 bg-opacity-30">
                    <i class="fas fa-file-alt text-base"></i>
                </div>
                <div class="ml-2">
                    <p class="text-xs opacity-80">Jumlah Permohonan</p>
                    <p class="text-lg font-bold">{{ $stats['permohonan']['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-3 text-white transform transition hover:scale-105">
            <div class="flex items-center">
                <div class="p-1 rounded-lg bg-purple-400 bg-opacity-30">
                    <i class="fas fa-check-double text-base"></i>
                </div>
                <div class="ml-2">
                    <p class="text-xs opacity-80">Respon Survei</p>
                    <p class="text-lg font-bold">{{ $stats['survey_response']['total'] }}</p>
                </div>
            </div>
        </div>


        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-3 text-white transform transition hover:scale-105">
            <div class="flex items-center">
                <div class="p-1 rounded-lg bg-green-400 bg-opacity-30">
                    <i class="fas fa-images text-base"></i>
                </div>
                <div class="ml-2">
                    <p class="text-xs opacity-80">Sliders</p>
                    <p class="text-lg font-bold">{{ $stats['slider']['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-3 text-white transform transition hover:scale-105">
            <div class="flex items-center">
                <div class="p-1 rounded-lg bg-purple-400 bg-opacity-30">
                    <i class="fas fa-photo-video text-base"></i>
                </div>
                <div class="ml-2">
                    <p class="text-xs opacity-80">Galeri</p>
                    <p class="text-lg font-bold">{{ $stats['galeri']['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-3 text-white transform transition hover:scale-105">
            <div class="flex items-center">
                <div class="p-1 rounded-lg bg-yellow-400 bg-opacity-30">
                    <i class="fas fa-users text-base"></i>
                </div>
                <div class="ml-2">
                    <p class="text-xs opacity-80">Pengunjung</p>
                    <p class="text-lg font-bold">{{ $stats['activity']['visitors'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl shadow-lg p-3 text-white transform transition hover:scale-105">
            <div class="flex items-center">
                <div class="p-1 rounded-lg bg-red-400 bg-opacity-30">
                    <i class="fas fa-eye text-base"></i>
                </div>
                <div class="ml-2">
                    <p class="text-xs opacity-80">Dilihat</p>
                    <p class="text-lg font-bold">{{ $stats['activity']['views'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-3 text-white transform transition hover:scale-105">
            <div class="flex items-center">
                <div class="p-1 rounded-lg bg-indigo-400 bg-opacity-30">
                    <i class="fas fa-download text-base"></i>
                </div>
                <div class="ml-2">
                    <p class="text-xs opacity-80">Diunduh</p>
                    <p class="text-lg font-bold">{{ $stats['activity']['downloads'] }}</p>
                </div>
            </div>
        </div>
    </div>



    <!-- Charts and Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Chart -->
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Statistik Kunjungan</h3>
                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Tahun Ini</span>
            </div>
            <div class="h-64">
                <canvas id="visitChart"></canvas>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white p-5 rounded-xl shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terbaru</h3>
                <a href="#" class="text-blue-600 text-sm hover:underline">Lihat Semua</a>
            </div>

            <div class="space-y-3 max-h-80 overflow-y-auto">
                @forelse($allRecentActivity as $activity)
                    <div class="flex items-start pb-2 border-b border-gray-50 last:border-0">
                        <div class="mr-3 mt-1">
                            <div class="bg-gray-200 border-2 border-dashed rounded-full w-8 h-8 flex items-center justify-center">
                                <i class="fas {{ $activity->icon }} text-gray-500"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500">{{ $activity->type }}</p>
                            <h5 class="text-sm font-medium text-gray-800 truncate">{{ Str::limit($activity->title, 40) }}</h5>
                            <div class="flex items-center justify-between mt-1">
                                <p class="text-xs text-gray-400">{{ $activity->date->format('d M Y') }}</p>
                                <span @class([
                                    'inline-block px-1.5 py-0.5 text-xs rounded-full',
                                    'bg-green-100 text-green-800' => $activity->status_color === 'green',
                                    'bg-blue-100 text-blue-800' => $activity->status_color === 'blue',
                                    'bg-purple-100 text-purple-800' => $activity->status_color === 'purple',
                                    'bg-yellow-100 text-yellow-800' => $activity->status_color === 'yellow',
                                    'bg-gray-100 text-gray-800' => $activity->status_color === 'gray',
                                ])>
                                    {{ Str::limit($activity->status, 20) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 py-4 text-center">Tidak ada aktivitas terbaru.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Additional Statistics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Permohonan Informasi Cards --}}
        <div class="bg-white p-5 rounded-xl shadow mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Permohonan Informasi</h3>
                <a href="#" class="text-blue-600 text-sm hover:underline">Lihat Semua</a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div class="bg-purple-50 p-3 rounded-lg text-center">
                    <i class="fas fa-hourglass-half text-purple-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Pending</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['permohonan']['pending'] }}</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg text-center">
                    <i class="fas fa-sync-alt text-blue-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Diproses</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['permohonan']['diproses'] }}</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg text-center">
                    <i class="fas fa-check-circle text-green-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Selesai</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['permohonan']['selesai'] }}</p>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <h4 class="font-medium text-gray-700 mb-2">Total Permohonan: {{ $stats['permohonan']['total'] }}</h4>
            </div>
        </div>

        {{-- Users Cards --}}
        <div class="bg-white p-5 rounded-xl shadow mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Pengguna Sistem</h3>
                <a href="{{ route('admin.users.index') }}" class="text-blue-600 text-sm hover:underline">Lihat Semua</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="bg-gray-50 p-3 rounded-lg text-center">
                    <i class="fas fa-users text-gray-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Total</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['user']['total'] }}</p>
                </div>
                <div class="bg-red-50 p-3 rounded-lg text-center">
                    <i class="fas fa-user-shield text-red-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Superadmin</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['user']['superadmin'] }}</p>
                </div>
                <div class="bg-yellow-50 p-3 rounded-lg text-center">
                    <i class="fas fa-user-tie text-yellow-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Admin</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['user']['admin'] }}</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg text-center">
                    <i class="fas fa-user text-green-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Normal</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['user']['normal'] }}</p>
                </div>
            </div>
        </div>
        
        {{-- Officials Cards --}}
        <div class="bg-white p-5 rounded-xl shadow mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Pejabat (Kepala OPD)</h3>
                <a href="{{ route('admin.officials.index') }}" class="text-blue-600 text-sm hover:underline">Lihat Semua</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="bg-gray-50 p-3 rounded-lg text-center">
                    <i class="fas fa-user-tie text-gray-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Total</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['official']['total'] }}</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg text-center">
                    <i class="fas fa-check text-green-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Aktif</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['official']['active'] }}</p>
                </div>
                <div class="bg-red-50 p-3 rounded-lg text-center">
                    <i class="fas fa-times text-red-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Nonaktif</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['official']['inactive'] }}</p>
                </div>
                <div class="bg-yellow-50 p-3 rounded-lg text-center">
                    <i class="fas fa-pencil-alt text-yellow-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Draft</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['official']['draft'] }}</p>
                </div>
            </div>
        </div>
        
        {{-- Organizations, Profil PPID, Struktur Organisasi --}}
        <div class="bg-white p-5 rounded-xl shadow mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Struktur Organisasi & Profil</h3>
                <a href="{{ route('admin.organizations.index') }}" class="text-blue-600 text-sm hover:underline">Lihat Semua</a>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-blue-50 p-3 rounded-lg text-center">
                    <i class="fas fa-building text-blue-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">OPD</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['organization']['total'] }}</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg text-center">
                    <i class="fas fa-address-card text-green-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Profil PPID</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['profil_ppid']['total'] }}</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg text-center">
                    <i class="fas fa-sitemap text-purple-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Struktur Org.</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['struktur_organisasi']['total'] }}</p>
                </div>
            </div>
        </div>

        {{-- Surveys & Standar Layanan & Laporan --}}
        <div class="bg-white p-5 rounded-xl shadow mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Lainnya</h3>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="bg-orange-50 p-3 rounded-lg text-center">
                    <i class="fas fa-poll text-orange-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Survei</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['survey']['total'] }}</p>
                </div>
                <div class="bg-teal-50 p-3 rounded-lg text-center">
                    <i class="fas fa-clipboard-list text-teal-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">S. Layanan</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['sub_standar_layanan']['total'] }}</p>
                </div>
                <div class="bg-cyan-50 p-3 rounded-lg text-center">
                    <i class="fas fa-file-alt text-cyan-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Laporan</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['laporan']['total'] }}</p>
                </div>
                <div class="bg-fuchsia-50 p-3 rounded-lg text-center">
                    <i class="fas fa-check-double text-fuchsia-600 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Respon Survei</p>
                    <p class="text-lg font-bold text-gray-800">{{ $stats['survey_response']['total'] }}</p>
                </div>
            </div>
        </div>
    </div>


    <!-- Quick Actions -->
    <div class="bg-white p-6 rounded-xl shadow">

        <h3 class="text-lg font-semibold text-gray-800 mb-4">Akses Cepat</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('admin.permohonan-informasi.index') }}" class="flex flex-col items-center justify-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                <i class="fas fa-file-signature text-2xl text-blue-600 mb-2"></i>
                <span class="text-sm text-gray-700">Permohonan Informasi</span>
            </a>
            <a href="{{ route('informasi-crud.index') }}" class="flex flex-col items-center justify-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition">
                <i class="fas fa-info-circle text-2xl text-green-600 mb-2"></i>
                <span class="text-sm text-gray-700">Informasi</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center justify-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition">
                <i class="fas fa-users text-2xl text-yellow-600 mb-2"></i>
                <span class="text-sm text-gray-700">Users</span>
            </a>
            <a href="{{ route('admin.sliders.index') }}" class="flex flex-col items-center justify-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition">
                <i class="fas fa-images text-2xl text-purple-600 mb-2"></i>
                <span class="text-sm text-gray-700">Sliders</span>
            </a>
        </div>
    </div>

    <!-- Chart Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('visitChart').getContext('2d');

            // Real data from controller
            const data = {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [
                    {
                        label: 'Pengunjung',
                        data: {!! json_encode($chartData) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }
                ]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

            const visitChart = new Chart(ctx, config);
        });
    </script>
@endsection