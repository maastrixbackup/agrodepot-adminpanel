<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SuccessStory
 *
 * @property int $success_id
 * @property int $user_id
 * @property string $content
 * @property int $submit_from
 * @property int $status
 * @property Carbon $created
 *
 * @package App\Models
 */
class SuccessStory extends Model
{
	protected $table = 'success_stories';
	protected $primaryKey = 'success_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'submit_from' => 'int',
		'status' => 'int',
		'created' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'content',
		'submit_from',
		'status',
		'created'
	];
    public function user()
    {
        return $this->belongsTo(MasterUser::class, 'user_id', 'user_id');
    }
}
