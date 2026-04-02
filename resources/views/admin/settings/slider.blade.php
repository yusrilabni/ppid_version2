@extends('admin.layouts.app')

@section('title', 'Pengaturan Slider Utama')

@section('content')
<div class="max-w-4xl mx-auto" x-data="{ 
    selectedRatio: '{{ $aspectRatio }}',
    duration: {{ $durationInSeconds }},
    increment() { this.duration++ },
    decrement() { if(this.duration > 1) this.duration-- }
}">
    <!-- Header with Back Button -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.sliders.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl text-gray-400 hover:text-blue-600 hover:border-blue-100 hover:shadow-sm transition-all">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Pengaturan Slider</h2>
                <p class="text-sm text-gray-500">Sesuaikan tampilan dan perilaku slider beranda</p>
            </div>
        </div>
        <i class="fas fa-sliders-h text-blue-100 text-4xl hidden md:block"></i>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Notification Area -->
        @if(session('success'))
            <div class="m-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center animate-fadeIn shadow-sm">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white mr-3 shrink-0">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.slider-settings.update') }}" method="POST" class="p-8 space-y-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Durasi Transisi with Stepper -->
                <div class="space-y-4">
                    <label class="block text-sm font-extrabold text-gray-700 uppercase tracking-widest">
                        Durasi Tampil (Detik)
                    </label>
                    <div class="flex items-center gap-3">
                        <button type="button" @click="decrement()" class="w-14 h-14 flex items-center justify-center bg-gray-50 border border-gray-200 rounded-2xl text-gray-600 hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition-all active:scale-95 shadow-sm">
                            <i class="fas fa-minus"></i>
                        </button>
                        
                        <div class="relative flex-grow">
                            <input type="number" name="duration_in_seconds" x-model="duration" 
                                   class="w-full h-14 text-center bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all text-xl font-black text-blue-600 shadow-inner appearance-none"
                                   readonly>
                        </div>

                        <button type="button" @click="increment()" class="w-14 h-14 flex items-center justify-center bg-gray-50 border border-gray-200 rounded-2xl text-gray-600 hover:bg-green-50 hover:text-green-600 hover:border-green-100 transition-all active:scale-95 shadow-sm">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <p class="text-[11px] text-gray-400 font-bold uppercase tracking-tight">Gunakan tombol +/- untuk mengatur kecepatan</p>
                </div>

                <!-- Tipe Animasi -->
                <div class="space-y-4">
                    <label class="block text-sm font-extrabold text-gray-700 uppercase tracking-widest">
                        Efek Transisi
                    </label>
                    <div class="relative">
                        <select name="animation_type" class="w-full h-14 pl-5 pr-10 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all font-bold text-gray-700 appearance-none shadow-sm">
                            <option value="fade" {{ $animationType == 'fade' ? 'selected' : '' }}>Pudar Halus (Default)</option>
                            <option value="slide" {{ $animationType == 'slide' ? 'selected' : '' }}>Geser Mulus (Slide)</option>
                            <option value="cube" {{ $animationType == 'cube' ? 'selected' : '' }}>Kubus 3D (Cube)</option>
                            <option value="flip" {{ $animationType == 'flip' ? 'selected' : '' }}>Balik 3D (Flip)</option>
                            <option value="coverflow" {{ $animationType == 'coverflow' ? 'selected' : '' }}>Aliran Sampul (Coverflow)</option>
                            <option value="cards" {{ $animationType == 'cards' ? 'selected' : '' }}>Tumpukan Kartu (Cards)</option>
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    <p class="text-[11px] text-gray-400 font-bold uppercase tracking-tight text-right">Gaya perpindahan slide</p>
                </div>

                <!-- Rasio Dimensi -->
                <div class="space-y-6 md:col-span-2 pt-4 border-t border-gray-50">
                    <label class="block text-sm font-extrabold text-gray-700 uppercase tracking-widest text-center">
                        Rasio Tampilan Slider
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
                            <div class="relative">
                                <input type="radio" id="ratio_{{ $loop->index }}" name="aspect_ratio" value="{{ $ratio['id'] }}" 
                                       class="peer hidden" 
                                       @change="selectedRatio = '{{ $ratio['id'] }}'"
                                       {{ $aspectRatio == $ratio['id'] ? 'checked' : '' }}>
                                
                                <label for="ratio_{{ $loop->index }}" 
                                       class="flex flex-col items-center justify-center p-5 border-2 rounded-[2rem] cursor-pointer transition-all duration-300 bg-gray-50 border-transparent hover:bg-white hover:border-blue-100 hover:shadow-md peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-lg peer-checked:shadow-blue-500/10">
                                    <span class="text-base font-black text-gray-800 peer-checked:text-blue-600">{{ $ratio['label'] }}</span>
                                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1">{{ $ratio['desc'] }}</span>
                                </label>

                                <div class="absolute -top-1 -right-1 hidden peer-checked:flex w-6 h-6 bg-blue-500 rounded-full items-center justify-center text-white shadow-md animate-bounce-short border-2 border-white">
                                    <i class="fas fa-check text-[10px]"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="pt-8 flex justify-center">
                <button type="submit" class="group relative px-12 py-5 bg-gray-900 text-white rounded-[2rem] font-black uppercase tracking-widest hover:bg-blue-600 transition-all duration-300 shadow-xl hover:shadow-blue-500/20 active:scale-95">
                    <span class="relative z-10 flex items-center">
                        <i class="fas fa-save mr-3 text-lg opacity-50 group-hover:opacity-100 transition-opacity"></i>
                        Simpan Pengaturan
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fadeIn { animation: fadeIn 0.4s ease-out; }
    
    @keyframes bounce-short {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }
    .animate-bounce-short { animation: bounce-short 1s ease-in-out infinite; }

    /* Hide number input arrows */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endsection
