<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\OfflineCart;
use App\Models\PostadImg;
use App\Models\SalesAdvertisement;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        $request->validate([
            'user_id' => 'required',
            'adv_id' => 'required',
            'qty' => 'required',
            'b2b' => 'required'
        ]);

        if ($request->adv_id) {
            $adv =  SalesAdvertisement::where('adv_id', $request->adv_id)->first();

            if (!empty($request->b2b)) {
                $price = $adv->b2bprice;
            } else {
                $price = $adv->price;
            }
            $alreadyAdded = Cart::where("adv_id", $request->adv_id)->where('user_id', $request->user_id)->first();

            if ($alreadyAdded)
                $objCart = Cart::where("adv_id", $request->adv_id)->where('user_id', $request->user_id)->first();
            else
                $objCart = new Cart();
            $objCart->user_id = $request->user_id;
            $objCart->adv_id = $request->adv_id;
            $objCart->qty = $request->qty;
            $objCart->total_price = number_format($price * $request->qty, 2);
            $objCart->created_at = date('Y-m-d h:i:s');
            $objCart->updated_at = date('Y-m-d h:i:s');
            $objCart->save();
            return response()->json(['msg' => 'Added to Cart Successfully']);
        }
    }
    public function updateQuantity(Request $request)
    {

        $request->validate([
            'user_id' => 'required',
            'adv_id' => 'required',
            'qty' => 'required',
            'b2b' => 'required'
        ]);

        if ($request->adv_id) {
            $adv =  SalesAdvertisement::where('adv_id', $request->adv_id)->first();

            if (!empty($request->b2b)) {
                $price = $adv->b2bprice;
            } else {
                $price = $adv->price;
            }

            $objCart = Cart::where("adv_id", $request->adv_id)->where('user_id', $request->user_id)->first();
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
            $cart = Cart::where('user_id', $request->user_id)->delete();

            return response()->json(['msg' => 'Cart emptied']);
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'There was an error,please try again']);
            //throw $th;
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
    public function update(Request $request)
    {
        $user_id = $request->user_id;

        $adv_id = $request->adv_id;
        $qty = $request->quantity;

        $cart = Cart::where('user_id', $user_id)->where('adv_id', $adv_id)->first();

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
            $cart_list = Cart::where('user_id', $user_id)->get();
            return response()->json(['data' => $cart_list, 'msg' => 'Cart Updated Successfully']);
        } else {
            return response()->json(['msg' => 'Something went wrong !! Please try again later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = Cart::where('id', $id)->first();

        if (Cart::destroy($cart->id)) {
            return response()->json(['msg' => 'Product deleted from cart Successfully']);
        } else {
            return response()->json(['msg' => 'Something went wrong !! Please try again later.']);
        }
    }

    public function lists(Request $request)
    {
        $request->validate([
            'user_id' => 'required'
        ]);

        $cart_data = array();
        $user_id = $request->user_id;
        $cart_list = Cart::where('user_id', $user_id)->get();
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

    public function cartSync(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        $ip_address = $request->ip();

        if ($ip_address) {
            $offlineCart = OfflineCart::where('ip_address', $ip_address)->get();

            if ($offlineCart) {
                foreach ($offlineCart as $key => $value) {
                    $cartItem = Cart::where('adv_id', $value->adv_id)
                        ->first();

                    if ($cartItem) {
                        $cartItem->qty += $value->qty;
                        $cartItem->total_price += $value->total_price;
                        $cartItem->updated_at = now();
                        $cartItem->save();
                    } else {
                        $cartItem = new Cart();
                        $cartItem->user_id = $request->user_id;
                        $cartItem->adv_id = $value->adv_id;
                        $cartItem->qty = $value->qty;
                        $cartItem->total_price = $value->total_price;
                        $cartItem->created_at = now();
                        $cartItem->updated_at = now();
                        $cartItem->save();
                    }
                }

                $offlineCart = OfflineCart::where('ip_address', $ip_address)->delete();

                return response()->json(['msg' => 'Cart Sync Successfully']);
            } else {
                return response()->json(['msg' => 'No offline cart found for this IP address'], 404);
            }
        }

        return response()->json(['msg' => 'IP address is required'], 400);
    }
}
