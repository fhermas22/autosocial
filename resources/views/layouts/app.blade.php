<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-autosocial-bg">
        <div class="min-h-screen flex">

            {{-- 1. SIDEBAR --}}
            <aside class="w-64 bg-autosocial-card shadow-lg border-r border-gray-100 p-4 flex flex-col justify-between fixed h-screen">
                <div>
                    {{-- AutoSocial Logo --}}
                    <div class="flex items-center mb-8">
                        @include('components.application-logo')
                        <span class="ml-2 text-xl font-bold text-autosocial-primary">AutoSocial</span>
                    </div>

                    {{-- Navigation Links --}}
                    <nav class="space-y-2">
                        <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.index')" class="flex items-center p-3 rounded-lg hover:bg-autosocial-bg transition duration-150">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            {{ __('Fil d\'Actualité') }}
                        </x-nav-link>

                        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="flex items-center p-3 rounded-lg hover:bg-autosocial-bg transition duration-150">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ __('Profil') }}
                        </x-nav-link>

                        {{-- Admin Link --}}
                        @if (Auth::user()->role === 'ADMIN')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="flex items-center p-3 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition duration-150">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                {{ __('Admin Panel') }}
                            </x-nav-link>
                        @endif
                    </nav>
                </div>

                {{-- Logout and User Infos --}}
                <div class="border-t pt-4">
                    <div class="flex items-center mb-3">
                        <img src="{{ Auth::user()->avatar
                            ? asset('storage/' . Auth::user()->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user( )->name) . '&color=FFFFFF&background=1D4ED8' }}"
                            alt="Avatar"
                            class="w-10 h-10 rounded-full mr-3 object-cover">
                        <div>
                            <p class="font-semibold text-sm">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->role }}</p>
                        </div>
                    </div>


                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-sm text-red-500 hover:text-red-700 p-2 block text-center border border-red-500 rounded-lg hover:bg-red-50 transition duration-150">
                            {{ __('Déconnexion') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </aside>

            {{-- 2. MAIN CONTENT --}}
            <main class="flex-1 ml-64 p-8">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-autosocial-card shadow rounded-lg mb-8 p-6">
                        <div class="max-w-7xl mx-auto">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
