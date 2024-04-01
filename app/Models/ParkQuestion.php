<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ParkQuestion
 * 
 * @property int $qid
 * @property int $user_id
 * @property int $park_id
 * @property int $park_type
 * @property string $question
 * @property int $parent
 * @property int $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class ParkQuestion extends Model
{
	protected $table = 'park_question';
	protected $primaryKey = 'qid';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'park_id' => 'int',
		'park_type' => 'int',
		'parent' => 'int',
		'status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'park_id',
		'park_type',
		'question',
		'parent',
		'status',
		'created',
		'modified'
	];

	public function parkQuestion()
	{
		return $this->belongsTo(ParkQuestion::class, 'qid', 'parent');
	}

	public function User()
	{
		return $this->belongsTo(MasterUser::class, 'user_id', 'user_id');
	}

	public function salesPark()
	{
		return $this->belongsTo(SalesPark::class, 'park_id', 'park_id');
	}
}
