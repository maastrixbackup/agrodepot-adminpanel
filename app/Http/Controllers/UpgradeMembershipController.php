<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UpgradeMembership;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpgradeMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('upgrade_membership as um')
            ->leftjoin('user_memberships as m', 'um.member_type', '=', 'm.memb_id')
            ->leftjoin('user_credit_account as c', 'um.upgrade_id', '=', 'c.upgrade_id')
            ->select('um.*', 'm.memb_type')
            ->get();
        foreach ($data as $menu) {
            $menu->transfer_id = Str::random(32); // Add a new property for the random key
        }

        return view("upgradeMemberships.list", compact("data"));
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
        $membership =  DB::table('upgrade_membership as um')
            ->leftJoin('user_memberships as m', 'um.member_type', '=', 'm.memb_id')
            ->leftJoin('user_credit_account as c', 'um.upgrade_id', '=', 'c.upgrade_id')
            ->leftJoin('master_countries as mc', 'mc.country_id', '=', 'um.county')
            ->leftJoin('master_locations as ml', 'ml.location_id', '=', 'um.city')
            ->select('um.*', 'm.memb_type', 'mc.country_name', 'ml.location_name')
            ->where('um.upgrade_id', $id)
            ->first();

        $randomKey = Str::random(32);

        return view('upgradeMemberships.show', compact('membership', 'randomKey'));
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
        $membershio = UpgradeMembership::find($id);
        $membershio->delete();
        return redirect()->route('upgrade-memberships.index')->with('success', 'Membership deleted successfully');
    }
}
