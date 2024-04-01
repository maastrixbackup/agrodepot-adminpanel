<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesSubcategory
 * 
 * @property int $subcategory_id
 * @property string $subcategory_name
 * @property int $category_id
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesSubcategory extends Model
{
	protected $table = 'sales_subcategories';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'subcategory_id' => 'int',
		'category_id' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'subcategory_id',
		'subcategory_name',
		'category_id',
		'created',
		'modified'
	];
}
