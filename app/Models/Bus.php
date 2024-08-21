<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $table = 'bus'; // Assuming 'bus' is the table name

    protected $fillable = [
        'bus_license_plate_no',
        'capacity',
        'status',
        'latitude',
        'longitude',
        'lastUpdateLocation',
        'route_id',
        'bus_parked_venue',
        'bus_type',
    ];

    protected $casts = [
        'lastUpdateLocation' => 'datetime', // Assuming 'lastUpdateLocation' is a timestamp column
    ];
}
