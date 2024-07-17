<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusDriverConductor extends Model
{
    use HasFactory;

    protected $table = 'busdriverconductor';

    protected $fillable = [
        'bus_with_driver_conductor',
        'date_time',
        'bus_license_plate_no',
        'driver_id',
        'conductor_id',
    ];
}
