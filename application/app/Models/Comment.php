<?php

namespace App\Models;

use App\Models\Post;
use App\Models\CommentVote;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeType($type)
    {

        return $this->where('type', '=', $type);
    }

    public function comments()
    {

        return $this->hasMany(Comment::class, 'parent_comment_id', 'id');
    }

    public function votes()
    {
        return $this->hasMany(CommentVote::class);
    }

    public function nested_comments_count()
    {
        if ($this->comments->count() > 0) {
            return $this->reply_count($this->comments);
        }
        return 0;
    }

    private function reply_count($comments)
    {
        $count = $comments->count();
        foreach ($comments as $comment) {
            $replay_comment = Comment::with('user', 'comments')->find($comment->id);
            if ($replay_comment) {
                if ($replay_comment->comments->count() > 0) {
                    $count += $this->reply_count($replay_comment->comments);
                }
            }
        }
        return $count;
    }

    public function deleteComments($comment, $count = 0)
    {

        if ($comment->comments->count() > 0) {
            foreach ($comment->comments as $comment) {
                $comment = Comment::with('comments')->find($comment->id);
                if ($comment->comments->count() > 0) {
                    $count = $this->deleteComments($comment, $count);
                }
                $count = $count + 1;
                $comment->comments->each->delete();
                $comment->delete();
                $comment->votes->each->delete();
            }
        }

        return $count;
    }
}
