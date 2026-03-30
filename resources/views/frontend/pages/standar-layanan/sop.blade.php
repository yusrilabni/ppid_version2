@extends('frontend.layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :breadcrumbs="[
                ['title' => 'Beranda', 'url' => route('home')],
                ['title' => 'Standar Layanan', 'url' => '#'],
                ['title' => 'SOP', 'url' => request()->fullUrl()]
            ]" />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold">SOP</h1>
                    <p class="mt-4">This is a placeholder page for the menu item.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
