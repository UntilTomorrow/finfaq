<?php

namespace App\Models;

use App\Models\PostVote;
use App\Models\PostImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
 

    public function scopePending()
    {
        return $this->where('status', '=', 0);
    }

    public function scopeActive()
    {
        return $this->where('status', '=', 1);
    }

    public function scopeRejected()
    {
        return $this->where('status', '=', 2);
    }

    public function scopeViews()
    {
        return $this->where('views', '=', 1);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function apply_job()
    {
        return $this->hasMany(ApplyJob::class);
    }

    public function post_report()
    {
        return $this->hasMany(PostCommentReport::class);
    }

    public function votes()
    {
        return $this->hasMany(PostVote::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

}
