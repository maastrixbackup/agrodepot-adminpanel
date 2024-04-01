<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ParkRating
 * 
 * @property int $id
 * @property int $user_id
 * @property int $park_id
 * @property int $rating_from
 * @property float $ratingno
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class ParkRating extends Model
{
	protected $table = 'park_ratings';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'park_id' => 'int',
		'rating_from' => 'int',
		'ratingno' => 'float',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'park_id',
		'rating_from',
		'ratingno',
		'created',
		'modified'
	];
}
