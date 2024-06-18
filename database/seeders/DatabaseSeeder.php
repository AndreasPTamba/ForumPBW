<?php

namespace Database\Seeders;

use App\Models\Like;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Share;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create main user
        $mainUser = User::factory()->create([
            'name' => 'Andreas Kurniawan',
            'email' => 'andre@gmail.com'
        ]);

        // Create additional users
        $users = User::factory(5)->create();

        // Combine all users including main user
        $allUsers = $users->concat([$mainUser]);

        $allPosts = collect();
        // Create top-level posts
        $posts = Post::factory(10)->create([
            'user_id' => $allUsers->random()->id,
            'id_post' => 0 // Set id_post to 0 for top-level posts
        ]);
        
        $allPosts = $allPosts->concat($posts);
        // Create replies with valid user_ids and id_post referencing existing top-level posts
        $replies = Post::factory(20)->make()->each(function ($reply) use ($allUsers, $allPosts) {
            $reply->user_id = $allUsers->random()->id;
            $reply->id_post = $allPosts->random()->id; // Reference any top-level post from $allPosts
            $reply->save();
            $allPosts->push($reply);
        });
    
        // Create likes with valid user_ids and post_ids
        $likes = Like::factory(40)->make()->each(function ($like) use ($allUsers, $allPosts) {
            $like->user_id = $allUsers->random()->id;
            $like->post_id = $allPosts->random()->id;
            $like->save();
        });
    
        // Create shares with valid user_ids and post_ids
        $shares = Share::factory(30)->make()->each(function ($share) use ($allUsers, $allPosts) {
            $share->user_id = $allUsers->random()->id;
            $share->post_id = $allPosts->random()->id;
            $share->save();
        });
    
        // Debugging: Check if users are created
        echo "Users Created: " . $allUsers->count() . "\n";
    
        // Debugging: Print out the post count
        echo "Total Posts Created: " . Post::count() . "\n";
    
        echo "Total Replies Created: " . $replies->count() . "\n";
    }
}