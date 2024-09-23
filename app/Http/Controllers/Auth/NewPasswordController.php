<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $check_token =  \DB::table('password_reset_tokens')->where([
            'email'=>$request->email,
            'token'=>$request->token
        ])->first();

        if(!($check_token)) {
            return back()->withInput()->with('error','Invalid Token');
        } else {
            AdminUser::where('email',$request->email)->update([
                'password' =>Hash::make($request->password)
            ]);
        }

        \DB::table('password_reset_tokens')->where([
            'email'=>$request->email
        ])->delete();
        
        return redirect()->route('login')->with('success','Your password has been changed! You can login with new password.');
    }
}
