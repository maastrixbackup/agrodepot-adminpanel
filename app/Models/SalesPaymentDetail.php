<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesPaymentDetail
 * 
 * @property int $payment_id
 * @property int $user_id
 * @property string $amount
 * @property string $transaction_id
 * @property string $payment_type
 * @property Carbon $paid_on
 * @property int $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesPaymentDetail extends Model
{
	protected $table = 'sales_payment_details';
	protected $primaryKey = 'payment_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'paid_on' => 'datetime',
		'status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'amount',
		'transaction_id',
		'payment_type',
		'paid_on',
		'status',
		'created',
		'modified'
	];
}
