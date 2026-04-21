<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'location',
        'biography',
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function favourites()
    {
        return $this->belongsToMany(Service::class, 'favourites', 'user_id', 'service_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}