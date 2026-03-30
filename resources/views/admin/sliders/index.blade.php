@extends('admin.layouts.app')

@section('title', 'Kelola Slider')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Manajemen Slider</h2>
                <p class="text-gray-600">Kelola gambar dan konten slider website</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.slider-settings.show') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                    <i class="fas fa-cog mr-2"></i> Pengaturan
                </a>
                <a href="{{ route('admin.sliders.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Slider Baru
                </a>
            </div>
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
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($sliders as $slider)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $slider->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="h-16 w-auto rounded object-cover">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($slider->active)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.sliders.edit', $slider) }}" class="text-blue-600 hover:text-blue-900 transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition" onclick="return confirm('Apakah Anda yakin ingin menghapus slider ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-images text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 text-lg">Tidak ada slider ditemukan</p>
                                    <p class="text-gray-400 mt-2">Mulai dengan membuat slider baru</p>
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
