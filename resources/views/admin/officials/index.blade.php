@extends('admin.layouts.app')

@section('title', 'Daftar Profil Pimpinan')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div class="flex items-center gap-4 w-full md:w-auto order-2 md:order-1">
                <form id="search-form" action="{{ route('admin.officials.index') }}" method="GET" class="relative w-full md:w-80">
                    <input type="text" name="search" id="search-input" value="{{ request('search') }}" placeholder="Cari nama, jabatan, OPD..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </form>
            </div>
            
            <div class="flex items-center justify-between md:justify-end gap-4 w-full md:w-auto order-1 md:order-2">
                <a href="{{ route('admin.officials.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow-sm whitespace-nowrap transition-colors">
                    Tambah Profil
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">OPD</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($officials as $official)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($official->photo)
                                            <img src="{{ asset('storage/' . $official->photo) }}" alt="{{ $official->full_name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-user text-gray-600"></i>
                                            </div>
                                        @endif
                                        <div>{{ $official->full_name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 max-w-xs overflow-hidden text-ellipsis">
                                    @php
                                        $jabatan = $official->position->name ?? 'N/A';
                                        $status_jabatan = $official->status_jabatan;

                                        if ($status_jabatan !== 'Definitif' && $status_jabatan) {
                                            preg_match('/\((\w+)\)/', $status_jabatan, $matches);
                                            $prefix = $matches[1] ?? '';
                                            $jabatan = trim($prefix) . '. ' . $jabatan;
                                        }
                                    @endphp
                                    {{ $jabatan }}
                                </td>
                                <td class="px-6 py-4 max-w-xs overflow-hidden text-ellipsis">
                                    {{ $official->organization->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $official->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($official->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <a href="{{ route('admin.officials.edit', $official) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    <form action="{{ route('admin.officials.destroy', $official) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada profil pimpinan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4">
                {{ $officials->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const searchForm = document.getElementById('search-form');
        let timeout = null;

        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                searchForm.submit();
            }, 500); // 500ms delay
        });
        
        // Put cursor at the end of input
        const val = searchInput.value;
        searchInput.value = '';
        searchInput.value = val;
        searchInput.focus();
    });
</script>
@endpush