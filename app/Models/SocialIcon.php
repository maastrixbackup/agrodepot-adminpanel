<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SocialIcon
 * 
 * @property int $social_id
 * @property string $social_name
 * @property string $social_img
 * @property string $social_link
 * @property int $orderno
 * @property Carbon $created
 *
 * @package App\Models
 */
class SocialIcon extends Model
{
	protected $table = 'social_icons';
	protected $primaryKey = 'social_id';
	public $timestamps = false;

	protected $casts = [
		'orderno' => 'int',
		'created' => 'datetime'
	];

	protected $fillable = [
		'social_name',
		'social_img',
		'social_link',
		'orderno',
		'created'
	];
}
