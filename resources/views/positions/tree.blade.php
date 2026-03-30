<ul class="space-y-1">
    @foreach($positions as $pos)
        <li class="border-l-2 border-blue-200 pl-4">
            <div class="flex items-center py-1">
                <i class="fas fa-user-tie text-blue-500 mr-2"></i>
                <span class="font-medium text-gray-800">{{ $pos->title }}</span>
                <span class="ml-2 text-sm text-gray-600">{{ $pos->name ?: '(Kosong)' }}</span>
                <a href="{{ route('admin.positions.edit', $pos) }}" class="ml-2 text-blue-600 hover:text-blue-800 text-sm">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.positions.destroy', $pos) }}" method="POST" class="inline-block ml-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jabatan ini?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
            @if($pos->children->count() > 0)
                <div class="mt-1">
                    @include('positions.tree', ['positions' => $pos->children])
                </div>
            @endif
        </li>
    @endforeach
</ul>