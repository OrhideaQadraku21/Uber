<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'user_id',
        'license_no',
        'phone',
        'is_active',
        'avg_rating',
        'is_online'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 1 driver -> 1 vehicle
    public function vehicle()
{
    return $this->hasOne(Vehicle::class);
}

}
