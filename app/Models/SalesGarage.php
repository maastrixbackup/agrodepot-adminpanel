<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesGarage
 * 
 * @property int $garage_id
 * @property string $sevice_name
 * @property string $company_name
 * @property string $vat
 * @property int $country_id
 * @property int $location_id
 * @property string $street
 * @property string $nr
 * @property string|null $other_add
 * @property int $postal_code
 * @property int $phone
 * @property int|null $fax
 * @property string $email
 * @property string|null $website
 * @property string $contact_person
 * @property string|null $logo
 * @property string|null $images
 * @property int $service_type
 * @property int $open_yr
 * @property string $service_desc
 * @property int|null $mechanics
 * @property int|null $elevators
 * @property int|null $capacity
 * @property int $avg_price
 * @property string $mon_fri_open_close
 * @property string|null $sat_open_close
 * @property string|null $sun_open_close
 * @property string|null $email_appointment
 * @property string|null $phone_appointment
 * @property string $brand_ids
 * @property string $machine_type
 * @property int $service_type_id
 * @property int $service_facility_id
 * @property int $payment_mode_id
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesGarage extends Model
{
	protected $table = 'sales_garage';
	protected $primaryKey = 'garage_id';
	public $timestamps = false;

	protected $casts = [
		'country_id' => 'int',
		'location_id' => 'int',
		'postal_code' => 'int',
		'phone' => 'int',
		'fax' => 'int',
		'service_type' => 'int',
		'open_yr' => 'int',
		'mechanics' => 'int',
		'elevators' => 'int',
		'capacity' => 'int',
		'avg_price' => 'int',
		'service_type_id' => 'int',
		'service_facility_id' => 'int',
		'payment_mode_id' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'sevice_name',
		'company_name',
		'vat',
		'country_id',
		'location_id',
		'street',
		'nr',
		'other_add',
		'postal_code',
		'phone',
		'fax',
		'email',
		'website',
		'contact_person',
		'logo',
		'images',
		'service_type',
		'open_yr',
		'service_desc',
		'mechanics',
		'elevators',
		'capacity',
		'avg_price',
		'mon_fri_open_close',
		'sat_open_close',
		'sun_open_close',
		'email_appointment',
		'phone_appointment',
		'brand_ids',
		'machine_type',
		'service_type_id',
		'service_facility_id',
		'payment_mode_id',
		'created',
		'modified'
	];
}
