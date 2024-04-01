<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesPaymentMode
 * 
 * @property int $id
 * @property string $payment_type
 *
 * @package App\Models
 */
class SalesPaymentMode extends Model
{
	protected $table = 'sales_payment_modes';
	public $timestamps = false;

	protected $fillable = [
		'payment_type'
	];
}
