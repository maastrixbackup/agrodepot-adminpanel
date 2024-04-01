<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PostadImg
 * 
 * @property int $imgid
 * @property int $post_ad_id
 * @property int $user_id
 * @property string $img_path
 *
 * @package App\Models
 */
class PostadImg extends Model
{
	protected $table = 'postad_img';
	protected $primaryKey = 'imgid';
	public $timestamps = false;

	protected $casts = [
		'post_ad_id' => 'int',
		'user_id' => 'int'
	];

	// protected $hidden = ['img_path'];

	protected $fillable = [
		'post_ad_id',
		'user_id',
		'img_path'
	];
}
