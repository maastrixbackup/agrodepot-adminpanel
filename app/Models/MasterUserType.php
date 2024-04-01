<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterUserType
 * 
 * @property int $ut_id
 * @property string $user_type
 *
 * @package App\Models
 */
class MasterUserType extends Model
{
	protected $table = 'master_user_types';
	protected $primaryKey = 'ut_id';
	public $timestamps = false;

	protected $fillable = [
		'user_type'
	];
}
