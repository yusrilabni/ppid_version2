@extends('frontend.layouts.app')

@section('title', 'Debug User')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Debug User Information</h1>
        @if ($user)
            <pre class="bg-gray-100 p-4 rounded">{{ print_r($user->toArray(), true) }}</pre>
        @else
            <p>No user is logged in.</p>
        @endif
    </div>
</div>
@endsection
