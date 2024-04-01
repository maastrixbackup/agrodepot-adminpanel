<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesServiceType
 * 
 * @property int $service_type_id
 * @property string $service_name
 * @property int $status
 *
 * @package App\Models
 */
class SalesServiceType extends Model
{
	protected $table = 'sales_service_types';
	protected $primaryKey = 'service_type_id';
	public $timestamps = false;

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'service_name',
		'status'
	];
}
