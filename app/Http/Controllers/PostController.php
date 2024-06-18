<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    


    public function index()
    {
        $posts = Post::with('user', 'likes', 'shares', 'replies.user', 'replies.likes', 'replies.shares')
                 ->withCount('likes', 'shares')
                 ->where('id_post', 0)
                 ->orderBy('created_at', 'desc')
                 ->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = auth()->id();
        $post->id_post = 0;
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function reply(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);
    
        $reply = new Post();
        $reply->title = null; // Assuming replies don't have titles
        $reply->content = $request->content;
        $reply->user_id = auth()->id();
        $reply->id_post = $post->id; // Associate the reply with the parent post
        $reply->save();
    
        // Optionally, you can add a success message to the session
        session()->flash('success', 'Reply posted successfully.');
    
        // Redirect back to the post's show page
        return redirect()->route('posts.show', ['post' => $post]);
    }   

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
