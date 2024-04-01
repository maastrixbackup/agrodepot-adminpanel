<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterCountry
 * 
 * @property int $country_id
 * @property string $country_name
 * @property string $country_short_name
 *
 * @package App\Models
 */
class MasterCountry extends Model
{
	protected $table = 'master_countries';
	protected $primaryKey = 'country_id';
	public $timestamps = false;

	protected $fillable = [
		'country_name',
		'country_short_name'
	];
}
