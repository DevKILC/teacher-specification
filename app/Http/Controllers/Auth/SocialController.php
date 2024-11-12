<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SocialController extends Controller
{
    // Redirect to the OAuth provider for social login
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Handle the OAuth provider callback and log the user in
    public function handleProviderCallback($provider)
    {
        try {
            // Ambil data user dari provider menggunakan Socialite
            $socialUser = Socialite::driver($provider)->stateless()->user();
            $email = $socialUser->getEmail();

            if (!$email) {
                return redirect('/login')->with('error', 'Email is required from provider.');
            }
    
            // Kirim request ke API eksternal
            $response = Http::post(config('api.API_BASE_LOGIN_URL_GOOGLE'), [
                'email' => $email,
                'token_fcm' => 'web',
                'password' => $socialUser->getId()
            ]);

            //  return (array) $socialUser;

       $user = $response->json();
        session(['user' => $user]);
    
            if ($user['success'] == true) {
                $data = $user['message'];
    
                $existingUser = User::where('email', $data['email'])->first();
    
                if ($existingUser) {
                    Auth::login($existingUser);
                } else {
                    $newUser = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'profile_photo_path' => $data['img_url'],
                        'password' => bcrypt(Str::random(16)),
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                    ]);
    
                    Auth::login($newUser);
                }
    
                // Redirect ke dashboard dengan pesan sukses
                return redirect('/dashboard')->with('success', 'Login successful!');
            } else {
                return redirect('/login')->with('error', 'No account associated with this Google account.');
            }
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'An error occurred during login: ' . $e->getMessage());
        }
    }
}    