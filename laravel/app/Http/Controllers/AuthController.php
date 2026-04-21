<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
   public function register(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'location' => 'nullable|string|max:255',
        'biography' => 'nullable|string',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
    ]);

    $photoPath = null;

    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('profile_photos', 'public');
    }

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'location' => $data['location'] ?? null,
        'biography' => $data['biography'] ?? null,
        'photo' => $photoPath,
    ]);

    return response()->json([
        'message' => 'Account created successfully.',
        'user' => $user,
    ], 201);
}

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! $token = auth('api')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = auth('api')->user();

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'location' => $user->location,
                'biography' => $user->biography,
                'photo' => $user->photo,
            ],
        ]);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}