<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesEmailText
 * 
 * @property int $email_text_id
 * @property string $email_name
 * @property string $subject
 * @property string $body
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesEmailText extends Model
{
	protected $table = 'sales_email_texts';
	protected $primaryKey = 'email_text_id';
	public $timestamps = false;

	protected $casts = [
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'email_name',
		'subject',
		'body',
		'created',
		'modified'
	];
}
