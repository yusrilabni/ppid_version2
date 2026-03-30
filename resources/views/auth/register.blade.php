<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-g">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ __('Admin Register') }} - {{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <div class="text-center">
                    <div class="mx-auto h-12 w-12 bg-blue-600 rounded-full flex items-center justify-center">
                        <i data-lucide="user-plus" class="h-6 w-6 text-white"></i>
                    </div>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        {{ __('Create an Account') }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ __('to manage PPID content') }}
                    </p>
                </div>
                
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="p-6">
                        <h2 class="text-center text-xl font-semibold mb-4">{{ __('Register') }}</h2>
                        <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="{ showPassword: false }">
                            @csrf

                            @if ($errors->any())
                                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autofocus
                                    placeholder="{{ __('Your Name') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                />
                                @error('name')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    placeholder="{{ __('your@email.com') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                />
                                @error('email')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                                <div class="relative">
                                    <input
                                        id="password"
                                        :type="showPassword ? 'text' : 'password'"
                                        name="password"
                                        required
                                        autocomplete="new-password"
                                        placeholder="••••••••"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    />
                                    <button
                                        type="button"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                        @click="showPassword = !showPassword"
                                    >
                                        <template x-if="showPassword">
                                            <i data-lucide="eye-off" class="h-4 w-4 text-gray-400"></i>
                                        </template>
                                        <template x-if="!showPassword">
                                            <i data-lucide="eye" class="h-4 w-4 text-gray-400"></i>
                                        </template>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                />
                            </div>

                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                {{ __('Register') }}
                            </button>
                        </form>
                        
                        <div class="mt-6 relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">{{ __('Or') }}</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="{{ url('api/auth/google') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM5.13 6.83a6.5 6.5 0 018.74 0L10 10.17 5.13 6.83zM10 13.17L14.87 9.83a6.5 6.5 0 01-8.74 0L10 13.17zM3.5 10a6.5 6.5 0 013.33-5.61L10 8.17l3.17-3.78A6.5 6.5 0 0116.5 10h-3a3.5 3.5 0 00-7 0h-3z" clip-rule="evenodd" />
                                </svg>
                                {{ __('Register with Google') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            lucide.createIcons();
        </script>
    </body>
</html>