<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'object',
        'social_link' => 'object',
        'ver_code_send_at' => 'datetime',
        
    ];


    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function experience()
    {
        return $this->hasMany(Experience::class);
    }

    public function all_post_comments_count()
    {
        $posts = $this->posts;
        $count = 0;
        foreach ($posts  as  $post) {
            $count +=  $post->comments->count();
        }
        return $count;
    }

    public function total_topic()
    {
        return $this->posts->pluck('category_id')->unique()->count();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id', 'desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status', '!=', 0);
    }

    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn () => $this->firstname || $this->lastname ? $this->firstname . ' ' . $this->lastname : '@' . $this->username,
        );
    }

    // SCOPES
    public function scopeActive()
    {
        return $this->where('status', 1);
    }

    public function scopeBanned()
    {
        return $this->where('status', 0);
    }

    public function scopeEmailUnverified()
    {
        return $this->where('ev', 0);
    }

    public function scopeMobileUnverified()
    {
        return $this->where('sv', 0);
    }

    public function scopeEmailVerified()
    {
        return $this->where('ev', 1);
    }

    public function scopeMobileVerified()
    {
        return $this->where('sv', 1);
    }


}
