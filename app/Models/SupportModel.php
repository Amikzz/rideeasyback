<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportModel extends Model
{
    use HasFactory;

    protected $table = 'support';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'bus_license_plate_no',
        'issue',
        'status'
    ];
}
