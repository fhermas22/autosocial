<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-red-700 leading-tight">
            {{ __('Tableau de Bord Administrateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- 1. Key Statistics (Dynamics) --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border-l-4 border-red-500">
                <h3 class="text-xl font-bold text-red-700 mb-6">Statistiques Clés</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    {{-- Slot for dynamic data --}}
                    {!! $stats !!}
                </div>
            </div>

            {{-- 2. User Management --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border-l-4 border-autosocial-primary">
                <h3 class="text-xl font-bold text-autosocial-primary mb-6">Gestion des Utilisateurs</h3>

                {{-- Slot for the user list --}}
                {!! $users_list !!}
            </div>

            {{-- 3. Post Management --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border-l-4 border-autosocial-secondary">
                <h3 class="text-xl font-bold text-autosocial-secondary mb-6">Gestion des Posts</h3>

                {{-- Slot for the list of posts --}}
                {!! $posts_list !!}
            </div>

            {{-- 4. Quick Administration Tools --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border-l-4 border-gray-400">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Outils d'Administration Rapides</h3>
                <div class="space-y-3">
                    <p>Pour créer un nouvel administrateur : <code class="bg-gray-100 p-1 rounded">php artisan user:make-admin [email]</code></p>
                    <p>Pour lancer manuellement le check-in IA : <code class="bg-gray-100 p-1 rounded">php artisan ai:checkin</code></p>
                    <p>Pour seeder de nouveaux utilisateurs IA : <code class="bg-gray-100 p-1 rounded">php artisan seed:ai-users 10</code></p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
