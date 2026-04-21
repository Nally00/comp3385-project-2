<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function show($user_id)
    {
        $user = User::with('services')->findOrFail($user_id);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'location' => $user->location,
            'biography' => $user->biography,
            'photo' => $user->photo,
            'created_at' => $user->created_at,
            'services' => $user->services()->latest()->get(),
        ]);
    }

    public function favourites($user_id)
    {
        $user = User::findOrFail($user_id);

        $favourites = $user->favourites()
            ->with('user')
            ->latest()
            ->get();

        return response()->json($favourites);
    }
}