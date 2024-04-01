<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = AdminUser::get();
        return view("adminUsers.list", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("adminUsers.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'string|required',
            'mail_id' => 'required',
            'user_id' => 'required',
            'pass' => 'required',
            'status' => 'required',
            
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $admin = new AdminUser();
        $admin->full_name = $request->input('full_name');
        $admin->name = $request->input('full_name');
        $admin->email = $request->input('mail_id');
        $admin->mail_id = $request->input('mail_id');
        $admin->user_id = $request->input('user_id');
        $admin->pass = $request->input('pass');
        $admin->password = bcrypt($request->input('pass'));
        $admin->email_verified_at = Carbon::parse($admin->email_verified_at	)->format("d-m-Y");
        $admin->is_active = $request->input('status')? 1 : 0;
        $admin->remember_token = Str::random(60);
        $admin->save();
    // dd($admin);
        
        return redirect()->route('admin-users.index')->with('success', 'Admin added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin_user = AdminUser::find($id);

        return view('adminUsers.show', compact('admin_user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = AdminUser::find($id);
        return view("adminUsers.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        

       
        $admin = AdminUser::find($id);
        $admin->full_name = $request->input('full_name');
        $admin->name = $request->input('full_name');
        $admin->email = $request->input('mail_id');
        $admin->mail_id = $request->input('mail_id');
        $admin->user_id = $request->input('user_id');
        $admin->pass = $request->input('pass');
        $admin->password = bcrypt($request->input('pass'));
        $admin->email_verified_at = Carbon::parse($admin->email_verified_at	)->format("d-m-Y");
        $admin->is_active = $request->input('status')? 1 : 0;
        $admin->remember_token = Str::random(60);
        $admin->save();
        return redirect()->route('admin-users.index')->with('success', 'AdminUser saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = AdminUser::find($id);
        
        $admin->delete();
        return redirect()->route('admin-users.index')->with('success', 'AdminUser deleted successfully');
    }
}
