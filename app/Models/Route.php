<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $table = 'route';
    use HasFactory;

    protected $fillable = [
        'route_id',
        'route_number',
        'start_location',
        'end_location',
        'distance',
        'duration',
    ];
}
