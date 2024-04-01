<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesQuestion
 * 
 * @property int $question_id
 * @property int $user_id
 * @property int $adv_id
 * @property string $type
 * @property string $question
 * @property int $parent
 * @property int $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesQuestion extends Model
{
	protected $table = 'sales_questions';
	protected $primaryKey = 'question_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'adv_id' => 'int',
		'parent' => 'int',
		'status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'adv_id',
		'type',
		'question',
		'parent',
		'status',
		'created',
		'modified'
	];


	public function parentQuestion()
    {
        return $this->belongsTo(SalesQuestion::class,'question_id','parent');
    }
}
