<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a person in the system.
 *
 * This model stores basic personal information, such as name, date of birth,
 * and contact details. It serves as a base for other user types like
 * drivers or conductors, linked by the `id_number`.
 *
 * @property int $id
 * @property string $id_number
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property \Illuminate\Support\Carbon $dob
 * @property string $gender
 * @property string $phone_no
 * @property string $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Person extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'person';
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dob' => 'date',
    ];
}
