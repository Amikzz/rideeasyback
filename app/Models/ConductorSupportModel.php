<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a support request from a conductor.
 *
 * This model stores information about support requests made by bus conductors,
 * including the conductor's details, the nature of the request, and its current status.
 *
 * @property int $id
 * @property string $conductor_name
 * @property string $conductor_id
 * @property string $request
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class ConductorSupportModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '_conductor_support';

    /**
     * The attributes that are mass assignable.
     *
     * These attributes can be set using mass assignment, which is useful for
     * handling form data when creating or updating support requests.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'conductor_name',
        'conductor_id',
        'request',
        'status',
    ];
}
