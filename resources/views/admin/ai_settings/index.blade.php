@extends('admin.layouts.app')

@section('title', 'Kelola Pengaturan AI')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Manajemen API Key AI</h2>
                <p class="text-gray-600">Kelola API key untuk integrasi AI (Gemini Flash, Pro, dll)</p>
            </div>
            <a href="{{ route('admin.ai-settings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i> Tambah API Key
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provider</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($settings as $setting)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $setting->provider }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500">{{ $setting->model }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($setting->is_active)
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
                                <div class="flex space-x-3 items-center">
                                    <a href="{{ route('admin.ai-settings.edit', $setting) }}" class="text-blue-600 hover:text-blue-900 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.ai-settings.destroy', $setting) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition" onclick="return confirm('Apakah Anda yakin ingin menghapus pengaturan ini?')" title="Hapus">
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
                                    <i class="fas fa-robot text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 text-lg">Tidak ada API Key AI ditemukan</p>
                                    <p class="text-gray-400 mt-2">Mulai dengan menambahkan API Key baru</p>
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
