<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BidQuestion
 *
 * @property int $qid
 * @property int $user_id
 * @property int $to_id
 * @property int $bidid
 * @property int $parts_id
 * @property int $request_id
 * @property string $description
 * @property int $status
 * @property int $parent
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class BidQuestion extends Model
{
	protected $table = 'bid_question';
	protected $primaryKey = 'qid';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'to_id' => 'int',
		'bidid' => 'int',
		'parts_id' => 'int',
		'request_id' => 'int',
		'status' => 'int',
		'parent' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'to_id',
		'bidid',
		'parts_id',
		'request_id',
		'description',
		'status',
		'parent',
		'created',
		'modified'
	];

	public function sender()
    {
        return $this->belongsTo(MasterUser::class, 'user_id', 'user_id');
    }
	public function receiver()
    {
        return $this->belongsTo(MasterUser::class, 'to_id', 'user_id');
    }
}
