<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a bus in the public transportation system.
 *
 * This model contains information about a specific bus, including its
 * license plate, capacity, current status, and location. It is a central
 * part of managing the fleet of buses within the application.
 *
 * @property int $id
 * @property string $bus_license_plate_no
 * @property int $capacity
 * @property string $status
 * @property float $latitude
 * @property float $longitude
 * @property \Illuminate\Support\Carbon $lastUpdateLocation
 * @property string $route_id
 * @property string $bus_parked_venue
 * @property string $bus_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Bus extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bus';

    /**
     * The attributes that are mass assignable.
     *
     * These attributes can be set using mass assignment, which is useful
     * for handling form data when creating or updating bus records.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bus_license_plate_no',
        'capacity',
        'status',
        'latitude',
        'longitude',
        'lastUpdateLocation',
        'route_id',
        'bus_parked_venue',
        'bus_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * This ensures that the `lastUpdateLocation` attribute is automatically
     * converted to a Carbon instance when accessed.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'lastUpdateLocation' => 'datetime',
    ];
}
