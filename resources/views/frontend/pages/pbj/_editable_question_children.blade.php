@php $numbering_char = 'a'; @endphp
@foreach ($children as $child)
    <div class="border-l-2 md:border-l-4 border-blue-100 pl-4 md:pl-8 py-3 mt-4 {{ $level > 1 ? 'ml-2 md:ml-8' : '' }} transition-all hover:border-blue-300">
        <div class="flex items-start">
            <span class="text-sm md:text-base font-bold text-gray-600 mr-2 md:mr-3 mt-0.5">
                @if ($level == 1)
                    {{ $numbering_char++ }}.
                @else
                    {{ $loop->iteration }}).
                @endif
            </span>
            <p class="text-sm md:text-base font-bold text-gray-700 leading-snug {{ $child->is_category ? 'text-gray-900' : '' }}">
                {{ $child->question }}
            </p>
        </div>

        <div class="mt-4 space-y-4 ml-6 md:ml-8">
            @php $childAnswer = $existingAnswers->get($child->id); @endphp
            
            @if($child->requires_link_submission)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="answers_{{ $child->id }}_url" class="text-[10px] md:text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Link Dokumen</label>
                    <input type="url" name="answers[{{ $child->id }}][url]" id="answers_{{ $child->id }}_url" 
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all url-input" 
                        placeholder="https://..." value="{{ old('answers.' . $child->id . '.url', $childAnswer->document_url ?? '') }}" data-question-id="{{ $child->id }}">
                </div>
                @if($canEdit)
                <div class="space-y-1.5">
                    <label for="answers_{{ $child->id }}_category" class="text-[10px] md:text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Klasifikasi</label>
                    <select name="answers[{{ $child->id }}][category]" id="answers_{{ $child->id }}_category" 
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        <option value="">-- Pilih --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ (old('answers.' . $child->id . '.category', $childAnswer->informasi->category ?? '') == $category) ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
            @endif

            @if($child->requires_file_submission)
            <div class="space-y-2">
                <label for="answers_{{ $child->id }}_file" class="text-[10px] md:text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Upload Berkas</label>
                @if($childAnswer && $childAnswer->document_file_path)
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 flex items-center justify-between mb-2">
                        <span class="text-[10px] md:text-xs text-blue-700 font-medium truncate max-w-[150px] md:max-w-xs">
                            <i class="fas fa-file-pdf mr-2"></i>{{ basename($childAnswer->document_file_path) }}
                        </span>
                        <a href="{{ asset('storage/' . $childAnswer->document_file_path) }}" target="_blank" class="text-[10px] md:text-xs font-bold text-blue-600 hover:text-blue-800 uppercase tracking-wider">Buka</a>
                    </div>
                @endif
                <input type="file" name="answers[{{ $child->id }}][file]" id="answers_{{ $child->id }}_file" 
                    class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition-all">
            </div>
            @endif
        </div>

        @if ($child->children->isNotEmpty())
            <div class="mt-2">
                @include('frontend.pages.pbj._editable_question_children', ['children' => $child->children, 'level' => $level + 1, 'existingAnswers' => $existingAnswers, 'canEdit' => $canEdit, 'categories' => $categories])
            </div>
        @endif
    </div>
@endforeach
