<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TempImg
 * 
 * @property int $img_id
 * @property int|null $post_id
 * @property int $random_id
 * @property string $ip_address
 * @property string $img_path
 *
 * @package App\Models
 */
class TempImg extends Model
{
	protected $table = 'temp_img';
	protected $primaryKey = 'img_id';
	public $timestamps = false;

	protected $casts = [
		'post_id' => 'int',
		'random_id' => 'int'
	];

	protected $fillable = [
		'post_id',
		'random_id',
		'ip_address',
		'img_path'
	];
}
