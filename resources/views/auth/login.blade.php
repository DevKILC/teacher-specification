<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input-auth id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input-auth id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class=" mt-4 flex justify-between">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

            </div>
           
            <div class="flex flex-col gap-3 items-center w-full mt-4">
                <x-button class="flex justify-center items-center w-full">
                    {{ __('Log in') }}
                </x-button>
            </form>
                <p class="text-[10px]">Or Login With</p>
                
                <a href="{{ route('auth.google', ['provider' => 'google']) }}" class="w-full flex items-center justify-center border border-blue-600 text-blue-600 py-2 bg-transparent rounded-md hover:bg-blue-600 hover:text-white transition-colors">
                    <!-- Google Logo SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 mb-0.5" viewBox="0 0 48 48">
                        <path fill="#4285F4" d="M24 9.5c3.9 0 6.8 1.6 8.4 3l6.1-6.1C34.9 3.6 29.9 1 24 1 14.9 1 7.1 6.7 4.5 14.2l7.2 5.6C13.4 13.1 18.2 9.5 24 9.5z"/>
                        <path fill="#34A853" d="M46.5 24.6c0-1.5-.2-3.2-.4-4.6H24v9.1h12.7c-.6 3.1-2.3 5.6-4.8 7.3l7.4 5.7c4.4-4.1 7.2-10.3 7.2-17.5z"/>
                        <path fill="#FBBC05" d="M11.7 27.3c-.7-2.1-1.1-4.4-1.1-6.8s.4-4.7 1.1-6.8L4.5 8C1.8 13.1 0 18.8 0 24.5s1.8 11.4 4.5 16.5l7.2-5.6z"/>
                        <path fill="#EA4335" d="M24 48c6.5 0 11.9-2.1 15.8-5.8l-7.4-5.7c-2.1 1.5-4.9 2.4-8.4 2.4-5.8 0-10.6-3.6-12.5-8.7L4.5 40.5C7.1 45.8 14.9 51.5 24 51.5z"/>
                    </svg>
                    {{ __('Continue with Google') }}
                </a>
                
            </div>
            

      
    </x-authentication-card>
</x-guest-layout>
