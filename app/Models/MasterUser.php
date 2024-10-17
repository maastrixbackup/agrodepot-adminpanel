<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * Class MasterUser
 *
 * @property int $user_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $email
 * @property string|null $pass
 * @property string|null $telephone1
 * @property string|null $telephone2
 * @property string|null $telephone3
 * @property string|null $telephone4
 * @property int|null $country_id
 * @property int|null $locality_id
 * @property int|null $postal_code
 * @property string|null $other_add
 * @property int|null $user_type_id
 * @property string|null $profile_img
 * @property int|null $is_active
 * @property int|null $is_admin
 * @property int|null $is_facebook
 * @property string|null $fb_id
 * @property int|null $wrong_login_attempt
 * @property Carbon|null $last_login
 * @property int|null $is_premium
 * @property Carbon|null $created
 * @property Carbon|null $modified
 * @property string|null $password
 * @property Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $name
 *
 * @package App\Models
 */

class MasterUser extends Authenticatable implements JWTSubject
{
    protected $table = 'master_users';
    protected $primaryKey = 'user_id';

    protected $casts = [
        'country_id' => 'int',
        'locality_id' => 'int',
        'postal_code' => 'int',
        'user_type_id' => 'int',
        'is_active' => 'int',
        'is_admin' => 'int',
        'is_facebook' => 'int',
        'wrong_login_attempt' => 'int',
        'last_login' => 'datetime',
        'is_premium' => 'int',
        'created' => 'datetime',
        'modified' => 'datetime',
        'email_verified_at' => 'datetime'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'pass',
        'telephone1',
        'telephone2',
        'telephone3',
        'telephone4',
        'country_id',
        'locality_id',
        'postal_code',
        'other_add',
        'user_type_id',
        'profile_img',
        'is_active',
        'is_admin',
        'is_facebook',
        'fb_id',
        'wrong_login_attempt',
        'last_login',
        'is_premium',
        'created',
        'modified',
        'password',
        'email_verified_at',
        'remember_token',
        'name',
        'changePwRequest',
        'changePwToken'
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
            'name' => $this->name
        ];
    }
    public function salesAdvertisements()
    {
        return $this->hasMany(SalesAdvertisement::class, 'user_id', 'user_id');
    }

    // public function country()
    // {
    //     return $this->belongsTo(MasterCountry::class);
    // }

    public function userType()
    {
        return $this->belongsTo(MasterUserType::class, 'user_type_id', 'ut_id');
    }
}
