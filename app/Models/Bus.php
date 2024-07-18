<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $table = 'bus'; // Assuming 'bus' is the table name
    protected $primaryKey = 'bus_license_plate_no'; // Assuming 'bus_license_plate_no' is your primary key

    protected $fillable = [
        'bus_license_plate_no',
        'latitude',
        'longitude',
        'lastUpdateLocation',
    ];

    protected $casts = [
        'lastUpdateLocation' => 'datetime', // Assuming 'lastUpdateLocation' is a timestamp column
    ];

}
