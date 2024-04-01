<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesView
 * 
 * @property int $view_id
 * @property int $adv_id
 * @property string $ip_address
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesView extends Model
{
	protected $table = 'sales_view';
	protected $primaryKey = 'view_id';
	public $timestamps = false;

	protected $casts = [
		'adv_id' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'adv_id',
		'ip_address',
		'created',
		'modified'
	];
}
