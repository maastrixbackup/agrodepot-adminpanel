<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\models\NewsletterTemplate;
use App\models\MailToSubscriber;
use App\models\SalesBrand;
use App\models\SalesCategory;
use App\models\MasterCountry;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendFormDataMail;

class SentMailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('mail_to_subscriber as ms')
        ->leftjoin('newsletter_template as nt','ms.compose_id','=','nt.compose_id')
        ->select('ms.*','nt.mail_subject')
        ->paginate(5);
       
        return view("newsLetters.sent_mail", compact("data"));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $limit = -1;
        $data = MailToSubscriber::select('user_type')->first();
        $brandlist = SalesBrand::where('flag',0)
                    ->orWhere('status',1)
                    ->limit($limit)
                    ->get();
        $categorylist = SalesCategory::where('flag',0)
                    ->orWhere('status',1)
                    ->limit($limit)
                    ->get();
        $countrylist = MasterCountry::orderby('country_name','asc')->get();

        $composelist = DB::table('newsletter_template as nt')
                    ->leftjoin('mail_to_subscriber as ms','nt.compose_id','=','ms.compose_id')
                    ->select('nt.mail_subject','ms.mail_id')
                    ->where('nt.user_type',$data->user_type)
                    ->first();

        $subscriberlist = DB::table('subscribe_alert as sa')
                        ->leftjoin('master_users as mu','sa.user_id','=','mu.user_id')
                        ->where('mu.user_type_id',$data->user_type)
                        ->orWhere('mu.is_active',1)
                        ->orWhere('wrong_login_attempt','<=',3)
                        ->select('mu.user_id','mu.first_name','mu.last_name')
                        ->get();

        return view("newsLetters.add-sent-mail", compact("data","brandlist","categorylist","countrylist","subscriberlist","composelist"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
      
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subscriber = MailToSubscriber::find($id);
        $subscriber->delete();
        return redirect()->route('sent-mail.index')->with('success', 'Subscriber deleted successfully');
    }


    public function sendEmail(Request $request)
    {
        // Retrieve form data
        $formData = $request->all();
        // dd($formData);
        
        // Send email
        Mail::to('prustyjyotsna32@gmail.com')->send(new SendFormDataMail($formData));
        
        // Check if the email was sent successfully
        if (Mail::failures()) {
            return back()->with('error', 'Failed to send email.');
        } else {
            return back()->with('success', 'Email has been sent successfully.');
        }
    }
}
