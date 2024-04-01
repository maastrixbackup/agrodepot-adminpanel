<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesBrand
 *
 * @property int $brand_id
 * @property string $brand_name
 * @property string $slug
 * @property int $flag
 * @property int $status
 * @property string $image
 * @property string $meta_description
 * @property string $meta_keywords
 * @property int|null $ordering
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesBrand extends Model
{
    protected $table = 'sales_brands';
    protected $primaryKey = 'brand_id';
    public $timestamps = false;

    protected $casts = [
        'flag' => 'int',
        'status' => 'int',
        'ordering' => 'int',
        'created' => 'datetime',
        'modified' => 'datetime'
    ];

    protected $fillable = [
        'brand_name',
        'slug',
        'flag',
        'status',
        'image',
        'meta_description',
        'meta_keywords',
        'ordering',
        'created',
        'modified'
    ];
    public function parent()
    {
        return $this->belongsTo(SalesBrand::class, 'flag', 'brand_id');
    }

    public function requestPart()
    {
        return $this->hasMany(RequestPart::class);
    }

    public function subBrands()
    {
        return $this->hasMany(SalesBrand::class, 'flag', 'brand_id')->where("status", 1)->orderBy('ordering', 'asc');
    }

   
}
