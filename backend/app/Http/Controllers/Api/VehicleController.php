<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        return response()->json(Vehicle::all());
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'driver_id' => ['required','exists:drivers,id'],
        'make' => ['required','string','max:100'],
        'model' => ['required','string','max:100'],
        'plate_no' => ['required','string','max:30','unique:vehicles,plate_no'],
        'year' => ['nullable','integer'],
        'color' => ['nullable','string','max:50'],
    ]);

    $vehicle = Vehicle::create($validated);

    return response()->json($vehicle, 201);
}
}
