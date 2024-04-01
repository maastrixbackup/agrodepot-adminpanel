<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesFleetComment
 * 
 * @property int $fleet_comment_id
 * @property int $fleet_truck_id
 * @property int $user_id
 * @property string $comment
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesFleetComment extends Model
{
	protected $table = 'sales_fleet_comments';
	protected $primaryKey = 'fleet_comment_id';
	public $timestamps = false;

	protected $casts = [
		'fleet_truck_id' => 'int',
		'user_id' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'fleet_truck_id',
		'user_id',
		'comment',
		'created',
		'modified'
	];
}
