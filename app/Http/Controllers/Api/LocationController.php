<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterCountry;
use App\Models\MasterLocation;
use App\Models\MasterUser;
use App\Models\SalesAdvertisement;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    //
    public function getCountries()
    {
        $data = MasterCountry::all();
        foreach ($data as $key => $value) {
            $user = MasterUser::where('country_id', $value->country_id)->select('user_id')->get();
            $count = SalesAdvertisement::whereIn("user_id", $user)->where("adv_status", 1)->count();
            $value["count"] = $count;
        }
        return response()->json(['data' => $data]);
    }
    public function getCities(Request $request, $Id)
    {
        //dd($Id);
        $city = MasterLocation::where('country_id', $Id)->get();
        return response()->json(['data' => $city]);
    }
}
