<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\AdminForgotPwMail;
use DB;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $token = \Str::random(64);
        \DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        $action_link = route('password.reset', ['token' => $token, 'email' => $request->email]);
        $body = "We are received a request to reset the password for Agro Depot account associated with " . $request->email .
            ".You can reset your password by clicking the link below ";



        $body = [
            'body' => $body,
            'action_link' => $action_link,
        ];

        Mail::to($request->email)->send(new AdminForgotPwMail($body));
        // Mail::send('emails.AdminForgotPwMail', $body, function ($message) use ($request) {
        //     $message->to($request->email);
        // });

        return back()->with('success', 'We have emailed your password reset link');

        // return redirect()->back()->with('success',  Toastr::success('We have emailed your password reset link', '', ["positionClass" => "toast-top-right"]));
    }
}
