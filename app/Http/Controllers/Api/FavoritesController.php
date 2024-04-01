<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesAddToFavourite;
use App\Models\SalesAdvertisement;
use App\Models\MasterUser;
use App\Models\PostadImg;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $advid = $request->input('advid');
        $ipaddress = $request->ip();

        $checkfav = SalesAdvertisement::where('user_id', $user_id)
            ->where('adv_id', $advid)
            ->first();

        if ($checkfav) {
            return response()->json(['message' => 'You have already added to favourite']);
        } else {
            $options = [
                'user_id' => $user_id,
                'adv_id' => $advid,
                'ip_address' => $ipaddress,
                'favcount' => 1,
                'created' => date('y-m-d h:i:s'),
                'modified' => date('y-m-d h:i:s')
            ];

            if (SalesAddToFavourite::create($options)) {
                return response()->json(['message' => 'Added to favourites successfully']);
            } else {
                return response()->json(['message' => 'You have Add to favourite adding failed']);
            }
        }
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

    public function mostViewed(Request $request)
    {
        \DB::enableQueryLog();
        $user_id = $request->user_id;
        \DB::statement("SET SQL_BIG_SELECTS=1");

        $most_viewed = SalesAdvertisement::leftJoin('sales_view', 'sales_view.adv_id', '=', 'sales_advertisements.adv_id')
            ->select('sales_advertisements.*', \DB::raw('COUNT(*) as totview'))
            ->where('sales_advertisements.user_id', $user_id)
            ->groupBy('sales_advertisements.adv_id')
            ->orderByDesc('totview')
            ->limit(10)
            ->get();
        $most_viewd_data = [];
        if (!empty($most_viewed)) {
            foreach ($most_viewed as $key => $row) {
                $adv_id = stripslashes($row->adv_id);
                $adv_name = stripslashes($row->adv_name);
                $slug = stripslashes($row->slug);
                $PostadImg = PostadImg::where('post_ad_id', $adv_id)->first();
                $adImg = !empty($PostadImg->img_path) ? $PostadImg->img_path : "";


                $most_viewd_data[$key]['opinion'] =  $adv_name;
                $most_viewd_data[$key]['image_ad'] =    asset('uploads/postad/' . $adImg);
                $most_viewd_data[$key]['total_view'] =  $row->totview;
                $most_viewd_data[$key]['slug'] =  $slug;
            }
        }

        return response()->json(['data' =>  $most_viewd_data]);
        //dd(\DB::getQueryLog());
    }

    public function favorites(Request $request)
    {
        \DB::enableQueryLog();
        $user_id = $request->user_id;
        \DB::statement("SET SQL_BIG_SELECTS=1");


        $fav =   \DB::select("select `sales_advertisements`.*, COUNT(*) as totfav, `sales_add_to_favourites`.`user_id` 
            from `sales_advertisements` 
            left join `sales_add_to_favourites` 
            on `sales_add_to_favourites`.`adv_id` = `sales_advertisements`.`adv_id` 
            where `sales_add_to_favourites`.`user_id` = " . $user_id . " 
            group by `sales_advertisements`.`adv_id` 
            order by `totfav` desc 
            limit 10");

        //dd(\DB::getQueryLog());
        $fav_data = [];

        if (!empty($fav)) {
            foreach ($fav as $key => $row) {
                $user = MasterUser::where('user_id', $row->user_id)->first();
                $adv_id = stripslashes($row->adv_id);
                $adv_name = stripslashes($row->adv_name);
                $slug = stripslashes($row->slug);
                $PostadImg = PostadImg::where('post_ad_id', $adv_id)->first();
                $adImg = !empty($PostadImg->img_path) ? $PostadImg->img_path : "";


                $fav_data[$key]['opinion'] =  $adv_name;
                $fav_data[$key]['image_ad'] =    asset('uploads/postad/' . $adImg);
                $fav_data[$key]['total_view'] =  $row->totfav;
                $fav_data[$key]['slug'] =  $slug;
                $fav_data[$key]['sales_clerk'] =   !empty($user) ?  $user->first_name . ' ' . $user->last_name : "";
                $fav_data[$key]['userId'] =   !empty($user) ?  $user->user_id  : 0;
            }
        }

        return response()->json(['data' =>  $fav_data]);
        //dd(\DB::getQueryLog());
    }

    public function isFavorite(Request $request)
    {
        $user_id = $request->user_id;
        $adv_id =  $request->advid;

        $user_type_id = MasterUser::where('user_id',$user_id)->first()->user_type_id;
       
        $sale_add_to_favs = SalesAddToFavourite::where('user_id', $user_id)->where('adv_id', $adv_id)->first();
        $sale_advs = SalesAdvertisement::where('adv_id', $adv_id)->first();
          
        $price = 0;
        if($user_type_id == 3){
            $price =  isset($sale_advs->b2bprice) ? $sale_advs->b2bprice : 0 ;
        }
       
        $data = !empty($sale_add_to_favs) ? 1 : 0;
        return response()->json(['data' =>  $data ,'b2bprice' => $price ]);
    }

    public function favoritesAds(Request $request)
    {
        \DB::enableQueryLog();
        $user_id = $request->user_id;
        \DB::statement("SET SQL_BIG_SELECTS=1");

        $fav =  \DB::select("SELECT `sales_advertisements`.*, COUNT(*) as totfav, `sales_add_to_favourites`.`user_id` 
            FROM `sales_advertisements` 
            LEFT JOIN `sales_add_to_favourites` 
            ON `sales_add_to_favourites`.`adv_id` = `sales_advertisements`.`adv_id` 
            WHERE `sales_advertisements`.`user_id` = " . $user_id . "  
            GROUP BY `sales_advertisements`.`adv_id`, `sales_add_to_favourites`.`user_id` 
            ORDER BY `totfav` DESC 
            LIMIT 10");

        // dd(\DB::getQueryLog());
        $fav_data = [];

        if (!empty($fav)) {
            foreach ($fav as $key => $row) {
                $user = MasterUser::where('user_id', $row->user_id)->first();
                $adv_id = stripslashes($row->adv_id);
                $adv_name = stripslashes($row->adv_name);
                $slug = stripslashes($row->slug);
                $PostadImg = PostadImg::where('post_ad_id', $adv_id)->first();
                $adImg = !empty($PostadImg->img_path) ? $PostadImg->img_path : "";


                $fav_data[$key]['opinion'] =  $adv_name;
                $fav_data[$key]['image_ad'] =    asset('uploads/postad/' . $adImg);
                $fav_data[$key]['total_view'] =  $row->totfav;
                $fav_data[$key]['slug'] =  $slug;
                $fav_data[$key]['sales_clerk'] =   !empty($user) ?  $user->first_name . ' ' . $user->last_name : "";
                $fav_data[$key]['userId'] =   !empty($user) ?  $user->user_id  : 0;
            }
        }
        return response()->json(['data' =>  $fav_data]);
    }
}
