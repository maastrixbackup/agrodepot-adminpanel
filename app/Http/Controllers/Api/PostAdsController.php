<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterMessage;
use App\Models\MasterCountry;
use App\Models\MasterLocation;
use App\Models\Notice;
use App\Models\SalesAdvertisement;
use App\Models\SalesOrder;
use App\Models\SalesWarranty;
use App\Models\MasterUser;
use App\Models\UserRating;
use App\Models\PostadImg;
use App\Models\PromotionPlan;
use Illuminate\Http\Request;
use DB;

class PostAdsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function deleteAd(Request $request,$userid)
    {
        $alladd = SalesAdvertisement::where('adv_status', 2)->where('user_id', $userid)->orderByDesc('adv_id')->limit(10)->get();

        $alladd_data = [];
        if (!empty($alladd)) {
            foreach ($alladd as $key =>  $row) {
                $firstPostadImg = PostadImg::where('post_ad_id', $row->adv_id)->orderBy('imgid', 'asc')->first();

                $alladd_data[$key]['opinion'] =    $row->adv_name;
                $alladd_data[$key]['for'] =   '-';
                $alladd_data[$key]['click_on'] =   'N/A';
                $alladd_data[$key]['amount'] =   $row->quantity;
                $alladd_data[$key]['price'] =   $row->price;
                $alladd_data[$key]['currency'] =   $row->currency;
                $alladd_data[$key]['slug'] =   $row->slug;
                $alladd_data[$key]['image_path'] =   asset('uploads/postad/' . $firstPostadImg->img_path);
            }
        }

        return response()->json(['data' => $alladd_data]);
    }

    /**
     * Display a listing of the resource.
     */
    public function promotedAd(Request $request,$userid)
    {
        $alladd  = \DB::table('sales_advertisements')
            ->leftJoin('promotion_ad', 'promotion_ad.adv_id', '=', 'sales_advertisements.adv_id')
            ->select('sales_advertisements.*', 'promotion_ad.*')
            ->where('sales_advertisements.adv_status', 1)
            ->where('sales_advertisements.user_id', $userid)
            ->where('sales_advertisements.is_promote', 1)
            ->orderBy('promotion_ad.created', 'desc')
            ->limit(10)
            ->get();

        $alladd_data = [];
        if (!empty($alladd)) {
            foreach ($alladd as $key =>  $row) {
                $firstPostadImg = PostadImg::where('post_ad_id', $row->adv_id)->orderBy('imgid', 'asc')->first();

                $homeplandetail = PromotionPlan::where('promotion_id', $row->promotion_home)->where('status', 1)->first();

                $listplandetail =  PromotionPlan::where('promotion_id', $row->promotion_list)->where('status', 1)->first();

                if ($row->promotion_home > 0) {
                    $home_page_expiry_date = date("d-m-Y", strtotime($row->is_home_expire));
                } else {
                    $home_page_expiry_date = 'Not Promoted for Home';
                }

                if ($row->promotion_home > 0) {
                    $priority_display_expiry_date = date("d-m-Y", strtotime($row->is_list_expire));
                } else {
                    $priority_display_expiry_date = 'Not Promoted for list';
                }

                if (!empty($homeplandetail)) {
                    $home_plan =  $homeplandetail->promotion_days . " Days(" .  $homeplandetail->promotion_price . " RON)";
                } else {
                    $home_plan = "N/A";
                }

                if (!empty($listplandetail)) {
                    $list_plan =  $listplandetail->promotion_days . " Days(" .  $listplandetail->promotion_price . " RON)";
                } else {
                    $list_plan = "N/A";
                }
                $alladd_data[$key]['slug'] =     $row->slug;
                $alladd_data[$key]['opinion'] =     $row->adv_name;
                $alladd_data[$key]['home_plan'] =   $home_plan;
                $alladd_data[$key]['list_plan'] =   $list_plan;
                $alladd_data[$key]['home_page_expiry_date'] =  $home_page_expiry_date;

                $alladd_data[$key]['priority_display_expiry_date'] =   $priority_display_expiry_date;
                $alladd_data[$key]['total_price'] =  $row->total_price . ' ' . $row->currency;
                $alladd_data[$key]['choice'] =   asset('uploads/postad/' . $firstPostadImg->img_path);
            }
        }

        return response()->json(['data' => $alladd_data]);
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
        //
    }
}
