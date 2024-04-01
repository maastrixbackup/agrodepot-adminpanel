<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AddCredit
 * 
 * @property int $id
 * @property int $credit_id
 * @property int $credits
 * @property int $credits_by
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class AddCredit extends Model
{
	protected $table = 'add_credits';
	public $timestamps = false;

	protected $casts = [
		'credit_id' => 'int',
		'credits' => 'int',
		'credits_by' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'credit_id',
		'credits',
		'credits_by',
		'created',
		'modified'
	];
}
