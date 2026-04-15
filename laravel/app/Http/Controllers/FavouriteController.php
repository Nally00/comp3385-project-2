<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function store($service_id)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $favourite = Favourite::create([
            'service_id' => $service_id,
            'user_id' => $user->id,
        ]);

        return response()->json($favourite, 201);
    }
}
