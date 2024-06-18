<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    
    protected $fillable = ['title', 'content', 'user_id', 'id_post'];

    protected $casts = ['published_at' => 'datetime'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function shares(): HasMany
    {
        return $this->hasMany(Share::class);
    }

    public function replies()
    {
        return $this->hasMany(Post::class, 'id_post')->orderBy('created_at', 'asc');
    }
}
