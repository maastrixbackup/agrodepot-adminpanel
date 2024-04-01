<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
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
            foreach ($request->adv_id as $key => $val) {
                $adv =  SalesAdvertisement::where('adv_id', $val)->first();

                if (!empty($request->b2b)) {
                    $price = $adv->b2bprice;
                } else {
                    $price = $adv->price;
                }

                $objCart = new Cart();
                $objCart->user_id = $request->user_id;
                $objCart->adv_id = $val;
                $objCart->qty = $request->qty[$key];
                $objCart->total_price = number_format($price * $request->qty[$key], 2);
                $objCart->created_at = date('Y-m-d h:i:s');
                $objCart->updated_at = date('Y-m-d h:i:s');
                $objCart->save();
            }
            return response()->json(['msg' => 'Added to Cart Successfully']);
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

        $cart = Cart::where('user_id', $user_id)->where('adv_id', $adv_id)->first();

        $adv =  SalesAdvertisement::where('adv_id', $adv_id)->first();

        if (!empty($request->b2b)) {
            $price = $adv->b2bprice;
        } else {
            $price = $adv->price;
        }


        $cart->qty = $request->qty;


        $cart->total_price = number_format($price * $request->qty, 2);
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


    public function  lists(Request $request)
    {
        $request->validate([
            'user_id' => 'required'

        ]);

        $cart_data = array();
        $user_id = $request->user_id;
        $cart_list = Cart::where('user_id', $user_id)->get();

        if (!empty($cart_list)) {
            foreach ($cart_list as $key => $val) {
                $adv =  SalesAdvertisement::where('adv_id', $val->adv_id)->first();
                $cart_data[$key]['id'] = $val->id;
                $cart_data[$key]['user_id'] = $val->user_id;
                $cart_data[$key]['adv_id'] = $val->adv_id;
                $cart_data[$key]['qty'] = $val->qty;
                $cart_data[$key]['adv_name'] = $adv->adv_name;
                $cart_data[$key]['slug'] = $adv->slug;
                $cart_data[$key]['total_price'] = $val->total_price;
                $cart_data[$key]['created_at'] = $val->created_at;
                $cart_data[$key]['updated_at'] = $val->updated_at;
            }
        }

        return response()->json(['data' => $cart_data]);
    }
}
