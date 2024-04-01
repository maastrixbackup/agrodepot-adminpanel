<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BidImg
 * 
 * @property int $img_id
 * @property int $bid_id
 * @property int $user_id
 * @property int $request_id
 * @property int $parts_id
 * @property string $img_path
 *
 * @package App\Models
 */
class BidImg extends Model
{
	protected $table = 'bid_img';
	protected $primaryKey = 'img_id';
	public $timestamps = false;

	protected $casts = [
		'bid_id' => 'int',
		'user_id' => 'int',
		'request_id' => 'int',
		'parts_id' => 'int'
	];

	protected $fillable = [
		'bid_id',
		'user_id',
		'request_id',
		'parts_id',
		'img_path'
	];
}
