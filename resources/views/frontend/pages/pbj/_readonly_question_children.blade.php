@php $numbering_char = 'a'; @endphp
@foreach ($children as $child)
    <div class="border-l-2 md:border-l-4 border-gray-100 pl-4 md:pl-8 py-3 mt-4 {{ $level > 1 ? 'ml-2 md:ml-8' : '' }} transition-all hover:border-blue-100">
        <div class="flex items-start">
            <span class="text-sm md:text-base font-bold text-gray-400 mr-2 md:mr-3 mt-0.5">
                @if ($level == 1)
                    {{ $numbering_char++ }}.
                @else
                    {{ $loop->iteration }}).
                @endif
            </span>
            
            @php $childAnswer = $existingAnswers->get($child->id); @endphp
            @if($childAnswer && $childAnswer->informasi)
                <a href="{{ route('frontend.informasi.detail', $childAnswer->informasi->slug) }}" class="text-sm md:text-base font-bold text-blue-600 hover:text-blue-800 leading-snug flex-1 transition-colors">
                    {{ $child->question }}
                    <i class="fas fa-external-link-alt ml-2 text-[10px] opacity-50"></i>
                </a>
            @else
                <p class="text-sm md:text-base font-medium text-gray-700 leading-snug flex-1">
                    {{ $child->question }}
                </p>
            @endif
        </div>

        @if ($child->children->isNotEmpty())
            <div class="mt-2">
                @include('frontend.pages.pbj._readonly_question_children', ['children' => $child->children, 'level' => $level + 1, 'existingAnswers' => $existingAnswers])
            </div>
        @endif
    </div>
@endforeach
