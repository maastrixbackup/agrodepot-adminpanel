<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BidOffer
 *
 * @property int $bid_id
 * @property int $user_id
 * @property int $request_id
 * @property int $parts_id
 * @property string $piece
 * @property float $price
 * @property string $currency
 * @property string $um
 * @property string $comment
 * @property string $offers
 * @property string $warranty
 * @property string $validity
 * @property int $availbility
 * @property int $personal_teaching
 * @property int $courier
 * @property float|null $courier_cost
 * @property int $free_courier
 * @property int $roman_mail
 * @property float|null $roman_mail_cost
 * @property int $free_roman_mail
 * @property int $time_required
 * @property string $terms_of_delivery
 * @property string $payment_method
 * @property int $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class BidOffer extends Model
{
	protected $table = 'bid_offers';
	protected $primaryKey = 'bid_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'request_id' => 'int',
		'parts_id' => 'int',
		'price' => 'float',
		'availbility' => 'int',
		'personal_teaching' => 'int',
		'courier' => 'int',
		'courier_cost' => 'float',
		'free_courier' => 'int',
		'roman_mail' => 'int',
		'roman_mail_cost' => 'float',
		'free_roman_mail' => 'int',
		'time_required' => 'int',
		'status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'request_id',
		'parts_id',
		'piece',
		'price',
		'currency',
		'um',
		'comment',
		'offers',
		'warranty',
		'validity',
		'availbility',
		'personal_teaching',
		'courier',
		'courier_cost',
		'free_courier',
		'roman_mail',
		'roman_mail_cost',
		'free_roman_mail',
		'time_required',
		'terms_of_delivery',
		'payment_method',
		'status',
		'created',
		'modified'
	];


	public function SubBrand()
    {
        return $this->belongsTo(SalesBrand::class,'flag','brand_id');
    }

	public function requestPart()
    {
        return $this->belongsTo(RequestPart::class, 'request_id');
    }

    public function salesBrand()
    {
        return $this->belongsTo(SalesBrand::class, 'brand_id');
    }

}
