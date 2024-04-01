<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesAdvertisement;
use App\Models\SalesBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    //
    public function BrandsList(Request $req)
    {
        \DB::enableQueryLog();
        $dontPaginate = $req->dontPaginate;
        $pageno = $req->pageNo ?? 1;
        $postsPerPage = 5;
        $toSkip = $postsPerPage * $pageno - $postsPerPage;
        $query = SalesBrand::where("flag", 0)->where("status", 1)->orderBy('ordering', 'asc')->select('brand_id', 'brand_name', 'image', 'slug');
        $totalCount = $query->count();
        $data = $dontPaginate ? $query->get() : $query->skip($toSkip)->take($postsPerPage)->get();
        // dd($data);
        if ($data) {
            foreach ($data as $key => $value) {
                $subCategories = SalesBrand::where("flag", $value->brand_id)->where("status", 1)->orderBy('ordering', 'asc')->select('brand_id', 'brand_name', 'image', 'slug')->get();
                $filePath = public_path('uploads/brand/' . $value->image);
                $count = SalesAdvertisement::where("adv_brand_id", "$value->brand_id")->where("adv_status", '1')->count();
                $value['count'] = $count;


                if (file_exists($filePath) && $value->image != "") {
                    $value['image'] = asset('uploads/brand/' . $value->image);
                } else {
                    $value['image'] = asset('uploads/brand/noimage.jpg');
                }
                $scount = 0;
                if ($subCategories) {
                    foreach ($subCategories as $key => $subcategory) {
                        $scount = SalesAdvertisement::where("adv_model_id", "$subcategory->brand_id")->where("adv_status", '1')->count();
                        $subcategory['count'] = $scount;
                        $filePath = public_path('uploads/brand/' . $subcategory->image);
                        if (file_exists($filePath) && $subcategory->image != "") {
                            $subcategory['image'] = asset('uploads/brand/' . $subcategory->image);
                        } else {
                            $subcategory['image'] = null;
                        }
                    }
                }
                $value['subBrands'] = $subCategories;
            }
        }
        return response()->json(["data" => $data, "count" => $totalCount]);
    }
}
