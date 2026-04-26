<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favourite;
use App\Models\User;
use App\Models\Service;

class FavouriteSeeder extends Seeder
{
    public function run(): void
    {
        $jane = User::where('email', 'jane@gmail.com')->first();
        $alex = User::where('email', 'alex@gmail.com')->first();

        $photo = Service::where('title', 'Professional Event Photography')->first();
        $music = Service::where('title', 'Music Production')->first();
        $tutor = Service::where('title', 'Tutoring for Web Development')->first();
        $social = Service::where('title', 'Social Media Marketing')->first();


        Favourite::create([
            'user_id' => $jane->id,
            'service_id' => $photo->id,
        ]);

         Favourite::create([
            'user_id' => $jane->id,
            'service_id' => $tutor->id,
        ]);



        Favourite::create([
            'user_id' => $alex->id,
            'service_id' => $tutor->id,
        ]);

        Favourite::create([
            'user_id' => $alex->id,
            'service_id' => $music->id,
        ]);

        Favourite::create([
            'user_id' => $alex->id,
            'service_id' => $photo->id,
        ]);

        Favourite::create([
            'user_id' => $alex->id,
            'service_id' => $social->id,
        ]);

    }
}