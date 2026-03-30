@extends('admin.layouts.app')

@section('title', 'Manajemen Profil PPID')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Manajemen Profil PPID</h2>
                <p class="text-gray-600">Kelola informasi profil Pejabat Pengelola Informasi dan Dokumentasi.</p>
            </div>
            <a href="{{ route('admin.profil-ppid.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i> Tambah Profil PPID
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('deleted'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center">
                <i class="fas fa-trash-alt mr-2"></i>
                <span>{{ session('deleted') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visi PPID (Ringkas)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Struktur PPID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($profilPpids as $profilPpid)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ Str::limit($profilPpid->vision, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($profilPpid->structure_image)
                                    <img src="{{ asset('storage/' . $profilPpid->structure_image) }}" alt="Struktur PPID" class="w-16 h-16 object-cover rounded-md">
                                @else
                                    <span class="text-gray-400">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <p>{{ $profilPpid->phone }}</p>
                                <p>{{ $profilPpid->email }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($profilPpid->status)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.profil-ppid.edit', $profilPpid) }}" class="text-blue-600 hover:text-blue-900 transition">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.profil-ppid.destroy', $profilPpid) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-info-circle text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 text-lg">Belum ada Profil PPID.</p>
                                    <p class="text-gray-400 mt-2">Buat profil PPID baru untuk ditampilkan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
