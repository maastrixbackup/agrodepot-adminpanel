<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesEmailAlert
 * 
 * @property int $alert_id
 * @property int $user_id
 * @property string|null $email
 * @property string|null $brand_ids
 * @property string $application_type
 * @property string $country_id
 * @property int $app_relist_alert
 * @property string $category_ids
 * @property int $app_separate_email
 * @property string $alert_type
 * @property string|null $email_send_time
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesEmailAlert extends Model
{
	protected $table = 'sales_email_alerts';
	protected $primaryKey = 'alert_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'app_relist_alert' => 'int',
		'app_separate_email' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'email',
		'brand_ids',
		'application_type',
		'country_id',
		'app_relist_alert',
		'category_ids',
		'app_separate_email',
		'alert_type',
		'email_send_time',
		'created',
		'modified'
	];
}
