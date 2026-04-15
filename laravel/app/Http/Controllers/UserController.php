<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\User;

class UserController extends Controller
{
    public function show($user_id)
    {
        return User::findOrFail($user_id);
    }

    public function favourites($user_id)
    {
        return Favourite::where('user_id', $user_id)->get();
    }
}
