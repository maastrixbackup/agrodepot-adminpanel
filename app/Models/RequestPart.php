<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestPart
 *
 * @property int $request_id
 * @property int $user_id
 * @property int $brand_id
 * @property int $model_id
 * @property string $want_song
 * @property string $version
 * @property string $yr_of_manufacture
 * @property string $engines
 * @property string $vehicle_identy_no
 * @property string $i_offer_parts
 * @property int $county
 * @property int $city
 * @property string $payment_mode
 * @property int $courier
 * @property float|null $courier_cost
 * @property int $free_courier
 * @property int $romanian_mail
 * @property float|null $romanian_mail_cost
 * @property int $free_romanian_mail
 * @property int $personal_teaching
 * @property Carbon $created
 * @property Carbon $modified
 * @property int $status
 *
 * @package App\Models
 */
class RequestPart extends Model
{
	protected $table = 'request_parts';
	protected $primaryKey = 'request_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'brand_id' => 'int',
		'model_id' => 'int',
		'county' => 'int',
		'city' => 'int',
		'courier' => 'int',
		'courier_cost' => 'float',
		'free_courier' => 'int',
		'romanian_mail' => 'int',
		'romanian_mail_cost' => 'float',
		'free_romanian_mail' => 'int',
		'personal_teaching' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime',
		'status' => 'int'
	];

	protected $fillable = [
		'user_id',
		'brand_id',
		'model_id',
		'want_song',
		'version',
		'yr_of_manufacture',
		'engines',
		'vehicle_identy_no',
		'i_offer_parts',
		'county',
		'city',
		'payment_mode',
		'courier',
		'courier_cost',
		'free_courier',
		'romanian_mail',
		'romanian_mail_cost',
		'free_romanian_mail',
		'personal_teaching',
		'created',
		'modified',
		'status'
	];


	public function parent()
    {
        return $this->belongsTo(SalesBrand::class,'brand_id','flag');
    }

	 public function bidOffers()
    {
        return $this->hasMany(BidOffer::class, 'request_id');
    }

	public function requestAccessories()
    {
        return $this->hasOne(RequestAccessory::class);
    }



}
