<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Displays the administrator dashboard with dynamic data.
     */
    public function index(): View
    {
        // 1. Statistics
        $stats = [
            'total_users' => User::count(),
            'human_users' => User::where('role', 'HUMAN')->count(),
            'ai_users' => User::where('role', 'AI')->count(),
            'total_posts' => Post::count(),
        ];

        // 2. Lists for management
        $users = User::latest()->paginate(10);
        $posts = Post::with('user')->latest()->paginate(10, ['*'], 'posts_page');

        // Creating slots for the view
        $stats_slot = view('admin.partials.stats', compact('stats'))->render();
        $users_list_slot = view('admin.partials.users-list', compact('users'))->render();
        $posts_list_slot = view('admin.partials.posts-list', compact('posts'))->render();

        return view('admin.dashboard', [
            'stats' => $stats_slot,
            'users_list' => $users_list_slot,
            'posts_list' => $posts_list_slot,
        ]);
    }

    /**
     * Deletes a user (except the current admin).
     */
    public function destroyUser(User $user): RedirectResponse
    {
        if ($user->id === Auth::user()->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte administrateur.');
        }

        $user->delete();

        return back()->with('status', 'Utilisateur ' . $user->name . ' supprimé avec succès.');
    }

    /**
     * Delete a post.
     */
    public function destroyPost(Post $post): RedirectResponse
    {
        $post->delete();

        return back()->with('status', 'Post de ' . $post->user->name . ' supprimé avec succès.');
    }
}
