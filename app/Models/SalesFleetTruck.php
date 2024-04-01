<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesFleetTruck
 * 
 * @property int $fleet_id
 * @property string $park_name
 * @property string $comp_name
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
 * @property string|null $fleet_pics
 * @property string|null $warranty_detail
 * @property string $brand_id
 * @property string|null $contact_person
 * @property int $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesFleetTruck extends Model
{
	protected $table = 'sales_fleet_trucks';
	protected $primaryKey = 'fleet_id';
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
		'park_name',
		'comp_name',
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
		'fleet_pics',
		'warranty_detail',
		'brand_id',
		'contact_person',
		'status',
		'created',
		'modified'
	];
}