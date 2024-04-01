<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomApiUserProvider extends EloquentUserProvider
{
    public function validateCredentials(mixed $user, array $credentials)
    {
        $plain = $credentials['password'];

        // Use MD5 verification for the API guard
        if (Auth::guard('api')->check()) {
            return Hash::check($plain, $user->getAuthPassword());
        } else {
            return parent::validateCredentials($user, $credentials); // Use default bcrypt for other guards
        }
    }
}
