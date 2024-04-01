<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NewsLetter
 * 
 * @property int $news_letter_id
 * @property string $news_name
 * @property string $news_email
 * @property int $status
 * @property Carbon $created
 *
 * @package App\Models
 */
class NewsLetter extends Model
{
	protected $table = 'news_letters';
	protected $primaryKey = 'news_letter_id';
	public $timestamps = false;

	protected $casts = [
		'status' => 'int',
		'created' => 'datetime'
	];

	protected $fillable = [
		'news_name',
		'news_email',
		'status',
		'created'
	];
}
