<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesSpeciality
 * 
 * @property int $speciality_id
 * @property string $speciality_name
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesSpeciality extends Model
{
	protected $table = 'sales_specialities';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'speciality_id' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'speciality_id',
		'speciality_name',
		'created',
		'modified'
	];
}
