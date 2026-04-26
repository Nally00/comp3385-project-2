<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\User;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $jane = User::where('email', 'jane@gmail.com')->first();
        $alex = User::where('email', 'alex@gmail.com')->first();

        Service::create([
            'title' => 'Resume Writing Workshop',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'category' => 'Writing & Editing',
            'rate' => 25,
            'rate_type' => 'per hour',
            'photo' => 'demo/services/resume.jpg',
            'user_id' => $jane->id,
        ]);

        Service::create([
            'title' => 'Social Media Marketing',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ',
            'category' => 'Social Media Management',
            'rate' => 350,
            'rate_type' => 'per month',
            'photo' => 'demo/services/socials.jpg',
            'user_id' => $jane->id,
        ]);

        Service::create([
            'title' => 'Tutoring for Web Development',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ',
            'category' => 'Tutoring',
            'rate' => 50,
            'rate_type' => 'per hour',
            'photo' => 'demo/services/web.jpg'  ,
            'user_id' => $jane->id,
        ]);

         Service::create([
            'title' => 'Music Production',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'category' => 'Music & Audio',
            'rate' => 250,
            'rate_type' => 'fixed',
            'photo' => 'demo/services/music.jpg' ,
            'user_id' => $alex->id,
        ]);

        Service::create([
            'title' => 'Professional Event Photography',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'category' => 'Photography',
            'rate' => 150,
            'rate_type' => 'per hour',
            'photo' =>'demo/services/photo.jpg',
            'user_id' => $alex->id,
        ]);

        Service::create([
            'title' => 'Event Flyer Design',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ',
            'category' => 'Graphic Design',
            'rate' => 45,
            'rate_type' => 'fixed',
            'photo' => 'demo/services/design.jpg' ,
            'user_id' => $alex->id,
        ]);
    }
}