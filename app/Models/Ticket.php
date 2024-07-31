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
        'status',
        'ticket_id'
    ];
}
