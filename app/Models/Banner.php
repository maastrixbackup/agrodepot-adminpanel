<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 * 
 * @property int $banner_id
 * @property string $banner_title
 * @property string $banner_caption
 * @property string $banner_img
 * @property int $status
 * @property int $orderno
 * @property Carbon $created
 *
 * @package App\Models
 */
class Banner extends Model
{
	protected $table = 'banners';
	protected $primaryKey = 'banner_id';
	public $timestamps = false;

	protected $casts = [
		'status' => 'int',
		'orderno' => 'int',
		'created' => 'datetime'
	];

	protected $fillable = [
		'banner_title',
		'banner_caption',
		'banner_img',
		'status',
		'orderno',
		'created'
	];
}
