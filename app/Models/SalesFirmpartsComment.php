<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesFirmpartsComment
 * 
 * @property int $firmparts_comment_id
 * @property int $parts_id
 * @property int $user_id
 * @property string $comment
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesFirmpartsComment extends Model
{
	protected $table = 'sales_firmparts_comments';
	protected $primaryKey = 'firmparts_comment_id';
	public $timestamps = false;

	protected $casts = [
		'parts_id' => 'int',
		'user_id' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'parts_id',
		'user_id',
		'comment',
		'created',
		'modified'
	];
}
