@extends('admin.layouts.app')

@section('title', 'Manajemen LHKPN')

@section('content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Manajemen LHKPN</h1>
                <p class="text-gray-600">Kelola Laporan Harta Kekayaan Penyelenggara Negara</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <form action="{{ url()->current() }}" method="GET" class="relative w-full sm:w-64">
                    <input type="text" name="search" id="officialSearch" value="{{ request('search') }}" placeholder="Cari nama atau jabatan..." 
                        class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </form>

                <div class="flex items-center bg-white p-1 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center px-3 border-r border-gray-100">
                        <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Tahun Laporan</span>
                    </div>
                    <select id="year_filter" onchange="window.location.href='/admin/lhkpn/' + this.value" 
                        class="form-select border-none focus:ring-0 text-blue-600 font-extrabold bg-transparent py-2 pl-3 pr-8 cursor-pointer">
                        @foreach($stats['available_years'] as $year)
                            <option value="{{ $year }}" {{ $stats['selected_year'] == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                        @if(!in_array(date('Y'), $stats['available_years']->toArray()))
                            <option value="{{ date('Y') }}" {{ $stats['selected_year'] == date('Y') ? 'selected' : '' }}>{{ date('Y') }}</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Notifications -->
        @if(session('success'))
            <div id="successNotification" class="mb-4 bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                <span>{{ session('success') }}</span>
                <button onclick="hideNotification('successNotification')" class="ml-auto text-green-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-blue-500 bg-opacity-10">
                        <i class="fas fa-users w-6 h-6 text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Pimpinan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_officials'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-500 bg-opacity-10">
                        <i class="fas fa-file-invoice-dollar w-6 h-6 text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Laporan LHKPN</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_lhkpn'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-xl p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-yellow-500 bg-opacity-10">
                        <i class="fas fa-calendar-alt w-6 h-6 text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Laporan Tahun Terbaru</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['latest_report_year'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content: Card Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="officialGrid">
            @forelse($items as $item)
                <div class="official-card bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-1" 
                    data-name="{{ strtolower($item->display_title) }}" 
                    data-title="{{ strtolower($item->full_name) }}"
                    data-org="{{ strtolower($item->organization_name) }}">
                    <!-- Card Header -->
                    <div class="p-5 flex items-start space-x-4">
                        @php
                            $photoUrl = $item->photo ? asset('storage/' . $item->photo) : null;
                            $photoExists = $photoUrl && file_exists(public_path('storage/' . $item->photo));
                        @endphp
                        @if ($photoExists)
                            <img class="w-20 h-20 rounded-full object-cover border-4 border-gray-100" src="{{ $photoUrl }}" alt="{{ $item->full_name }}">
                        @else
                            <div class="w-20 h-20 rounded-full bg-gray-200 border-4 border-gray-100 flex items-center justify-center text-gray-500 text-3xl">
                                <i class="fas fa-{{ $item->type === 'unit' ? 'building' : 'user' }}"></i>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 text-lg leading-tight">{{ $item->display_title }}</h3>
                            <p class="text-xs text-gray-500 italic">{{ $item->organization_name }}</p>
                        </div>
                    </div>
                    
                    <!-- Status for Selected Year -->
                    <div class="px-5 py-3 bg-gray-50 border-y border-gray-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Status {{ $stats['selected_year'] }}</span>
                            @if($item->current_year_lhkpn)
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full">TERSEDIA</span>
                            @else
                                <span class="px-2 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-full">BELUM ADA</span>
                            @endif
                        </div>
                        
                        @if($item->current_year_lhkpn)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                    <span class="text-sm font-semibold text-gray-800">Rp{{ number_format($item->current_year_lhkpn->total_wealth, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ asset('storage/' . $item->current_year_lhkpn->file_path) }}" target="_blank" class="p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-colors">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.lhkpn.destroy', $item->current_year_lhkpn) }}" method="POST" onsubmit="return confirm('Hapus Laporan tahun {{ $stats['selected_year'] }} ini?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-colors">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <p class="text-xs text-gray-400 italic">Belum mengunggah laporan untuk tahun {{ $stats['selected_year'] }}</p>
                        @endif
                    </div>
                    
                    <!-- LHKPN History -->
                    <div class="px-5 py-4 flex-grow">
                        <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="w-full flex items-center justify-between text-sm font-semibold text-gray-700 hover:text-blue-600 transition-colors focus:outline-none">
                            <span>Riwayat Laporan</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="hidden mt-3 space-y-2">
                            @php $history = $item->lhkpns->where('report_year', '!=', $stats['selected_year']); @endphp
                            @forelse($history as $lhkpn)
                                <div class="flex justify-between items-center text-xs p-2 bg-gray-50 rounded-lg border border-gray-100">
                                    <div class="font-medium">
                                        Tahun {{ $lhkpn->report_year }} 
                                        <span class="text-gray-400">({{ $lhkpn->report_type }})</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ asset('storage/' . $lhkpn->file_path) }}" target="_blank" class="text-blue-500 hover:text-blue-700"><i class="fas fa-eye"></i></a>
                                        <form action="{{ route('admin.lhkpn.destroy', $lhkpn) }}" method="POST" onsubmit="return confirm('Hapus Laporan ini?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-[10px] text-gray-400 text-center py-2 italic">Tidak ada riwayat laporan lainnya.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="p-4 bg-gray-50 border-t mt-auto">
                        <a href="{{ route('admin.lhkpn.create', ['unit_id' => $item->unit_id, 'position_id' => $item->position_id]) }}" class="w-full block text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-sm transition-all duration-200">
                            <i class="fas fa-upload mr-2"></i> Unggah Laporan Baru
                        </a>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 lg:col-span-3 text-center py-12">
                    <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-700">Tidak ada data pimpinan</h3>
                    <p class="text-gray-500">Sistem tidak menemukan data pimpinan yang dapat ditampilkan.</p>
                </div>
            @endforelse
        </div>

        <div id="noResults" class="hidden text-center py-12 bg-white rounded-2xl shadow-sm border border-gray-200 mt-8">
            <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-700">Tidak ada hasil ditemukan</h3>
            <p class="text-gray-500">Coba kata kunci pencarian yang berbeda.</p>
        </div>

        <!-- Pagination -->
        @if(isset($items) && method_exists($items, 'links'))
            <div class="mt-10" id="paginationContainer">
                {{ $items->links() }}
            </div>
        @endif
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
                    hideNotification('successNotification');
                }
            }, 3000);

            // Real-time Search Logic with Server-side Fallback
            const searchInput = document.getElementById('officialSearch');
            const searchForm = searchInput.closest('form');
            const cards = document.querySelectorAll('.official-card');
            const grid = document.getElementById('officialGrid');
            const noResults = document.getElementById('noResults');
            const pagination = document.getElementById('paginationContainer');
            let searchTimeout;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.toLowerCase().trim();
                    let hasVisibleCards = false;

                    // Clear previous timeout
                    clearTimeout(searchTimeout);

                    // Instant client-side filtering
                    cards.forEach(card => {
                        const name = card.getAttribute('data-name');
                        const title = card.getAttribute('data-title');
                        const org = card.getAttribute('data-org');

                        if (name.includes(query) || title.includes(query) || org.includes(query)) {
                            card.style.display = '';
                            hasVisibleCards = true;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Handle display logic
                    if (query === '') {
                        noResults.classList.add('hidden');
                        if (pagination) pagination.classList.remove('hidden');
                        // If we had a search param in URL but cleared the box, reload to show all
                        if (new URLSearchParams(window.location.search).has('search')) {
                            searchTimeout = setTimeout(() => searchForm.submit(), 500);
                        }
                    } else {
                        if (pagination) pagination.classList.add('hidden');
                        if (hasVisibleCards) {
                            noResults.classList.add('hidden');
                        } else {
                            // If no results found on current page, wait a bit then search server-side
                            noResults.classList.remove('hidden');
                            searchTimeout = setTimeout(() => {
                                searchForm.submit();
                            }, 1000);
                        }
                    }
                });

                // Handle Enter key manually if needed, though form will handle it
                searchForm.addEventListener('submit', function() {
                    // Could show a loader here
                });
            }
        });
    </script>
@endsection
