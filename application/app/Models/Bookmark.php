<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;
    protected $guarded= ['id'];

    public function bookmark_post(){
        return $this->belongsTo(Post::class);
    }

    public function bookmark_user(){
        return $this->belongsTo(User::class);
    }

}
