@extends('admin.layouts.app')

@section('title', 'Detail Profil Pimpinan')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Detail Profil Pimpinan</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.officials.edit', $official) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('admin.officials.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Profile Photo -->
            <div class="md:w-1/3 flex justify-center">
                <div class="relative">
                    @if($official->photo)
                        <img src="{{ asset('storage/' . $official->photo) }}" 
                             alt="{{ $official->full_name }}" 
                             class="w-64 h-64 object-cover rounded-lg shadow-md mx-auto">
                    @else
                        <div class="w-64 h-64 bg-gray-200 rounded-lg shadow-md flex items-center justify-center mx-auto">
                            <i class="fas fa-user text-6xl text-gray-400"></i>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Profile Info -->
            <div class="md:w-2/3">
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-user text-blue-500 mr-3"></i>
                        <span class="font-medium text-gray-700">Nama:</span>
                        <span class="ml-2 text-gray-800 text-lg font-semibold">{{ $official->full_name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-id-card text-blue-500 mr-3"></i>
                        <span class="font-medium text-gray-700">Jabatan:</span>
                        <span class="ml-2 text-gray-600">{{ $official->position->name }}</span>
                    </div>
                    
                    @if($official->organization)
                        <div class="flex items-center">
                            <i class="fas fa-building text-blue-500 mr-3"></i>
                            <span class="font-medium text-gray-700">OPD:</span>
                            <span class="ml-2 text-gray-600">{{ $official->organization->name }}</span>
                        </div>
                    @endif
                    
                    @if($official->nip)
                        <div class="flex items-center">
                            <i class="fas fa-id-card text-blue-500 mr-3"></i>
                            <span class="font-medium text-gray-700">NIP:</span>
                            <span class="ml-2 text-gray-600">{{ $official->nip }}</span>
                        </div>
                    @endif
                    
                    @if($official->birth_place || $official->birth_date)
                        <div class="flex items-center">
                            <i class="fas fa-birthday-cake text-blue-500 mr-3"></i>
                            <span class="font-medium text-gray-700">Lahir:</span>
                            <span class="ml-2 text-gray-600">
                                @if($official->birth_place && $official->birth_date)
                                    {{ $official->birth_place }}, {{ $official->birth_date->format('d F Y') }}
                                @elseif($official->birth_place)
                                    {{ $official->birth_place }}
                                @elseif($official->birth_date)
                                    {{ $official->birth_date->format('d F Y') }}
                                @endif
                            </span>
                        </div>
                    @endif
                    
                    @if($official->start_term)
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-blue-500 mr-3"></i>
                            <span class="font-medium text-gray-700">Mulai Jabatan:</span>
                            <span class="ml-2 text-gray-600">{{ $official->start_term->format('d F Y') }}</span>
                        </div>
                    @endif
                    
                    @if($official->end_term)
                        <div class="flex items-center">
                            <i class="fas fa-calendar-times text-blue-500 mr-3"></i>
                            <span class="font-medium text-gray-700">Akhir Jabatan:</span>
                            <span class="ml-2 text-gray-600">{{ $official->end_term->format('d F Y') }}</span>
                        </div>
                    @endif
                    
                    <div class="flex items-center">
                        <i class="fas fa-circle text-blue-500 mr-3"></i>
                        <span class="font-medium text-gray-700">Status:</span>
                        <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $official->status === 'active' ? 'bg-green-100 text-green-800' : 
                               ($official->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 
                               'bg-red-100 text-red-800') }}">
                            {{ ucfirst($official->status) }}
                        </span>
                    </div>
                    
                    <div class="flex items-center">
                        <i class="fas fa-calendar text-blue-500 mr-3"></i>
                        <span class="font-medium text-gray-700">Dibuat:</span>
                        <span class="ml-2 text-gray-600">{{ $official->created_at->format('d F Y H:i') }}</span>
                    </div>
                    
                    @if($official->updated_at != $official->created_at)
                        <div class="flex items-center">
                            <i class="fas fa-sync-alt text-blue-500 mr-3"></i>
                            <span class="font-medium text-gray-700">Diperbarui:</span>
                            <span class="ml-2 text-gray-600">{{ $official->updated_at->format('d F Y H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Biography -->
        @if($official->biography)
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-book text-blue-500 mr-2"></i>
                    Biodata
                </h2>
                <div class="text-gray-600 leading-relaxed">
                    {!! nl2br(e($official->biography)) !!}
                </div>
            </div>
        @endif
        
        <!-- Education History -->
        @if($official->educations->count() > 0)
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-graduation-cap text-blue-500 mr-2"></i>
                    Pendidikan
                </h2>
                <div class="space-y-4">
                    @foreach($official->educations->sortBy('start_year') as $education)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-bold text-gray-800">{{ $education->degree }}</h3>
                            <p class="text-gray-600">{{ $education->institution }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                @if($education->start_year)
                                    {{ $education->start_year }}
                                    @if($education->end_year && $education->end_year != $education->start_year)
                                        - {{ $education->end_year }}
                                    @endif
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Career History -->
        @if($official->careerHistories->count() > 0)
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-briefcase text-blue-500 mr-2"></i>
                    Riwayat Karir
                </h2>
                <div class="space-y-4">
                    @foreach($official->careerHistories->sortByDesc('start_date') as $career)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-bold text-gray-800">{{ $career->title }}</h3>
                            <p class="text-gray-600">{{ $career->organization_name }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                @if($career->start_date)
                                    {{ $career->start_date->format('F Y') }}
                                    @if($career->end_date)
                                        - {{ $career->end_date->format('F Y') }}
                                    @else
                                        - Sekarang
                                    @endif
                                @endif
                            </p>
                            @if($career->description)
                                <p class="mt-2 text-gray-600">{{ $career->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Awards -->
        @if($official->awards->count() > 0)
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-trophy text-blue-500 mr-2"></i>
                    Penghargaan
                </h2>
                <div class="space-y-4">
                    @foreach($official->awards as $award)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-bold text-gray-800">{{ $award->title }}</h3>
                            <p class="text-gray-600">{{ $award->issuer }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                @if($award->date)
                                    {{ $award->date->format('d F Y') }}
                                @endif
                            </p>
                            @if($award->description)
                                <p class="mt-2 text-gray-600">{{ $award->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection