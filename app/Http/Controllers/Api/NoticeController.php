<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\RequestAccessory;
use App\Models\RequestPart;
use App\Models\SalesAdvertisement;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function getUserNoticeData($userId)
    {
        $notices = Notice::where('user_status', 0)
            ->where('user_id', $userId)
            ->get();

        $data = [];
        if (!$notices->isEmpty()) {
            foreach ($notices as $key => $val) {
                $data[$key]['notice_id'] = $val->notice_id;
                $data[$key]['notice_type'] = $val->notice_type;
                $data[$key]['postid'] = $val->postid;
                $data[$key]['user_id'] = $val->user_id;
                $data[$key]['notice_name'] = $val->notice_name;
                $data[$key]['status'] = $val->status;
                $data[$key]['user_status'] = $val->user_status;
                $data[$key]['created'] = date('d-m-Y', strtotime($val->created));
                if ($val->notice_type == 'sales-add' || $val->notice_type == 'sales-modified'  || $val->notice_type == 'sales-question') {
                    $sales_details = SalesAdvertisement::where('adv_id', $val->postid)->first();
                    if ($sales_details) {
                        $data[$key]['slug'] = '/sales-details/' . $sales_details->slug;
                    }
                } elseif ($val->notice_type === 'request-parts' || $val->notice_type === 'request-modified'  || $val->notice_type === 'request-question') {
                    $request_parts_details = RequestAccessory::where('request_id', $val->postid)->first();
                    if ($request_parts_details) {
                        $data[$key]['slug'] = '/request-parts/' . $request_parts_details->slug;
                    }
                    // } elseif ($val->notice_type === 'sales-order') {
                    //     $sales_order_details = SalesOrder::where('id', $val->postid)->first();
                    //     if ($sales_order_details) {
                    //         $data[$key]['slug'] = '/commands/' . $sales_order_details->id;
                    //     }
                } elseif ($val->notice_type === 'seller-rate') {
                    $data[$key]['slug'] = '/rating-given-buyer/';
                } elseif ($val->notice_type === 'buyer-rate') {
                    $data[$key]['slug'] = '/rating-given-seller/';
                } else {
                    $data[$key]['slug'] = '/rating-given-seller/';
                }
            }
        }

        $noticeCount = $notices->count();
        return response()->json([
            'notice_count' => $noticeCount,
            'notices' => $data
        ]);
    }
    public function clearNotication($userId)
    {
        Notice::where('user_status', 0)
            ->where('user_id', $userId)
            ->update(['user_status' => 1]);
    }
    public function readNotification($notice_id)
    {
        Notice::find($notice_id)
            ->update(['user_status' => 1]);
    }
}
