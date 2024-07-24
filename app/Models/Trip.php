<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trip';

    protected $fillable = [
        'trip_id',
        'bus_with_driver_conductor_id',
        'schedule_id',
        'departure_time',
        'arrival_time',
        'status',
        'process'
    ];
}
