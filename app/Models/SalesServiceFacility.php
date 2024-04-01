<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesServiceFacility
 * 
 * @property int $facility_id
 * @property string $facility_name
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesServiceFacility extends Model
{
	protected $table = 'sales_service_facilities';
	protected $primaryKey = 'facility_id';
	public $timestamps = false;

	protected $casts = [
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'facility_name',
		'created',
		'modified'
	];
}
