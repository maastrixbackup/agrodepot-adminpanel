<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SubscribeAlert
 * 
 * @property int $alert_id
 * @property int $user_id
 * @property string $brand_list
 * @property string $categories
 * @property string $couties
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SubscribeAlert extends Model
{
	protected $table = 'subscribe_alert';
	protected $primaryKey = 'alert_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'brand_list',
		'categories',
		'couties',
		'created',
		'modified'
	];
}
