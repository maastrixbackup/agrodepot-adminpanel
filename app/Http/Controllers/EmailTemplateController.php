<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = EmailTemplate::get();
        return view("emailTemplates.list", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view("emailTemplates.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'email_of' => 'string|required',
            'mail_subject' => 'required',
            'mail_body' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $email = new EmailTemplate();
        $email->email_of = $request->input('email_of');
        $email->mail_subject = $request->input('mail_subject');
        $email->mail_body = $request->input('mail_body');
        $email->compose_status = $request->input('status');
        $email->created =  Carbon::parse($email->created)->format("d-m-Y");
        $email->save();
        //dd($email);
        
        return redirect()->route('templates.index')->with('success', 'Template added successfully');
      
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $email = EmailTemplate::find($id);

        return view('emailTemplates.show', compact('email'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $data = EmailTemplate::find($id);
        return view("emailTemplates.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $email = EmailTemplate::find($id);
        $email->email_of = $request->input('email_of');
        $email->mail_subject = $request->input('mail_subject');
        $email->mail_body = $request->input('mail_body');
        $email->compose_status = $request->input('compose_status');
        $email->save();
        //dd($email);
        
        return redirect()->route('templates.index')->with('success', 'Template updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $email = EmailTemplate::find($id);
        
        $email->delete();
        return redirect()->route('templates.index')->with('success', 'Template deleted successfully');
    }
}
