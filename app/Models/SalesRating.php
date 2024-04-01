<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesRating
 * 
 * @property int $rating_id
 * @property int|null $adv_id
 * @property int|null $user_id
 * @property float|null $rating
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesRating extends Model
{
	protected $table = 'sales_rating';
	protected $primaryKey = 'rating_id';
	public $timestamps = false;

	protected $casts = [
		'adv_id' => 'int',
		'user_id' => 'int',
		'rating' => 'float',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'adv_id',
		'user_id',
		'rating',
		'created',
		'modified'
	];
}
