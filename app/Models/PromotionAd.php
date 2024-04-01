<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PromotionAd
 * 
 * @property int $promotion_id
 * @property int $user_id
 * @property int $adv_id
 * @property float $total_price
 * @property string $promotion_type
 * @property int $promotion_list
 * @property int $promotion_home
 * @property float $listprice
 * @property float $homeprice
 * @property int $status
 * @property string $transfer_id
 * @property Carbon $is_home_expire
 * @property Carbon $is_list_expire
 * @property string $payment_mthd
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class PromotionAd extends Model
{
	protected $table = 'promotion_ad';
	protected $primaryKey = 'promotion_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'adv_id' => 'int',
		'total_price' => 'float',
		'promotion_list' => 'int',
		'promotion_home' => 'int',
		'listprice' => 'float',
		'homeprice' => 'float',
		'status' => 'int',
		'is_home_expire' => 'datetime',
		'is_list_expire' => 'datetime',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'adv_id',
		'total_price',
		'promotion_type',
		'promotion_list',
		'promotion_home',
		'listprice',
		'homeprice',
		'status',
		'transfer_id',
		'is_home_expire',
		'is_list_expire',
		'payment_mthd',
		'created',
		'modified'
	];
}
