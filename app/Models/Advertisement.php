<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Advertisement
 * 
 * @property int $ad_id
 * @property string $title
 * @property int $ad_type
 * @property string $banner_title
 * @property string $banner_link
 * @property string $banner_image
 * @property string $ad_script
 * @property int $show_position
 * @property int $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class Advertisement extends Model
{
	protected $table = 'advertisements';
	protected $primaryKey = 'ad_id';
	public $timestamps = false;

	protected $casts = [
		'ad_type' => 'int',
		'show_position' => 'int',
		'status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'title',
		'ad_type',
		'banner_title',
		'banner_link',
		'banner_image',
		'ad_script',
		'show_position',
		'status',
		'created',
		'modified'
	];

	
}
