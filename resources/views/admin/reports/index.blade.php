@extends('admin.layouts.app')

@section('title', 'Rekap Laporan PPID')

@section('content')
    <div class="w-full">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md::items-center md:justify-between gap-4 p-6 border-b border-gray-200">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Rekap Laporan PPID</h1>
            </div>
        </div>

        <div class="p-6">
        <!-- Date Filter and Export Options -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Filter & Ekspor</h2>
            <form id="filterForm" action="{{ route('admin.reports.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 items-end">
                    <div>
                        <label for="startDate" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date" id="startDate" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-10">
                    </div>
                    <div>
                        <label for="endDate" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                        <input type="date" id="endDate" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-10">
                    </div>
                    <div>
                        <label for="unitId" class="block text-sm font-medium text-gray-700">Unit Kerja</label>
                        <select id="unitId" name="unit_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-10">
                            <option value="">Semua Unit</option>
                            @foreach($unitMap as $unitId => $unit)
                                <option value="{{ $unitId }}" {{ (string)$selectedUnitId === (string)$unitId ? 'selected' : '' }}>
                                    {{ $unit['unit_nama'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-filter mr-2"></i> Terapkan Filter
                        </button>
                        <button type="button" id="exportExcelButton" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-file-excel mr-2"></i> Ekspor Excel
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabbed Interface -->
        <div x-data="{ openTab: '{{ request()->query('tab', 'total') }}' }">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 px-6 py-4" aria-label="Tabs">
                    <a href="#" @click.prevent="openTab = 'total'" :class="{ 'border-blue-500 text-blue-600': openTab === 'total', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': openTab !== 'total' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Total Laporan
                    </a>
                    <a href="#" @click.prevent="openTab = 'informasi'" :class="{ 'border-blue-500 text-blue-600': openTab === 'informasi', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': openTab !== 'informasi' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Laporan Informasi
                    </a>
                    <a href="#" @click.prevent="openTab = 'permohonan'" :class="{ 'border-blue-500 text-blue-600': openTab === 'permohonan', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': openTab !== 'permohonan' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Laporan Permohonan
                    </a>
                    <a href="#" @click.prevent="openTab = 'survey'" :class="{ 'border-blue-500 text-blue-600': openTab === 'survey', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': openTab !== 'survey' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Laporan Survei
                    </a>
                    <a href="#" @click.prevent="openTab = 'visitors'" :class="{ 'border-blue-500 text-blue-600': openTab === 'visitors', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': openTab !== 'visitors' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Statistik Laporan
                    </a>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                {{-- Total Reports Tab Content --}}
                <div x-show="openTab === 'total'">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Laporan Total</h3>

                    {{-- Informasi Summary --}}
                    <div class="mb-8">
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Laporan Informasi (Terbaru)</h4>
                        @if($informasiReports->isEmpty())
                            <p class="text-gray-600">Tidak ada informasi terbaru dalam periode ini.</p>
                        @else
                            <div class="overflow-x-auto bg-white rounded-lg shadow">
                                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                    <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Judul</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kategori</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jenis Dokumen</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Unit</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/12">Tanggal Dibuat</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">URL Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($informasiReports->take(5) as $info) {{-- Show top 5 --}}
                                            <tr>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900 break-words min-w-0">{{ $info->title }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $info->category }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $info->jenis_dokumen }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $info->organization->name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $info->created_at->format('d M Y') }}</td>
                                                <td class="px-6 py-4 text-sm text-blue-600 hover:underline break-words min-w-0">
                                                    <a href="{{ route('frontend.informasi.detail', ['slug' => $info->slug]) }}" target="_blank">{{ route('frontend.informasi.detail', ['slug' => $info->slug]) }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2 text-right">
                                <a href="#" @click.prevent="openTab = 'informasi'" class="text-blue-600 hover:underline text-sm">Lihat Semua Informasi</a>
                            </div>
                        @endif
                    </div>

                    {{-- Permohonan Summary --}}
                    <div class="mb-8">
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Laporan Permohonan (Terbaru)</h4>
                        @if($permohonanReports->isEmpty())
                            <p class="text-gray-600">Tidak ada permohonan terbaru dalam periode ini.</p>
                        @else
                            <div class="overflow-x-auto bg-white rounded-lg shadow">
                                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                    <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/12">Kode Unik</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Subjek</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/12">Pemohon</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/12">Tanggal</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/12">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($permohonanReports->take(5) as $permohonan) {{-- Show top 5 --}}
                                            <tr>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900 break-words min-w-0">{{ $permohonan->unique_code }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500 break-words min-w-0">{{ $permohonan->subject }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    @if($permohonan->privacy_status === 'anonim')
                                                        Anonim
                                                    @elseif($permohonan->privacy_status === 'publik')
                                                        {{ $permohonan->user->name ?? 'N/A' }}
                                                    @else {{-- rahasia --}}
                                                        ****
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $permohonan->created_at->format('d M Y') }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $permohonan->status }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2 text-right">
                                <a href="#" @click.prevent="openTab = 'permohonan'" class="text-blue-600 hover:underline text-sm">Lihat Semua Permohonan</a>
                            </div>
                        @endif
                    </div>

                    {{-- Survey Summary --}}
                    <div class="mb-8">
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Laporan Survei (Terbaru)</h4>
                        @if($surveyReports->isEmpty())
                            <p class="text-gray-600">Tidak ada pengisian survei terbaru dalam periode ini.</p>
                        @else
                            <div class="overflow-x-auto bg-white rounded-lg shadow">
                                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                    <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/12">ID Respon</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Survei</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-3/12">Responden</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-3/12">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($surveyReports->take(5) as $surveyResponse) {{-- Show top 5 --}}
                                            <tr>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $surveyResponse->id }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500 break-words min-w-0">{{ $surveyResponse->survey->title ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    @if($surveyResponse->privacy_status === 'anonim')
                                                        Anonim
                                                    @elseif($surveyResponse->privacy_status === 'publik')
                                                        {{ $surveyResponse->responden_name ?? ($surveyResponse->user->name ?? 'N/A') }}
                                                    @else {{-- rahasia --}}
                                                        ****
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $surveyResponse->created_at->format('d M Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2 text-right">
                                <a href="#" @click.prevent="openTab = 'survey'" class="text-blue-600 hover:underline text-sm">Lihat Semua Survei</a>
                            </div>
                        @endif
                    </div>

                    {{-- Pengunjung Summary --}}
                    <div class="mb-8">
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Statistik Laporan</h4>
                        @if(empty($dashboardStatsForReports))
                            <p class="text-gray-600">Tidak ada data statistik dalam periode ini.</p>
                        @else
                            <div class="overflow-x-auto bg-white rounded-lg shadow">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/2">Nama Statistik</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/2">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Informasi</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalInformasiCount'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Permohonan Informasi</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalPermohonanCount'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Respon Survei</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalSurveyResponses'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Kunjungan</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalVisits'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Dilihat (Page Views)</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalPageViews'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Unduhan</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalDownloads'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Pengguna</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalUsers'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Organisasi</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalOrganizations'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Pejabat</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalOfficials'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Sliders</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalSliders'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Galeri</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalGaleri'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Sub Standar Layanan</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalSubStandarLayanan'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Laporan</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalLaporan'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Informasi Reports Tab Content --}}
                <div x-show="openTab === 'informasi'">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Laporan Informasi</h3>
                    @if($informasiReports->isEmpty())
                        <p class="text-gray-600 text-center py-4">Tidak ada laporan informasi dalam periode ini.</p>
                    @else
                        <div class="overflow-x-auto bg-white rounded-lg shadow">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Judul</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kategori</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jenis Dokumen</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Unit</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/12">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/12">Tanggal Dibuat</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/12">Jumlah Download</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">URL Detail</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($informasiReports as $informasi)
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 break-words min-w-0">{{ $informasi->title }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $informasi->category }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $informasi->jenis_dokumen }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $informasi->organization->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $informasi->status }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $informasi->created_at->format('d M Y') }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $informasi->download_count }}</td>
                                            <td class="px-6 py-4 text-sm text-blue-600 hover:underline break-words min-w-0">
                                                <a href="{{ route('frontend.informasi.detail', ['slug' => $informasi->slug]) }}" target="_blank">{{ route('frontend.informasi.detail', ['slug' => $informasi->slug]) }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $informasiReports->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>

                {{-- Permohonan Reports Tab Content --}}
                <div x-show="openTab === 'permohonan'">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Laporan Permohonan Informasi</h3>
                    @if($permohonanReports->isEmpty())
                        <p class="text-gray-600 text-center py-4">Tidak ada laporan permohonan informasi dalam periode ini.</p>
                    @else
                        <div class="overflow-x-auto bg-white rounded-lg shadow">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/12">Kode Unik</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Subjek Permohonan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/12">Pemohon</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/12">Tanggal Permohonan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/12">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($permohonanReports as $permohonan)
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 break-words min-w-0">{{ $permohonan->unique_code }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500 break-words min-w-0">{{ $permohonan->subject }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                    @if($permohonan->privacy_status === 'anonim')
                                                        Anonim
                                                    @elseif($permohonan->privacy_status === 'publik')
                                                        {{ $permohonan->user->name ?? 'N/A' }}
                                                    @else {{-- rahasia --}}
                                                        ****
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $permohonan->created_at->format('d M Y') }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $permohonan->status }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $permohonanReports->appends(request()->query())->links() }}
                            </div>
                        @endif
                    </div>

                    {{-- Survey Reports Tab Content --}}
                                    <div x-show="openTab === 'survey'">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Laporan Survei</h3>                        @if($surveyReports->isEmpty())
                            <p class="text-gray-600 text-center py-4">Tidak ada pengisian survei dalam periode ini.</p>
                        @else
                            <div class="overflow-x-auto bg-white rounded-lg shadow">
                                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                    <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/12">ID Respon</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Survei</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-3/12">Responden</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-3/12">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($surveyReports as $surveyResponse)
                                            <tr>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $surveyResponse->id }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500 break-words min-w-0">{{ $surveyResponse->survey->title ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    @if($surveyResponse->privacy_status === 'anonim')
                                                        Anonim
                                                    @elseif($surveyResponse->privacy_status === 'publik')
                                                        {{ $surveyResponse->responden_name ?? ($surveyResponse->user->name ?? 'N/A') }}
                                                    @else {{-- rahasia --}}
                                                        ****
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $surveyResponse->created_at->format('d M Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $surveyReports->appends(request()->query())->links() }}
                            </div>
                        @endif
                    </div>

                    {{-- Pengunjung Reports Tab Content --}}
                    <div x-show="openTab === 'visitors'">
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Statistik Laporan</h4>
                        @if(empty($dashboardStatsForReports))
                            <p class="text-gray-600">Tidak ada data statistik dalam periode ini.</p>
                        @else
                            <div class="overflow-x-auto bg-white rounded-lg shadow">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/2">Nama Statistik</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/2">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Informasi</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalInformasiCount'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Permohonan Informasi</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalPermohonanCount'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Respon Survei</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalSurveyResponses'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Kunjungan</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalVisits'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Dilihat (Page Views)</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalPageViews'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Unduhan</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalDownloads'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Pengguna</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalUsers'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Organisasi</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalOrganizations'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Pejabat</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalOfficials'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Sliders</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalSliders'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Galeri</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalGaleri'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Sub Standar Layanan</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalSubStandarLayanan'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Total Laporan</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dashboardStatsForReports['totalLaporan'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div> <!-- Closes the <div class="p-6"> that wraps the Tab Content (all x-show blocks) -->
        </div> <!-- Closes the <div x-data="{ openTab: 'total' }"> (Tabbed Interface) -->
        </div> <!-- Closes the <div class="p-6"> that wraps the filter and tabbed interface sections -->
    </div> <!-- Closes the <div class="bg-white rounded-xl shadow-lg overflow-hidden"> -->
</div> <!-- Closes the <div class="w-full"> -->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            const exportExcelButton = document.getElementById('exportExcelButton'); // Corrected ID

            exportExcelButton.addEventListener('click', function() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;
                let exportUrl = '';
                
                // Prioritize getting the active tab from the URL parameter
                const urlParams = new URLSearchParams(window.location.search);
                let activeTab = urlParams.get('tab');

                // Fallback to Alpine.js data if not found in URL
                if (!activeTab) {
                    const alpineDataElement = document.querySelector('[x-data]');
                    if (alpineDataElement && alpineDataElement.__x && alpineDataElement.__x.$data) {
                        activeTab = alpineDataElement.__x.$data.openTab;
                    } else {
                        console.warn('Alpine.js x-data element or its data not found, and no tab in URL. Defaulting to "total".');
                        activeTab = 'total'; // Default to 'total' if Alpine.js data is also unavailable
                    }
                }

                switch (activeTab) {
                    case 'total':
                        exportUrl = '{{ route('admin.reports.total.export') }}';
                        break;
                    case 'informasi':
                        exportUrl = '{{ route('admin.reports.informasi.export') }}';
                        break;
                    case 'permohonan':
                        exportUrl = '{{ route('admin.reports.permohonan.export') }}';
                        break;
                    case 'survey':
                        exportUrl = '{{ route('admin.reports.survey.export') }}';
                        break;
                    case 'visitors':
                        exportUrl = '{{ route('admin.reports.visitors.export') }}';
                        break;
                }

                if (exportUrl) {
                    window.location.href = `${exportUrl}?start_date=${startDate}&end_date=${endDate}`;
                } else {
                    console.error('No export URL determined for the active tab:', activeTab);
                }
            });

            // Update URL parameters when filter form is submitted
            document.getElementById('filterForm').addEventListener('submit', function(event) {
                // The form submission will handle updating URL parameters naturally
                // No need for client-side JS to modify URL on submit
            });

            // Set initial tab based on URL parameter, if any
            const urlParams = new URLSearchParams(window.location.search);
            const tabFromUrl = urlParams.get('tab');
            if (tabFromUrl) {
                // Wrap in setTimeout to ensure Alpine.js is fully initialized
                setTimeout(() => {
                    const alpineDataElement = document.querySelector('[x-data]');
                    if (alpineDataElement && alpineDataElement.__x && alpineDataElement.__x.$data) {
                        alpineDataElement.__x.$data.openTab = tabFromUrl;
                    } else {
                        console.warn('Alpine.js x-data element or its data not found on initial tab set.');
                    }
                }, 0); // 0ms delay
            }

            // Update URL with tab when tab changes
            document.querySelectorAll('nav[aria-label="Tabs"] a').forEach(tabLink => {
                tabLink.addEventListener('click', function() {
                    const newTab = this.getAttribute('@click.prevent').match(/'(.*?)'/)[1];
                    const currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.set('tab', newTab);
                    window.history.pushState({}, '', currentUrl.toString());
                });
            });
        });
    </script>
@endpush
