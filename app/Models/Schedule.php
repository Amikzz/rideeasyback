<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'route_id',
        'date'
    ];
}
