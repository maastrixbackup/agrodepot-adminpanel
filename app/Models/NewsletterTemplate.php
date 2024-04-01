<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NewsletterTemplate
 * 
 * @property int $compose_id
 * @property int $user_type
 * @property string $mail_subject
 * @property string $mail_body
 * @property int $compose_status
 * @property Carbon $created
 *
 * @package App\Models
 */
class NewsletterTemplate extends Model
{
	protected $table = 'newsletter_template';
	protected $primaryKey = 'compose_id';
	public $timestamps = false;

	protected $casts = [
		'user_type' => 'int',
		'compose_status' => 'int',
		'created' => 'datetime'
	];

	protected $fillable = [
		'user_type',
		'mail_subject',
		'mail_body',
		'compose_status',
		'created'
	];
}
