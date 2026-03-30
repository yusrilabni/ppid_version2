@php
    use App\Helpers\PrivacyHelper;

    $statusConfig = [
        'Publik' => ['class' => 'bg-blue-100 text-blue-800', 'icon' => 'fas fa-globe-asia'],
        'Anonim' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fas fa-user-secret'],
        'Rahasia' => ['class' => 'bg-red-100 text-red-800', 'icon' => 'fas fa-lock'],
    ];
    
    $privacyConfig = $statusConfig[$permohonan->privacy_status] ?? ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'fas fa-question-circle'];
    
    $responseType = $permohonan->responses->isNotEmpty() ? $permohonan->responses->first()->response_type : null;
    $responseTypeClass = match($responseType) {
        'Respon Awal' => 'bg-indigo-100 text-indigo-800',
        'Tindaklanjut' => 'bg-purple-100 text-purple-800',
        default => 'bg-gray-100 text-gray-800',
    };

    $is_anonim_status = $permohonan->privacy_status == 'Anonim';
    $is_owner = Auth::check() && Auth::id() == $permohonan->user_id;
    $should_anonymize_data = $is_anonim_status && !$is_owner;
@endphp

<div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow flex flex-col justify-between h-full">
    <!-- Top Section: User Info & Details -->
    <div>
        <div class="flex items-start space-x-4">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                @if ($permohonan->user && $permohonan->user->profile_photo_path)
                    <img src="{{ asset('storage/' . $permohonan->user->profile_photo_path) }}" 
                         alt="{{ PrivacyHelper::maskName($permohonan->user->name ?? '', $should_anonymize_data) }}" 
                         class="h-12 w-12 rounded-full object-cover border-2 border-gray-200">
                @else
                    <div class="h-12 w-12 rounded-full bg-gray-100 border-2 border-gray-200 flex items-center justify-center">
                        <i class="fas fa-user text-gray-400 text-lg"></i>
                    </div>
                @endif
            </div>

            <!-- Details -->
            <div class="flex-1">
                <div class="flex items-center flex-wrap gap-2 mb-2">
                    <h4 class="font-semibold text-gray-800">
                        {{ PrivacyHelper::maskName($permohonan->user->name ?? $permohonan->nama_pemohon, $should_anonymize_data) }}
                    </h4>
                    
                    <span class="inline-flex items-center text-xs font-medium px-3 py-1 rounded-full {{ $privacyConfig['class'] }}">
                        <i class="{{ $privacyConfig['icon'] }} mr-1.5 text-xs"></i>
                        {{ $permohonan->privacy_status }}
                    </span>
                    
                    @if($responseType) {{-- Check if responseType is not null --}}
                        @php
                            $displayResponseType = str_replace('Tindaklanjut Permohonan', 'Tindaklanjut', $responseType);
                        @endphp
                        <span class="text-xs font-medium px-3 py-1 rounded-full {{ $responseTypeClass }}">
                            {{ $displayResponseType }}
                        </span>
                    @endif
                    
                    <span class="text-xs text-gray-500 ml-auto">
                        {{ $permohonan->created_at->format('d M Y, H:i') }}
                    </span>
                </div>
                
                <p class="text-gray-600 line-clamp-2">
                    {{ $permohonan->detail_informasi }}
                </p>
                

            </div>
        </div>
    </div>

    <!-- Bottom Section: Actions -->
    <div class="flex justify-between items-center mt-4">
        <!-- ID and Time Ago moved here -->
        <div class="flex items-center text-sm text-gray-500">
            <i class="fas fa-hashtag text-gray-400 mr-1.5"></i>
            <span class="mr-4">ID: {{ $permohonan->unique_code }}</span>
            
            <i class="fas fa-calendar text-gray-400 mr-1.5 ml-4"></i>
            <span>{{ $permohonan->created_at->diffForHumans() }}</span>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.permohonan-informasi.show', ['permohonan_informasi' => $permohonan]) }}" 
               class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center">
                <i class="fas fa-eye mr-2"></i>
                Detail
            </a>
            
            @if($actions === 'pending')
                <form action="{{ route('admin.permohonan-informasi.destroy', ['permohonan_informasi' => $permohonan]) }}" 
                          method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" 
                                class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus
                        </button>
                    </form>
            @endif

                @if($actions === 'diproses')
                    @if($permohonan->responses->isNotEmpty() && $permohonan->responses->first()->response_type === 'Tindaklanjut')
                    <form action="{{ route('admin.permohonan-informasi.complete', ['permohonan_informasi' => $permohonan]) }}" 
                          method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan permohonan ini?');">
                        @csrf
                        <button type="submit" 
                                class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center">
                            <i class="fas fa-check mr-2"></i>
                            Selesaikan
                        </button>
                    </form>
                    @endif
                    
                    <form action="{{ route('admin.permohonan-informasi.reject', ['permohonan_informasi' => $permohonan]) }}" 
                          method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menolak permohonan ini?');">
                        @csrf
                        <button type="submit" 
                                class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center">
                            <i class="fas fa-times mr-2"></i>
                            Tolak
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.permohonan-informasi.destroy', ['permohonan_informasi' => $permohonan]) }}" 
                          method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" 
                                class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus
                        </button>
                    </form>
                @endif
                
                @if(in_array($actions, ['selesai', 'ditolak']))
                    <form action="{{ route('admin.permohonan-informasi.destroy', ['permohonan_informasi' => $permohonan]) }}" 
                          method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" 
                                class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>
</div>