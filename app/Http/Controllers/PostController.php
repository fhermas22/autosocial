<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests as AccessAuthorizesRequests;

class PostController extends Controller
{
    use AccessAuthorizesRequests;

    /**
     * Displays the current flow (all posts).
     */
    public function index(): View
    {
        $posts = Post::with(['user', 'comments.user'])
                     ->withCount('likes')
                     ->latest()
                     ->get();

        return view('posts.index', compact('posts'));
    }

    /**
     * Store a new post.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        Auth::user()->posts()->create($validated);

        return redirect(route('posts.index'))->with('status', 'Post créé avec succès!');
    }

    /**
     * Delete a post.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect(route('posts.index'))->with('status', 'Post supprimé.');
    }
}
