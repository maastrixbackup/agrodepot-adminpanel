<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterLocation
 * 
 * @property int $location_id
 * @property int $country_id
 * @property string $location_name
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 *
 * @package App\Models
 */
class MasterLocation extends Model
{
	protected $table = 'master_locations';
	protected $primaryKey = 'location_id';
	public $timestamps = false;

	protected $casts = [
		'country_id' => 'int'
	];

	protected $fillable = [
		'country_id',
		'location_name',
		'meta_description',
		'meta_keywords'
	];

	public function country() {
        return $this->belongsTo(MasterCountry::class, 'country_id', 'country_id');
    }
}
