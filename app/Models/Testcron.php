<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Testcron
 * 
 * @property int $id
 * @property string $name
 *
 * @package App\Models
 */
class Testcron extends Model
{
	protected $table = 'testcron';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];
}
