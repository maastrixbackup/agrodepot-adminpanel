<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ManageMessage
 * 
 * @property int $msg_id
 * @property int $from_user
 * @property int $to_user
 * @property string $message
 * @property int $parent
 * @property int $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class ManageMessage extends Model
{
	protected $table = 'manage_message';
	protected $primaryKey = 'msg_id';
	public $timestamps = false;

	protected $casts = [
		'from_user' => 'int',
		'to_user' => 'int',
		'parent' => 'int',
		'status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'from_user',
		'to_user',
		'message',
		'parent',
		'status',
		'created',
		'modified'
	];
}
