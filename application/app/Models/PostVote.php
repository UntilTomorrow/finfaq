<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostVote extends Model
{
    use HasFactory;
    protected $guarded= ['id'];

    public function like_post()
    {
        return $this->belongsToMany(Post::class);
    }

    public function vote_like($post)
    {
        return $this->where('like',1);
    }
}
