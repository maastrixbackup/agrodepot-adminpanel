<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Theme
 * 
 * @property int $theme_id
 * @property string $html_tag
 * @property string $font_size
 * @property string $font_color
 * @property int $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class Theme extends Model
{
	protected $table = 'themes';
	protected $primaryKey = 'theme_id';
	public $timestamps = false;

	protected $casts = [
		'status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'html_tag',
		'font_size',
		'font_color',
		'status',
		'created',
		'modified'
	];
}
