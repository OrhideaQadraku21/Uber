<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'driver_id' => ['required', 'exists:drivers,id'],
            'make' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'plate_no' => ['required', 'string', 'max:30', 'unique:vehicles,plate_no'],
            'color' => ['nullable', 'string', 'max:50'],
            'year' => ['nullable', 'integer', 'min:1990', 'max:2100'],
            'type' => ['required', 'in:standard,premium,van'],
        ]);

        $vehicle = Vehicle::create($data);

        return response()->json($vehicle, 201);
    }
}
