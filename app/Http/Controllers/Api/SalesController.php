<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterCountry;
use App\Models\MasterLocation;
use App\Models\MasterUser;
use App\Models\PostadImg;
use App\Models\SalesAdvertisement;
use App\Models\SalesBrand;
use App\Models\SalesCategory;
use App\Models\SalesQuestion;
use App\Models\SalesWarranty;
use App\Models\UpgradeMembership;
use App\Models\UserMembership;
use App\Models\UserRating;
use App\Models\SalesRating;
use App\Models\SalesView;
use App\Models\SalesAddToFavourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;



class SalesController extends Controller
{
    //
    public function getSalesProducts(Request $req, $uid = null)
    {
        $cat = $req->cat;
        $subcat = $req->subcat;
        $brand = $req->brand;
        $model = $req->model;
        $pageno = $req->pageNo ?? 1;
        $country = $req->country;
        $seller = $req->seller;
        $startingRange = $req->startingRange;
        $endingRange = $req->endingRange;
        $sortBy = $req->sortBy ? $req->sortBy : "adv_id";
        $postsPerPage  = $req->postsPerPage ? $req->postsPerPage : 10;
        $searchTxt  = $req->searchTxt;
        $search = $req->search;
        $toSkip = $postsPerPage * $pageno - $postsPerPage;
        // dd($req->all());
        $salesProducts = SalesAdvertisement::orderBy("adv_id", "desc")->where("adv_status", 1);

        if ($country) {
            $user = MasterUser::where('country_id', $country)->select('user_id')->get();
            $salesProducts->whereIn("user_id", $user);
        }
        if ($cat) {
            $salesProducts->where('category_id', $cat);
        }
        if ($subcat) {
            $salesProducts->where('sub_cat_id', $subcat);
        }
        if ($model) {
            $salesProducts->where('adv_model_id', $model);
        }
        if ($brand) {
            $salesProducts->where('adv_brand_id', $brand);
        }
        if ($seller) {
            $salesProducts->where('user_id', $seller);
        }
        if ($uid) {
            $salesProducts->where('user_id', $uid);
        }
        if ($searchTxt) {

            $userIds = MasterUser::where('first_name', 'like', '%' . $searchTxt . '%')
                ->orWhere('last_name', 'like', '%' . $searchTxt . '%')
                ->pluck('user_id')
                ->toArray();

            $salesProducts->whereIn('user_id', $userIds);
        }

        if ($search) {
            $salesProducts->where('adv_name', 'like', '%' . $search . '%')->orWhere('adv_details', 'like', '%' . $search . '%');

            $categoryIds = SalesCategory::where('category_name', 'like', '%' . $search . '%')
                ->pluck('category_id')
                ->toArray();
            $subcategoryIds = SalesCategory::where('category_name', 'like', '%' . $search . '%')
                ->pluck('category_id')
                ->toArray();

            $brandIds = SalesBrand::where('brand_name', 'like', '%' . $search . '%')
                ->pluck('brand_id')
                ->toArray();

            $modelIds = SalesBrand::where('brand_name', 'like', '%' . $search . '%')
                ->pluck('brand_id')
                ->toArray();

            $salesProducts->whereIn('category_id', $categoryIds)
                ->orWhereIn('sub_cat_id', $subcategoryIds)
                ->orWhereIn('adv_brand_id', $brandIds)
                ->orWhereIn('adv_model_id', $modelIds);
        }

        $count = $salesProducts->count();
        $data = $salesProducts->skip($toSkip)->take($postsPerPage)->get();
        foreach ($data as $key => $value) {
            $productImages = PostadImg::where('post_ad_id', $value->adv_id)->first();
            $user = MasterUser::where('user_id', $value->user_id)->first();
            if ($user) {
                $country = MasterCountry::where('country_id', $user->country_id)->first();
                $location = MasterLocation::where('location_id', $user->locality_id)->first();
                if ($country)
                    $value['country'] = $country->country_name;
                if ($location)
                    $value['location'] = $location->location_name;
                $membs = UpgradeMembership::where("user_id", $value->user_id)->orderBy("created", "desc")->first();
                if ($membs) {
                    $membPlan = UserMembership::find($membs->member_type);
                    $value['user']['membertype'] = "Award winning seller";
                    $filePath = public_path('uploads/memberplanimg/' . $membPlan->plan_img);

                    if (file_exists($filePath) && $membPlan->plan_img != "") {
                        $value['user']['memberShipImage'] = asset('uploads/memberplanimg/' . $membPlan->plan_img);
                    } else {
                        $value['user']['memberShipImage'] = asset('uploads/postad/noimage.jpg');
                    }
                }
            }
            $value["user"] = $user;

            if ($productImages) {
                $filePath = public_path('uploads/postad/' . $productImages->img_path);

                if (file_exists($filePath) && $productImages->img_path != "") {
                    $value['image'] = asset('uploads/postad/' . $productImages->img_path);
                } else {
                    $value['image'] = asset('uploads/postad/noimage.jpg');
                }
            }
        }
        return response()->json(['data' => $data, "count" => $count], 200);
    }
    public function getProductDetails(Request $req, $slug)
    {
        $product = SalesAdvertisement::where('slug', $slug)->first();
        // dd($product);
        $productImages = PostadImg::where('post_ad_id', $product->adv_id)->get();
        // dd($productImages);
        foreach ($productImages as $key => $value) {
            $filePath = public_path('uploads/postad/' . $value->img_path);
            if (file_exists($filePath) && $value->img_path != "") {
                $value['image'] = asset('uploads/postad/' . $value->img_path);
            } else {
                $value['image'] = asset('uploads/postad/noimage.jpg');
            }

            $value['imgid'] = $value->imgid;
        }
        $modelIds = explode(",", $product->adv_model_id);
        $models = SalesBrand::whereIn('brand_id', $modelIds)->select('brand_name', 'flag')->orderBy('brand_id', 'desc')->get();
        foreach ($models as $key => $model) {
            $model['parent'] = $model->parent;
        }
        $product['category'] = $models;
        $product['images'] = $productImages;
        $product['user'] = $product->user;



        $filePath = public_path('uploads/profileimg/' . $product->user->profile_img);

        if (file_exists($filePath) && $product->user->profile_img != "") {
            $product['user']['profile_img'] = asset('uploads/profileimg/' . $product->user->profile_img);
        } else {
            $product['user']['profile_img'] = asset('uploads/postad/noimage.jpg');
        }
        $product['user']['membertype'] = "Free seller";
        $membs = UpgradeMembership::where("user_id", $product->user->user_id)->orderBy("created", "desc")->first();
        // dd($membs);
        if ($membs) {
            $membPlan = UserMembership::find($membs->member_type);
            $product['user']['membertype'] = "Award winning seller";
            $filePath = public_path('uploads/memberplanimg/' . $membPlan->plan_img);

            if (file_exists($filePath) && $membPlan->plan_img != "") {
                $product['user']['memberShipImage'] = asset('uploads/memberplanimg/' . $membPlan->plan_img);
            } else {
                $product['user']['memberShipImage'] = asset('uploads/postad/noimage.jpg');
            }
        }

        $country = MasterCountry::find($product->user->country_id);
        $location = MasterLocation::find($product->user->locality_id);
        $product['country'] = $country ? $country->country_name : "";
        $product['location'] = $location ? $location->location_name : "";
        $warranty = SalesWarranty::find($product->user->user_id);
        $product['warranty'] = $warranty ? 1:0;

        $product['noOfUsersRated'] = 0;

        $sales_review = SalesRating::where("adv_id", $product->adv_id)->get();
        if ($sales_review) {
            $product_rating = 0;
            foreach ($sales_review as $review) {
                $product_rating += $review->rating;
            }
            if ($product_rating) {
                $product['sales_rating'] = $product_rating / $sales_review->count();
                $product['noOfUsersRated'] = $sales_review->count();
            } else {
                $product['sales_rating'] = 0;
            }
        } else {
            $product['sales_rating'] = 0;
            $product['noOfUsersRated'] = 0;
        }

        $user_reviews = UserRating::where("user_id", $product->user->user_id)->get();
        $user_review_count = $user_reviews->count();
        $user_total_rating = 0;
        $a = 0;
        $product['user_rating'] = 5;
        $product['user_rating_overall'] = 100;
        if ($user_review_count > 0) {
            foreach ($user_reviews as $review) {
                $a += $review->grade == 1 ? $review->grade : 0;
                $user_rating = $review->productdescribedval + $review->communicationval + $review->deliverytimeval + $review->cost_of_transportval;
                $user_total_rating += $user_rating;
                $user_total_rating /= 4;
            }
            $avg_rating = $user_total_rating / $user_review_count;
            $product['user_rating'] = number_format($avg_rating, 2);
            $product['user_rating_overall'] = number_format($a / $user_review_count * 100, 2);
        }

        $objSalesView = new SalesView();
        $objSalesView->adv_id = $product->adv_id;
        $objSalesView->ip_address = $req->ip();
        $objSalesView->created = date('y-m-d h:i:s');
        $objSalesView->modified = date('y-m-d h:i:s');
        $objSalesView->save();

        $total_views = SalesView::where('adv_id',  $product->adv_id)->count();

        $product['total_views'] =  $total_views;
        return response()->json($product);
    }
    public function relatedProducts($id)
    {
        $products = SalesAdvertisement::where('adv_brand_id', $id)->limit(10)->get();
        foreach ($products as $key => $model) {
            $productImage = PostadImg::where('post_ad_id', $model->adv_id)->first();
            if ($productImage) {
                $filePath = public_path('uploads/postad/' . $productImage->img_path);

                if (file_exists($filePath) && $productImage->img_path != "") {
                    $productImage['imageUrl'] = asset('uploads/postad/' . $productImage->img_path);
                } else {
                    $productImage['imageUrl'] = asset('uploads/postad/noimage.jpg');
                }
                $model['image'] = $productImage->imageUrl;
            }
        }
        return response()->json($products);
    }
    public function getSubCategories(Request $request, $catId)
    {
        $subcategories = SalesCategory::where('flag', '!=', 0)->where('flag', $catId)->get();
        return response()->json(['data' => $subcategories]);
    }
    public function getModels(Request $request, $Id)
    {
        $models = SalesBrand::where('flag', '!=', 0)->where('flag', $Id)->get();
        return response()->json(['data' => $models]);
    }
    public function getAllCategories()
    {
        $categories = SalesCategory::where('flag', 0)->get();
        return response()->json(['categories' => $categories]);
    }
    public function getAllBrands()
    {
        $brands = SalesBrand::where('flag', 0)->select('brand_id', 'brand_name')->get();
        return response()->json(['brands' => $brands]);
    }
    public function publishAdstore(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'category_id' => 'required',
            'sub_cat_id' => 'required',
            'adv_img' => 'required|max:2048',
            'adv_name' => 'required',
            'adv_details' => 'required',
            'product_cond' => 'required',
            'payment_mode' => 'required',
            'price' => 'required',
            'currency' => 'required',
            'quantity' => 'required',
            'time_required' => 'required',
            'selectedBrand' => 'required'
        ]);
        $slug = $request->slug;

        if ($slug) {
            $sale = SalesAdvertisement::where('slug', $slug)->first();
        } else {
            $sale = new SalesAdvertisement();
        }


        $brandString = "";
        $modelString = "";
        foreach ($request->selectedBrand as $key => $value) {
            if ($key < count($request->selectedBrand) - 1) {
                $brandString .= $value['brandId'] . ",";
                $modelString .= $value['modelId'] . ",";
            } else {
                $brandString .= $value['brandId'];
                $modelString .= $value['modelId'];
            }
        }
        $originalString = $request->input('adv_name');
        $sale->user_id = $request->input('user_id');
        $sale->category_id = $request->input('category_id');
        $sale->adv_details = $request->input('adv_details');
        $sale->adv_name = $request->input('adv_name');
        $sale->sub_cat_id = $request->input('sub_cat_id');
        if (!$slug) {
            $baseSlug = Str::slug($originalString);
            $slug1 = $baseSlug;
            $count = 1;
            while (SalesAdvertisement::where('slug', $slug1)->exists()) {
                $slug1 = $baseSlug . '-' . $count;
                $count++;
            }

            $sale->slug = $slug1;
        } else {
            $image = [];
            $images = $request->adv_img;
            foreach ($images as $key => $value) {
                array_push($image, $value['imgid']);
            }


            $prv_img = PostadImg::where('post_ad_id', $sale->adv_id)->whereNotIn('imgid', $image)->get();

            foreach ($prv_img as $prvimgDelete) {
                $imagePath = public_path('uploads/postad/') . $prvimgDelete->img_path;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $prvimgDelete->delete();
            }

            // return response()->json([
            //     'status' => 'successpp',
            //     'sale' =>  $prv_img,
            //     'message' => $slug ? 'Sales Advertisement updated successfully' : 'Sales Advertisement created successfully'
            // ]);
        }
        $sale->adv_model_id = $modelString;
        $sale->adv_brand_id = $brandString;
        $sale->product_cond = $request->input('product_cond');
        $sale->currency = $request->input('currency');
        $sale->quantity = $request->input('quantity');
        $sale->payment_mode = implode(",", $request->input('payment_mode'));
        $sale->personal_teaching = $request->input('personal_teaching') == "true" ? 1 : 0;
        $sale->courier = $request->input('courier') == "true" ? 1 : 0;
        $sale->courier_cost = $request->input('courier_cost');
        $sale->free_courier = $request->input('free_courier') == "true" ? 1 : 0;
        $sale->romanian_mail = $request->input('romanian_mail') == "true" ? 1 : 0;
        $sale->romanian_mail_cost = $request->input('romanian_mail_cost');
        $sale->free_romanian_mail = $request->input('free_romanian_mail') == "true" ? 1 : 0;
        $sale->price = $request->input('price');
        $sale->b2bprice = $request->input('b2bprice') ? $request->input('b2bprice') : $request->input('price');
        $sale->time_required = $request->input('time_required');
        $sale->adv_status = $slug ? 1 :0;
        $sale->availability = $request->input('availability');
        $sale->warranty = $request->input('warranty');
        $sale->invoice = $request->input('invoice');
        $sale->sku = $request->input('sku');
        $sale->meta_title = 'null';
        $sale->meta_desc = 'null';
        $sale->meta_keywords = 'null';
        $sale->created =  Carbon::parse($sale->created)->format("d-m-Y");
        $sale->modified = Carbon::parse($sale->modified)->format("d-m-Y");
        $sale->save();

        if ($request->hasFile('adv_img')) {
            $images = $request->file('adv_img');
            // dd($images);
            foreach ($images as $image) {

                $imageName = time() . '_' . $image->getClientOriginalName();


                $image->move(public_path('uploads/postad/'), $imageName);
                $imageNames[] = $imageName;
                $saleImage = new PostadImg();
                $saleImage->post_ad_id = $sale->adv_id;
                $saleImage->user_id = $sale->user_id;
                $saleImage->img_path = $imageName;
                $saleImage->save();
            }
        }
        return response()->json([
            'status' => 'success',
            'sale' => $sale,
            'message' => $slug ? 'Sales Advertisement updated successfully' : 'Sales Advertisement created successfully'
        ]);




        // if ($saleId) {
        //     return response()->json([
        //         'status' => 'success',
        //         'sale' => $sale,
        //         'message' => 'Sales Advertisement updated successfully',
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => 'success',
        //         'sale' => $sale,
        //         'message' => 'Sales Advertisement created successfully',
        //     ]);
        // }
    }
    public function recentPieseAuto()
    {
        $products = SalesAdvertisement::orderBy('created', 'desc')->limit(3)->get();
        foreach ($products as $key => $model) {
            $productImage = PostadImg::where('post_ad_id', $model->adv_id)->first();
            if ($productImage) {
                $filePath = public_path('uploads/postad/' . $productImage->img_path);

                if (file_exists($filePath) && $productImage->img_path != "") {
                    $productImage['imageUrl'] = asset('uploads/postad/' . $productImage->img_path);
                } else {
                    $productImage['imageUrl'] = asset('uploads/postad/noimage.jpg');
                }
                $model['image'] = $productImage->imageUrl;
            }
        }
        return response()->json($products);
    }
    public function rateProduct(Request $req)
    {
        $userId = $req->userId;
        $advId = $req->advId;
        $rating = $req->rating;

        $productRating = SalesRating::where('user_id', $userId)->where('adv_id', $advId)->first();
        if ($productRating) {
            $productRating->rating = $rating;
            $productRating->save();
        } else {
            $productRating = new SalesRating();
            $productRating->user_id = $userId;
            $productRating->adv_id = $advId;
            $productRating->rating = $rating;
            $productRating->save();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Product rated successfully',
        ]);
    }
    public function activate_sale(Request $req)
    {
        $advId = $req->advId;
        $sale = SalesAdvertisement::find($advId);
        $sale->adv_status = 1;
        $sale->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Product activated successfully',
        ]);
    }
    public function edit_product(Request $req)
    {
        $advId = $req->advId;
        $sale = SalesAdvertisement::find($advId);
        $productImages = PostadImg::where('post_ad_id', $sale->adv_id)->get();
        foreach ($productImages as $key => $value) {
            $filePath = public_path('uploads/postad/' . $value->img_path);
            if (file_exists($filePath) && $value->img_path != "") {
                $value['image'] = asset('uploads/postad/' . $value->img_path);
            } else {
                $value['image'] = asset('uploads/postad/noimage.jpg');
            }
        }
        $sale["images"] = $productImages;
        return response()->json([
            'sale' => $sale,
            'status' => 'success',
        ]);
    }

    public function getSku()
    {
        $lastAd = SalesAdvertisement::orderBy('adv_id', 'desc')->first();

        $advID = '';
        if (!empty($lastAd)) {
            $lsid = $lastAd->sku;
            $lastSkuId = explode('S', $lsid);
            $lastSkuId1 = $lastSkuId[1] + 1;
            $advID = $lastSkuId[0] . 'S' . $lastSkuId1;
        } else {
            $advID = 'PS10001';
        }

        return response()->json([
            'status' => 'success',
            'data' => $advID
        ]);
    }
    public function deleteAdvertisement(Request $request)
    {
        $advId = $request->advId;
        $sale = SalesAdvertisement::find($advId);
        if ($sale->delete()) {

            $prv_img = PostadImg::where('post_ad_id', $sale->adv_id)->get();

            foreach ($prv_img as $prvimgDelete) {
                $imagePath = public_path('uploads/postad/') . $prvimgDelete->img_path;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $prvimgDelete->delete();
            }
            return response()->json([
                'status' => 'Advertisement deleted successfully',
            ]);
        }
        return response()->json([
            'status' => 'There was an error deleting the advertisement',
        ]);
    }
}
