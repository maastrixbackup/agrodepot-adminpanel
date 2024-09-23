<?php

namespace App\Http\Controllers;

use App\Models\RequestAccessory;
use Illuminate\Http\Request;
use App\Models\RequestPart;
use App\Models\RequestImg;
use App\Models\SalesPark;
use Illuminate\Support\Facades\DB;

class RequestPartsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = RequestPart::with('parent')
            ->leftjoin('sales_brands as sb', 'request_parts.brand_id', '=', 'sb.brand_id')
            ->leftjoin('request_accessories as ra', 'request_parts.request_id', '=', 'ra.request_id')
            ->leftjoin('master_users as ms', 'request_parts.user_id', '=', 'ms.user_id')
            ->select('request_parts.*', 'ms.first_name', 'sb.brand_name', 'ra.name_piece')->orderBy("request_parts.request_id", "desc")
            ->get();
        return view('reports.request-parts', compact('data'));
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = RequestPart::with('parent')
            ->leftjoin('sales_brands as sb', 'request_parts.brand_id', '=', 'sb.brand_id')
            ->leftjoin('request_accessories as ra', 'request_parts.request_id', '=', 'ra.request_id')

            ->leftjoin('master_users as ms', 'request_parts.user_id', '=', 'ms.user_id')
            ->select('request_parts.*', 'ms.first_name', 'sb.brand_name', 'ra.name_piece')
            ->where('request_parts.request_id', $id)
            ->first();

        $images = RequestImg::where("parts_id", $id)->get();
        // dd($images);
        return view("reports.view-parts", compact("data", "images"));
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $parts = RequestPart::where("request_id", $id);
        $acc = RequestAccessory::where("request_id", $id);
        $acc->delete();
        $images = RequestImg::where("parts_id", $id)->get();
        foreach ($images as $image) {
            $previousImagePath = public_path('uploads/requestpart/' . $image->img_path);
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }
        $images = RequestImg::where("parts_id", $id);
        if ($images)
            $images->delete();
        $parts->delete();


        return redirect()->route('request-parts.index')->with('success', 'parts deleted successfully');
    }

    public function updateStatus(Request $request, $partId)
    {
        $parts = RequestPart::find($partId);
        $parts->status = $request->input('status');
        $parts->save();

        return response()->json(['message' => 'Status updated successfully', 'status' => $parts->status]);
    }
    public function deleteDuplicateEntries()
    {
        $requestAccessories = RequestAccessory::all();

        // Loop through each request accessory
        foreach ($requestAccessories as $requestAccessory) {
            $slug = $requestAccessory->slug;
            $count = 1;

            // Check if the slug already exists in the database
            while (RequestAccessory::where('slug', $slug)->exists()) {
                // If it exists, modify the slug
                $slug = $requestAccessory->slug . '-' . $count;
                $count++;
            }

            // Update the slug in the database
            $requestAccessory->slug = $slug;
            $requestAccessory->save();
        }
    }
}
