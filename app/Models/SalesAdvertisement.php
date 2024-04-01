<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesAdvertisement
 *
 * @property int $adv_id
 * @property int $user_id
 * @property int $category_id
 * @property int $sub_cat_id
 * @property string $adv_name
 * @property string $slug
 * @property string|null $adv_details
 * @property string|null $adv_img
 * @property string|null $adv_brand_id
 * @property string $adv_model_id
 * @property string $product_cond
 * @property float $price
 * @property string $currency
 * @property int $quantity
 * @property string $payment_mode
 * @property int $personal_teaching
 * @property int $courier
 * @property float|null $courier_cost
 * @property int $free_courier
 * @property int $romanian_mail
 * @property float|null $romanian_mail_cost
 * @property int $free_romanian_mail
 * @property int $time_required
 * @property int $adv_status
 * @property int $is_promote
 * @property int $is_promote_list
 * @property string $availability
 * @property string $warranty
 * @property string $invoice
 * @property string $meta_title
 * @property string $meta_desc
 * @property string $meta_keywords
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @package App\Models
 */
class SalesAdvertisement extends Model
{
    protected $table = 'sales_advertisements';
    protected $primaryKey = 'adv_id';
    public $timestamps = false;

    protected $casts = [
        'user_id' => 'int',
        'category_id' => 'int',
        'sub_cat_id' => 'int',
        'price' => 'float',
        'quantity' => 'int',
        'personal_teaching' => 'int',
        'courier' => 'int',
        'courier_cost' => 'float',
        'free_courier' => 'int',
        'romanian_mail' => 'int',
        'romanian_mail_cost' => 'float',
        'free_romanian_mail' => 'int',
        'time_required' => 'int',
        'adv_status' => 'int',
        'is_promote' => 'int',
        'is_promote_list' => 'int',
        'created' => 'datetime',
        'modified' => 'datetime'
    ];

    protected $fillable = [
        'user_id',
        'category_id',
        'sub_cat_id',
        'adv_name',
        'slug',
        'adv_details',
        'adv_img',
        'adv_brand_id',
        'adv_model_id',
        'product_cond',
        'price',
        'currency',
        'quantity',
        'payment_mode',
        'personal_teaching',
        'courier',
        'courier_cost',
        'free_courier',
        'romanian_mail',
        'romanian_mail_cost',
        'free_romanian_mail',
        'time_required',
        'adv_status',
        'is_promote',
        'is_promote_list',
        'availability',
        'warranty',
        'invoice',
        'meta_title',
        'meta_desc',
        'meta_keywords',
        'created',
        'modified'
    ];
    public function user()
    {
        return $this->belongsTo(MasterUser::class, 'user_id', 'user_id');
    }
    public function category()
    {
        return $this->belongsTo(SalesCategory::class, 'category_id', 'category_id');
    }
}
