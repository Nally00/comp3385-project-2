<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    private array $allowedCategories = [
        'cleaning',
        'tutoring',
        'delivery',
        'repair',
        'consulting',
    ];

    private array $allowedRateTypes = [
        'hourly',
        'fixed',
        'project',
    ];

    public function index()
    {
        return Service::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => ['required', 'string', 'max:255', Rule::in($this->allowedCategories)],
            'rate' => 'required|numeric|min:0',
            'rate_type' => ['required', 'string', 'max:255', Rule::in($this->allowedRateTypes)],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('services', 'public');
        }

        $service = Service::create($data);

        return response()->json($service, 201);
    }

    public function show($service_id)
    {
        return Service::findOrFail($service_id);
    }

    public function search(Request $request)
    {
        $query = $request->query('q');

        $results = Service::when($query, function ($builder, $value) {
            $builder->where('title', 'like', "%{$value}%")
                ->orWhere('description', 'like', "%{$value}%")
                ->orWhere('category', 'like', "%{$value}%");
        })->get();

        return response()->json($results);
    }
}
