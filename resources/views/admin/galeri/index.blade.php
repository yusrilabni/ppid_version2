@extends('admin.layouts.app')

@section('title', 'Kelola Galeri')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Manajemen Galeri</h2>
                <p class="text-gray-600">Kelola gambar dan video galeri website</p>
            </div>
            <a href="{{ route('admin.galeri.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i> Tambah Galeri Baru
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

        @if(session('deleted'))
            <div id="deletedNotification" class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center">
                <i class="fas fa-trash-alt mr-2"></i>
                <span>{{ session('deleted') }}</span>
                <button onclick="hideNotification('deletedNotification')" class="ml-auto text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Media</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($galeris as $galeri)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $galeri->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($galeri->type === 'foto')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Foto
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Video
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500">{{ $galeri->category ?: '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($galeri->type === 'foto' && $galeri->image)
                                    <img src="{{ asset('storage/' . $galeri->image) }}" alt="{{ $galeri->title }}" class="h-16 w-auto rounded object-cover">
                                @elseif($galeri->type === 'video' && $galeri->video)
                                    @php
                                        // Extract YouTube video ID from URL
                                        $videoId = null;
                                        $url = parse_url($galeri->video);
                                        if (isset($url['host'])) {
                                            if (strpos($url['host'], 'youtube.com') !== false || strpos($url['host'], 'youtu.be') !== false) {
                                                if (isset($url['query'])) {
                                                    parse_str($url['query'], $params);
                                                    $videoId = $params['v'] ?? null;
                                                }
                                                if (!$videoId && isset($url['path'])) {
                                                    $pathParts = explode('/', $url['path']);
                                                    $videoId = end($pathParts);
                                                }
                                            }
                                        }
                                    @endphp
                                    @if($videoId)
                                        <img src="https://img.youtube.com/vi/{{ $videoId }}/default.jpg" alt="Video Thumbnail" class="h-16 w-auto rounded object-cover">
                                    @else
                                        <span class="text-sm text-blue-600">Tautan Video</span>
                                    @endif
                                @else
                                    <span class="text-sm text-gray-500">Tidak ada media</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex space-x-3 items-center">
                                    <form action="{{ route('admin.galeri.toggle-pin', $galeri) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="{{ $galeri->is_pinned ? 'text-orange-500' : 'text-gray-400' }} hover:text-orange-600 transition" title="{{ $galeri->is_pinned ? 'Lepaskan Pin' : 'Pin Foto' }}">
                                            <i class="fas fa-thumbtack {{ $galeri->is_pinned ? '' : 'transform -rotate-45' }}"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.galeri.edit', $galeri) }}" class="text-blue-600 hover:text-blue-900 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.galeri.destroy', $galeri) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition" onclick="return confirm('Apakah Anda yakin ingin menghapus galeri ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-photo-video text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 text-lg">Tidak ada galeri ditemukan</p>
                                    <p class="text-gray-400 mt-2">Mulai dengan membuat galeri baru</p>
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

        // Auto-hide notifications after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const successNotification = document.getElementById('successNotification');
                const deletedNotification = document.getElementById('deletedNotification');

                if (successNotification) {
                    successNotification.style.display = 'none';
                }
                if (deletedNotification) {
                    deletedNotification.style.display = 'none';
                }
            }, 3000);
        });
    </script>
@endsection