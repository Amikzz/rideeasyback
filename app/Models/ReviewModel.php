<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a user review for a bus.
 *
 * This model stores feedback provided by users about their experience
 * on a particular bus. It includes a rating and a text review, linked
 * to a user and a bus.
 *
 * @property int $id
 * @property string $user_id
 * @property string $bus_license_plate_no
 * @property string $review
 * @property string $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class ReviewModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'review';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'bus_license_plate_no',
        'review',
        'rating',
    ];
}
