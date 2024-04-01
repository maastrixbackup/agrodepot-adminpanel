<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesFirmPart
 * 
 * @property int $parts_id
 * @property string $comp_name
 * @property string $commercial_name
 * @property string $vat
 * @property int $country_id
 * @property int $location_id
 * @property string|null $postal_code
 * @property string|null $street
 * @property string $nr
 * @property string|null $other_add
 * @property int $phone
 * @property int|null $fax
 * @property string $email
 * @property string|null $website
 * @property string|null $description
 * @property string|null $logo
 * @property string|null $parts_pics
 * @property string|null $warranty_detail
 * @property string $brand_id
 * @property string|null $contact_person
 * @property int $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesFirmPart extends Model
{
	protected $table = 'sales_firm_parts';
	protected $primaryKey = 'parts_id';
	public $timestamps = false;

	protected $casts = [
		'country_id' => 'int',
		'location_id' => 'int',
		'phone' => 'int',
		'fax' => 'int',
		'status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'comp_name',
		'commercial_name',
		'vat',
		'country_id',
		'location_id',
		'postal_code',
		'street',
		'nr',
		'other_add',
		'phone',
		'fax',
		'email',
		'website',
		'description',
		'logo',
		'parts_pics',
		'warranty_detail',
		'brand_id',
		'contact_person',
		'status',
		'created',
		'modified'
	];
}
