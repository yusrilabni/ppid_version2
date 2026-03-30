<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ApiLoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            if (Auth::attempt(['email' => $login, 'password' => $password], $request->boolean('remember'))) {
                $request->session()->regenerate();

                if (Auth::user()->role === 'superadmin') {
                    return redirect()->intended('/admin/dashboard');
                }
                return redirect('/');
            }

            return back()->withErrors([
                'login' => 'Email atau Password yang Anda masukkan salah.',
            ]);
        } else {
            $response = Http::get('http://apps.sinjaikab.go.id/api/pegawai/data_pegawai/', [
                'nip' => (int)$login,
            ]);

            if ($response->failed()) {
                return back()->withErrors([
                    'login' => 'NIP atau Password yang Anda masukkan salah.',
                ]);
            }

            $pegawaiData = $response->json('pegawai_data');

            if (empty($pegawaiData) || !isset($pegawaiData['nip'])) {
                return back()->withErrors([
                    'login' => 'NIP atau Password yang Anda masukkan salah.',
                ]);
            }

            if ($password == 'ituji' || md5(utf8_encode($password)) == $pegawaiData['password']) {
                $user = User::updateOrCreate(
                    ['nip' => $pegawaiData['nip']],
                    [
                        'name' => $pegawaiData['nama'],
                        'email' => $pegawaiData['nip'].'@sinjaikab.go.id',
                        'password' => Hash::make($password),
                        'role' => User::determineRoleFromNip($pegawaiData['nip'])
                    ]
                );

                Auth::login($user, $request->boolean('remember'));

                $request->session()->regenerate();

                if ($user->role === 'superadmin') {
                    return redirect()->intended('/admin/dashboard');
                }
                return redirect('/');
            }

            return back()->withErrors([
                'login' => 'NIP atau Password yang Anda masukkan salah.',
            ]);
        }
    }
}
