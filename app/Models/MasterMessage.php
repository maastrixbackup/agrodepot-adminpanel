<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterMessage
 * 
 * @property int $msg_id
 * @property string $msg_name
 * @property string $msg
 *
 * @package App\Models
 */
class MasterMessage extends Model
{
	protected $table = 'master_messages';
	protected $primaryKey = 'msg_id';
	public $timestamps = false;

	protected $fillable = [
		'msg_name',
		'msg'
	];
}
