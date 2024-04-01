<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRating
 * 
 * @property int $rating_id
 * @property int $user_id
 * @property int $from_user_id
 * @property int $orderid
 * @property int $adv_id
 * @property int $grade
 * @property string $how_to_know
 * @property float $productdescribedval
 * @property float $communicationval
 * @property float $deliverytimeval
 * @property float $cost_of_transportval
 * @property int $rating_type
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class UserRating extends Model
{
	protected $table = 'user_rating';
	protected $primaryKey = 'rating_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'from_user_id' => 'int',
		'orderid' => 'int',
		'adv_id' => 'int',
		'grade' => 'int',
		'productdescribedval' => 'float',
		'communicationval' => 'float',
		'deliverytimeval' => 'float',
		'cost_of_transportval' => 'float',
		'rating_type' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'from_user_id',
		'orderid',
		'adv_id',
		'grade',
		'how_to_know',
		'productdescribedval',
		'communicationval',
		'deliverytimeval',
		'cost_of_transportval',
		'rating_type',
		'created',
		'modified'
	];
}
