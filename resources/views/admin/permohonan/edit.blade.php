@extends('admin.layouts.app')

@section('title', 'Edit Permohonan Informasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Edit Permohonan Informasi</h2>

        <form action="{{ route('admin.permohonan-informasi.update', ['permohonan_informasi' => $permohonan]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Pemohon -->
                <div>
                    <label for="nama_pemohon" class="block text-sm font-medium text-gray-700">Nama Pemohon</label>
                    <input type="text" id="nama_pemohon" name="nama_pemohon" value="{{ old('nama_pemohon', $permohonan->nama_pemohon) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Email Pemohon -->
                <div>
                    <label for="email_pemohon" class="block text-sm font-medium text-gray-700">Email Pemohon</label>
                    <input type="email" id="email_pemohon" name="email_pemohon" value="{{ old('email_pemohon', $permohonan->email_pemohon) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Detail Informasi -->
            <div class="mt-6">
                <label for="detail_informasi" class="block text-sm font-medium text-gray-700">Detail Informasi yang Diminta</label>
                <textarea id="detail_informasi" name="detail_informasi" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('detail_informasi', $permohonan->detail_informasi) }}</textarea>
            </div>
            
            <!-- Status Permohonan -->
            <div class="mt-6">
                 <label for="status_permohonan" class="block text-sm font-medium text-gray-700">Status Permohonan</label>
                 <select id="status_permohonan" name="status_permohonan" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="pending" @if($permohonan->status_permohonan === 'pending') selected @endif>Belum ditindak Lanjuti</option>
                    <option value="diproses" @if($permohonan->status_permohonan === 'diproses') selected @endif>Sedang Di Proses</option>
                    <option value="selesai" @if($permohonan->status_permohonan === 'selesai') selected @endif>Selesai</option>
                    <option value="ditolak" @if($permohonan->status_permohonan === 'ditolak') selected @endif>Ditolak</option>
                 </select>
            </div>


            <!-- Submit Button -->
            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.permohonan-informasi.show', ['permohonan_informasi' => $permohonan]) }}" class="mr-4 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Update Permohonan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
