@php
    $indent = $level * 20; // 20px indentation per level
@endphp

<tr>
    <td class="px-6 py-4 whitespace-nowrap">
        <div style="padding-left: {{ $indent }}px;" class="flex items-center">
            <i class="fas fa-sitemap text-gray-400 mr-2"></i>
            <span class="font-medium text-gray-900">{{ $position->title }}</span>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $position->name ?? '-' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $position->parent ? $position->parent->title : '-' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        @if($position->members->count() > 0)
            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                {{ $position->members->count() }} anggota
            </span>
        @else
            <span class="text-gray-400">-</span>
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $position->order_number }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.organizations.positions.edit', [$organization, $position]) }}" class="text-indigo-600 hover:text-indigo-900">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('admin.organizations.positions.destroy', [$organization, $position]) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus jabatan ini?')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </td>
</tr>

@if($position->children->count() > 0)
    @foreach($position->children as $child)
        @include('admin.organizations.positions.tree', ['position' => $child, 'level' => $level + 1])
    @endforeach
@endif