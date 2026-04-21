<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'rate',
        'rate_type',
        'photo',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}