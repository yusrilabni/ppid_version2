@extends('admin.layouts.app')

@section('title', 'Struktur Organisasi')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Struktur Organisasi</h2>
                <p class="text-gray-600">Tampilkan hierarki organisasi secara visual</p>
            </div>
            <a href="{{ route('admin.organizations.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i> Buat Organisasi Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="space-y-8">
            @forelse($organizations as $organization)
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $organization->name }}</h3>
                        <a href="{{ route('admin.organizations.positions.index', $organization) }}" class="text-sm text-blue-600 hover:underline">
                            Kelola Detail & Jabatan &rarr;
                        </a>
                    </div>
                    
                    @if($organization->struktur && $organization->struktur->image_path)
                        <div class="text-center bg-gray-50 p-4 rounded-lg">
                            <img src="{{ asset('storage/' . $organization->struktur->image_path) }}" alt="Struktur Organisasi {{ $organization->name }}" class="max-w-full h-auto mx-auto rounded-lg border">
                        </div>
                    @else
                        <div class="relative pl-6 border-l-2 border-gray-200 space-y-4">
                            @forelse($organization->positions_tree as $position)
                                <div class="ml-4">
                                    <div class="flex items-center p-3 bg-blue-50 rounded-lg border border-blue-100">
                                        <i class="fas fa-user-tie text-blue-600 mr-3"></i>
                                        <div>
                                            <h4 class="font-medium text-gray-800">{{ $position->title }}</h4>
                                            <p class="text-sm text-gray-600">{{ $position->name ?? '' }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($position->children->count() > 0)
                                        <div class="relative pl-6 ml-4 border-l-2 border-gray-100 space-y-4 mt-4">
                                            @foreach($position->children as $childPosition)
                                                <div class="flex items-center p-3 bg-green-50 rounded-lg border border-green-100">
                                                    <i class="fas fa-user text-green-600 mr-3"></i>
                                                    <div>
                                                        <h5 class="font-medium text-gray-800">{{ $childPosition->title }}</h5>
                                                        <p class="text-sm text-gray-600">{{ $childPosition->name ?? '' }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">Tidak ada posisi yang didefinisikan untuk organisasi ini. Klik 'Kelola Detail & Jabatan' untuk menambahkan.</p>
                            @endforelse
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-12">
                    <i class="fas fa-sitemap text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Tidak ada organisasi ditemukan</p>
                    <p class="text-gray-400 mt-2">Buat organisasi pertama Anda untuk mulai mengatur struktur</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection