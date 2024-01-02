<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;
    protected $guarded= ['id'];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class,'sender_id','id');
    }
    
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class,'receiver_id','id');
    }
}
