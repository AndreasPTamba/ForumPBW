<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
  public function store(Request $request)
  {
    // Validate the incoming request data
    $validatedData = $request->validate([
      'post_id' => 'required|exists:posts,id',
      'content' => 'required|string|max:255',
    ]);

    // Create the reply using the Post model
    $reply = new Post();
    $reply->content = $validatedData['content'];
    $reply->user_id = auth()->id(); // Assuming you're using Laravel's authentication
    $reply->id_post = $validatedData['post_id']; // Assign the post_id

    // Save the reply to the database
    $reply->save();

    // Optionally, load relationships (likes, shares) if needed
    $reply->load('user', 'likes', 'shares');

    // Return JSON response with the newly created reply
    return response()->json([
        'success' => true,
        'reply' => $reply,
    ]);
  }
}
