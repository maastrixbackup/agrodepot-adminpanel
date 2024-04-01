<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminTheme
 * 
 * @property int $id
 * @property string $theme_name
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class AdminTheme extends Model
{
	protected $table = 'admin_theme';
	public $timestamps = false;

	protected $casts = [
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'theme_name',
		'created',
		'modified'
	];
}
