<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\PostadImg;
use App\Models\SalesAdvertisement;
use Illuminate\Http\Request;

class WishlistController extends Controller
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
        ]);

        if ($request->adv_id) {
            $alreadyAdded = Wishlist::where("adv_id", $request->adv_id)->where('user_id', $request->user_id)->first();

            if ($alreadyAdded)
                $objwishlist = Wishlist::where("adv_id", $request->adv_id)->where('user_id', $request->user_id)->first();
            else
                $objwishlist = new Wishlist();
            $objwishlist->user_id = $request->user_id;
            $objwishlist->adv_id = $request->adv_id;
            $objwishlist->save();
            return response()->json(['msg' => 'Added to Wishlist Successfully']);
        }
    }
    // public function emptyWishlist(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'user_id' => 'required',
    //         ]);
    //         $wishlist = Wishlist::where('user_id', $request->user_id)->delete();

    //         return response()->json(['msg' => 'Wishlist emptied']);
    //     } catch (\Throwable $th) {
    //         return response()->json(['msg' => 'There was an error,please try again']);
    //         //throw $th;
    //     }
    // }

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
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $wish_list_id = $request->id;
        $wishlist = Wishlist::where('id', $wish_list_id)->first();

        if (Wishlist::destroy($wishlist->id)) {
            return response()->json(['msg' => 'Advertisement deleted from Wishlist Successfully']);
        } else {
            return response()->json(['msg' => 'Something went wrong !! Please try again later.']);
        }
    }

    public function lists(Request $request)
    {
        $request->validate([
            'user_id' => 'required'
        ]);

        $wishlist_data = array();
        $user_id = $request->user_id;
        $wishlist_list = Wishlist::where('user_id', $user_id)->get();

        if (!empty($wishlist_list)) {
            foreach ($wishlist_list as $key => $val) {
                $adv = SalesAdvertisement::where('adv_id', $val->adv_id)->first();

                if ($adv !== null) {
                    $ProductsImages = PostadImg::where('post_ad_id', $adv->adv_id)->first();
                    $imagePath = $ProductsImages ? public_path('uploads/postad/' . $ProductsImages->img_path) : null;
                    $wishlist_data[$key]['id'] = $val->id;
                    $wishlist_data[$key]['availablity'] = $val->availability;
                    $wishlist_data[$key]['slug'] = $adv->slug;
                    $wishlist_data[$key]['adv_id'] = $adv->adv_id;
                    $wishlist_data[$key]['adv_name'] = $adv->adv_name;
                    if ($imagePath && file_exists($imagePath)) {
                        $wishlist_data[$key]['image'] = asset('uploads/postad/' . $ProductsImages->img_path);
                    } else {
                        $wishlist_data[$key]['image'] = asset('uploads/postad/noimage.jpg');
                    }
                    $wishlist_data[$key]['price'] = $adv->price;
                    $wishlist_data[$key]['currency'] = $adv->currency;
                } else {
                    $wishlist_data[$key]['no_adv_found'] = "Advertisement not found for wishlist item";
                }
            }
        }
        return response()->json([
            'data' => $wishlist_data,
        ]);
    }
}
