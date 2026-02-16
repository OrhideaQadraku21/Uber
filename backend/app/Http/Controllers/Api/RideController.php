<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ride;
use Illuminate\Http\Request;

class RideController extends Controller
{
    public function index()
    {
        return response()->json(Ride::latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pickup' => ['required', 'string', 'max:255'],
            'destination' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $ride = Ride::create($validated);

        return response()->json($ride, 201);
    }
}
