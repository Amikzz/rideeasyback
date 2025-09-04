<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a bus ticket.
 *
 * This model stores all the details related to a single bus ticket,
 * including information about the bus, passenger, trip, and fare.
 *
 * @property int $id
 * @property string $bus_license_plate_no
 * @property string $passenger_id
 * @property string $trip_id
 * @property string $start_location
 * @property string $end_location
 * @property \Illuminate\Support\Carbon $date
 * @property string $departure_time
 * @property string $status
 * @property string $ticket_id
 * @property int $no_of_adults
 * @property int $no_of_children
 * @property float $amount
 * @property float $total_fare
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Ticket extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected  $table = 'tickets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bus_license_plate_no',
        'passenger_id',
        'trip_id',
        'start_location',
        'end_location',
        'date',
        'departure_time',
        'status',
        'ticket_id',
        'no_of_adults',
        'no_of_children',
        'amount',
        'total_fare'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'departure_time' => 'datetime:H:i:s',
    ];
}
