@foreach ($children as $child)
    <tr class="hover:bg-gray-50 transition-colors duration-200">
        <td class="py-4 px-6" style="width: 150px;">
            <span style="padding-left: {{ $level * 20 }}px;">
                @php
                    $numbering = '';
                    if ($level == 1) {
                        $numbering = chr(96 + $loop->iteration) . '.'; // 'a.', 'b.', 'c.'
                    } else { // $level >= 2
                        $numbering = $loop->iteration . ').'; // '1).', '2).', '3).'
                    }
                @endphp
                {{ $numbering }}
            </span>
        </td>        <td class="py-4 px-6 {{ $child->is_category ? 'font-bold' : '' }}">{{ $child->question }}</td>
        <td class="py-4 px-6">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.pbj-questions.edit', $child->id) }}" class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" title="Edit">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </a>
                <form action="{{ route('admin.pbj-questions.destroy', $child->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pertanyaan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" title="Hapus">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </td>
    </tr>
    @if ($child->children->isNotEmpty())
        @include('admin.pbj.questions._question_children', ['children' => $child->children, 'level' => $level + 1])
    @endif
@endforeach
