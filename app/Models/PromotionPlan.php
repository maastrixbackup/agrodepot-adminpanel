<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PromotionPlan
 * 
 * @property int $promotion_id
 * @property int $promotion_type
 * @property int $promotion_days
 * @property float $promotion_price
 * @property int $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class PromotionPlan extends Model
{
	protected $table = 'promotion_plan';
	protected $primaryKey = 'promotion_id';
	public $timestamps = false;

	protected $casts = [
		'promotion_type' => 'int',
		'promotion_days' => 'int',
		'promotion_price' => 'float',
		'status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'promotion_type',
		'promotion_days',
		'promotion_price',
		'status',
		'created',
		'modified'
	];
}
