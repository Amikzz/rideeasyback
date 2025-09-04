<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a bus driver.
 *
 * This model stores information about a driver, linking them to a unique
 * ID number and a driver-specific identifier. It is likely associated with
 * a `Person` model to store more detailed personal information.
 *
 * @property int $id
 * @property string $id_number
 * @property string $driver_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Driver extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'driver';

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_number',
        'driver_id',
    ];
}
