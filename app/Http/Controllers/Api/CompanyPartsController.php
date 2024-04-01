<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterCountry;
use App\Models\MasterLocation;
use App\Models\MasterUser;
use App\Models\ParkImg;
use App\Models\SalesBrand;
use App\Models\SalesPark;
use Illuminate\Http\Request;

class CompanyPartsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $companyParks = SalesPark::where("status", 1)->where("add_type", 2)->orderBy("park_id", "DESC")->get();
        foreach ($companyParks as $key => $value) {
            $filePath = public_path('uploads/company_logo/' . $value->logo);

            if (file_exists($filePath) && $value->logo != "") {
                $value['imageUrl'] = asset('uploads/company_logo/' . $value->logo);
            } else {
                $value['imageUrl'] = asset('uploads/brand/noimage.jpg');
            }
            $brandIds = explode(",", $value->brand_id);
            $brands = SalesBrand::whereIn("brand_id", $brandIds)->select("brand_name")->get();
            $value['brands'] = $brands;
            $value['country'] = MasterCountry::find($value->country_id) ? MasterCountry::find($value->country_id)->country_name : "";
            $value['location'] = MasterLocation::find($value->location_id) ? MasterLocation::find($value->location_id)->location_name : "";
        }
        return response()->json($companyParks);
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
    public function show(string $slug)
    {
        //
        $companyParks = SalesPark::where("slug", $slug)->first();
        $parkImages = ParkImg::where("park_id", $companyParks->park_id)->get();
        foreach ($parkImages as $key => $value1) {
            $filePath = public_path('uploads/parkimg/' . $value1->img_path);

            if (file_exists($filePath) && $value1->img_path != "") {
                $value1['imageUrl'] = asset('uploads/parkimg/' . $value1->img_path);
            } else {
                $value1['imageUrl'] = asset('uploads/brand/noimage.jpg');
            }
        }
        $companyParks["parkImages"] = $parkImages;
        $filePath = public_path('uploads/company_logo/' . $companyParks->logo);

        if (file_exists($filePath) && $companyParks->logo != "") {
            $companyParks['companyLogo'] = asset('uploads/company_logo/' . $companyParks->logo);
        } else {
            $companyParks['companyLogo'] = asset('uploads/brand/noimage.jpg');
        }
        $brandIds = explode(",", $companyParks->brand_id);
        $brands = SalesBrand::whereIn("brand_id", $brandIds)->select("brand_name")->get();
        $companyParks['brands'] = $brands;
        $companyParks['country'] = MasterCountry::find($companyParks->country_id) ? MasterCountry::find($companyParks->country_id)->country_name : "";
        $companyParks['location'] = MasterLocation::find($companyParks->location_id) ? MasterLocation::find($companyParks->location_id)->location_name : "";
        $companyParks['user'] = MasterUser::find($companyParks->user_id);

        return response()->json($companyParks);
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
        //
    }
}
