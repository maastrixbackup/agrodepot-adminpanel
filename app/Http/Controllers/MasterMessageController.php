<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterMessage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MasterMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = MasterMessage::get();
        
        return view("masterMessages.list", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("masterMessages.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'msg_name' => 'string|required',
            'msg' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $message = new MasterMessage();
        $message->msg_name = $request->input('msg_name');
        $message->msg = $request->input('msg');
        $message->save();

        //dd($message);
       
        return redirect()->route('messages.index')->with('success', 'Message added successfully');
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
        $data = MasterMessage::find($id);
        return view("masterMessages.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $message =  MasterMessage::find($id);
        $message->msg_name = $request->input('msg_name');
        $message->msg = $request->input('msg');
        $message->save();

        //dd($message);
       
        return redirect()->route('messages.index')->with('success', 'Message updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
