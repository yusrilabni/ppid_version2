@extends('frontend.layouts.app')

@php
    $jabatan_asli = $official->position->name;
    $jabatan_tampilan = $jabatan_asli;
    $status_jabatan = $official->status_jabatan;

    // Apply organization-specific logic first
    if (strtolower($jabatan_asli) === 'kepala opd' && $official->organization) {
        $orgName = $official->organization->name;
        $orgNameLower = strtolower($orgName);

        if (str_contains($orgNameLower, 'dinas')) {
            $jabatan_tampilan = 'Kepala ' . $orgName;
        } elseif (str_contains($orgNameLower, 'kecamatan')) {
            $nama_kecamatan = str_ireplace('Kantor Kecamatan ', '', $orgName);
            $jabatan_tampilan = 'Camat ' . $nama_kecamatan;
        } elseif (str_contains($orgNameLower, 'badan')) {
            $jabatan_tampilan = 'Kepala ' . $orgName;
        }
    }

    // Then, apply status_jabatan prefix if not 'Definitif'
    if ($status_jabatan !== 'Definitif' && !empty($status_jabatan)) {
        preg_match('/\((\w+)\)/', $status_jabatan, $matches);
        $prefix = $matches[1] ?? '';
        if (!empty($prefix)) {
            $jabatan_tampilan = trim($prefix) . '. ' . $jabatan_tampilan;
        }
    }

    // Final variable to be used in the view
    $jabatan = $jabatan_tampilan;
@endphp

@section('title', 'Profil ' . $jabatan . ' - ' . $official->full_name)

@section('meta')
    <meta property="og:title" content="Profil {{ $jabatan }} - {{ $official->full_name }}">
    <meta property="og:description" content="Profil resmi {{ $official->full_name }} sebagai {{ $jabatan }} Kabupaten Sinjai.">
    <meta property="og:image" content="{{ $official->photo ? asset('storage/' . $official->photo) : asset('storage/logo/Lambang_Kabupaten_Sinjai_OG.jpg') }}">
    <meta name="twitter:title" content="Profil {{ $jabatan }} - {{ $official->full_name }}">
    <meta name="twitter:description" content="Profil resmi {{ $official->full_name }} sebagai {{ $jabatan }} Kabupaten Sinjai.">
    <meta name="twitter:image" content="{{ $official->photo ? asset('storage/' . $official->photo) : asset('storage/logo/Lambang_Kabupaten_Sinjai_OG.jpg') }}">
@endsection

