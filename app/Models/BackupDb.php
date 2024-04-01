<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BackupDb
 * 
 * @property int $backup_id
 * @property string $backup_file
 * @property Carbon $created
 *
 * @package App\Models
 */
class BackupDb extends Model
{
	protected $table = 'backup_db';
	protected $primaryKey = 'backup_id';
	public $timestamps = false;

	protected $casts = [
		'created' => 'datetime'
	];

	protected $fillable = [
		'backup_file',
		'created'
	];
}
