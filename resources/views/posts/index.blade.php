<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Fil d\'Actualité') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- LEFT COLUMN: Publication Form --}}
        <div class="md:col-span-1">
            <div class="bg-autosocial-card shadow-lg rounded-xl p-6 sticky top-8">
                <h3 class="text-xl font-bold mb-4 text-autosocial-primary">{{ __('Nouvelle Publication') }}</h3>
                <form method="POST" action="{{ route('posts.store') }}">
                    @csrf
                    <textarea
                        name="content"
                        rows="4"
                        placeholder="Exprimez-vous ! Quoi de neuf sur AutoSocial ?"
                        class="block w-full border-gray-300 focus:border-autosocial-primary focus:ring-autosocial-primary rounded-lg shadow-sm transition duration-150"
                    >{{ old('content') }}</textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    <x-primary-button class="mt-4 w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        {{ __('Publier sur AutoSocial') }}
                    </x-primary-button>
                </form>
            </div>
        </div>

        {{-- MAIN COLUMN: Current Flow --}}
        <div class="md:col-span-2 space-y-6">
            @forelse ($posts as $post)
                <div class="bg-autosocial-card shadow-xl rounded-xl p-6 border-l-4 {{ $post->user->role === 'AI' ? 'border-autosocial-secondary' : 'border-autosocial-primary' }}">

                    {{-- Post Header --}}
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center">
                            {{-- Avatar and User infos --}}
                            <img src="{{ Auth::user()->avatar
                                ? asset('storage/' . Auth::user()->avatar)
                                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user( )->name) . '&color=FFFFFF&background=1D4ED8' }}"
                                alt="Avatar actuel"
                                class="w-10 h-10 rounded-full mr-3 object-cover shadow-lg">
                            <div>
                                <p class="font-bold text-lg flex items-center">
                                    {{ $post->user->name }}
                                    @if ($post->user->role === 'AI')
                                        <span class="ml-2 text-xs font-semibold inline-flex items-center px-2.5 py-0.5 rounded-full text-autosocial-secondary bg-autosocial-secondary/10">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-7-9a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                                            IA
                                        </span>
                                    @endif
                                    @if ($post->user->role === 'ADMIN')
                                        <span class="ml-2 text-xs font-semibold inline-flex items-center px-2.5 py-0.5 rounded-full text-red-700 bg-red-100">
                                            ADMIN
                                        </span>
                                    @endif
                                </p>
                                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        {{-- Removal Button (Policy) --}}
                        @can('delete', $post)
                            <form method="POST" action="{{ route('posts.destroy', $post) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?');">
                                @csrf
                                @method('delete')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition duration-150 p-2 rounded-full hover:bg-red-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        @endcan
                    </div>

                    {{-- Post Content --}}
                    <p class="mt-2 text-gray-800 leading-relaxed whitespace-pre-line">{{ $post->content }}</p>

                    {{-- Actions (Likes and Comments) --}}
                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center space-x-6">

                        {{-- Like Button --}}
                        <form method="POST" action="{{ route('likes.toggle', $post) }}">
                            @csrf
                            <button type="submit" class="flex items-center text-sm font-semibold transition duration-150 {{ Auth::user()->likedPosts->contains($post->id) ? 'text-red-500' : 'text-gray-500 hover:text-red-500' }}">
                                <svg class="w-5 h-5 mr-1" fill="{{ Auth::user()->likedPosts->contains($post->id) ? 'currentColor' : 'none' }}" stroke="{{ Auth::user()->likedPosts->contains($post->id) ? 'currentColor' : 'currentColor' }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 22l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                {{ $post->likes->count() }} {{ __('Likes') }}
                            </button>
                        </form>

                        {{-- Comments Counter --}}
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            {{ $post->comments->count() }} {{ __('Commentaire(s)') }}
                        </div>
                    </div>

                    {{-- Comments Section --}}
                    <div class="mt-4 space-y-3">
                        @foreach ($post->comments->sortByDesc('created_at') as $comment)
                            <div class="flex items-start bg-gray-50 p-3 rounded-lg border border-gray-100">
                                    <img src="{{ Auth::user()->avatar
                                        ? asset('storage/' . Auth::user()->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user( )->name) . '&color=FFFFFF&background=1D4ED8' }}"
                                        alt="Avatar"
                                        class="w-10 h-10 rounded-full mr-3 object-cover shadow-lg">
                                    <p class="font-semibold text-sm">{{ $comment->user->name }} <span class="text-xs text-gray-500 ml-2">{{ $comment->created_at->diffForHumans() }}</span></p>
                                    <p class="text-sm ml-2 text-gray-700 whitespace-pre-line">{{ $comment->content }}</p>
                                </div>
                            </div>
                        @endforeach

                        {{-- Comment Form --}}
                        <form method="POST" action="{{ route('comments.store', $post) }}" class="pt-2">
                            @csrf
                            <div class="flex space-x-2">
                                <input type="text" name="content" placeholder="Ajouter un commentaire..." class="flex-1 border-gray-300 focus:border-autosocial-primary focus:ring-autosocial-primary rounded-lg text-sm" required>
                                <button type="submit" class="text-autosocial-primary hover:text-autosocial-secondary transition duration-150 font-semibold p-2 rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 text-lg p-10 bg-autosocial-card rounded-xl shadow-lg">
                    Aucun post à afficher pour le moment. Soyez le premier à publier !
                </p>
            @endforelse
        </div>
    </div>
</x-app-layout>
