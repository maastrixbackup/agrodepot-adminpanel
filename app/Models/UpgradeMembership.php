<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UpgradeMembership
 * 
 * @property int $upgrade_id
 * @property int $user_id
 * @property int $member_type
 * @property string $payment_method
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property int $county
 * @property int $city
 * @property int $zip
 * @property int $shipping_different
 * @property string $shipping_name
 * @property string $shipping_email
 * @property string $shipping_phone
 * @property string $shipping_address
 * @property int $shipping_county
 * @property int $shipping_city
 * @property int $shipping_zip
 * @property int $payment_status
 * @property string $transfer_id
 * @property Carbon $created
 * @property Carbon $modified
 * @property int $plan_status
 * @property float $price
 * @property int $credit
 *
 * @package App\Models
 */
class UpgradeMembership extends Model
{
	protected $table = 'upgrade_membership';
	protected $primaryKey = 'upgrade_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'member_type' => 'int',
		'county' => 'int',
		'city' => 'int',
		'zip' => 'int',
		'shipping_different' => 'int',
		'shipping_county' => 'int',
		'shipping_city' => 'int',
		'shipping_zip' => 'int',
		'payment_status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime',
		'plan_status' => 'int',
		'price' => 'float',
		'credit' => 'int'
	];

	protected $fillable = [
		'user_id',
		'member_type',
		'payment_method',
		'name',
		'email',
		'phone',
		'address',
		'county',
		'city',
		'zip',
		'shipping_different',
		'shipping_name',
		'shipping_email',
		'shipping_phone',
		'shipping_address',
		'shipping_county',
		'shipping_city',
		'shipping_zip',
		'payment_status',
		'transfer_id',
		'created',
		'modified',
		'plan_status',
		'price',
		'credit'
	];
}
