<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserTotalCredit
 * 
 * @property int $id
 * @property int $user_id
 * @property int $credits
 *
 * @package App\Models
 */
class UserTotalCredit extends Model
{
	protected $table = 'user_total_credit';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'credits' => 'int'
	];

	protected $fillable = [
		'user_id',
		'credits'
	];
}
