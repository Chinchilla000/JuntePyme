<x-guest-layout>
    <style>
        .auth-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
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

        @media (max-width: 768px) {
            .auth-card {
                padding: 1rem;
            }

            .auth-header h2 {
                font-size: 1.25rem;
            }

            .auth-footer a {
                font-size: 0.9rem;
            }

            .btn {
                width: 100%;
            }

            .btn + .btn {
                margin-top: 0.5rem;
            }
        }
    </style>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="auth-card">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="auth-header">
                <img src="{{ asset('assets/img/gallery/logo2.png') }}" alt="FullBigotes Logo">
                <h2>Regístrate</h2>
                <p>Crea una nueva cuenta ingresando tus datos.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                  type="password"
                                  name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ml-3">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="auth-footer">
                <p>¿Ya tienes una cuenta?</p>
                <a href="{{ route('login') }}">Inicia sesión aquí</a>
            </div>
        </div>
    </div>
</x-guest-layout>