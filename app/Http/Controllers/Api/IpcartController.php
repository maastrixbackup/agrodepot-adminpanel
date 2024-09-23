<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OfflineCart;
use App\Models\PostadImg;
use App\Models\SalesAdvertisement;
use Illuminate\Http\Request;

class IpcartController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'adv_id' => 'required',
            'qty' => 'required',
            'b2b' => 'required'
        ]);
        $ipaddress = $request->ip();

        if ($request->adv_id) {
            $adv =  SalesAdvertisement::where('adv_id', $request->adv_id)->first();

            if (!empty($request->b2b)) {
                $price = $adv->b2bprice;
            } else {
                $price = $adv->price;
            }
            $alreadyAdded = OfflineCart::where("adv_id", $request->adv_id)->where('ip_address', $ipaddress)->first();

            if ($alreadyAdded)
                $objCart = OfflineCart::where("adv_id", $request->adv_id)->where('ip_address', $ipaddress)->first();
            else
                $objCart = new OfflineCart();
            $objCart->ip_address = $ipaddress;
            $objCart->adv_id = $request->adv_id;
            $objCart->qty = $request->qty;
            $objCart->total_price = number_format($price * $request->qty, 2);
            $objCart->created_at = date('Y-m-d h:i:s');
            $objCart->updated_at = date('Y-m-d h:i:s');
            $objCart->save();
            return response()->json(['msg' => 'Added to Cart Successfully']);
        }
    }
    public function emptyCart(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required',
            ]);
            $ipaddress = $request->ip();

            $cart = OfflineCart::where('ip_address', $ipaddress)->delete();

            return response()->json(['msg' => 'Cart emptied']);
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'There was an error,please try again']);
            //throw $th;
        }
    }
    public function destroy(string $id)
    {
        $cart = OfflineCart::where('id', $id)->first();

        if (OfflineCart::destroy($cart->id)) {
            return response()->json(['msg' => 'Product deleted from cart Successfully']);
        } else {
            return response()->json(['msg' => 'Something went wrong !! Please try again later.']);
        }
    }
    public function lists(Request $request)
    {
        $ipaddress = $request->ip();


        $cart_data = array();
        $cart_list = OfflineCart::where('ip_address', $ipaddress)->get();
        $total_cart_price = 0;
        $total_items = 0; // Initialize total items counter

        if (!empty($cart_list)) {
            foreach ($cart_list as $key => $val) {
                $adv = SalesAdvertisement::where('adv_id', $val->adv_id)->first();
                $productImages = PostadImg::where('post_ad_id', $adv->adv_id)->first();
                $item_total_price = $val->qty * $adv->price;
                $total_cart_price += $item_total_price;
                $total_items++; // Increment total items counter
                if ($productImages) {
                    $filePath = public_path('uploads/postad/' . $productImages->img_path);
                    if (file_exists($filePath) && $productImages->img_path != "") {
                        $cart_data[$key]['image'] = asset('uploads/postad/' . $productImages->img_path);
                    } else {
                        $cart_data[$key]['image'] = asset('uploads/postad/noimage.jpg');
                    }
                }
                $cart_data[$key]['adv'] = $adv;
                $cart_data[$key]['id'] = $val->id;
                $cart_data[$key]['user_id'] = $val->user_id;
                $cart_data[$key]['adv_id'] = $val->adv_id;
                $cart_data[$key]['qty'] = $val->qty;
                $cart_data[$key]['total_price'] = $val->total_price;
                $cart_data[$key]['created_at'] = $val->created_at;
                $cart_data[$key]['updated_at'] = $val->updated_at;
            }
        }

        return response()->json([
            'data' => $cart_data,
            'total_cart_price' => $total_cart_price,
            'total_items' => $total_items // Include total items in the response
        ]);
    }
    public function update(Request $request)
    {
        $ipaddress = $request->ip();


        $adv_id = $request->adv_id;
        $qty = $request->quantity;

        $cart = OfflineCart::where('ip_address', $ipaddress)->where('adv_id', $adv_id)->first();

        $adv =  SalesAdvertisement::where('adv_id', $adv_id)->first();
        if ($cart->qty + $qty >= $adv->quantity) {
            return response()->json(['msg' => 'Maximum quantity already added to cart']);
        }
        if ($cart->qty + $qty == 0) {
            $this->destroy($cart->id);
        }
        if (!empty($request->b2b)) {
            $price = $adv->b2bprice;
        } else {
            $price = $adv->price;
        }

        $cart->qty = $cart->qty + $qty;
        $cart->delivery_method = $request->delivery_method ? $request->delivery_method : $cart->delivery_method;



        $cart->total_price = number_format($price * $request->quantity, 2);
        if ($cart->save()) {
            $cart_list = OfflineCart::where('ip_address', $ipaddress)->get();
            return response()->json(['data' => $cart_list, 'msg' => 'Cart Updated Successfully']);
        } else {
            return response()->json(['msg' => 'Something went wrong !! Please try again later.']);
        }
    }
}
