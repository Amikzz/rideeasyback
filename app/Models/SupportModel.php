<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a user support request.
 *
 * This model stores information about support requests submitted by users,
 * including their contact details, the bus involved, a description of the issue,
 * and the status of the request.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $bus_license_plate_no
 * @property string $issue
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class SupportModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'support';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'bus_license_plate_no',
        'issue',
        'status'
    ];
}
