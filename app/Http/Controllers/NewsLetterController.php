<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Models\NewsLetter;
use App\Models\NewsletterTemplate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NewsLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = NewsLetter::get();
        return view("newsLetters.list", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("newsLetters.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'news_name' => 'string|required',
            'news_email' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $newsletter = new NewsLetter();
        $newsletter->news_name = $request->input('news_name');
        $newsletter->news_email = $request->input('news_email');
        $newsletter->status = $request->input('status');
        $newsletter->created = Carbon::parse($newsletter->created)->format("d-m-Y");

        $newsletter->status = $request->input('status') ? 1 : 0;
        $newsletter->save();

        //dd($newsletter);

        return redirect()->route('newsletters.index')->with('success', 'NewsLetter added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = NewsLetter::find($id);
        return view("newsLetters.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $newsletter = NewsLetter::find($id);
        $newsletter->news_name = $request->input('news_name');
        $newsletter->news_email = $request->input('news_email');
        $newsletter->created = Carbon::parse($newsletter->created)->format("d-m-Y");
        $newsletter->status = $request->input('status') ? 1 : 0;
        $newsletter->save();
        //dd($newsletter);
        return redirect()->route('newsletters.index')->with('success', 'NewsLetter updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = NewsLetter::find($id);
        $user->delete();
        return redirect()->route('newsletters.index')->with('success', 'NewsLetter deleted successfully');
    }

    public function updateStatus(Request $request, $Id)
    {
        $newsletter = NewsLetter::find($Id);
        $newsletter->status = $request->input('status');
        $newsletter->save();

        return response()->json(['message' => 'Status updated successfully', 'status' => $newsletter->status]);
    }

    public function newsletterResend(Request $request, $id)
    {
        $newsLetter = NewsLetter::find($id);

        if (!$newsLetter) {
            return redirect()->route('newsletters');
        }

        $link = route('confirm_email', ['id' => $id]);

        // Mail functionality start here
        $messageBody = '<table width="400" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" colspan="2">Dear ' . $newsLetter->news_name . ',</td>
                    </tr>
                    <tr>
                    <td>You have successfully subscribed to the newsletter in Dezmembraripenet. To receive any more newsletters, confirm your E-Mail ID by clicking <a href="' . $link . '">here</a> or paste the below URL in your browser:<br>' . $link . '.</td>
                    </tr>
                    <tr>
                        <td align="left">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle">Thank You</td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle">Dezmembraripenet</td>
                    </tr>
                </table>';

        $adminMsg = '<table width="400" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" colspan="2">Dear Admin,</td>
                    </tr>
                    <tr>
                    <td colspan="2">A new user subscribed to the newsletter on your site. Below are the user subscribe details:</td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Name: </td>
                        <td>' . $newsLetter->news_name . '</td>
                    </tr>
                    <tr>
                        <td>E-Mail ID: </td>
                        <td>' . $newsLetter->news_email . '</td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle">Thank You</td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle">Dezmembraripenet</td>
                    </tr>
                </table>';

        $siteemailID = 'info@dezmembraripenet.com'; // Default email if siteemail is not found

        // Get site email from AdminUser model
        $siteemail = AdminUser::find(2); // Assuming 2 is the uid for site email
        if ($siteemail) {
            $siteemailID = $siteemail->mail_id;
        }

        $to_email = $newsLetter->news_email;

        // Send email to subscriber
        Mail::send([], [], function ($mail) use ($to_email, $siteemailID, $messageBody) {
            $mail->to($to_email)
                ->subject('Dezmembraripenet :: Re-send News letter confirmation')
                ->html($messageBody) // Use html method to set the email body
                ->from($siteemailID, 'Dezmembraripenet')
                ->replyTo($siteemailID, 'Dezmembraripenet');
        });

        // Send email to admin
        Mail::send([], [], function ($mail) use ($siteemailID, $to_email, $adminMsg) {
            $mail->to($siteemailID)
                ->subject('Dezmembraripenet :: Re-send News letter confirmation')
                ->html($adminMsg) // Use html method to set the email body
                ->from($to_email, 'Dezmembraripenet')
                ->replyTo($siteemailID, 'Dezmembraripenet');
        });

        return redirect()->route('newsletters.index')->with('success', 'Mail re-sent successfully to subscriber to confirm the E-Mail ID.');
    }


    public function confirmEmail(Request $request)
    {
        $id = $request->id;

        if ($id) {
            $newsLetter = NewsLetter::find($id);

            if ($newsLetter) {
                $newsLetter->status = 1;

                if ($newsLetter->save()) {
                    return redirect('https://agrodepot-frontend.vercel.app/?confirm=1');
                } else {
                    return redirect('https://agrodepot-frontend.vercel.app/?confirm=0');
                }
            }
        }

        // Redirect if id parameter is not set or if NewsLetter with the given id is not found
        return redirect('https://agrodepot-frontend.vercel.app/?confirm=0');
    }
}
