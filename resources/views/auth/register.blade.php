<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Auth PPID - Register</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('storage/logo/favicon_io/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" type="image/webp" href="{{ asset('storage/logo/favicon_io/ppid.webp') }}">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #eef2f7, #dbe5f1);
            min-height: 100vh;
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 55px rgba(0, 0, 0, .08);
            padding: 1.2rem 2.5rem 2.6rem;
        }

        .ppid-logo {
            display: block;
            height: 210px;
            width: auto;
            margin: 0 auto -50px;
            line-height: 0;
        }

        .login-title {
            margin: 0;
            padding: 0;
            line-height: 1.05;
        }

        .input-field {
            border: 2px solid #e5e7eb;
            padding-left: 44px;
            padding-right: 44px;
            transition: .2s;
        }

        .input-field:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .15);
            outline: none;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }

        .btn-login {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            transition: .25s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, .35);
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
        }
    </style>
</head>

<body class="antialiased">

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            <div class="login-card">

                <!-- HEADER -->
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/logo/Logo PPID With Caption.png') }}" alt="PPID" class="ppid-logo"
                        fetchpriority="high" loading="eager"
                        onerror="this.onerror=null; this.src='{{ asset('storage/logo/ppid.webp') }}'">

                    <h1 class="login-title text-2xl font-bold text-gray-800">
                        BUAT AKUN
                    </h1>

                    <p class="text-gray-600 text-sm mt-1">
                        Daftar sebagai pemohon informasi publik
                    </p>
                </div>

                <!-- ERRORS -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" x-data="{ show: false, showConfirm: false }" class="space-y-5">
                    @csrf

                    <!-- NAME -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <span class="input-icon"><i data-lucide="user"></i></span>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                class="input-field w-full py-2.5 rounded-lg" placeholder="Masukkan nama lengkap">
                        </div>
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <span class="input-icon"><i data-lucide="mail"></i></span>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="input-field w-full py-2.5 rounded-lg" placeholder="Masukkan email aktif">
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kata Sandi</label>
                        <div class="relative">
                            <span class="input-icon"><i data-lucide="lock"></i></span>
                            <input :type="show ? 'text' : 'password'" name="password" required
                                class="input-field w-full py-2.5 rounded-lg" placeholder="Buat kata sandi">
                            <span class="password-toggle" @click="show = !show">
                                <i x-show="!show" data-lucide="eye" class="w-4 h-4"></i>
                                <i x-show="show" data-lucide="eye-off" class="w-4 h-4"></i>
                            </span>
                        </div>
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Sandi</label>
                        <div class="relative">
                            <span class="input-icon"><i data-lucide="shield-check"></i></span>
                            <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                                class="input-field w-full py-2.5 rounded-lg" placeholder="Ulangi kata sandi">
                            <span class="password-toggle" @click="showConfirm = !showConfirm">
                                <i x-show="!showConfirm" data-lucide="eye" class="w-4 h-4"></i>
                                <i x-show="showConfirm" data-lucide="eye-off" class="w-4 h-4"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn-login w-full text-white py-3 rounded-lg font-bold mt-2 shadow-lg">
                        Daftar Akun Baru
                    </button>
                </form>

                <div class="mt-7 text-center">
                    <p class="text-sm text-gray-600 mb-3">Sudah punya akun?</p>
                    <a href="{{ route('login') }}"
                        class="block w-full py-3 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition font-medium">
                        Kembali ke Login
                    </a>
                </div>

            </div>

            <p class="text-center text-xs text-gray-600 mt-6">
                © {{ date('Y') }} PPID – {{ config('app.name') }}
            </p>

        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>

</body>

</html>
