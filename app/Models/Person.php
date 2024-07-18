<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

    protected $table = 'person';
    use HasFactory;

    protected $fillable = [
        'id_number',
        'first_name',
        'last_name',
        'password',
        'dob',
        'gender',
        'phone_no',
        'address',
    ];
}
