<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\UserCreditAccount;
use Illuminate\Http\Request;
use App\Models\UserCreditWallet;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('user_credit_account as uc')
        ->leftjoin('upgrade_membership as um','uc.upgrade_id','=','um.upgrade_id')
        ->leftjoin('master_users as ms','uc.user_id','=','ms.user_id')
        ->select('uc.*','um.*','ms.first_name')
        ->get();

        foreach ($data as $menu) {
            $menu->transfer_id = Str::random(32);
        }

        return view("credits.list", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {




    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = UserCreditAccount::where('user_id', $id)->get();
        

        return view("credits.show", compact("data"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = UserCreditAccount::find($id);
        return view('credits.add', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $credits =  UserCreditAccount::find($id);
        $credits->credits += $request->input('credits');
        $credits->save();

        return redirect()->route('credits.index')->with('success', 'Amount added successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $credits = UserCreditAccount::find($id);
        
        $credits->delete();
        return redirect()->route('credits.index')->with('success', 'Credits deleted successfully');
    }
}
