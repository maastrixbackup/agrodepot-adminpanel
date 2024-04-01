<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ParksquestionImage
 * 
 * @property int $id
 * @property int $qid
 * @property int $postid
 * @property string $img_file
 * @property Carbon $created
 *
 * @package App\Models
 */
class ParksquestionImage extends Model
{
	protected $table = 'parksquestion_images';
	public $timestamps = false;

	protected $casts = [
		'qid' => 'int',
		'postid' => 'int',
		'created' => 'datetime'
	];

	protected $fillable = [
		'qid',
		'postid',
		'img_file',
		'created'
	];
}
