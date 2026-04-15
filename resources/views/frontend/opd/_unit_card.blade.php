<div class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 ease-in-out overflow-hidden flex flex-col h-full border border-gray-100 hover:border-blue-100 transform hover:-translate-y-2">
    <div class="p-8 flex-grow flex flex-col">
        <div class="flex items-center justify-center mb-6">
            <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center group-hover:bg-blue-600 transition-colors duration-300">
                <i class="fas {{ $icon }} text-blue-600 text-3xl group-hover:text-white transition-colors duration-300"></i>
            </div>
        </div>
        <h2 class="text-xl font-bold text-gray-800 mb-3 text-center leading-tight">{{ $unit['name'] }}</h2>
        <div class="flex items-start text-gray-500 mb-6 text-center justify-center text-sm">
            <i class="fas fa-map-marker-alt text-blue-500 mr-2 mt-0.5"></i>
            <p class="flex-grow line-clamp-2">{!! $unit['address'] ?? 'Alamat belum ditambahkan.' !!}</p>
        </div>
        
        <div class="mt-auto space-y-3">
            @if($unit['slug'])
                <a href="{{ route('opd.dip.show', $unit['slug']) }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 w-full shadow-lg shadow-blue-100 hover:shadow-blue-200">
                    <i class="fas fa-file-alt mr-2"></i> Lihat Daftar Informasi Publik
                </a>
            @else
                <span class="inline-flex items-center justify-center bg-gray-100 text-gray-400 font-bold py-3 px-6 rounded-xl w-full cursor-not-allowed italic">
                    Belum Terdaftar
                </span>
            @endif
            
            @if($unit['website_url'])
                <a href="{{ $unit['website_url'] }}" target="_blank" class="inline-flex items-center justify-center bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold py-2.5 px-6 rounded-xl transition-all duration-300 w-full border border-gray-100">
                    <i class="fas fa-globe mr-2 text-blue-500"></i> Website Resmi
                </a>
            @endif
        </div>
    </div>
</div>
