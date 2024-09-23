<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BidOffer;
use App\Models\RequestAccessory;
use Illuminate\Support\Facades\DB;

class BidOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('bid_offers as bo')
               ->leftjoin('master_users as ms','bo.user_id','=','ms.user_id')
               ->leftjoin('request_parts as rp','bo.request_id','=','rp.request_id')
               ->leftjoin('request_accessories as ra','bo.parts_id','=','ra.part_id')
               ->select('bo.*','ms.first_name','ms.last_name','ra.status as sts')
               ->get();
        return view("reports.bid_offer", compact("data"));
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
        $data = DB::table('bid_offers as bo')
        ->leftjoin('master_users as ms','bo.user_id','=','ms.user_id')
        ->leftjoin('request_parts as rp','bo.request_id','=','rp.request_id')
        ->leftjoin('request_accessories as ra','bo.parts_id','=','ra.part_id')
        ->select('bo.*','ms.first_name','ms.last_name')
        ->where('bo.bid_id',$id)
        ->first();
        return view("reports.bid_show", compact("data"));
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
        $offer = BidOffer::find($id);
        $offer->delete();
        return redirect()->route('bidoffer.index')->with('success', 'offers deleted successfully');
    }

    public function showParts(Request $request, $Id)
    {
        $data = BidOffer::with('requestPart.salesBrand')
        ->leftJoin('master_users as ms', 'bid_offers.user_id', '=', 'ms.user_id')
        ->leftJoin('request_parts as rp', 'bid_offers.request_id', '=', 'rp.request_id')
        ->leftJoin('sales_brands as sb', 'rp.brand_id', '=', 'sb.brand_id')
        ->leftJoin('sales_brands as sub_sb', 'rp.model_id', '=', 'sub_sb.brand_id')
        ->leftJoin('request_accessories as ra', 'bid_offers.parts_id', '=', 'ra.part_id')
        ->select(
            'ms.first_name',
            'ms.last_name',
            'sb.brand_name as brand_name',
            'sub_sb.brand_name as model_name',
            'rp.version',
            'rp.yr_of_manufacture as manufacture',
            'rp.engines as engine',
            'rp.vehicle_identy_no as vehicle',
            'rp.i_offer_parts',
            'rp.county',
            'rp.city',
            'ra.name_piece',
            'ra.description',
            'ra.part_no',
            'ra.max_price',
            'ra.currency',
            'ra.status',
            'ra.offerno',
            'ra.modified'
        )
        ->where('bid_offers.bid_id', $Id)
        ->first();



        // dd($data);

        $images = DB::table('request_parts as rs')
           ->leftjoin('request_accessories as ra','rs.request_id','=','ra.request_id')
           ->leftjoin('request_img as ri','ra.part_id','=','ri.parts_id')
           ->select('ri.img_path')
           ->where('rs.request_id', $Id)
           ->get();
        return view("reports.bid-parts", compact("data",'images'));
    }

    public function updateStatus(Request $request, $bidId)
    {
        $bids = RequestAccessory::find($bidId);

        // $bids = DB::table('bid_offers as bo')
        // ->leftjoin('request_accessories as ra','bo.parts_id','=','ra.part_id')
        $bids->status = $request->input('status');
        $bids->save();

        return response()->json(['message' => 'Status updated successfully', 'status' => $bids->status]);
    }


}
