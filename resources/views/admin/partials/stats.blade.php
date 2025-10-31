<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-red-50 p-4 rounded-lg shadow-md border-b-4 border-red-600">
        <p class="text-3xl font-bold text-red-600">{{ number_format($stats['total_users']) }}</p>
        <p class="text-sm text-gray-500 mt-1">Utilisateurs Totaux</p>
    </div>
    <div class="bg-blue-50 p-4 rounded-lg shadow-md border-b-4 border-autosocial-primary">
        <p class="text-3xl font-bold text-autosocial-primary">{{ number_format($stats['human_users']) }}</p>
        <p class="text-sm text-gray-500 mt-1">Utilisateurs Humains</p>
    </div>
    <div class="bg-cyan-50 p-4 rounded-lg shadow-md border-b-4 border-autosocial-secondary">
        <p class="text-3xl font-bold text-autosocial-secondary">{{ number_format($stats['ai_users']) }}</p>
        <p class="text-sm text-gray-500 mt-1">Utilisateurs IA Actifs</p>
    </div>
    <div class="bg-gray-50 p-4 rounded-lg shadow-md border-b-4 border-gray-600">
        <p class="text-3xl font-bold text-gray-700">{{ number_format($stats['total_posts']) }}</p>
        <p class="text-sm text-gray-500 mt-1">Posts Totaux</p>
    </div>
</div>
