<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

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

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('lang.switch', app()->getLocale() == 'fr' ? 'en' : 'fr') }}" 
                   class="me-4 px-3 py-1 border border-gray-300 rounded text-sm font-bold text-gray-600 hover:bg-gray-100 transition mr-3">
                    {{ app()->getLocale() == 'fr' ? 'EN' : 'FR' }}
                </a>
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>


{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Connexion - RetinaScan</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-white">

    <div class="min-h-screen w-full flex">

        <div class="hidden lg:flex w-1/2 bg-blue-600 relative items-center justify-center overflow-hidden">
            
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-700"></div>
            
            <div class="absolute top-0 -left-20 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 -right-20 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-32 left-20 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

            <svg class="absolute bottom-0 left-0 w-full text-white opacity-10" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" fill-opacity="1" d="M0,64L48,80C96,96,192,128,288,128C384,128,480,96,576,90.7C672,85,768,107,864,122.7C960,139,1056,149,1152,133.3C1248,117,1344,75,1392,53.3L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>

            <div class="relative z-10 text-center px-12 text-white">
                <div class="mb-8 flex justify-center">
                     <x-application-logo class="w-24 h-24 fill-current text-white" />
                </div>
                <h1 class="text-5xl font-bold tracking-tight mb-4">Content de vous revoir !</h1>
                <p class="text-blue-100 text-lg font-light leading-relaxed">
                    Accédez à votre espace de diagnostic assisté par IA.<br>
                    La précision au service de vos patients.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-24 bg-white">
            <div class="w-full max-w-md space-y-8">
                
                <div class="text-left mb-10">
                    <h2 class="text-3xl font-bold text-gray-900">Connexion</h2>
                    <p class="mt-2 text-sm text-gray-500">Veuillez saisir vos identifiants pour continuer.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required autofocus
                            class="block w-full px-5 py-4 bg-gray-50 border border-transparent rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="docteur@exemple.com"
                            value="{{ old('email') }}">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full px-5 py-4 bg-gray-50 border border-transparent rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer">
                                Se souvenir de moi
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-bold text-blue-600 hover:text-blue-500">
                                    Mot de passe oublié ?
                                </a>
                            </div>
                        @endif
                    </div>

                    <button type="submit" 
                        class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-1">
                        SE CONNECTER
                    </button>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Pas encore de compte ? 
                            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-500">
                                Créer un compte
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</body>
</html> --}}
