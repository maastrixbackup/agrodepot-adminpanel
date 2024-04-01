<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesAdvertisement;
use App\Models\SalesCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function getCategories($paginate = "")
    {
        if ($paginate)
            $detailsCat = SalesCategory::where('flag', 0)->paginate(5);
        else
            $detailsCat = SalesCategory::where('flag', 0)->get();
        foreach ($detailsCat as $key => $cat) {
            $category_data = SalesCategory::where("flag", $cat->category_id)->get();
            $count = SalesAdvertisement::where("category_id", $cat->category_id)->where("adv_status", 1)->count();
            $cat['count'] = $count;
            foreach ($category_data as $key => $value) {
                $count = SalesAdvertisement::where("sub_cat_id", $value->category_id)->where("category_id", $cat->category_id)->where("adv_status", 1)->count();
                $value['count'] = $count;
            }
            $cat['subCategory'] = $category_data;
        }
        return response()->json($detailsCat);
    }
}
