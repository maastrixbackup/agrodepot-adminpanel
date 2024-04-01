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
        $salesOrders = SalesOrder::leftJoin('sales_advertisements as PostAd', 'PostAd.adv_id', '=', 'sales_order.adv_id')
            ->where('sales_order.user_id', $userid)
            ->select('PostAd.*', 'sales_order.*')
            ->orderBy('sales_order.orderid', 'desc')
            ->get();
        // dd($salesOrders);
        foreach ($salesOrders as $key => $val) {
            $data[$key]['id'] =  $val->id;
            $data[$key]['adv_id'] = isset($val->PostAd->adv_id) ? $val->PostAd->adv_id : 'N/A';
            $data[$key]['adv_name'] =  isset($val->PostAd->adv_name) ? $val->PostAd->adv_name : 'N/A';
            $data[$key]['orderid'] =  isset($val->sales_order->orderid) ? $val->sales_order->orderid : 'N/A';
            $data[$key]['qty'] =  isset($val->sales_order->qty) ? $val->sales_order->qty : 'N/A';
            $data[$key]['price'] =  isset($val->PostAd->price) ? $val->PostAd->price : 'N/A';
            $details = MasterUser::where('user_id', $val->PostAd->user_id)->first();
        }
        return response()->json($data);
    }
}
