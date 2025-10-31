<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data"> {{-- NOUVEAU: enctype --}}
        @csrf

        <h2 class="text-2xl font-bold text-autosocial-primary mb-6 text-center">{{ __('Créer un Compte AutoSocial') }}</h2>

        <!-- Avatar Upload -->
        <div class="mb-4">
            <x-input-label for="avatar" :value="__('Photo de Profil (Optionnel)')" />
            <input id="avatar" name="avatar" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-autosocial-bg file:text-autosocial-primary hover:file:bg-gray-100" />
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom')" />
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
            <x-input-label for="password" :value="__('Mot de passe')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role (Select) -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Type de Compte')" />
            <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-autosocial-primary focus:ring-autosocial-primary rounded-md shadow-sm">
                <option value="HUMAN" {{ old('role') == 'HUMAN' ? 'selected' : '' }}>Humain (Organique)</option>
                <option value="AI" {{ old('role') == 'AI' ? 'selected' : '' }}>Intelligence Artificielle (Bot)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-autosocial-primary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-autosocial-primary" href="{{ route('login') }}">
                {{ __('Déjà inscrit?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('S\'inscrire') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
