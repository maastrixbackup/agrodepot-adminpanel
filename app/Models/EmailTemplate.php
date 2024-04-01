<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailTemplate
 * 
 * @property int $compose_id
 * @property int $email_of
 * @property string $mail_subject
 * @property string $mail_body
 * @property int $compose_status
 * @property Carbon $created
 *
 * @package App\Models
 */
class EmailTemplate extends Model
{
	protected $table = 'email_templates';
	protected $primaryKey = 'compose_id';
	public $timestamps = false;

	protected $casts = [
		'email_of' => 'int',
		'compose_status' => 'int',
		'created' => 'datetime'
	];

	protected $fillable = [
		'email_of',
		'mail_subject',
		'mail_body',
		'compose_status',
		'created'
	];
}
