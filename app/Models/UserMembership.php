<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserMembership
 * 
 * @property int $memb_id
 * @property string $memb_type
 * @property float $price
 * @property int $credits
 * @property string $plan_img
 * @property int $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class UserMembership extends Model
{
	protected $table = 'user_memberships';
	protected $primaryKey = 'memb_id';
	public $timestamps = false;

	protected $casts = [
		'price' => 'float',
		'credits' => 'int',
		'status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'memb_type',
		'price',
		'credits',
		'plan_img',
		'status',
		'created',
		'modified'
	];
}
