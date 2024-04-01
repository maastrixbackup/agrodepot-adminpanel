<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MailToSubscriber
 * 
 * @property int $mail_id
 * @property int $user_type
 * @property string $brandlist
 * @property string $categorylist
 * @property string $countylist
 * @property int $compose_id
 * @property string $mail_list
 * @property Carbon $created
 *
 * @package App\Models
 */
class MailToSubscriber extends Model
{
	protected $table = 'mail_to_subscriber';
	protected $primaryKey = 'mail_id';
	public $timestamps = false;

	protected $casts = [
		'user_type' => 'int',
		'compose_id' => 'int',
		'created' => 'datetime'
	];

	protected $fillable = [
		'user_type',
		'brandlist',
		'categorylist',
		'countylist',
		'compose_id',
		'mail_list',
		'created'
	];
}
