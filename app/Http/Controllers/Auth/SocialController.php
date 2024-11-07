<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
            // Ambil data user dari provider menggunakan token
            $socialUser = Socialite::driver($provider)->stateless()->user();

            // Data dari Socialite yang digunakan untuk login
            $email = $socialUser->getEmail();
            $name = $socialUser->getName();
            $password = $socialUser->getPassword();
            $imgUrl = $socialUser->getAvatar();

            // Pastikan email ada
            if (!$email) {
                return response()->json(['error' => 'Email is required from provider.'], 422);
            }

            // Kirim HTTP POST request ke API eksternal untuk validasi login
            $response = Http::post(config('api.API_BASE_LOGIN_URL_GOOGLE'), [
                'email' => $email,
                'password' => 'defaultpassword', // Bisa menyesuaikan jika diperlukan atau kosongkan untuk login berbasis OAuth
                'token_fcm' => 'web' // Token FCM bisa diambil dari request atau diberikan default
            ]);

            // Parse response API
            $user = $response->json();

            // Simpan data user ke session jika perlu
            session(['user' => $user]);

            // Jika login berhasil dari API
            if ($user['success'] == true) {
                $data = $user['message'];

                // Simpan data user ke dalam session (gunakan API data)
                session(['user_data' => $data]);

                // Login dengan token dari API jika tersedia
                $apiToken = $data['api_token'] ?? null;

                // Redirect ke dashboard atau halaman yang sesuai dengan API token
                return redirect('/dashboard')->with('token', $apiToken);
            } else {
                // Jika user tidak ditemukan, arahkan kembali ke halaman login dengan error
                return redirect('/login')->with('error', 'No account associated with this email.');
            }


            // Jika API login gagal
            return redirect('/login')->with('error', 'Login failed. Please try again.');
        } catch (\Exception $e) {
            // Tangani jika terjadi error
            return redirect('/login')->with('error', 'An error occurred during login: ' . $e->getMessage());
        }
    }
}
