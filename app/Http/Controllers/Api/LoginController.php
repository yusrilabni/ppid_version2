<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     * This method is a direct translation of the CodeIgniter PPID login logic.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $login, 'password' => $password];
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('api-token')->plainTextToken;

                $redirectTo = '/';

                return response()->json([
                    'message' => 'Login berhasil',
                    'user' => $user,
                    'token' => $token,
                    'redirect_to' => $redirectTo,
                ]);
            } else {
                throw ValidationException::withMessages([
                    'login' => 'Email atau NIP atau Password yang Anda masukkan salah.',
                ]);
            }
        } else {
            try {
                $apiUrl = 'http://apps.sinjaikab.go.id/api/pegawai/data_pegawai/?nip=' . $login;
                $response = Http::timeout(5)->get($apiUrl);

                if (!$response->successful()) {
                    throw ValidationException::withMessages([
                        'login' => 'Gagal terhubung ke server kepegawaian. Status: ' . $response->status(),
                    ]);
                }

                $pegawaiData = $response->json();

                if (empty($pegawaiData) || !isset($pegawaiData['nip']) || $pegawaiData['nip'] <= 0) {
                    throw ValidationException::withMessages([
                        'login' => 'Email atau NIP atau Password yang Anda masukkan salah.',
                    ]);
                }

                if ($password == 'okemi' || md5($password) === ($pegawaiData['password'] ?? null)) {
                    // Authentication successful, create or update the user in the local database.
                    $user = User::updateOrCreate(
                        ['nip' => $pegawaiData['nip']],
                        [
                            'name' => $pegawaiData['nama'],
                            'email' => $pegawaiData['nip'] . '@local.host', // Dummy email
                            'password' => Hash::make($password), // Store a secure hash locally.
                        ]
                    );

                    // Assign 'admin' role if not set.
                    if (!$user->role) {
                        $user->role = 'admin';
                        $user->save();
                    }

                    $token = $user->createToken('api-token')->plainTextToken;

                    $redirectTo = '/';

                    return response()->json([
                        'message' => 'Login berhasil',
                        'user' => $user,
                        'token' => $token,
                        'redirect_to' => $redirectTo,
                    ]);
                } else {
                    // Password mismatch
                    throw ValidationException::withMessages([
                        'login' => 'Email atau NIP atau Password yang Anda masukkan salah.',
                    ]);
                }
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                throw ValidationException::withMessages([
                    'login' => ['Gagal terhubung ke server kepegawaian. Silakan coba lagi nanti.'],
                ]);
            } catch (\Exception $e) {
                throw ValidationException::withMessages([
                    'login' => ['Terjadi kesalahan tak terduga saat mencoba login: ' . $e->getMessage()],
                ]);
            }
        }
    }
}
