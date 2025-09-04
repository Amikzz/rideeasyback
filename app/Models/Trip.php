<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a single bus trip.
 *
 * This model contains the details of a specific trip, including its
 * schedule, the bus and personnel assigned, and its current status.
 * It is a key part of the system for tracking and managing bus movements.
 *
 * @property int $id
 * @property string $trip_id
 * @property string $bus_with_driver_conductor_id
 * @property string $schedule_id
 * @property string $departure_time
 * @property string $arrival_time
 * @property string $status
 * @property string $process
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Trip extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trip';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'trip_id',
        'bus_with_driver_conductor_id',
        'schedule_id',
        'departure_time',
        'arrival_time',
        'status',
        'process'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'departure_time' => 'datetime:H:i:s',
        'arrival_time' => 'datetime:H:i:s',
    ];
}
