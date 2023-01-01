<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function handleGoogleCallback()
    {
        // Retrieve the user's information from Google
        $googleUser = Socialite::driver('google')->stateless()->user();
        // Find or create the user in your database
        $user = User::where('email', $googleUser->email)->first();
        if ($user) {
            $data = User::firstOrCreate(['email' => $googleUser->email]);
        } else {
            $data = User::firstOrCreate(['email' => $googleUser->email, 'name' => $googleUser->name, 'password' => Hash::make('cctvSemarang987')]);
        }

        // Log the user in
        Auth::login($data);

        // Redirect the user to the dashboard
        return redirect()->route('dashboard');
    }
    public function handleProvideCallback($provider)
    {
        try {

            $user = Socialite::driver($provider)->stateless()->user();
        } catch (Exception $e) {
            return redirect()->back();
        }
        // find or create user and send params user get from socialite and provider
        $authUser = $this->findOrCreateUser($user, $provider);

        // login user
        Auth()->login($authUser, true);

        // setelah login redirect ke dashboard
        return redirect()->route('dashboard');
    }
}
