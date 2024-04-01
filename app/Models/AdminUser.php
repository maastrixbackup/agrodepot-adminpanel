<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * Class AdminUser
 *
 * @property int $uid
 * @property string|null $full_name
 * @property string|null $mail_id
 * @property string|null $user_id
 * @property string|null $pass
 * @property bool|null $is_active
 * @property Carbon|null $created
 * @property string $name
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class AdminUser extends Authenticatable
{
	protected $table = 'admin_users';
	protected $primaryKey = 'uid';

	protected $casts = [
		'is_active' => 'bool',
		'created' => 'datetime',
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'full_name',
		'mail_id',
		'user_id',
		'pass',
		'is_active',
		'created',
		'name',
		'email',
		'email_verified_at',
		'password',
		'remember_token'
	];
}
