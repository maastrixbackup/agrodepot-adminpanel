<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatusUpdated;
use Illuminate\Http\Request;
use App\Models\SalesOrder;
use App\Models\SalesAdvertisement;
use App\Models\BidImg;
use App\Models\MasterUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SalesOrder::with('salesAdvertisement.user')
            ->leftjoin('master_users as ms', 'sales_order.user_id', '=', 'ms.user_id')
            ->leftjoin('sales_advertisements as sa', 'sales_order.adv_id', '=', 'sa.adv_id')
            ->select('sales_order.*', 'sa.adv_name', 'sa.user_id', 'ms.first_name', 'ms.last_name')
            ->get();

        return view("reports.sales_order", compact("data"));
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
        $data = SalesOrder::with('salesAdvertisement.user')
            ->leftjoin('master_users as ms', 'sales_order.user_id', '=', 'ms.user_id')
            ->leftjoin('sales_advertisements as sa', 'sales_order.adv_id', '=', 'sa.adv_id')
            ->select('sales_order.*', 'sa.adv_name', 'sa.user_id', 'ms.first_name', 'ms.last_name')
            ->where('sales_order.id', $id)
            ->first();

        return view("reports.sales_view", compact("data"));
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
        $order = SalesOrder::find($id);

        $order->delete();
        return redirect()->route('saleorder.index')->with('success', 'SalesOrder deleted successfully');
    }

    public function getAllOrders(string $id)
    {
        $data = SalesOrder::with('subBrand', 'subCategory')
            ->leftjoin('sales_advertisements as sa', 'sales_order.adv_id', '=', 'sa.adv_id')
            ->leftjoin('sales_categories as ca', 'sa.category_id', '=', 'ca.category_id')
            ->leftjoin('sales_brands as sb', 'sa.adv_brand_id', '=', 'sb.brand_id')
            ->select('sales_order.*', 'sa.*', 'ca.category_name', 'sb.brand_name')
            ->where('sales_order.id', $id)
            ->first();

        $images = DB::table('sales_order as so')

            ->leftjoin('sales_advertisements as sa', 'so.adv_id', '=', 'sa.adv_id')
            ->leftjoin('postad_img as pi', 'sa.adv_id', '=', 'pi.post_ad_id')
            ->select('pi.img_path')
            ->where('so.id', $id)
            ->get();

        return view("reports.order_view", compact("data", "images"));
    }

    public function updateDeliveryStatus(Request $request, $Id)
    {
        $sales = SalesOrder::find($Id);
        $sales->delivery_status = $request->input('delivery_status');
        $sales->save();

        return response()->json(['message' => 'Status updated successfully', 'status' => $sales->delivery_status]);
    }

    public function updateStatus(Request $request, $Id)
    {
        $sales = SalesOrder::find($Id);
        $UserDetails = MasterUser::where('user_id', $sales->user_id)->first();
        $Usermail = $UserDetails->email;
        $status = $request->input('status');

        // Define a mapping of status codes to text representations
        $statusTexts = [
            '0' => 'New order',
            '1' => 'Confirmed order',
            '2' => 'Completed order',
            '3' => 'Shipped order',
            '4' => 'Cancelled order'
        ];

        // Get the text representation of the status
        $statusText = $statusTexts[$status] ?? 'Unknown status';

        // Define product review URL if status is "Completed order"
        $productReviewUrl = null;
        if ($status === '2') { // '2' corresponds to "Completed order"
            // You should replace 'product_id' and 'website_url' with actual values from your application
            $productReviewUrl = "https://agrodepot-frontend.vercel.app/piese-auto";
        }

        $sales->status = $status;
        $sales->save();

        // Send email
        Mail::to('amlannayak530@gmail.com')->send(new OrderStatusUpdated($statusText, $productReviewUrl));

        return response()->json(['message' => 'Status updated successfully', 'status' => $statusText]);

        return response()->json(['message' => 'Status updated successfully', 'status' => $statusText]);
    }
}
