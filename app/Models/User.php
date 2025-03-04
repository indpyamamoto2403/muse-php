<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
        'profile_photo_path',
        'occupation',
        'self_introduction',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = [
        'icon_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    /**
     * ユーザーは沢山のアート作品を投稿するので
     * @return void
     */
    public function art()
    {
        return $this->hasMany(Art::class);
    }
    
    public function likes()
    {
        return $this->hasMany(Art::class, 'likes');
    }

    public function saves()
    {
        return $this->hasMany(Art::class, 'saves');
    }

    /**
     * @param \Illuminate\Http\UploadedFile $photo
     * @return void
     */
    public function getIconUrlAttribute()
    {
        return $this->profile_photo_path
            ? asset(Storage::url($this->profile_photo_path))
            : asset(Storage::url('profile-photos/default.png'));
    }


}
