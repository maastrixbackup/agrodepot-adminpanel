<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class News
 * 
 * @property int $news_id
 * @property string $news_title
 * @property string $news_content
 * @property string $news_img
 * @property int $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class News extends Model
{
	protected $table = 'news';
	protected $primaryKey = 'news_id';
	public $timestamps = false;

	protected $casts = [
		'status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'news_title',
		'news_content',
		'news_img',
		'status',
		'created',
		'modified'
	];
}
