<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesWarrantyDetail
 * 
 * @property int $warranty_id
 * @property int|null $warranty_disclaimer
 * @property int|null $warrent_month
 * @property string|null $warrent_term
 * @property int|null $return_days
 * @property string|null $return_method
 * @property string|null $transportation_cost_support
 * @property string|null $additional_info
 * @property string|null $delivery_type
 * @property float|null $delivery_cost
 * @property int|null $delivery_time
 * @property string|null $package_details
 * @property int|null $payment_id
 * @property string|null $product_condition
 * @property int $send_invoice
 * @property string|null $order_response
 * @property string|null $msg_content
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesWarrantyDetail extends Model
{
	protected $table = 'sales_warranty_details';
	protected $primaryKey = 'warranty_id';
	public $timestamps = false;

	protected $casts = [
		'warranty_disclaimer' => 'int',
		'warrent_month' => 'int',
		'return_days' => 'int',
		'delivery_cost' => 'float',
		'delivery_time' => 'int',
		'payment_id' => 'int',
		'send_invoice' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'warranty_disclaimer',
		'warrent_month',
		'warrent_term',
		'return_days',
		'return_method',
		'transportation_cost_support',
		'additional_info',
		'delivery_type',
		'delivery_cost',
		'delivery_time',
		'package_details',
		'payment_id',
		'product_condition',
		'send_invoice',
		'order_response',
		'msg_content',
		'created',
		'modified'
	];
}
