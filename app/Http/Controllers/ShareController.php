<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Share;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function store(Post $post)
    {
        // Check if the user has already shared the post
        if ($post->shares()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already shared this post.');
        }

        // Create a new share
        $share = new Share();
        $share->user_id = auth()->id();
        $post->shares()->save($share);

        return back()->with('success', 'Post shared successfully.');
    }
}