<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrder
 * 
 * @property int $id
 * @property string $orderid
 * @property int $user_id
 * @property int $adv_id
 * @property int $qty
 * @property float $totprice
 * @property string $delivery_method
 * @property string $fname
 * @property string $lname
 * @property string $phone
 * @property int $county
 * @property int $location
 * @property int $postcode
 * @property string $delivery_add
 * @property string $note_command
 * @property int $save_info
 * @property int $status
 * @property int $delivery_status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesOrder extends Model
{
	protected $table = 'sales_order';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'adv_id' => 'int',
		'qty' => 'int',
		'totprice' => 'float',
		'county' => 'int',
		'location' => 'int',
		'postcode' => 'int',
		'save_info' => 'int',
		'status' => 'int',
		'delivery_status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'orderid',
		'user_id',
		'adv_id',
		'qty',
		'totprice',
		'delivery_method',
		'fname',
		'lname',
		'phone',
		'county',
		'location',
		'postcode',
		'delivery_add',
		'note_command',
		'save_info',
		'status',
		'delivery_status',
		'created',
		'modified'
	];

	public function salesAdvertisement()
    {
        return $this->belongsTo(SalesAdvertisement::class, 'user_id', 'user_id');
    }

	public function subBrand()
    {
        return $this->belongsTo(SalesBrand::class, 'adv_model_id', 'brand_id');
    }

	public function subCategory()
    {
        return $this->belongsTo(SalesCategory::class, 'category_id', 'flag');
    }

	// Define the relationship with PostAd
    public function PostAd()
    {
        return $this->belongsTo(SalesAdvertisement::class, 'adv_id');
    }
}
