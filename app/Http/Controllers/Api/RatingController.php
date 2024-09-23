<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesOrder;
use App\Models\MasterUser;
use Illuminate\Http\Request;



class RatingController extends Controller
{
    public function ratingReceiveBuyer($id)
    {
        $userid =  $id;
        $data = array();
        $salesOrders = SalesOrder::join('sales_advertisements as PostAd', 'PostAd.adv_id', '=', 'sales_order.adv_id')
            ->where('sales_order.user_id', $id)
            ->select('PostAd.*', 'sales_order.*')
            ->orderBy('sales_order.orderid', 'desc')
            ->get();
        // dd($salesOrders);
        foreach ($salesOrders as $key => $val) {
            $data[$key]['id'] =  $val->id;
            $data[$key]['adv_id'] = isset($val->PostAd->adv_id) ? $val->PostAd->adv_id : 'N/A';
            $data[$key]['adv_name'] =  isset($val->PostAd->adv_name) ? $val->PostAd->adv_name : 'N/A';
            $data[$key]['slug'] =  isset($val->PostAd->slug) ? $val->PostAd->slug : 'N/A';
            $data[$key]['orderid'] =  isset($val->orderid) ? $val->orderid : 'N/A';
            $data[$key]['qty'] =  isset($val->qty) ? $val->qty : 'N/A';
            $data[$key]['price'] =  isset($val->PostAd->price) ? $val->PostAd->price : 'N/A';
            $data[$key]['currency'] =  isset($val->PostAd->currency) ? $val->PostAd->currency : 'N/A';
            $details = MasterUser::where('user_id', $val->PostAd->user_id)->first();
            $data[$key]['sales_clerk'] = $details->first_name . ' ' . $details->last_name;
            $data[$key]['phone_no'] = isset($details->telephone1) ? $details->telephone1 : 'N/A';
            $data[$key]['email_id'] = isset($details->email) ? $details->email : 'N/A';
            $data[$key]['post_code'] = isset($details->postal_code) ? $details->postal_code : 'N/A';
            $data[$key]['address'] = isset($details->other_add) ? $details->other_add : 'N/A';
            $data[$key]['user_rating'] = userProfileResult($details->user_id);
            $data[$key]['date_of_purchase'] = date("F d, Y H:i", strtotime($val->created));
        }
        return response()->json($data);
    }

    public function ratingReceiveSeller($id)
    {
        $userid =  $id;
        $data = array();

        $salesOrders = SalesOrder::join('sales_advertisements as PostAd', 'PostAd.adv_id', '=', 'sales_order.id')
            ->where('PostAd.user_id', $userid)
            ->select('PostAd.*', 'sales_order.*')
            ->orderBy('sales_order.orderid', 'desc')
            ->get();

        foreach ($salesOrders as $key => $val) {
            $data[$key]['id'] = $val->id;
            $data[$key]['adv_id'] = $val->adv_id ?? 'N/A';
            $data[$key]['adv_name'] = $val->adv_name ?? 'N/A';
            $data[$key]['slug'] = $val->slug ?? 'N/A';
            $data[$key]['orderid'] = $val->orderid ?? 'N/A';
            $data[$key]['qty'] = $val->qty ?? 'N/A';
            $data[$key]['price'] = $val->price ?? 'N/A';
            $data[$key]['currency'] = $val->currency ?? 'N/A';

            // Check if PostAd exists before accessing its properties
            if ($val->PostAd) {
                $details = MasterUser::where('user_id', $val->PostAd->user_id)->first();
                if ($details) {
                    $data[$key]['sales_clerk'] = $details->first_name . ' ' . $details->last_name;
                    $data[$key]['phone_no'] = $details->telephone1 ?? 'N/A';
                    $data[$key]['email_id'] = $details->email ?? 'N/A';
                    $data[$key]['post_code'] = $details->postal_code ?? 'N/A';
                    $data[$key]['address'] = $details->other_add ?? 'N/A';
                    $data[$key]['user_rating'] = userProfileResult($details->user_id);
                } else {
                    $data[$key]['sales_clerk'] = 'N/A';
                    $data[$key]['phone_no'] = 'N/A';
                    $data[$key]['email_id'] = 'N/A';
                    $data[$key]['post_code'] = 'N/A';
                    $data[$key]['address'] = 'N/A';
                    $data[$key]['user_rating'] = 'N/A';
                }
            } else {
                $data[$key]['sales_clerk'] = 'N/A';
                $data[$key]['phone_no'] = 'N/A';
                $data[$key]['email_id'] = 'N/A';
                $data[$key]['post_code'] = 'N/A';
                $data[$key]['address'] = 'N/A';
                $data[$key]['user_rating'] = 'N/A';
            }

            $data[$key]['date_of_purchase'] = date("F d, Y H:i", strtotime($val->created_at));
        }

        return response()->json($data);
    }
}
