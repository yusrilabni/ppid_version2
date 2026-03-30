@extends('frontend.layouts.app')

@section('content')
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs Aligned with Content -->
            <div class="mb-4">
                <x-breadcrumbs :breadcrumbs="[
                    ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                    ['title' => 'Tentang OPD', 'url' => '#', 'icon' => 'fas fa-building']
                ]" />
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 text-gray-900">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Tentang OPD</h1>
                        <p class="text-gray-600">Temukan tentang OPD dari berbagai unit</p>
                    </div>

                    @if($organizations->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($organizations as $organization)
                                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-5">
                                        <h3 class="text-xl font-bold text-white text-center">{{ $organization->name }}</h3>
                                    </div>
                                    <div class="p-6">
                                        <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-blue-600">{{ $organization->total_positions ?? $organization->positions_tree->count() }}</div>
                                                <div class="text-xs text-gray-500">Jabatan</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-green-600">{{ $organization->total_members ?? 0 }}</div>
                                                <div class="text-xs text-gray-500">Anggota</div>
                                            </div>
                                        </div>

                                        <div class="flex justify-center">
                                            <a
                                                href="{{ route('organization.detail', $organization->id) }}"
                                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition text-center"
                                            >
                                                Lihat Tentang OPD
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-medium text-gray-900 mb-2">Belum Ada Organisasi</h3>
                            <p class="text-gray-500 max-w-md mx-auto">Belum ada organisasi yang terdaftar dalam sistem. Silakan kembali lagi nanti.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

