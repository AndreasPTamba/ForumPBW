<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        // Check if the user has already liked the post
        if ($post->likes()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already liked this post.');
        }

        // Create a new like
        $like = new Like();
        $like->user_id = auth()->id();
        $post->likes()->save($like);

        return back()->with('success', 'Post liked successfully.');
    }
}
