<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TempMembershipDetail
 * 
 * @property int $temp_mem_id
 * @property int $randomid
 * @property string $fname
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property int $city
 * @property int $state
 * @property int $zip
 * @property int $copydetails
 * @property string $shipping_fname
 * @property string $shipping_email
 * @property string $shipping_phone
 * @property string $shipping_address
 * @property int $shipping_city
 * @property int $shipping_state
 * @property int $shipping_zip
 * @property string $pmt_from
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class TempMembershipDetail extends Model
{
	protected $table = 'temp_membership_details';
	protected $primaryKey = 'temp_mem_id';
	public $timestamps = false;

	protected $casts = [
		'randomid' => 'int',
		'city' => 'int',
		'state' => 'int',
		'zip' => 'int',
		'copydetails' => 'int',
		'shipping_city' => 'int',
		'shipping_state' => 'int',
		'shipping_zip' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'randomid',
		'fname',
		'email',
		'phone',
		'address',
		'city',
		'state',
		'zip',
		'copydetails',
		'shipping_fname',
		'shipping_email',
		'shipping_phone',
		'shipping_address',
		'shipping_city',
		'shipping_state',
		'shipping_zip',
		'pmt_from',
		'created',
		'modified'
	];
}
