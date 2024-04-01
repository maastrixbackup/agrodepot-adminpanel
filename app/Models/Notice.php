<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notice
 * 
 * @property int $notice_id
 * @property string $notice_type
 * @property int $postid
 * @property int $user_id
 * @property string $notice_name
 * @property int $status
 * @property int $user_status
 * @property Carbon $created
 *
 * @package App\Models
 */
class Notice extends Model
{
	protected $table = 'notice';
	protected $primaryKey = 'notice_id';
	public $timestamps = false;

	protected $casts = [
		'postid' => 'int',
		'user_id' => 'int',
		'status' => 'int',
		'user_status' => 'int',
		'created' => 'datetime'
	];

	protected $fillable = [
		'notice_type',
		'postid',
		'user_id',
		'notice_name',
		'status',
		'user_status',
		'created'
	];
}
