<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserCreditAccount
 * 
 * @property int $credit_id
 * @property int $upgrade_id
 * @property int $user_id
 * @property int $credits
 * @property int $ammount
 * @property Carbon $expiry_date
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class UserCreditAccount extends Model
{
	protected $table = 'user_credit_account';
	protected $primaryKey = 'credit_id';
	public $timestamps = false;

	protected $casts = [
		'upgrade_id' => 'int',
		'user_id' => 'int',
		'credits' => 'int',
		'ammount' => 'int',
		'expiry_date' => 'datetime',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'upgrade_id',
		'user_id',
		'credits',
		'ammount',
		'expiry_date',
		'created',
		'modified'
	];
}
