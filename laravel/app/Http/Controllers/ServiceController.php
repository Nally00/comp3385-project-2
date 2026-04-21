<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    private array $allowedCategories = [
        'Web Development',
        'Graphic Design',
        'Photography',
        'Video Editing',
        'Writing & Editing',
        'Tutoring',
        'Music & Audio',
        'Data Entry',
        'Social Media Management',
        'Translation',
    ];

    private array $allowedRateTypes = [
        'per hour',
        'per day',
        'per week',
        'per month',
        'fixed',
    ];

    public function index()
    {
        return Service::with('user')->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => ['required', Rule::in($this->allowedCategories)],
            'rate' => 'required|numeric|min:0',
            'rate_type' => ['required', Rule::in($this->allowedRateTypes)],
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('services', 'public');
        }

        $data['user_id'] = auth('api')->id();

        $service = Service::create($data);

        return response()->json([
            'message' => 'Service added successfully.',
            'service' => $service,
        ], 201);
    }

    public function show($service_id)
    {
        return Service::with('user')->findOrFail($service_id);
    }

    public function search(Request $request) 
    {
        $query = $request->query('q');

        $results = Service::with('user')
            ->when($query, function ($builder, $value) {
                $builder->where('title', 'like', "%{$value}%")
                    ->orWhere('description', 'like', "%{$value}%")
                    ->orWhere('category', 'like', "%{$value}%");
            })
            ->latest()
            ->get();

        return response()->json($results);
    }
}