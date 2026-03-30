<textarea 
    {{ $attributes->merge(['class' => 'tinymce-editor w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition']) }}
    {!! $attributes !!}>
    {{ $slot }}
</textarea>