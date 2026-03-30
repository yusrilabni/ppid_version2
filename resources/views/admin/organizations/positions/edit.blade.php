@extends('admin.layouts.app')

@section('title', 'Edit Jabatan Organisasi')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Edit Jabatan: {{ $position->title }}</h2>
            <a href="{{ route('admin.organizations.positions.index', $organization) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.organizations.positions.update', [$organization, $position]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Jabatan *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $position->title) }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $position->name) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Jabatan Induk</label>
                    <select name="parent_id" id="parent_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Jabatan Utama (Tanpa Induk)</option>
                        @foreach($allPositions as $pos)
                            <option value="{{ $pos->id }}" {{ old('parent_id', $position->parent_id) == $pos->id ? 'selected' : '' }}>
                                {{ str_repeat('— ', $pos->computeDepth()) }} {{ $pos->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order_number" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                    <input type="number" name="order_number" id="order_number" value="{{ old('order_number', $position->order_number) }}" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('order_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                    <i class="fas fa-sync-alt mr-2"></i> Update Jabatan
                </button>
            </div>
        </form>
    </div>
@endsection