<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected  $table = 'tickets';

    protected $fillable = [
        'bus_license_plate_no',
        'passenger_id',
        'trip_id',
        'start_location',
        'end_location',
        'date',
        'departure_time',
        'status',
        'ticket_id',
        'no_of_adults',
        'no_of_children',
        'amount',
    ];
}
