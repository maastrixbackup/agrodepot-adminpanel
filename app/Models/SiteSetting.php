<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SiteSetting
 * 
 * @property int $id
 * @property string $logo_title
 * @property string $logo_image
 * @property Carbon $created_date
 *
 * @package App\Models
 */
class SiteSetting extends Model
{
	protected $table = 'site_setting';
	public $timestamps = false;

	protected $casts = [
		'created_date' => 'datetime'
	];

	protected $fillable = [
		'logo_title',
		'logo_image',
		'created_date'
	];
}
