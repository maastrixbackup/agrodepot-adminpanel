<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminBlockIp
 * 
 * @property int $ip_id
 * @property string $block_ip
 * @property string $remark
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class AdminBlockIp extends Model
{
	protected $table = 'admin_block_ip';
	protected $primaryKey = 'ip_id';
	public $timestamps = false;

	protected $casts = [
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'block_ip',
		'remark',
		'created',
		'modified'
	];
}
