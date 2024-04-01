<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminLang
 * 
 * @property int $lid
 * @property string $en_label
 * @property string $roman_label
 *
 * @package App\Models
 */
class AdminLang extends Model
{
	protected $table = 'admin_langs';
	protected $primaryKey = 'lid';
	public $timestamps = false;

	protected $fillable = [
		'en_label',
		'roman_label'
	];
}
