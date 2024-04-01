<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BidTempFile
 * 
 * @property int $temp_id
 * @property string $img_pth
 * @property string $ip_address
 * @property int $user_id
 * @property int $parts_id
 * @property int $seq_no
 *
 * @package App\Models
 */
class BidTempFile extends Model
{
	protected $table = 'bid_temp_file';
	protected $primaryKey = 'temp_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'parts_id' => 'int',
		'seq_no' => 'int'
	];

	protected $fillable = [
		'img_pth',
		'ip_address',
		'user_id',
		'parts_id',
		'seq_no'
	];
}
