<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestTempImg
 * 
 * @property int $id
 * @property int $seqno
 * @property string $ip_address
 * @property string $img_path
 *
 * @package App\Models
 */
class RequestTempImg extends Model
{
	protected $table = 'request_temp_img';
	public $timestamps = false;

	protected $casts = [
		'seqno' => 'int'
	];

	protected $fillable = [
		'seqno',
		'ip_address',
		'img_path'
	];
}
