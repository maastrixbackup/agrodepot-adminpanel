<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterUser;
use App\Models\MasterCountry;
use App\Models\MasterLocation;
use App\Models\MasterUserType;
use Illuminate\Support\Facades\Validator;


class MasterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = MasterUser::with('userType')->orderBy("user_id","desc")->paginate('10');
        $totalUser = MasterUser::count();
        $totalBuyer = MasterUser::where('user_type_id', 1)->count();
        $totalSeller= MasterUser::where('user_type_id', 2)->count();

        return view("masterusers.list", compact('data','totalUser','totalBuyer','totalSeller'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $countries = MasterCountry::pluck('country_name', 'country_id');

        $users = MasterUserType::pluck('user_type', 'ut_id');
        return view("masterusers.add",compact('countries','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'telephone1' => 'required',
            'telephone2' => 'required',
            'telephone3' => 'required',
            'telephone4' => 'required',
            'country' => 'required',
            'city' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = new MasterUser();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->pass = bcrypt($request->input('password'));
        $user->telephone1 = $request->input('telephone1');
        $user->telephone2 = $request->input('telephone2');
        $user->telephone3 = $request->input('telephone3');
        $user->telephone4 = $request->input('telephone4');
        $user->country_id = $request->input('country');
        $user->locality_id = $request->input('city');
        $user->user_type_id = $request->input('user_type');
        $user->is_active = $request->input('status');
        $user->save();

        //dd($user);
        return redirect()->route('users.index')->with('success', 'User added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = MasterUser::find($id);
        $countries = MasterCountry::pluck('country_name', 'country_id');
        $city = MasterLocation::select('location_id', 'location_name')->paginate(20);
        $users = MasterUserType::pluck('user_type', 'ut_id');
        return view("masterusers.edit", compact("data","countries","city","users"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = MasterUser::find($id);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->pass = $request->input('password');
        $user->telephone1 = $request->input('telephone1');
        $user->telephone2 = $request->input('telephone2');
        $user->telephone3 = $request->input('telephone3');
        $user->telephone4 = $request->input('telephone4');
        $user->country_id = $request->input('country');
        $user->locality_id = $request->input('city');
        $user->user_type_id = $request->input('user_type');
        $user->is_active = $request->input('status');
        $user->save();


        return redirect()->route('users.index')->with('success', 'User saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = MasterUser::find($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
