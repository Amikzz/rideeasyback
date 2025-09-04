<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents the assignment of a driver and conductor to a bus.
 *
 * This model links a bus, a driver, and a conductor together for a specific
 * period. It is used to track which personnel are assigned to which bus
 * at any given time.
 *
 * @property int $id
 * @property string $bus_with_driver_conductor
 * @property \Illuminate\Support\Carbon $date_time
 * @property string $bus_license_plate_no
 * @property string $driver_id
 * @property string $conductor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class BusDriverConductor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'busdriverconductor';

    /**
     * The attributes that are mass assignable.
     *
     * These attributes can be set using mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bus_with_driver_conductor',
        'date_time',
        'bus_license_plate_no',
        'driver_id',
        'conductor_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_time' => 'datetime',
    ];
}
