<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLogin;
use Illuminate\Support\Facades\DB;

class AuditLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data =DB::table('audit_logins as al')
           ->leftjoin('master_users as ms','al.user_id','=','ms.user_id')
           ->select('al.*','ms.first_name')
           ->get();
        return view("reports.audit-login", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $logins = AuditLogin::find($id);
        $logins->delete();
        return redirect()->route('audit-login.index')->with('success', 'logins deleted successfully');
    }
}
