<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConductorSupportModel extends Model
{
    use HasFactory;

    protected $table = '_conductor_support';

    protected $fillable = [
        'conductor_name',
        'conductor_id',
        'request',
    ];
}
