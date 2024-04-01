<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestAccessory
 * 
 * @property int $part_id
 * @property int $request_id
 * @property string $name_piece
 * @property string $slug
 * @property string $description
 * @property string $part_no
 * @property int $max_price
 * @property string $currency
 * @property string $part_img
 * @property int $offerno
 * @property int $status
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class RequestAccessory extends Model
{
	protected $table = 'request_accessories';
	protected $primaryKey = 'part_id';
	public $timestamps = false;

	protected $casts = [
		'request_id' => 'int',
		'max_price' => 'int',
		'offerno' => 'int',
		'status' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime'
	];

	protected $fillable = [
		'request_id',
		'name_piece',
		'slug',
		'description',
		'part_no',
		'max_price',
		'currency',
		'part_img',
		'offerno',
		'status',
		'created',
		'modified'
	];

	public function requestImg()
    {
        return $this->hasOne(RequestImg::class);
    }
}
