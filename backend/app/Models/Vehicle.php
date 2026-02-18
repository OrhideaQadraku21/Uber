<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'driver_id',
        'make',
        'model',
        'plate_no',
        'color',
        'year',
        'type',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
