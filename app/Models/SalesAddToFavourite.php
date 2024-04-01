<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesAddToFavourite
 * 
 * @property int $fav_id
 * @property int $user_id
 * @property int $adv_id
 * @property string $ip_address
 * @property int $favcount
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesAddToFavourite extends Model
{
	protected $table = 'sales_add_to_favourites';
	protected $primaryKey = 'fav_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'adv_id' => 'int',
		'favcount' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'adv_id',
		'ip_address',
		'favcount',
		'created',
		'modified'
	];
}
