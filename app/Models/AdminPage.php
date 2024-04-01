<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminPage
 * 
 * @property int $pid
 * @property string|null $page_slug
 * @property string|null $page_name
 * @property string|null $page_title
 * @property string|null $meta_title
 * @property string|null $meta_desc
 * @property string|null $meta_keywords
 * @property string|null $page_desc
 * @property Carbon|null $created
 * @property Carbon|null $modified
 * @property bool|null $is_active
 *
 * @package App\Models
 */
class AdminPage extends Model
{
	protected $table = 'admin_pages';
	protected $primaryKey = 'pid';
	public $timestamps = false;

	protected $casts = [
		'created' => 'datetime',
		'modified' => 'datetime',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'page_slug',
		'page_name',
		'page_title',
		'meta_title',
		'meta_desc',
		'meta_keywords',
		'page_desc',
		'created',
		'modified',
		'is_active'
	];
}
