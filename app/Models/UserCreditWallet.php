<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserCreditWallet
 * 
 * @property int $credit_id
 * @property int $credits_by
 * @property int $user_id
 * @property int $credits
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class UserCreditWallet extends Model
{
	protected $table = 'user_credit_wallet';
	protected $primaryKey = 'credit_id';
	public $timestamps = false;

	protected $casts = [
		'credits_by' => 'int',
		'user_id' => 'int',
		'credits' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'credits_by',
		'user_id',
		'credits',
		'created',
		'modified'
	];
}
