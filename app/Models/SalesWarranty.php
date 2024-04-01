<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesWarranty
 * 
 * @property int $warranty_id
 * @property int $user_id
 * @property int $disclaimer_of_warranty
 * @property string $discaimer_warranty_mth
 * @property string $terms_of_warranty
 * @property int $return_policy
 * @property int $return_policy_days
 * @property string $method_return_accepted
 * @property string $transportation_cost
 * @property string $return_policy_info
 * @property int $personal_teaching
 * @property int $courier
 * @property float|null $courier_cost
 * @property int $free_courier
 * @property int $romanian_mail
 * @property float|null $romanian_cost
 * @property int $free_romanian
 * @property int $time_required
 * @property string $sending_package
 * @property string $payment_methods
 * @property string $product_condition
 * @property string $invoice
 * @property string $message_response
 * @property string $message_content
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesWarranty extends Model
{
	protected $table = 'sales_warranties';
	protected $primaryKey = 'warranty_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'disclaimer_of_warranty' => 'int',
		'return_policy' => 'int',
		'return_policy_days' => 'int',
		'personal_teaching' => 'int',
		'courier' => 'int',
		'courier_cost' => 'float',
		'free_courier' => 'int',
		'romanian_mail' => 'int',
		'romanian_cost' => 'float',
		'free_romanian' => 'int',
		'time_required' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'disclaimer_of_warranty',
		'discaimer_warranty_mth',
		'terms_of_warranty',
		'return_policy',
		'return_policy_days',
		'method_return_accepted',
		'transportation_cost',
		'return_policy_info',
		'personal_teaching',
		'courier',
		'courier_cost',
		'free_courier',
		'romanian_mail',
		'romanian_cost',
		'free_romanian',
		'time_required',
		'sending_package',
		'payment_methods',
		'product_condition',
		'invoice',
		'message_response',
		'message_content',
		'created',
		'modified'
	];
}
