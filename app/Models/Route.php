<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a bus route.
 *
 * This model stores information about a specific bus route, including its
 * unique identifier, start and end points, distance, and estimated duration.
 *
 * @property int $id
 * @property string $route_id
 * @property string $route_number
 * @property string $start_location
 * @property string $end_location
 * @property float $distance
 * @property int $duration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Route extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'route';
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'route_id',
        'route_number',
        'start_location',
        'end_location',
        'distance',
        'duration',
    ];
}
