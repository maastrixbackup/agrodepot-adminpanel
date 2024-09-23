<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Mail\NewB2BUserMail;
use App\Models\EmailTemplate;
use App\Models\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Support\Str;


class ForgotPwController extends Controller
{
    //
    public function forgotPasswordSendMail(Request $request)
    {
        // dd(1);
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if ($request->email) {
            $chk_user =  MasterUser::where("email", $request->email)->first();
            $token = Str::random(60);
            $chk_user->fgt_pw_token = $token;
            $chk_user->save();
            // $check = Hash::check($currentpassword, $chk_user->password);
            if ($chk_user) {
                $emailTemplate = EmailTemplate::where('email_of', 2)->first()->mail_body;
                $AccountLink = "http://localhost:3000/reset-password/" . $token;
                $emailTemplate = str_replace("{Name}", $chk_user->first_name . ' ' . $request->last_name, $emailTemplate);
                $emailTemplate = str_replace("{link}", $AccountLink, $emailTemplate);
                $body =  $emailTemplate;

                $body = [
                    'body' => $body
                ];

                Mail::to($request->email)->send(new ForgotPassword($body));
                return response()->json([
                    'message' => 'A link to reset your password has been sent to your E-mail address.',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'New password and confirm password are not same',
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'Sorry !! We could not found this user in our system.',
            ], 400);
        }
    }
    public function resetPassword(Request $request)
    {
        // dd(1);
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|different:current_password',
            'confirm_new_password' => 'required',
            'fgt_pw_token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $newpassword = $request->new_password;
        $confirmpassword = $request->confirm_new_password;
        $chk_user =  MasterUser::where("fgt_pw_token", $request->fgt_pw_token)->first();
        if ($chk_user) {
            // $check = Hash::check($currentpassword, $chk_user->password);
            if ($newpassword == $confirmpassword) {
                // MasterUser::where('id', $request->user_id)->update(['password' => Hash::make($newpassword)]);
                $chk_user->pass = md5($newpassword);
                $chk_user->fgt_pw_token = "";
                $chk_user->save();
                return response()->json([
                    'message' => 'Password Changed Successfully.',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'New password and confirm password are not same',
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'Sorry !! We could not found this user in our system.',
            ], 400);
        }
    }
}
