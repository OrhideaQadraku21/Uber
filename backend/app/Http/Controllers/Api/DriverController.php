<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    // GET /api/drivers  (ADMIN)
    public function index()
    {
        return response()->json(
            Driver::with('user')->orderByDesc('id')->get()
        );
    }

    // POST /api/drivers  (ADMIN)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:150', Rule::unique('users', 'email')],
            'password'   => ['required', 'string', 'min:6'],
            'license_no' => ['required', 'string', 'max:50', Rule::unique('drivers', 'license_no')],
            'phone'      => ['nullable', 'string', 'max:30'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'driver',
        ]);

        $driver = Driver::create([
            'user_id' => $user->id,
            'license_no' => $validated['license_no'],
            'phone' => $validated['phone'] ?? null,
            'is_active' => true,
            'is_online' => false,
            'avg_rating' => 0,
        ]);

        return response()->json([
            'user' => $user,
            'driver' => $driver,
        ], 201);
    }
}