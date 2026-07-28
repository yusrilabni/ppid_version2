@extends('admin.layouts.app')

@section('title', 'Kelola Informasi Pemkab')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Manajemen Informasi Pemkab</h2>
                <p class="text-gray-600">Kelola dokumen transparansi Pemerintah Kabupaten</p>
            </div>
            <a href="{{ route('admin.informasi-pemkab.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i> Tambah Dokumen
            </a>
        </div>

        <!-- Notifications -->
        @if(session('success'))
            <div id="successNotification" class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
                <button onclick="hideNotification('successNotification')" class="ml-auto text-green-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Dokumen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($informasi_pemkabs as $dokumen)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $dokumen->judul }}</div>
                                @if($dokumen->organization)
                                    <div class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-building mr-1"></i> {{ $dokumen->organization->name }}
                                    </div>
                                @endif
                                <div class="text-xs text-gray-400 mt-1">
                                    <i class="fas fa-network-wired mr-1"></i> IP: {{ $dokumen->ip_address ?? 'Tidak tercatat' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $dokumen->kategori }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $dokumen->jenis_dokumen }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $dokumen->tahun }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($dokumen->file_path)
                                    @if(str_starts_with($dokumen->file_path, 'http'))
                                        <a href="{{ $dokumen->file_path }}" target="_blank" class="text-blue-600 hover:text-blue-800 flex items-center">
                                            <i class="fas fa-external-link-alt mr-1"></i> Buka Link
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 flex items-center">
                                            <i class="fas fa-file-download mr-1"></i> Unduh
                                        </a>
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex space-x-3 items-center">
                                    <a href="{{ route('admin.informasi-pemkab.edit', $dokumen->id) }}" class="text-blue-600 hover:text-blue-900 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.informasi-pemkab.destroy', $dokumen->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition" onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-folder-open text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 text-lg">Belum ada dokumen Informasi Pemkab</p>
                                    <p class="text-gray-400 mt-2">Mulai dengan menambahkan dokumen baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
