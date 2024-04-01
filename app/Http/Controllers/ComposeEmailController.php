<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\NewsletterTemplate;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ComposeEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = NewsletterTemplate::paginate(10);
        return view("newsLetters.compose-mail", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("newsLetters.mail-add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       // dd($request->all());
        $validator = Validator::make($request->all(), [
            'user_type' => 'string|required',
            'mail_subject' => 'required',
            'mail_body' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $composemail = new NewsletterTemplate();
        $composemail->user_type = $request->input('user_type');
        $composemail->mail_subject = $request->input('mail_subject');
        $composemail->mail_body = $request->input('mail_body');
        $composemail->compose_status = $request->input('status');
        $composemail->created = Carbon::parse($composemail->created)->format("d-m-Y");
        $composemail->save();

        //dd($composemail);
       
        return redirect()->route('compose-mail.index')->with('success', 'compose email added successfully');
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
        $data = NewsletterTemplate::find($id);
        return view("newsLetters.compose-edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $composemail = NewsletterTemplate::find($id);
        $composemail->user_type = $request->input('user_type');
        $composemail->mail_subject = $request->input('mail_subject');
        $composemail->mail_body = $request->input('mail_body');
        $composemail->compose_status = $request->input('status');
        $composemail->created = Carbon::parse($composemail->created)->format("d-m-Y");
        $composemail->save();

        //dd($composemail);
       
        return redirect()->route('compose-mail.index')->with('success', 'compose email updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $composemail = NewsletterTemplate::find($id);
        $composemail->delete();
        return redirect()->route('compose-mail.index')->with('success', 'compose email deleted successfully');
    }
}
