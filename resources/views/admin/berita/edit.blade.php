@extends('admin.layouts.app')

@section('title', 'Edit Berita')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Edit Berita</h2>
            <p class="text-gray-600">Update news article information</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-start">
                <div>
                    <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>
                </div>
                <div>
                    <strong class="font-bold">Whoops!</strong>
                    <span class="block">There were some problems with your input.</span>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" value="{{ old('title', $berita->title) }}" required>
            </div>

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                <x-forms.tiny-mce-editor id="content" name="content" rows="10" required>{{ old('content', $berita->content) }}</x-forms.tiny-mce-editor>
            </div>

            <div class="mb-6">
                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
                <textarea name="excerpt" id="excerpt" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" rows="3">{{ old('excerpt', $berita->excerpt) }}</textarea>
                <p class="mt-2 text-sm text-gray-500">Short description that appears in listings</p>
            </div>

            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">New Image (Optional)</label>
                <input type="file" name="image" id="image" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" accept="image/*">
                <p class="mt-2 text-sm text-gray-500">Leave blank to keep the current image</p>
                @if($berita->image)
                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                        <img src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->title }}" class="h-32 w-auto object-cover rounded border border-gray-200">
                    </div>
                @endif
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <div class="flex items-center">
                    <input type="hidden" name="published" value="0">
                    <input type="checkbox" name="published" id="published" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" {{ old('published', $berita->published) ? 'checked' : '' }}>
                    <label for="published" class="ml-2 block text-sm text-gray-700">Published</label>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                    Update Berita
                </button>
                <a href="{{ route('admin.berita.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-6 rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
    <script>
        tinymce.init({
            selector: '#content',
            height: 400,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic forecolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>
@endsection