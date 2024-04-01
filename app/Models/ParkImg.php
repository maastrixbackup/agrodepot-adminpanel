<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ParkImg
 * 
 * @property int $img_id
 * @property int $park_id
 * @property string $img_path
 *
 * @package App\Models
 */
class ParkImg extends Model
{
	protected $table = 'park_imgs';
	protected $primaryKey = 'img_id';
	public $timestamps = false;

	protected $casts = [
		'park_id' => 'int'
	];

	protected $fillable = [
		'park_id',
		'img_path'
	];
}
