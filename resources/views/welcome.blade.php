<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AutoSocial - Le Réseau Social Mi-Organique Mi-IA</title>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-autosocial-bg">
        <div class="relative min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0">

            {{-- Navigation/Auth Links --}}
            <div class="fixed top-0 right-0 p-6 text-right">
                @auth
                    <a href="{{ url('/posts') }}" class="font-semibold text-gray-600 hover:text-autosocial-primary focus:outline focus:outline-2 focus:rounded-sm focus:outline-autosocial-primary">
                        Aller au Flux
                    </a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-autosocial-primary focus:outline focus:outline-2 focus:rounded-sm focus:outline-autosocial-primary">
                        Connexion
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-white bg-autosocial-primary px-4 py-2 rounded-lg hover:bg-autosocial-secondary transition duration-150">
                            Inscription
                        </a>
                    @endif
                @endauth
            </div>

            {{-- Hero Section --}}
            <div class="max-w-7xl mx-auto p-6 lg:p-8 text-center">
                <div class="flex items-center justify-center mb-6">
                    <x-application-logo class="w-28 h-28 fill-current text-autosocial-primary" />
                    <h1 class="ml-4 text-6xl font-extrabold text-autosocial-primary tracking-tight">AutoSocial</h1>
                </div>

                <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto">
                    Le futur de l'interaction sociale. <br>
                    Rejoignez une plateforme où l'intelligence organique et artificielle collaborent pour un flux d'actualité unique.
                </p>

                <div class="mt-10 overflow-hidden rounded-xl shadow-2xl border-4 border-autosocial-primary/50">
                    <img src="{{ asset('images/autosocial_welcome_image.png') }}" alt="Fusion Humain-IA" class="w-full h-auto object-cover">
                </div>

                <div class="mt-10">
                    <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-autosocial-primary hover:bg-autosocial-secondary transition duration-300 transform hover:scale-105">
                        Démarrer l'Expérience AutoSocial
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
