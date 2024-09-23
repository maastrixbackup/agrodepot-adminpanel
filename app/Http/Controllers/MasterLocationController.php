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
    public function index(Request $request)
    {
        $country_id = $request->input('country_id');

        $country_data = MasterCountry::orderBy('country_name', 'asc')->get();

        // $query = MasterLocation::with('country');

        // if ($country_id) {
        //     $query->where('country_id', $country_id);
        // }

        // $data = $query->get();

        return view('locations.list', compact('country_data', 'country_id'));
    }

    public function getLocations(Request $request)
    {
        // dd($request->all());
        ## Read value
        $draw = $request->get('draw');
        $row = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        $columnIndex = $request['order'][0]['column']; // Column index
        $columnName = $request['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $request['order'][0]['dir']; // asc or desc
        $searchValue = $request['search']['value']; // Search value
        $country_id = $request->input('country_id');
        $searchtxt = $request->searchtxt;

        ## Read value

        $data = array();

        $totalRecords = MasterLocation::select('count(*) as allcount')->count();
        $LocationRecords = MasterLocation::orderBy('location_id', 'desc')->select('master_locations.*');

        if ($country_id) {
            $LocationRecords->where('country_id', $country_id);
        }

         if ($searchValue) {
            $LocationRecords->where('location_name', 'like', '%' . $searchValue . '%')->orwhere('country_id', 'like', '%' . $searchValue . '%');
        }
        // Counting total records
        $totalRecords = $LocationRecords->count();

        // Applying pagination
        $LocationRecords = $LocationRecords->paginate($request->input('length'));
        $i = 1;
        foreach ($LocationRecords as $key => $record) {
            $btns = '';
            $delete_btn = route('locations.destroy', $record->location_id);
            $edit_btn = route('locations.edit', $record->location_id);
            $btns .= '<a class="edit-btn" title="Edit" href="' . $edit_btn . '"><i class="fas fa-edit"></i></a>';
            $btns .= '<button title="Delete" class="dl-btn trash remove-location" data-id="' . $record->location_id . '" data-action="' . $delete_btn . '"><i class="fas fa-trash"></i></button>';

            $action = '<div class="d-flex customButtonContainer">' . $btns . '</div>';


            $country = $record->country->country_name;
            $location_name = $record->location_name ? $record->location_name : "N/A";



            $data[] = array(
                "id" =>  $record->location_id ? $record->location_id : "NA",
                "country" =>  $country,
                "location_name" => $location_name,
                "action" =>  $action

            );
        }
        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ];

        echo json_encode($response);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = MasterCountry::get();
        return view('locations.add', compact('locations'));
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
        return view("locations.edit", compact("data", "locations"));
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
