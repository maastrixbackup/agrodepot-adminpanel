<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesCategory
 *
 * @property int $category_id
 * @property string $category_name
 * @property string $slug
 * @property int|null $flag
 * @property int $status
 * @property string $meta_description
 * @property string $meta_keywords
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesCategory extends Model
{
    protected $table = 'sales_categories';
    protected $primaryKey = 'category_id';
    public $timestamps = false;

    protected $casts = [
        'flag' => 'int',
        'status' => 'int',
        'created' => 'datetime',
        'modified' => 'datetime'
    ];

    protected $fillable = [
        'category_name',
        'slug',
        'flag',
        'status',
        'meta_description',
        'meta_keywords',
        'created',
        'modified'
    ];

    public function categoryName()
    {
        return $this->belongsTo(SalesCategory::class, 'flag', 'category_id');
    }
    public function salesAdvertisements()
    {
        return $this->hasMany(SalesAdvertisement::class, 'category_id', 'category_id');
    }
}
