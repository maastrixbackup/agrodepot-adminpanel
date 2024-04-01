<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesWorkmanshipQuotation
 * 
 * @property int $quotation_id
 * @property int $brand_id
 * @property int $model_id
 * @property string $version
 * @property int $manufacture_yr
 * @property int $engines
 * @property int $chassis
 * @property int $country_id
 * @property int $location_id
 * @property string $title
 * @property string $description
 * @property int|null $supply_by
 * @property string|null $images
 * @property string $speciality_id
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesWorkmanshipQuotation extends Model
{
	protected $table = 'sales_workmanship_quotations';
	protected $primaryKey = 'quotation_id';
	public $timestamps = false;

	protected $casts = [
		'brand_id' => 'int',
		'model_id' => 'int',
		'manufacture_yr' => 'int',
		'engines' => 'int',
		'chassis' => 'int',
		'country_id' => 'int',
		'location_id' => 'int',
		'supply_by' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'brand_id',
		'model_id',
		'version',
		'manufacture_yr',
		'engines',
		'chassis',
		'country_id',
		'location_id',
		'title',
		'description',
		'supply_by',
		'images',
		'speciality_id',
		'created',
		'modified'
	];
}
