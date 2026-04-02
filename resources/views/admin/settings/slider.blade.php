@extends('admin.layouts.app')

@section('title', 'Pengaturan Slider Utama')

@section('content')
<div class="max-w-4xl mx-auto" x-data="{ selectedRatio: '{{ $aspectRatio }}' }">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-white to-blue-50/30 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Pengaturan Slider</h2>
                <p class="text-sm text-gray-500 mt-1">Sesuaikan tampilan dan animasi profesional untuk slider beranda</p>
            </div>
            <i class="fas fa-magic text-blue-200 text-3xl"></i>
        </div>

        <form action="{{ route('admin.slider-settings.update') }}" method="POST" class="p-8 space-y-8">
            @csrf
            
            @if(session('success'))
                <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl flex items-center shadow-sm animate-fadeIn">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Durasi Transisi -->
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">
                        <i class="fas fa-clock mr-2 text-blue-500"></i> Durasi Tampil (Detik)
                    </label>
                    <div class="relative">
                        <input type="number" name="duration_in_seconds" value="{{ $durationInSeconds }}" 
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all text-lg font-bold"
                               required min="1">
                        <span class="absolute right-4 top-3.5 text-gray-400 font-medium text-sm">DETIK</span>
                    </div>
                </div>

                <!-- Tipe Animasi -->
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">
                        <i class="fas fa-film mr-2 text-blue-500"></i> Efek Transisi
                    </label>
                    <select name="animation_type" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all font-bold text-blue-600">
                        <option value="fade" {{ $animationType == 'fade' ? 'selected' : '' }}>Pudar Halus (Default)</option>
                        <option value="slide" {{ $animationType == 'slide' ? 'selected' : '' }}>Geser Mulus (Slide)</option>
                        <option value="cube" {{ $animationType == 'cube' ? 'selected' : '' }}>Kubus 3D (Cube)</option>
                        <option value="flip" {{ $animationType == 'flip' ? 'selected' : '' }}>Balik 3D (Flip)</option>
                        <option value="coverflow" {{ $animationType == 'coverflow' ? 'selected' : '' }}>Aliran Sampul (Coverflow)</option>
                        <option value="cards" {{ $animationType == 'cards' ? 'selected' : '' }}>Tumpukan Kartu (Cards)</option>
                    </select>
                </div>

                <!-- Rasio Dimensi -->
                <div class="space-y-3 md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">
                        <i class="fas fa-expand mr-2 text-blue-500"></i> Rasio Tampilan (Ukuran Layar)
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        @php
                            $ratios = [
                                ['id' => 'aspect-video', 'label' => '16:9', 'desc' => 'Landscape'],
                                ['id' => 'aspect-[4/3]', 'label' => '4:3', 'desc' => 'Classic'],
                                ['id' => 'aspect-[21/9]', 'label' => '21:9', 'desc' => 'Ultra Wide'],
                                ['id' => 'aspect-first', 'label' => 'Slide 1', 'desc' => 'Paten Awal'],
                                ['id' => 'aspect-auto', 'label' => 'Auto', 'desc' => 'Beda-beda'],
                            ];
                        @endphp
                        @foreach($ratios as $ratio)
                            <div class="relative group">
                                <input type="radio" id="ratio_{{ $loop->index }}" name="aspect_ratio" value="{{ $ratio['id'] }}" 
                                       class="peer hidden" 
                                       x-model="selectedRatio"
                                       {{ $aspectRatio == $ratio['id'] ? 'checked' : '' }}>
                                <label for="ratio_{{ $loop->index }}" 
                                       class="flex flex-col p-4 border rounded-2xl cursor-pointer transition-all bg-gray-50 border-gray-100 group-hover:bg-gray-100 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200">
                                    <span class="text-sm font-bold text-gray-800">{{ $ratio['label'] }}</span>
                                    <span class="text-[10px] text-gray-400 mt-1 uppercase">{{ $ratio['desc'] }}</span>
                                </label>
                                <template x-if="selectedRatio === '{{ $ratio['id'] }}'">
                                    <i class="fas fa-check-circle absolute top-2 right-2 text-blue-500 animate-fadeIn pointer-events-none"></i>
                                </template>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 italic mt-4">
                        <strong>Catatan:</strong> Pilih "Paten Awal" agar semua slide mengikuti tinggi gambar pertama secara seragam.
                    </p>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" class="px-10 py-4 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 hover:scale-[1.02] transition-all shadow-lg shadow-blue-100 flex items-center">
                    <i class="fas fa-save mr-2 text-lg"></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: scale(0.8); } to { opacity: 1; transform: scale(1); } }
    .animate-fadeIn { animation: fadeIn 0.2s ease-out; }
</style>
@endsection
