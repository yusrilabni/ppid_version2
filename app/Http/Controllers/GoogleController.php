<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        $driver = Socialite::driver('google');
        $driver->setHttpClient(new \GuzzleHttp\Client([
            'force_ip_resolve' => 'v4',
            'curl' => [
                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            ],
            'timeout' => 15,
            'connect_timeout' => 10,
        ]));
        return $driver->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $driver = Socialite::driver('google');
            $driver->setHttpClient(new \GuzzleHttp\Client([
                'force_ip_resolve' => 'v4',
                'curl' => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                ],
                'timeout' => 15,
                'connect_timeout' => 10,
            ]));
            $user = $driver->user();

            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){
                Auth::login($finduser);
                return redirect()->intended('dashboard');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => Hash::make('password')
                ]);

                Auth::login($newUser);
                return redirect()->intended('dashboard');
            }

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong or You have rejected the app!');
        }
    }
}