<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecentView
 * 
 * @property int $recent_id
 * @property string $ip_id
 * @property int $adv_id
 * @property Carbon $created
 * @property Carbon $exp_date
 *
 * @package App\Models
 */
class RecentView extends Model
{
	protected $table = 'recent_views';
	protected $primaryKey = 'recent_id';
	public $timestamps = false;

	protected $casts = [
		'adv_id' => 'int',
		'created' => 'datetime',
		'exp_date' => 'datetime'
	];

	protected $fillable = [
		'ip_id',
		'adv_id',
		'created',
		'exp_date'
	];
}
