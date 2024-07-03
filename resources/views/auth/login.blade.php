<x-guest-layout>
    <style>
        .auth-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-header img {
            max-width: 150px;
            margin-bottom: 1rem;
        }

        .auth-header h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .auth-footer {
            text-align: center;
            margin-top: 1rem;
        }

        .auth-footer a {
            color: #40E0D0;
            text-decoration: none;
            margin-top: 1rem;
            display: inline-block;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="auth-card">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="auth-header">
                <img src="{{ asset('assets/img/gallery/logo2.png') }}" alt="FullBigotes Logo">
                <h2>Iniciar Sesión</h2>
                <p>Bienvenido de nuevo, por favor ingresa tus credenciales.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="auth-footer">
                <p>¿No tienes una cuenta?</p>
                <a href="{{ route('register') }}">Regístrate aquí</a>
            </div>
        </div>
    </div>
</x-guest-layout>