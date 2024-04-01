<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminMenu
 * 
 * @property int $menu_id
 * @property string $menu_name
 * @property int $flag
 * @property int $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class AdminMenu extends Model
{
	protected $table = 'admin_menu';
	protected $primaryKey = 'menu_id';
	public $timestamps = false;

	protected $casts = [
		'flag' => 'int',
		'status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'menu_name',
		'flag',
		'status',
		'created',
		'modified'
	];
}
