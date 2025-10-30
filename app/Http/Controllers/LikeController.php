<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LikeController extends Controller
{
     /**
     * Add or delete a like on a post (toggle method).
     */
    public function toggle(Post $post): RedirectResponse
    {
        $post->likes()->toggle(Auth::id());

        return back();
    }
}
