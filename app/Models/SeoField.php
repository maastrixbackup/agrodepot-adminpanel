<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SeoField
 * 
 * @property int $seo_id
 * @property string $page_name
 * @property string $meta_title
 * @property string $meta_desc
 * @property string $meta_keyword
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SeoField extends Model
{
	protected $table = 'seo_fields';
	protected $primaryKey = 'seo_id';
	public $timestamps = false;

	protected $casts = [
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'page_name',
		'meta_title',
		'meta_desc',
		'meta_keyword',
		'created',
		'modified'
	];
}
