<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterLocation;
use App\Models\MasterCountry;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class MasterLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = MasterLocation::with('country')->paginate(10);
        return view('locations.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = MasterCountry::get();
        return view('locations.add',compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'string|required',
            'location_name' => 'required',
           
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

       
    
        $location = new MasterLocation();
        $location->country_id = $request->input('country_id');
        $location->location_name = $request->input('location_name');
        $location->save();
        //dd($location);
        
        return redirect()->route('locations.index')->with('success', 'Location added successfully');
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
        $data = MasterLocation::find($id);
        $locations = MasterCountry::get();
        return view("locations.edit", compact("data","locations"));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $location = MasterLocation::find($id);
        $location->country_id = $request->input('country_id');
        $location->location_name = $request->input('location_name');
        $location->save();
        //dd($location);
        
        return redirect()->route('locations.index')->with('success', 'Location updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location = MasterLocation::find($id);
        
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Location deleted successfully');
    }
}
