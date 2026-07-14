@extends('admin.layouts.app')

@section('title', 'Edit Semua Jawaban Responden')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <nav class="flex text-sm text-gray-500 font-medium mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li><a href="{{ route('admin.surveys.responses.index', $survey->slug) }}" class="hover:text-blue-600 transition-colors">Respon Survei</a></li>
                        <li><span class="mx-2 text-gray-300">/</span></li>
                        <li class="text-gray-900" aria-current="page">Edit Responden #{{ $response->id }}</li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Edit Jawaban Responden</h1>
                <p class="mt-2 text-sm text-gray-500">Edit seluruh jawaban untuk responden yang mengisi pada <span class="font-bold">{{ $response->created_at->format('d M Y, H:i') }}</span>.</p>
            </div>
            
            <a href="{{ route('admin.surveys.responses.index', $survey->slug) }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-200 rounded-xl shadow-sm text-sm font-bold text-gray-700 hover:bg-gray-50 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.surveys.responses.updateAll', [$survey->slug, $response->id]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6 sm:p-8 space-y-8">
                @foreach($sortedQuestions as $index => $question)
                    @php
                        $answer = $response->answers->firstWhere('question_id', $question->id);
                        $currentAnswer = $answer ? $answer->answer_text : '';
                    @endphp
                    
                    <div class="p-5 bg-gray-50 rounded-xl border border-gray-100 relative group transition-all hover:border-blue-200 hover:bg-blue-50/30">
                        <div class="absolute -left-3 -top-3 w-8 h-8 bg-blue-600 text-white font-bold rounded-lg flex items-center justify-center shadow-md">
                            {{ $index + 1 }}
                        </div>
                        
                        <label class="block text-sm font-bold text-gray-900 mb-4 pl-4">
                            {{ $question->question_text }}
                        </label>
                        
                        <div class="pl-4">
                            @if($question->question_type === 'Skala Kepuasan')
                                <select name="answers[{{ $question->id }}]" class="mt-1 block w-full max-w-md pl-3 pr-10 py-3 text-sm font-medium border-gray-200 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-xl bg-white shadow-sm">
                                    <option value="">Pilih Nilai Skala (1-5)...</option>
                                    @for($i=1; $i<=5; $i++)
                                        <option value="{{ $i }}" {{ $currentAnswer == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ $i === 1 ? '(Sangat Kurang)' : ($i === 5 ? '(Sangat Baik)' : '') }}
                                        </option>
                                    @endfor
                                </select>
                                
                            @elseif(in_array($question->question_type, ['Checkbox', 'Pilihan Ganda', 'Dropdown', 'Pilihan Ganda (Berbobot)']))
                                @php
                                    $parsedAnswer = $currentAnswer;
                                    if(in_array($question->question_type, ['Checkbox', 'Pilihan Ganda', 'Dropdown', 'Pilihan Ganda (Berbobot)'])) {
                                        $arr = json_decode($currentAnswer, true);
                                        if(is_array($arr) && count($arr) > 0) {
                                            $parsedAnswer = $arr[0];
                                        }
                                    }
                                @endphp
                                <select name="answers[{{ $question->id }}]" class="mt-1 block w-full max-w-md pl-3 pr-10 py-3 text-sm font-medium border-gray-200 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-xl bg-white shadow-sm">
                                    <option value="">Pilih Opsi...</option>
                                    @foreach($question->options as $option)
                                        <option value="{{ $option->id }}" {{ $parsedAnswer == $option->id ? 'selected' : '' }}>
                                            {{ $option->option_text }}
                                        </option>
                                    @endforeach
                                </select>
                            
                            @else
                                <textarea name="answers[{{ $question->id }}]" rows="4" class="mt-1 block w-full border border-gray-200 rounded-xl shadow-sm py-3 px-4 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Masukkan jawaban...">{{ $currentAnswer }}</textarea>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Footer / Action Buttons -->
            <div class="px-6 py-5 bg-gray-50 border-t border-gray-100 flex items-center justify-end rounded-b-2xl gap-3">
                <a href="{{ route('admin.surveys.responses.index', $survey->slug) }}" class="inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-6 py-2.5 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none transition-all">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center rounded-xl border border-transparent shadow-md px-6 py-2.5 bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 focus:outline-none transition-all">
                    <i class="fas fa-save mr-2 mt-0.5"></i> Simpan Semua Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
