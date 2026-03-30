@props(['name'])

@php
    $words = explode(' ', $name);
    $initials = '';
    $wordCount = count($words);

    if ($wordCount === 4) {
        $limit = 3;
    } else {
        $limit = $wordCount;
    }

    for ($i = 0; $i < $limit; $i++) {
        $initials .= strtoupper(substr($words[$i], 0, 1));
    }
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center justify-center bg-gray-300 rounded-full text-white font-bold']) }}>
    {{ $initials }}
</div>
