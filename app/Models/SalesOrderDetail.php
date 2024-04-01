<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrderDetail
 * 
 * @property int $id
 * @property string $order_id
 * @property int $adv_id
 * @property int $product_quantity
 * @property string $amount
 * @property string $email
 * @property string $name
 * @property string $phone_mobile
 * @property int $region_id
 * @property int $locality_id
 * @property string $zip
 * @property string $address
 * @property string $notes
 * @property string $seller_notes
 * @property string $delivery
 * @property bool $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesOrderDetail extends Model
{
	protected $table = 'sales_order_details';
	public $timestamps = false;

	protected $casts = [
		'adv_id' => 'int',
		'product_quantity' => 'int',
		'region_id' => 'int',
		'locality_id' => 'int',
		'status' => 'bool',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'order_id',
		'adv_id',
		'product_quantity',
		'amount',
		'email',
		'name',
		'phone_mobile',
		'region_id',
		'locality_id',
		'zip',
		'address',
		'notes',
		'seller_notes',
		'delivery',
		'status',
		'created',
		'modified'
	];
}
