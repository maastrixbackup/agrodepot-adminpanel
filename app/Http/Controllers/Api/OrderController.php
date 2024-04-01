<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterMessage;
use App\Models\MasterCountry;
use App\Models\MasterLocation;
use App\Models\Notice;
use App\Models\SalesAdvertisement;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use App\Models\SalesWarranty;
use App\Models\MasterUser;
use App\Models\UserRating;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use DB;
use App\Mail\SalesOrderMail;
use App\Mail\SalesOrderAdminMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $userid = $request->userId;

        $warrantyDetails = SalesWarranty::where('user_id', $userid)->first();

        if (!empty($warrantyDetails)) {
            $msgdetail = ($warrantyDetails->message_response == 1) ?
                '<table><tr><td colspan="3">' . nl2br(stripslashes($warrantyDetails->message_content)) . '</td></tr></table>' :
                '<table><tr><td colspan="3">Your order booked has been successfully purchased.<br/></td></tr><tr><td colspan="3">Thank you for your purchase!<br/><br/></td></tr></table>';
        } else {
            $msgdetail = '</table><tr><td colspan="3">Your order booked has been successfully purchased.<br/></td></tr><tr><td colspan="3">Thank you for your purchase!<br/><br/></td></tr></table>';
        }
        $lastOrder = SalesOrder::orderBy('id', 'desc')->first();
        $orderID = '';

        if (!empty($lastOrder)) {
            $lsid = $lastOrder->orderid;
            $lastEmpId = explode('R', $lsid);
            $lastEmpId1 = $lastEmpId[1] + 1;
            $orderID = $lastEmpId[0] . 'R' . $lastEmpId1;
        } else {
            $orderID = 'OR10001';
        }


        $alreadyOrdered = SalesOrder::where('user_id', $userid)->where('adv_id', $request->adv_id)->first();
        if ($alreadyOrdered) {
            return response()->json(['message' => 'You have already ordered this item once!'], 300);
        }
        $product = SalesAdvertisement::find($request->adv_id[1]);

        $user = MasterUser::where('user_id', $userid)->first();
        $newOrder = new SalesOrder();
        $newOrder->user_id = $userid;
        $newOrder->orderid = $orderID;
        $newOrder->adv_id = $request->adv_id[1];
        $newOrder->qty = $request->addedQuantity[1];
        $newOrder->totprice = $request->addedQuantity[1] * $product->price;
        $newOrder->delivery_method = $request->deliveryMethod[1];
        $newOrder->fname = $request->first_name;
        $newOrder->lname = $request->last_name;
        $newOrder->phone = $request->telephone1;
        $newOrder->county = $request->country_id;
        $newOrder->location = $request->locality_id;
        $newOrder->postcode = $request->postal;
        $newOrder->delivery_add = $request->deliveryAddress;
        $newOrder->status = 0;
        $newOrder->delivery_status = 0;
        $newOrder->note_command = "";
        $newOrder->save_info = 0;
        $newOrder->created = date('y-m-d h:m:s');
        $newOrder->modified = date('y-m-d h:m:s');
        if ($newOrder->save()) {
            $tr = "";
            if (!empty($request->adv_id)) {
                foreach ($request->adv_id as $key => $val) {
                    $product = SalesAdvertisement::find($request->adv_id[$key]);
                    $objSalesOrderDetail = new SalesOrderDetail();
                    $objSalesOrderDetail->order_id =  $orderID;
                    $objSalesOrderDetail->adv_id = $val;
                    $objSalesOrderDetail->product_quantity = $request->addedQuantity[$key];
                    $objSalesOrderDetail->amount = $request->addedQuantity[$key] * $product->price;
                    $objSalesOrderDetail->email = $user->email;
                    $objSalesOrderDetail->name = $request->first_name . ' ' . $request->last_name;
                    $objSalesOrderDetail->phone_mobile = $request->telephone1;
                    $objSalesOrderDetail->region_id = $request->country_id;
                    $objSalesOrderDetail->locality_id = $request->locality_id;
                    $objSalesOrderDetail->zip = $request->postal;
                    $objSalesOrderDetail->address = $request->deliveryAddress;
                    $objSalesOrderDetail->notes = "";
                    $objSalesOrderDetail->seller_notes = "";
                    $objSalesOrderDetail->delivery = "";
                    $objSalesOrderDetail->status = 0;
                    $objSalesOrderDetail->delivery_method  =  $request->deliveryMethod[$key];
                    $objSalesOrderDetail->created = date('y-m-d h:m:s');
                    $objSalesOrderDetail->modified = date('y-m-d h:m:s');
                    $objSalesOrderDetail->save();

                    $tr .= '<tr><td>' . stripslashes($product->adv_name) . '</td><td>' . stripslashes($request->addedQuantity[$key]) . '</td><td>' . stripslashes($request->addedQuantity[$key] * $product->price) . ' RON</td></tr>';

                    $notice = new Notice();
                    $notice->notice_type = "sales-order";
                    $notice->postid = $request->adv_id[$key];
                    $notice->notice_name = "Sales Order";
                    $notice->user_id = $userid;
                    $notice->save();
                }
            }

            $MyPurchaseLink = '<a href="https://agrodepot-frontend.vercel.app/dashboard/my-purchases">here</a>';


            $OrderrId = 'Order ID#: <strong>' . $orderID . '</strong>';
            $OrderDetaill = '<table width="492" border="1">
                            <tr>
                            <td width="30%" align="center">Title</td>
                            <td width="31%" align="center">Quantity</td>
                            <td width="30%" align="center">Price</td>
                            </tr>' . $tr . '<table>';

            $emailTemplate = EmailTemplate::where('email_of', 3)->first()->mail_body;
            $emailTemplate = str_replace("{Name}", $request->first_name . ' ' . $request->last_name, $emailTemplate);
            $emailTemplate = str_replace("{sellerMsgDetail}", '', $emailTemplate);
            $emailTemplate = str_replace("{MyPurchaseLink}", $MyPurchaseLink, $emailTemplate);
            $emailTemplate = str_replace("{OrderId}", $OrderrId, $emailTemplate);
            $emailTemplate = str_replace("{OrderDetail}", $OrderDetaill, $emailTemplate);

            $body =  $emailTemplate;

            $body = [
                'body' => $body
            ];

            Mail::to('swetalina.maastrix@gmail.com')->send(new SalesOrderMail($body));


            $emailTemplate1 = EmailTemplate::where('email_of', 5)->first()->mail_body;



            $emailTemplate1 = str_replace("{Name}", $request->first_name . ' ' . $request->last_name, $emailTemplate1);
            $emailTemplate1 = str_replace('{OrderId}', $OrderrId, $emailTemplate1);
            $emailTemplate1 = str_replace('{orderDetail}', $OrderDetaill, $emailTemplate1);

            $body1 =  $emailTemplate1;

            $body1 = [
                'body' => $body1
            ];

            Mail::to('swetalina.maastrix@gmail.com')->send(new SalesOrderAdminMail($body1));


            return response()->json(['message' => 'Order Placed Succesfully'], 200);
        }
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

    /**
     * Show the new orders.
     */

    public function Order(Request $request)
    {
        $request->validate([
            'user_id' => 'required'

        ]);
        $status = $request->status;
        if (!empty($status)) {
            $andwhr = [
                ['post_ads.user_id', '=', $request->user_id],
                ['sales_order.status', '=', $status]
            ];
        } else {
            $andwhr = [
                ['post_ads.user_id', '=', $request->user_id]
            ];
        }

        $sales_orders_data = [];
        $SalesOrders = DB::table('sales_order')
            ->leftJoin('sales_advertisements as post_ads', 'post_ads.adv_id', '=', 'sales_order.adv_id')
            ->select('post_ads.adv_name', 'post_ads.price', 'post_ads.slug', 'post_ads.currency', 'post_ads.personal_teaching', 'post_ads.courier', 'post_ads.courier_cost', 'post_ads.free_courier', 'post_ads.romanian_mail', 'post_ads.romanian_mail_cost', 'post_ads.free_romanian_mail', 'sales_order.user_id', 'sales_order.orderid', 'sales_order.qty', 'sales_order.fname', 'sales_order.lname', 'sales_order.county', 'sales_order.location', 'sales_order.postcode', 'sales_order.delivery_add', 'sales_order.totprice', 'sales_order.delivery_method', 'sales_order.created')
            ->where($andwhr)
            ->orderBy('sales_order.orderid', 'desc')
            ->limit(10)
            ->get();

        if (!empty($SalesOrders)) {
            foreach ($SalesOrders as $key =>  $SalesOrdersRes) {
                $user = MasterUser::where('user_id', $SalesOrdersRes->user_id)->first();
                $sales_orders_data[$key]['adv_name'] =   isset($SalesOrdersRes->adv_name) ? $SalesOrdersRes->adv_name  : "";
                $sales_orders_data[$key]['order_id'] =   isset($SalesOrdersRes->orderid) ? $SalesOrdersRes->orderid  : "";
                $sales_orders_data[$key]['qty'] =   isset($SalesOrdersRes->qty) ? $SalesOrdersRes->qty  : "";
                $sales_orders_data[$key]['price'] =   isset($SalesOrdersRes->price) ? $SalesOrdersRes->price  : "";
                $sales_orders_data[$key]['created'] =   isset($SalesOrdersRes->created) ? $SalesOrdersRes->created  : "";
                $sales_orders_data[$key]['slug'] =   isset($SalesOrdersRes->slug) ? $SalesOrdersRes->slug  : "";
                $sales_orders_data[$key]['currency'] =   isset($SalesOrdersRes->currency) ? $SalesOrdersRes->currency  : "";
                $personal_teaching =   isset($SalesOrdersRes->personal_teaching) ? $SalesOrdersRes->personal_teaching  : "";
                $courier =   isset($SalesOrdersRes->courier) ? $SalesOrdersRes->courier  : "";
                $courier_cost =   isset($SalesOrdersRes->courier_cost) ? $SalesOrdersRes->courier_cost  : "";
                $free_courier =   isset($SalesOrdersRes->free_courier) ? $SalesOrdersRes->free_courier  : "";
                $romanian_mail =   isset($SalesOrdersRes->romanian_mail) ? $SalesOrdersRes->romanian_mail  : "";
                $romanian_mail_cost =   isset($SalesOrdersRes->romanian_mail_cost) ? $SalesOrdersRes->romanian_mail_cost  : "";
                $free_romanian_mail =   isset($SalesOrdersRes->free_romanian_mail) ? $SalesOrdersRes->free_romanian_mail  : "";

                $sales_orders_data[$key]['user_id'] =  isset($user->user_id) ? $user->user_id : "";
                $sales_orders_data[$key]['odered_prin'] = isset($user->first_name) ? $user->first_name . ' ' . $user->last_name : "";
                $sales_orders_data[$key]['phone_no'] = isset($user->telephone1) ? $user->telephone1 : "";
                $sales_orders_data[$key]['email'] = isset($user->email) ? $user->email : "";
                $sales_orders_data[$key]['postal_code'] = isset($user->postal_code) ? $user->postal_code : "";
                $sales_orders_data[$key]['address'] = isset($user->other_add) ? $user->other_add : "";

                $sales_orders_data[$key]['delivery_name'] = isset($SalesOrdersRes->fname) ? $SalesOrdersRes->fname . ' ' . $SalesOrdersRes->lname : "";


                $cname = "";
                if (!empty($SalesOrdersRes->county)) {

                    $country = MasterCountry::where('country_id', $SalesOrdersRes->county)->first();

                    if (!empty($country)) {
                        $cname =  $country->country_name;
                    }
                }



                $location = "";
                if (!empty($SalesOrdersRes->location)) {
                    $locationrow = MasterLocation::where('location_id', $SalesOrdersRes->location)->first();
                    if (!empty($locationrow)) {
                        $location =  trim($locationrow->location_name);
                    }
                }

                $sales_orders_data[$key]['country'] = $cname;
                $sales_orders_data[$key]['location'] = $location;
                $sales_orders_data[$key]['postal_code'] = isset($SalesOrdersRes->postcode) ? $SalesOrdersRes->postcode : "";
                $sales_orders_data[$key]['delivery_address'] = isset($SalesOrdersRes->delivery_add) ? $SalesOrdersRes->delivery_add : "";

                if ($SalesOrdersRes->delivery_method == "Personal Teaching") {
                    if ($personal_teaching == 1) {
                        $dm = 'Personal Teaching';
                    }
                } else if ($SalesOrdersRes->delivery_method == "courier") {
                    if ($courier == 1 || $free_courier == 1) {
                        if ($free_courier == 1) {
                            $cost = 'free shipping';
                        } else {
                            $cost = $courier_cost . ' RON';
                        }

                        $dm = 'Courier(' . $cost . ')';
                    }
                } else if ($SalesOrdersRes->delivery_method == "roman") {

                    if ($romanian_mail == 1 || $free_romanian_mail == 1) {
                        if ($free_romanian_mail == 1) {
                            $rcost = 'free shipping';
                        } else {
                            $rcost = $romanian_mail_cost . ' RON';
                        }

                        $dm = 'ROMANIANMAIL(' . $rcost . ')';
                    }
                }
                $sales_orders_data[$key]['delivery_method'] = $dm;
                $sales_orders_data[$key]['pre_total'] = isset($SalesOrdersRes->totprice) ? $SalesOrdersRes->totprice : "";

                $grade = 0;
                if (!empty($user->user_id)) {
                    $allpositivegrade = UserRating::where('user_id', $user->user_id)
                        ->orderBy('rating_id', 'desc')
                        ->get();

                    $grade = 0;

                    if ($allpositivegrade->isNotEmpty()) {
                        foreach ($allpositivegrade as $rating) {
                            $grade += $rating->grade;
                        }
                    }
                }

                $sales_orders_data[$key]['rating'] =  $grade;
            }
        }
        return response()->json(['data' => $sales_orders_data]);
    }

    public function outOfStock(Request $request)
    {
        $user_id = $request->user_id;

        DB::enableQueryLog();
        $outofstocks = SalesOrder::leftJoin('sales_advertisements', 'sales_order.adv_id', '=', 'sales_advertisements.adv_id')
            ->selectRaw('sales_advertisements.*, SUM(sales_order.qty) as totqty')
            ->where('sales_advertisements.adv_status', 1)
            ->where('sales_advertisements.user_id', $user_id)
            ->orderBy('sales_advertisements.adv_id', 'desc')
            ->groupBy('sales_order.adv_id')
            ->get();

        //dd(DB::getQueryLog());
        $outofstock_data = [];
        if (!empty($outofstocks)) {
            foreach ($outofstocks as $key =>  $outofstock) {
                if ($outofstock->totqty == $outofstock->quantity) {
                    $rw = SalesOrder::where('adv_id', $outofstock->adv_id)->first();
                    $orderID = $rw->orderid;
                    $qty = $rw->qty;
                    $price = $outofstock->price;
                    $created = $rw->created;
                    $slug = $outofstock->slug;
                    $currency = $outofstock->currency;

                    $outofstock_data[$key]['adv_name'] =   isset($outofstock->adv_name) ? $outofstock->adv_name  : "";
                    $outofstock_data[$key]['order_id'] =   $orderID;
                    $outofstock_data[$key]['qty'] =   $qty;
                    $outofstock_data[$key]['price'] =   $price;
                    $outofstock_data[$key]['currency'] =   $currency;
                    $outofstock_data[$key]['created'] =  $created;
                    $outofstock_data[$key]['slug'] =  $slug;
                }
            }
        }
        return response()->json(['data' => $outofstock_data]);
    }
}
