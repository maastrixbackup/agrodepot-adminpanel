<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesAddPart
 * 
 * @property int $part_id
 * @property int $brand_id
 * @property int $model_id
 * @property string $version
 * @property int $manufacture_yr
 * @property int $engine
 * @property int|null $identification_no
 * @property string $name_piece
 * @property string|null $description
 * @property int|null $part_no
 * @property float|null $price
 * @property int|null $currency
 * @property int|null $offer_parts
 * @property int $country_id
 * @property int $location_id
 * @property string|null $file_name
 * @property int $is_solved
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesAddPart extends Model
{
	protected $table = 'sales_add_parts';
	protected $primaryKey = 'part_id';
	public $timestamps = false;

	protected $casts = [
		'brand_id' => 'int',
		'model_id' => 'int',
		'manufacture_yr' => 'int',
		'engine' => 'int',
		'identification_no' => 'int',
		'part_no' => 'int',
		'price' => 'float',
		'currency' => 'int',
		'offer_parts' => 'int',
		'country_id' => 'int',
		'location_id' => 'int',
		'is_solved' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'brand_id',
		'model_id',
		'version',
		'manufacture_yr',
		'engine',
		'identification_no',
		'name_piece',
		'description',
		'part_no',
		'price',
		'currency',
		'offer_parts',
		'country_id',
		'location_id',
		'file_name',
		'is_solved',
		'created',
		'modified'
	];
}
