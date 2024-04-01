<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TempPromoteAd
 * 
 * @property int $temp_id
 * @property int $user_id
 * @property int $adv_id
 * @property string $promotion_type
 * @property int $promotion_list
 * @property int $promotion_home
 * @property float $list_price
 * @property float $home_price
 * @property float $total_price
 * @property string $random_id
 *
 * @package App\Models
 */
class TempPromoteAd extends Model
{
	protected $table = 'temp_promote_ad';
	protected $primaryKey = 'temp_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'adv_id' => 'int',
		'promotion_list' => 'int',
		'promotion_home' => 'int',
		'list_price' => 'float',
		'home_price' => 'float',
		'total_price' => 'float'
	];

	protected $fillable = [
		'user_id',
		'adv_id',
		'promotion_type',
		'promotion_list',
		'promotion_home',
		'list_price',
		'home_price',
		'total_price',
		'random_id'
	];
}
