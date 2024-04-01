<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PartsOrder
 * 
 * @property int $id
 * @property string $orderid
 * @property int $user_id
 * @property int $request_id
 * @property int $parts_id
 * @property int $bid_id
 * @property float $totprice
 * @property string $delivery_method
 * @property string $fname
 * @property string $lname
 * @property string $phone
 * @property int $county
 * @property int $location
 * @property int $postcode
 * @property string $delivery_add
 * @property string $note_command
 * @property int $status
 * @property int $delivery_status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class PartsOrder extends Model
{
	protected $table = 'parts_order';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'request_id' => 'int',
		'parts_id' => 'int',
		'bid_id' => 'int',
		'totprice' => 'float',
		'county' => 'int',
		'location' => 'int',
		'postcode' => 'int',
		'status' => 'int',
		'delivery_status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'orderid',
		'user_id',
		'request_id',
		'parts_id',
		'bid_id',
		'totprice',
		'delivery_method',
		'fname',
		'lname',
		'phone',
		'county',
		'location',
		'postcode',
		'delivery_add',
		'note_command',
		'status',
		'delivery_status',
		'created',
		'modified'
	];

	public function user()
    {
        return $this->belongsTo(MasterUser::class, 'user_id', 'user_id');
    }
}