@section('content')
    <div class="py-8 bg-gradient-to-b from-gray-50 to-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs Aligned with Content -->
            <div class="mb-4">
                <x-breadcrumbs :breadcrumbs="[
                    ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                    ['title' => Str::limit($official->full_name, 25), 'url' => '#', 'icon' => 'fas fa-' . ($icon ?? 'user')]
                ]" />
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header Section -->
                <div class="p-8">
                    <div class="flex flex-col items-center gap-8">
                        <!-- Profile Photo -->
                        <div class="w-full flex justify-center">
                            @if ($official->photo)
                                <img src="{{ asset('storage/' . $official->photo) }}" alt="{{ $official->full_name }}"
                                    class="w-64 h-80 object-contain max-w-full max-h-[320px] rounded-xl">
                            @else
                                <div class="w-64 h-80 bg-gray-200 flex items-center justify-center rounded-xl">
                                    <i class="fas fa-user text-8xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <!-- Profile Info -->
                        <div class="text-center">
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">{{ $official->full_name }}</h1>
                            <p class="text-xl md:text-2xl font-semibold text-gray-600 mb-3">
                                {{ $jabatan }}
                            </p>
                            @if ($official->organization)
                                <p class="text-gray-500 italic">{{ $official->organization->name }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="p-8 text-gray-800">
                    <!-- Personal Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @if ($official->birth_place || $official->birth_date)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-birthday-cake text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <p class="font-medium text-gray-700">Lahir</p>
                                        <p class="text-gray-600">
                                            @if ($official->birth_place && $official->birth_date)
                                                {{ $official->birth_place }}, {{ $official->birth_date->format('d F Y') }}
                                            @elseif($official->birth_place)
                                                {{ $official->birth_place }}
                                            @elseif($official->birth_date)
                                                {{ $official->birth_date->format('d F Y') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($official->religion)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-pray text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <p class="font-medium text-gray-700">Agama</p>
                                        <p class="text-gray-600">{{ $official->religion }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($official->marital_status)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-heart text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <p class="font-medium text-gray-700">Status</p>
                                        <p class="text-gray-600">{{ $official->marital_status }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($official->nip)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-id-card text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <p class="font-medium text-gray-700">NIP</p>
                                        <p class="text-gray-600">{{ $official->nip }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($official->start_term)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <p class="font-medium text-gray-700">Mulai Jabatan</p>
                                        <p class="text-gray-600">{{ $official->start_term->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($official->end_term)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-times text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <p class="font-medium text-gray-700">Akhir Jabatan</p>
                                        <p class="text-gray-600">{{ $official->end_term->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($official->email)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <p class="font-medium text-gray-700">Email</p>
                                        <p class="text-gray-600">{{ $official->email }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($official->home_address)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-start">
                                    <i class="fas fa-home text-blue-500 mr-3 mt-1 text-lg"></i>
                                    <div>
                                        <p class="font-medium text-gray-700">Alamat</p>
                                        <p class="text-gray-600">{!! nl2br(e($official->home_address)) !!}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Biography -->
                    @if ($official->biography)
                        <div class="bg-gray-50 rounded-lg p-6 mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-book text-blue-500 mr-3"></i>
                                Biodata
                            </h2>
                            <div class="text-gray-600 leading-relaxed">
                                {!! nl2br(e($official->biography)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Family -->
                    @if ($official->spouse_name || $official->children->count() > 0)
                        <div class="mb-10">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-users text-blue-500 mr-3"></i>
                                Keluarga
                            </h2>
                            <div class="grid grid-cols-1 gap-6">
                                @if ($official->spouse_name)
                                    @php
                                        $spouse_label = ($official->jenis_kelamin === 'Perempuan') ? 'Nama Suami' : 'Nama Istri';
                                    @endphp
                                    <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-sm flex items-center gap-5 hover:border-blue-200 transition-all group">
                                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-500 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                            <i class="fas fa-heart text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-xs font-bold text-gray-400 mb-1">{{ $spouse_label }}</h3>
                                            <p class="text-xl font-black text-gray-800">{{ $official->spouse_name }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($official->children->count() > 0)
                                    <div class="bg-gray-50/50 p-6 rounded-[2rem] border border-gray-100">
                                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-5 flex items-center gap-2">
                                            <i class="fas fa-child text-blue-400"></i> Daftar Anak ({{ $official->children->count() }})
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach ($official->children as $child)
                                                <div class="bg-white p-5 rounded-2xl border border-gray-200/60 shadow-sm hover:border-blue-300 hover:shadow-md transition-all group">
                                                    <div class="flex items-center gap-3">
                                                        <span class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-[10px] font-black text-gray-400 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                                            {{ $loop->iteration }}
                                                        </span>
                                                        <p class="font-bold text-gray-800">{{ $child->name }}</p>
                                                    </div>
                                                    @if ($child->birth_place || $child->birth_date)
                                                        <p class="text-[10px] text-gray-400 mt-2 ml-11 font-medium italic">
                                                            Lahir: {{ $child->birth_place ?? '-' }}, {{ $child->birth_date ? $child->birth_date->format('d/m/Y') : '-' }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Education History -->
                    @if ($official->educations->count() > 0)
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-graduation-cap text-blue-500 mr-3"></i>
                                Pendidikan
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($official->educations->sortBy('start_year') as $education)
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                        <h3 class="font-bold text-gray-800 mb-2">{{ $education->degree }}</h3>
                                        @if ($education->institution)
                                            <p class="text-gray-700 mb-1"><span class="font-medium">Institusi:</span>
                                                {{ $education->institution }}</p>
                                        @endif
                                        @if ($education->start_year || $education->end_year)
                                            <p class="text-gray-700">
                                                @if ($education->start_year && $education->end_year)
                                                    <span class="font-medium">Tahun:</span> {{ $education->start_year }} -
                                                    {{ $education->end_year }}
                                                @elseif($education->start_year)
                                                    <span class="font-medium">Tahun:</span> {{ $education->start_year }} -
                                                    Sekarang
                                                @elseif($education->end_year)
                                                    <span class="font-medium">Tahun :</span> {{ $education->end_year }}
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Career History -->
                    @if ($official->careerHistories->count() > 0)
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-briefcase text-blue-500 mr-3"></i>
                                Riwayat Karir
                            </h2>
                            <div class="space-y-4">
                                @foreach ($official->careerHistories->sortByDesc('start_date') as $career)
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                        <h3 class="font-bold text-gray-800 text-lg mb-2">{{ $career->title }}</h3>
                                        @if ($career->organization_name)
                                            <p class="text-gray-700 mb-1"><span class="font-medium">Organisasi:</span>
                                                {{ $career->organization_name }}</p>
                                        @endif
                                        @if ($career->start_year || $career->end_year)
                                            <p class="text-gray-700 mb-1">
                                                @if ($career->start_year && $career->end_year)
                                                    <span class="font-medium">Tahun:</span> {{ $career->start_year }} -
                                                    {{ $career->end_year }}
                                                @elseif($career->start_year)
                                                    <span class="font-medium">Tahun:</span> {{ $career->start_year }} -
                                                    Sekarang
                                                @elseif($career->end_year)
                                                    <span class="font-medium">Tahun :</span> {{ $career->end_year }}
                                                @endif
                                            </p>
                                        @endif
                                        @if ($career->description)
                                            <p class="text-gray-600"><span class="font-medium">Deskripsi:</span>
                                                {{ $career->description }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Awards -->
                    @if ($official->awards->count() > 0)
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-trophy text-blue-500 mr-3"></i>
                                Penghargaan
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($official->awards as $award)
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                        <h3 class="font-bold text-gray-800 text-lg mb-2">{{ $award->title }}</h3>
                                        @if ($award->issuer)
                                            <p class="text-gray-700 mb-1"><span class="font-medium">Pemberi:</span>
                                                {{ $award->issuer }}</p>
                                        @endif
                                        @if ($award->year)
                                            <p class="text-gray-700 mb-1"><span class="font-medium">Tahun:</span>
                                                {{ $award->year }}</p>
                                        @endif
                                        @if ($award->description)
                                            <p class="text-gray-600"><span class="font-medium">Deskripsi:</span>
                                                {{ $award->description }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Training History -->
                    @if ($official->trainingHistories->count() > 0)
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-chalkboard-teacher text-blue-500 mr-3"></i>
                                Diklat
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($official->trainingHistories as $training)
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                        <h3 class="font-bold text-gray-800 mb-2">{{ $training->name }}</h3>
                                        @if ($training->organizer)
                                            <p class="text-gray-700 mb-1"><span class="font-medium">Penyelenggara:</span>
                                                {{ $training->organizer }}</p>
                                        @endif
                                        @if ($training->year)
                                            <p class="text-gray-700"><span class="font-medium">Tahun:</span>
                                                {{ $training->year }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Organizational History -->
                    @if ($official->organizationalHistories->count() > 0)
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-sitemap text-blue-500 mr-3"></i>
                                Organisasi
                            </h2>
                            <div class="space-y-4">
                                @foreach ($official->organizationalHistories as $organization)
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                        <h3 class="font-bold text-gray-800 text-lg mb-2">
                                            {{ $organization->organization_name }}</h3>
                                        @if ($organization->position)
                                            <p class="text-gray-700 mb-1"><span class="font-medium">Jabatan:</span>
                                                {{ $organization->position }}</p>
                                        @endif
                                        @if ($organization->start_year || $organization->end_year)
                                            <p class="text-gray-700">
                                                @if ($organization->start_year && $organization->end_year)
                                                    <span class="font-medium">Tahun:</span>
                                                    {{ $organization->start_year }} - {{ $organization->end_year }}
                                                @elseif($organization->start_year)
                                                    <span class="font-medium">Tahun:</span>
                                                    {{ $organization->start_year }} - Sekarang
                                                @elseif($organization->end_year)
                                                    <span class="font-medium">Tahun :</span> {{ $organization->end_year }}
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
