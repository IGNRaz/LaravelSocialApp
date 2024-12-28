<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'usernames',
        'userage',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',

        ];
        
    }

    public function following(){
        return $this->belongsToMany(User::class, 'followers_users', 'follower_id', 'user_id')->withTimestamps();
    }

    public function followers(){
        return $this->belongsToMany(User::class, 'followers_users', 'user_id', 'follower_id')->withTimestamps();

    }

    public function follows(User $user){ 
        return $this->following()->where('user_id', $user->id)->exists();
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function comments()
{
    return $this->hasMany(Comment::class);
}

}
