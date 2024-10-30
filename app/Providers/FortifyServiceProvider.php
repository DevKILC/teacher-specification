<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

    


        Fortify::authenticateUsing(function (Request $request) {
            
            // call api to authenticate user
            $response = Http::post(config('api.API_BASE_LOGIN_URL'), [
                'email' => $request->email,
                'password' => $request->password,
                'token_fcm' => 'web'
            ]);

            $user = $response->json();

            if($user['success'] == true) {
                $data = $user['message'];

                $existingUser = User::where('email', $data['email'])->first();

                if ($existingUser) {
                    return $existingUser;
                } else {
                    $newUser = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'profile_photo_path' => $data['img_url'],  // Adjust to profile_photo_path if you store it
                        'password' => bcrypt(Str::random(16)), // Generate a random password
                    ]);


                    return $newUser;
                }
            }

            return null;
        });
    }
}
