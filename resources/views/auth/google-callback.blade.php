<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Google Login Callback - {{ config('app.name', 'Laravel') }}</title>

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
                        <i data-lucide="check" class="h-6 w-6 text-white"></i>
                    </div>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        Login Successful
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Your API token is below.
                    </p>
                </div>

                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="p-6">
                        <h2 class="text-center text-xl font-semibold mb-4">API Token</h2>
                        <div class="bg-gray-100 rounded-md p-4 text-sm text-gray-700 break-all">
                            {{ request()->get('token') }}
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
