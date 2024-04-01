<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BidquestionImage
 * 
 * @property int $id
 * @property int $qid
 * @property int $requestid
 * @property int $parts_id
 * @property int $bidid
 * @property string $img_file
 * @property Carbon $created
 *
 * @package App\Models
 */
class BidquestionImage extends Model
{
	protected $table = 'bidquestion_images';
	public $timestamps = false;

	protected $casts = [
		'qid' => 'int',
		'requestid' => 'int',
		'parts_id' => 'int',
		'bidid' => 'int',
		'created' => 'datetime'
	];

	protected $fillable = [
		'qid',
		'requestid',
		'parts_id',
		'bidid',
		'img_file',
		'created'
	];
}
