<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestQuestion
 * 
 * @property int $question_id
 * @property int $parent
 * @property int $user_id
 * @property int $parts_id
 * @property int $request_id
 * @property string $description
 * @property Carbon $created
 *
 * @package App\Models
 */
class RequestQuestion extends Model
{
	protected $table = 'request_question';
	protected $primaryKey = 'question_id';
	public $timestamps = false;

	protected $casts = [
		'parent' => 'int',
		'user_id' => 'int',
		'parts_id' => 'int',
		'request_id' => 'int',
		'created' => 'datetime'
	];

	protected $fillable = [
		'parent',
		'user_id',
		'parts_id',
		'request_id',
		'description',
		'created'
	];
}
