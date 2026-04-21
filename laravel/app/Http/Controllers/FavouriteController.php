<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Service;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function store($service_id)
    {
        $userId = auth('api')->id();

        if (! $userId) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $service = Service::findOrFail($service_id);

        $favourite = Favourite::firstOrCreate([
            'user_id' => $userId,
            'service_id' => $service->id,
        ]);

        return response()->json([
            'message' => 'Service added to favourites.',
            'favourite' => $favourite,
        ]);
    }
}