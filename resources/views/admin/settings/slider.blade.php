@extends('admin.layouts.app')

@section('title', 'Pengaturan Slider Utama')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-white to-blue-50/30 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Pengaturan Slider</h2>
                <p class="text-sm text-gray-500 mt-1">Sesuaikan tampilan dan perilaku slider di halaman beranda</p>
            </div>
            <i class="fas fa-sliders-h text-blue-200 text-3xl"></i>
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
                        <i class="fas fa-clock mr-2 text-blue-500"></i> Durasi Transisi (Detik)
                    </label>
                    <div class="relative">
                        <input type="number" name="duration_in_seconds" value="{{ $durationInSeconds }}" 
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all text-lg font-bold"
                               required min="1">
                        <span class="absolute right-4 top-3.5 text-gray-400 font-medium text-sm">DETIK</span>
                    </div>
                    <p class="text-xs text-gray-400 italic">Lama waktu gambar tampil sebelum berpindah otomatis.</p>
                </div>

                <!-- Tipe Animasi -->
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">
                        <i class="fas fa-magic mr-2 text-blue-500"></i> Efek Animasi
                    </label>
                    <select name="animation_type" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all font-medium">
                        <option value="slide" {{ $animationType == 'slide' ? 'selected' : '' }}>Geser (Slide)</option>
                        <option value="fade" {{ $animationType == 'fade' ? 'selected' : '' }}>Pudar (Fade)</option>
                        <option value="cube" {{ $animationType == 'cube' ? 'selected' : '' }}>Kubus (Cube)</option>
                        <option value="flip" {{ $animationType == 'flip' ? 'selected' : '' }}>Balik (Flip)</option>
                        <option value="creative" {{ $animationType == 'creative' ? 'selected' : '' }}>Kreatif (Creative)</option>
                    </select>
                    <p class="text-xs text-gray-400 italic">Pilih gaya transisi perpindahan gambar.</p>
                </div>

                <!-- Rasio Dimensi -->
                <div class="space-y-3 md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">
                        <i class="fas fa-expand mr-2 text-blue-500"></i> Rasio Tampilan (Aspect Ratio)
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @php
                            $ratios = [
                                ['id' => 'aspect-video', 'label' => '16:9 (Landscape)', 'desc' => 'Standar Video'],
                                ['id' => 'aspect-[4/3]', 'label' => '4:3 (Classic)', 'desc' => 'Standar TV'],
                                ['id' => 'aspect-[21/9]', 'label' => '21:9 (Cinematic)', 'desc' => 'Sangat Lebar'],
                                ['id' => 'aspect-auto', 'label' => 'Auto (Asli)', 'desc' => 'Ikuti Ukuran Gambar'],
                            ];
                        @endphp
                        @foreach($ratios as $ratio)
                            <label class="relative flex flex-col p-4 border rounded-2xl cursor-pointer hover:bg-blue-50 transition-all {{ $aspectRatio == $ratio['id'] ? 'border-blue-500 bg-blue-50 ring-2 ring-blue-200' : 'border-gray-100 bg-gray-50' }}">
                                <input type="radio" name="aspect_ratio" value="{{ $ratio['id'] }}" class="hidden" {{ $aspectRatio == $ratio['id'] ? 'checked' : '' }}>
                                <span class="text-sm font-bold text-gray-800">{{ $ratio['label'] }}</span>
                                <span class="text-[10px] text-gray-400 mt-1 uppercase">{{ $ratio['desc'] }}</span>
                                @if($aspectRatio == $ratio['id'])
                                    <i class="fas fa-check-circle absolute top-2 right-2 text-blue-500"></i>
                                @endif
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" class="px-10 py-4 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 hover:scale-[1.02] transition-all shadow-lg shadow-blue-100 flex items-center">
                    <i class="fas fa-save mr-2 text-lg"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Preview Box (Info) -->
    <div class="mt-8 bg-blue-600 rounded-2xl p-6 text-white flex items-start shadow-xl shadow-blue-100">
        <div class="bg-white/20 p-3 rounded-xl mr-4">
            <i class="fas fa-lightbulb text-xl"></i>
        </div>
        <div>
            <h4 class="font-bold">Tips Tampilan</h4>
            <p class="text-sm text-blue-50 opacity-90 mt-1">Rasio 16:9 adalah rasio yang paling direkomendasikan untuk website modern. Gunakan gambar dengan resolusi minimal 1920x1080 piksel untuk hasil terbaik.</p>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fadeIn { animation: fadeIn 0.3s ease-out; }
</style>
@endsection
