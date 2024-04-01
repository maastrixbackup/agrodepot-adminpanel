<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestImg
 * 
 * @property int $img_id
 * @property int $parts_id
 * @property string $img_path
 * @property int $seq_no
 *
 * @package App\Models
 */
class RequestImg extends Model
{
	protected $table = 'request_img';
	protected $primaryKey = 'img_id';
	public $timestamps = false;

	protected $casts = [
		'parts_id' => 'int',
		'seq_no' => 'int'
	];

	protected $fillable = [
		'parts_id',
		'img_path',
		'seq_no'
	];
}
