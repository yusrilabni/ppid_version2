@extends('frontend.layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Profile', 'url' => request()->fullUrl(), 'icon' => 'fas fa-user']
        ]" />
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div>
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>


    </div>
</div>
@endsection
