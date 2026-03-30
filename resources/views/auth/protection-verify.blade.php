<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Verifikasi Proteksi Login - {{ config('app.name', 'Laravel') }}</title>

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
                        <i data-lucide="shield-alert" class="h-6 w-6 text-white"></i>
                    </div>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        {{ __('Verifikasi Proteksi') }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ __('Akses ke sistem login memerlukan verifikasi tambahan') }}
                    </p>
                </div>

                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="p-6">
                        <h2 class="text-center text-xl font-semibold mb-4">{{ __('Verifikasi Proteksi Login') }}</h2>

                        <p class="text-gray-600 text-center mb-4">
                            {{ __('Akses ke sistem login memerlukan verifikasi tambahan. Silakan masukkan password proteksi untuk melanjutkan.') }}
                        </p>

                        @if(session('error'))
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.protection.verify.post') }}" class="space-y-4">
                            @csrf

                            <div>
                                <label for="protection_password" class="block text-sm font-medium text-gray-700">{{ __('Password Proteksi') }}</label>
                                <input
                                    type="password"
                                    id="protection_password"
                                    name="protection_password"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('protection_password') border-red-500 @enderror"
                                    placeholder="{{ __('Masukkan password proteksi') }}"
                                >
                                @error('protection_password')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button
                                type="submit"
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700"
                            >
                                {{ __('Verifikasi & Lanjutkan') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            lucide.createIcons();
        </script>
    </body>
</html>