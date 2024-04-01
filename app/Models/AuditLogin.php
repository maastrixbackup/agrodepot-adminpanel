<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AuditLogin
 * 
 * @property int $audit_id
 * @property int $user_id
 * @property Carbon|null $login_time
 * @property Carbon|null $logout_time
 * @property int|null $session_time
 * @property string|null $ip_address
 *
 * @package App\Models
 */
class AuditLogin extends Model
{
	protected $table = 'audit_logins';
	protected $primaryKey = 'audit_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'login_time' => 'datetime',
		'logout_time' => 'datetime',
		'session_time' => 'int'
	];

	protected $fillable = [
		'user_id',
		'login_time',
		'logout_time',
		'session_time',
		'ip_address'
	];
}
