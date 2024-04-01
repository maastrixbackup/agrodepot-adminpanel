<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestquestionImage
 * 
 * @property int $id
 * @property int $qid
 * @property int $requestid
 * @property int $parts_id
 * @property string $img_file
 * @property Carbon $created
 *
 * @package App\Models
 */
class RequestquestionImage extends Model
{
	protected $table = 'requestquestion_images';
	public $timestamps = false;

	protected $casts = [
		'qid' => 'int',
		'requestid' => 'int',
		'parts_id' => 'int',
		'created' => 'datetime'
	];

	protected $fillable = [
		'qid',
		'requestid',
		'parts_id',
		'img_file',
		'created'
	];
}
