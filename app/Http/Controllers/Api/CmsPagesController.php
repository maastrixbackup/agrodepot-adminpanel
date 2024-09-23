<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PostadImg;
use App\Models\SuccessStory;
use Illuminate\Http\Request;
use App\Models\cmsPage;
use App\Models\Banner;
use App\Models\SalesCategory;
use App\Models\AdminLang;
use App\Models\Advertisement;
use App\Models\MasterCountry;
use App\Models\MasterLocation;
use App\Models\MasterUser;
use App\Models\News;
use App\Models\PromotionAd;
use App\Models\RequestImg;
use App\Models\RequestPart;
use App\Models\SalesAdvertisement;
use App\Models\SalesBrand;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class CmsPagesController extends Controller
{
    //
    public function cmsPageDetails($id)
    {
        $cmsPage = cmsPage::where("title", $id)->first();
        $fieldData = json_decode($cmsPage->fields);
        $data = array();
        foreach ($fieldData as $key => $value) {
            $filePath = public_path('images/' . $value);

            if (file_exists($filePath)) {
                $data[$key] = asset('images/' . $value);
            } else {
                $data[$key] = $value;
            }
        }
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }

    public function homePageDetails()
    {
        $detailsBanner = Banner::where("status", 1)->get();
        // $detailsLang = AdminLang::get();
        $detailsCat = SalesCategory::get();
        $banner_details = [];
        $language_details = [];
        $cat_details = [];
        $images = [];
        $i = 0;
        $cmsPage = cmsPage::where("title", 'homepage')->first();
        $fieldData = json_decode($cmsPage->fields);
        $data = array();
        foreach ($fieldData as $key => $value) {
            $filePath = public_path('images/' . $value);

            if (file_exists($filePath)) {
                $data[$key] = asset('images/' . $value);
            } else {
                $data[$key] = $value;
            }
        }

        foreach ($detailsBanner as $key => $detail) {
            $banner_details[$key]['banner_id'] = $detail->banner_id;
            $banner_details[$key]['banner_title'] = $detail->banner_title;
            $banner_details[$key]['banner_caption'] = $detail->banner_caption;
            $banner_details[$key]['banner_caption'] = $detail->banner_caption;
            $filePath = public_path('uploads/banner/' . $detail->banner_img);

            if (file_exists($filePath)) {
                $banner_details[$key]['banner_img'] = asset('uploads/banner/' . $detail->banner_img);
            } else {
                $banner_details[$key]['banner_img'] = '';
            }
        }



        // foreach ($detailsLang as $key => $lang) {
        //     $language_details[$key]['lid'] = $lang->lid;
        //     $language_details[$key]['en_label'] = $lang->en_label;
        //     $language_details[$key]['roman_label'] = $lang->roman_label;
        // }

        foreach ($detailsCat as $key => $cat) {
            $category_data = SalesCategory::where("flag", $cat->category_id)->get();
            $cat['subCategory'] = $category_data;
        }
        $brands = SalesBrand::where("status", 1)->where("image", "!=", "")->limit(10)->get();
        foreach ($brands as $key => $value) {
            $filePath = public_path('uploads/brand/' . $value->image);

            if (file_exists($filePath) && $value->image != "") {
                $value['image'] = asset('uploads/brand/' . $value->image);
            } else {
                $value['image'] = null;
            }
        }
        $currentDate = date("Y-m-d");

        $promoteAd = SalesAdvertisement::leftJoin('promotion_ad', 'promotion_ad.adv_id', '=', 'sales_advertisements.adv_id')
            ->select(
                'sales_advertisements.adv_name',
                'sales_advertisements.price',
                'sales_advertisements.currency',
                'sales_advertisements.adv_id',
                'sales_advertisements.slug',
                'promotion_ad.adv_id',
                'promotion_ad.promotion_id',
            )
            ->where('sales_advertisements.adv_status', 1)
            ->where('sales_advertisements.is_promote', 1)
            ->whereRaw('FIND_IN_SET(1, promotion_ad.promotion_type)')
            ->where('promotion_ad.is_home_expire', '>=', $currentDate)
            ->groupBy(
                'sales_advertisements.adv_name',
                'sales_advertisements.price',
                'sales_advertisements.currency',
                'sales_advertisements.adv_id',
                'sales_advertisements.slug',
                'promotion_ad.adv_id',
                'promotion_ad.promotion_id'
            )
            ->orderBy('promotion_ad.created', 'desc')
            ->get();

        foreach ($promoteAd as $key => $value) {
            $imageName = PostadImg::where("post_ad_id", $value->adv_id)->first();
            $filePath = public_path('uploads/postad/' . $imageName->img_path);

            if (file_exists($filePath) && $imageName->img_path != "") {
                $value['adv_img'] = asset('uploads/postad/' . $imageName->img_path);
            } else {
                $value['adv_img'] = null;
            }
        }
        $left1 = Advertisement::where('status', 1)
            ->where('show_position', 2)
            ->first();
        $filePath = public_path('uploads/advertisement/' . $left1->banner_image);

        if (file_exists($filePath) && $left1->banner_image != "") {
            $left1['banner_image'] = asset('uploads/advertisement/' . $left1->banner_image);
        }
        $left2 = Advertisement::where('status', 1)
            ->where('show_position', 3)
            ->first();
        $filePath = public_path('uploads/advertisement/' . $left2->banner_image);

        if (file_exists($filePath) && $left2->banner_image != "") {
            $left2['banner_image'] = asset('uploads/advertisement/' . $left2->banner_image);
        }

        $middleAd = Advertisement::where('status', 1)
            ->where('show_position', 4)
            ->first();
        $filePath = public_path('uploads/advertisement/' . $middleAd->banner_image);

        if (file_exists($filePath) && $middleAd->banner_image != "") {
            $middleAd['banner_image'] = asset('uploads/advertisement/' . $middleAd->banner_image);
        }
        $topAd = Advertisement::where('status', 1)
            ->where('show_position', 1)
            ->first();
        $filePath = public_path('uploads/advertisement/' . $topAd->banner_image);

        if (file_exists($filePath) && $topAd->banner_image != "") {
            $topAd['banner_image'] = asset('uploads/advertisement/' . $topAd->banner_image);
        }
        $ads = array();
        $ads['left1'] = $left1;
        $ads['left2'] = $left2;
        $ads['middleAd'] = $middleAd;
        $ads['topAd'] = $topAd;

        $recentRes = SalesAdvertisement::where('adv_status', 1)
            ->orderBy('adv_id', 'desc')
            ->limit(5)
            ->get();
        foreach ($recentRes as $key => $value) {
            $imageName = PostadImg::where("post_ad_id", $value->adv_id)->first();
            if ($imageName) {
                $filePath = public_path('uploads/postad/' . $imageName->img_path);

                if ($imageName->img_path != "" && file_exists($filePath)) {
                    $value['imageUrl'] = asset('uploads/postad/' . $imageName->img_path);
                }
            }
        }
        $premiumRes = PromotionAd::leftJoin('master_users', 'master_users.user_id', '=', 'promotion_ad.user_id')
            ->select('master_users.*')
            ->where('master_users.is_active', 1)
            ->where('master_users.wrong_login_attempt', '<=', 3)
            ->groupBy('promotion_ad.user_id', 'master_users.user_id', 'master_users.first_name', 'master_users.first_name', 'master_users.last_name', 'master_users.email', 'master_users.pass', 'master_users.pass', 'master_users.telephone1', 'master_users.telephone2', 'master_users.telephone3', 'master_users.telephone4', 'master_users.country_id', 'master_users.locality_id', 'master_users.postal_code', 'master_users.other_add', 'master_users.user_type_id', 'master_users.profile_img', 'master_users.is_active', 'master_users.is_admin', 'master_users.is_facebook', 'master_users.fb_id', 'master_users.wrong_login_attempt', 'master_users.last_login', 'master_users.is_premium', 'master_users.company_name', 'master_users.cui', 'master_users.reg_no', 'master_users.regd_off_add', 'master_users.country_regd_off', 'master_users.regd_off_city', 'master_users.regd_off_country', 'master_users.bank', 'master_users.account', 'master_users.created', 'master_users.modified', 'master_users.password', 'master_users.email_verified_at', 'master_users.fgt_pw_token', 'master_users.created_at', 'master_users.updated_at')
            ->orderByDesc('promotion_ad.user_id')
            ->get();
        foreach ($premiumRes as $key => $value) {
            $filePath = public_path('uploads/profileimg/' . $value->profile_img);

            if ($value->profile_img != "" && file_exists($filePath)) {
                $value['profile_img'] = asset('uploads/profileimg/' . $value->profile_img);
            }
            $country = MasterCountry::find($value->country_id);
            $location = MasterLocation::find($value->locality_id);
            $value['country'] = $country->country_name;
            $value['location'] = $location->location_name;
        }
        $promoteSecAd = SalesAdvertisement::leftJoin('promotion_ad', 'promotion_ad.adv_id', '=', 'sales_advertisements.adv_id')
            ->where('sales_advertisements.adv_status', 1)
            ->where('sales_advertisements.is_promote', 1)
            ->whereRaw('FIND_IN_SET(1, promotion_ad.promotion_type)')
            ->where('promotion_ad.is_home_expire', '>=', $currentDate)
            ->select(
                'sales_advertisements.adv_id',
                'sales_advertisements.slug',
                'sales_advertisements.adv_name',
                'sales_advertisements.price',
                'sales_advertisements.currency',
                'promotion_ad.promotion_id',
            )
            ->groupBy(
                'sales_advertisements.adv_id',
                'sales_advertisements.adv_name',
                'sales_advertisements.slug',
                'sales_advertisements.price',
                'sales_advertisements.currency',
                'promotion_ad.promotion_id'
            )
            ->orderByDesc('promotion_ad.created')
            ->limit(4)
            ->get();
        foreach ($promoteSecAd as $key => $value) {
            $imageName = PostadImg::where("post_ad_id", $value->adv_id)->first();
            $filePath = public_path('uploads/postad/' . $imageName->img_path);

            if (file_exists($filePath) && $imageName->img_path != "") {
                $value['image'] = asset('uploads/postad/' . $imageName->img_path);
            } else {
                $value['image'] = null;
            }
        }





        return response()->json([
            'status' => 'success',
            'banner_details' =>  $banner_details,
            // 'language_details' => $language_details,
            'cat_details' => $detailsCat,
            'pageData' => $data,
            'brands' => $brands,
            'promotedAds' => $promoteAd,
            'advertisements' => $ads,
            'recentRes' => $recentRes,
            'premiumRes' => $premiumRes,
            'promoteSecAd' => $promoteSecAd,
        ], 200);
    }

    public function homePagePartTwo()
    {
        $currentDate = date("Y-m-d");
        //$cmsPage = cmsPage::where("title", 'homepage')->first();

        $storyRes = SuccessStory::where('status', 1)
            ->orderByDesc('success_id')
            ->first();
        $storyRes['user'] = $storyRes->user;
        $filePath = public_path('uploads/profileimg/' . $storyRes->user->profile_img);
        if ($storyRes->user->profile_img != "" && file_exists($filePath)) {
            $storyRes['user']['profile_img'] = asset('uploads/profileimg/' . $storyRes->user->profile_img);
        }
        $country = MasterCountry::find($storyRes->user->country_id);
        $location = MasterLocation::find($storyRes->user->locality_id);
        $storyRes['user']['country'] = $country->country_name;
        $storyRes['user']['location'] = $location->location_name;

        $newsRes = News::where('status', 1)
            ->orderByDesc('news_id')
            ->limit(2)
            ->get();
        foreach ($newsRes as $key => $value) {
            $filePath = public_path('uploads/news/' . $value->news_img);

            if ($value->news_img != "" && file_exists($filePath)) {
                $value['news_img'] = asset('uploads/news/' . $value->news_img);
            }
        }

        $recentPartsRes = RequestPart::leftJoin('request_accessories', 'request_accessories.request_id', '=', 'request_parts.request_id')
            ->where('request_accessories.status', 1)
            ->where('request_parts.status', 1)
            ->select('request_parts.*', 'request_accessories.*')
            ->orderByDesc('request_accessories.part_id')
            ->limit(5)
            ->get();
        foreach ($recentPartsRes as $key => $value) {
            $image = RequestImg::where('parts_id', $value->request_id)->first();
            if ($image) {
                $filePath = public_path('uploads/requestpart/' . $image->img_path);

                if ($image->img_path != "" && file_exists($filePath)) {
                    $value['image'] = asset('uploads/requestpart/' . $image->img_path);
                }
            }
        }


        $mostFavRes = FacadesDB::table('sales_add_to_favourites as SalesAddToFavourite')
            ->leftJoin('sales_advertisements as SalesAdvertisement', 'SalesAddToFavourite.adv_id', '=', 'SalesAdvertisement.adv_id')
            ->select(
                FacadesDB::raw('COUNT(*) as totfav'),
                'SalesAdvertisement.adv_id',
                'SalesAdvertisement.slug',
                'SalesAdvertisement.adv_name',
                'SalesAdvertisement.price',
                'SalesAdvertisement.currency',
            )
            ->groupBy('SalesAddToFavourite.adv_id', 'SalesAdvertisement.adv_id', 'SalesAdvertisement.adv_name', 'SalesAdvertisement.slug', 'SalesAdvertisement.price', 'SalesAdvertisement.currency')
            ->orderByDesc('totfav')
            ->limit(5)
            ->get();

        foreach ($mostFavRes as $key => $value) {
            $imageName = PostadImg::where("post_ad_id", $value->adv_id)->first();
            if ($imageName) {
                $filePath = public_path('uploads/postad/' . $imageName->img_path);
                if (file_exists($filePath) && $imageName->img_path != "") {
                    $value->image = asset('uploads/postad/' . $imageName->img_path);
                } else {
                    $value->image = null;
                }
            }
        }
        $mostViewRes = SalesAdvertisement::selectRaw('COUNT(*) as totview, sales_advertisements.adv_id')
            ->addSelect(
                'sales_advertisements.adv_id',
                'sales_advertisements.slug',
                'sales_advertisements.adv_name',
                'sales_advertisements.price',
                'sales_advertisements.currency',
            )
            ->leftJoin('sales_view', 'sales_view.adv_id', '=', 'sales_advertisements.adv_id')
            ->groupBy(
                'sales_advertisements.adv_id',
                'sales_advertisements.adv_name',
                'sales_advertisements.price',
                'sales_advertisements.currency',
                'sales_advertisements.slug',
            )
            ->orderByDesc('totview')
            ->limit(5)
            ->get();

        foreach ($mostViewRes as $key => $value) {
            $imageName = PostadImg::where("post_ad_id", $value->adv_id)->first();
            if ($imageName) {
                $filePath = public_path('uploads/postad/' . $imageName->img_path);
                if (file_exists($filePath) && $imageName->img_path != "") {
                    $value->image = asset('uploads/postad/' . $imageName->img_path);
                } else {
                    $value->image = null;
                }
            }
        }



        return response()->json([
            'status' => 'success',

            'recentPartsRes' => $recentPartsRes,
            'mostFavRes' => $mostFavRes,
            'mostViewRes' => $mostViewRes,
            'storyRes' => $storyRes,
            'newsRes' => $newsRes,
        ], 200);
    }

    public function footerBrands(Request $request)
    {
        $brands = SalesBrand::where('flag', 0)->limit(8)->get();
        $brand_data = [];

        if (!$brands->isEmpty()) {
            foreach ($brands as $key => $row) {
                $brand_data[$key]['brand_name'] = $row->brand_name;
                $brand_data[$key]['brand_id'] = $row->brand_id;
            }
        }

        return response()->json(['data' => $brand_data]);
    }

    public function footerCategories(Request $request)
    {
        $categories = SalesCategory::where('flag', 0)->limit(8)->get();
        $category_data = [];

        if (!$categories->isEmpty()) {
            foreach ($categories as $key => $row) {
                $category_data[$key]['category_name'] = $row->category_name;
                $category_data[$key]['category_id'] = $row->category_id;
            }
        }

        return response()->json(['data' => $categories]);
    }




    // public function getData(Request $request, string $id)
    // {
    //     $cmsPageData = cmsPage::where("title", $id)->first();

    //     if (!$cmsPageData) {
    //         return response()->json(['error' => 'Page not found'], 404);
    //     }

    //     $fieldData = json_decode($cmsPageData->fields, true);
    //     $structuredData = [
    //         'products' => [
    //             'images' => [
    //                 $fieldData['product1image'] ?? null,
    //                 $fieldData['product2image'] ?? null,
    //                 $fieldData['product3image'] ?? null
    //             ],
    //             'titles' => [
    //                 [
    //                     'title1' => $fieldData['product1title1'] ?? null,
    //                     'title2' => $fieldData['product1title2'] ?? null
    //                 ],
    //                 [
    //                     'title1' => $fieldData['product2title1'] ?? null,
    //                     'title2' => $fieldData['product2title2'] ?? null
    //                 ],
    //                 [
    //                     'title1' => $fieldData['product3title1'] ?? null,
    //                     'title2' => $fieldData['product3title2'] ?? null
    //                 ]
    //             ],
    //             'buttonUrls' => [
    //                 $fieldData['product1ButtonUrl'] ?? null,
    //                 $fieldData['product2ButtonUrl'] ?? null,
    //                 $fieldData['product3ButtonUrl'] ?? null
    //             ]
    //         ],
    //         'steps' => [
    //             [
    //                 'number' => $fieldData['step1Number'] ?? null,
    //                 'title' => $fieldData['step1Title'] ?? null,
    //                 'image' => $fieldData['step1Image'] ?? null
    //             ],
    //             [
    //                 'number' => $fieldData['step2Number'] ?? null,
    //                 'title' => $fieldData['step2Title'] ?? null,
    //                 'image' => $fieldData['step2Image'] ?? null
    //             ],
    //             [
    //                 'number' => $fieldData['step3Number'] ?? null,
    //                 'title' => $fieldData['step3Title'] ?? null,
    //                 'image' => $fieldData['step3Image'] ?? null
    //             ]
    //         ]
    //     ];

    //     return response()->json($structuredData);
    // }

    public function getData(Request $request, string $id)
    {
        $cmsPageData = cmsPage::where("title", $id)->first();

        if (!$cmsPageData) {
            return response()->json(['error' => 'Page not found'], 404);
        }

        $fieldData = json_decode($cmsPageData->fields, true);
        $baseUrl = asset('images');

        $structuredData = [
            'product1image' => isset($fieldData['product1image']) ? $baseUrl . '/' . $fieldData['product1image'] : null,
            'product2image' => isset($fieldData['product2image']) ? $baseUrl . '/' . $fieldData['product2image'] : null,
            'product3image' => isset($fieldData['product3image']) ? $baseUrl . '/' . $fieldData['product3image'] : null,
            'product1title1' => $fieldData['product1title1'] ?? null,
            'product1title2' => $fieldData['product1title2'] ?? null,
            'product2title1' => $fieldData['product2title1'] ?? null,
            'product2title2' => $fieldData['product2title2'] ?? null,
            'product3title1' => $fieldData['product3title1'] ?? null,
            'product3title2' => $fieldData['product3title2'] ?? null,
            'product1ButtonUrl' => $fieldData['product1ButtonUrl'] ?? null,
            'product2ButtonUrl' => $fieldData['product2ButtonUrl'] ?? null,
            'product3ButtonUrl' => $fieldData['product3ButtonUrl'] ?? null,
            'step1Number' => $fieldData['step1Number'] ?? null,
            'step1Title' => $fieldData['step1Title'] ?? null,
            'step1Image' => isset($fieldData['step1Image']) ? $baseUrl . '/' . $fieldData['step1Image'] : null,
            'step2Number' => $fieldData['step2Number'] ?? null,
            'step2Title' => $fieldData['step2Title'] ?? null,
            'step2Image' => isset($fieldData['step2Image']) ? $baseUrl . '/' . $fieldData['step2Image'] : null,
            'step3Number' => $fieldData['step3Number'] ?? null,
            'step3Title' => $fieldData['step3Title'] ?? null,
            'step3Image' => isset($fieldData['step3Image']) ? $baseUrl . '/' . $fieldData['step3Image'] : null,
        ];

        return response()->json($structuredData);
    }


    public function getCounts()
    {
        $productCount = SalesAdvertisement::where('adv_status', 1)->count();
        $sellerCount = MasterUser::where('is_active', 1)
            ->where('wrong_login_attempt', '<=', 3)
            ->where('user_type_id', 2)
            ->count();
        $buyerCount = MasterUser::where('is_active', 1)
            ->where('wrong_login_attempt', '<=', 3)
            ->where('user_type_id', 1)
            ->count();
        $offerCount = RequestPart::leftJoin('request_accessories', 'request_accessories.request_id', '=', 'request_parts.request_id')
            ->where('request_accessories.status', 1)
            ->where('request_parts.status', 1)
            ->count();
        return response()->json([
            'Products' => $productCount,
            'SellingLeads' => $sellerCount,
            'BuyingLeads' => $buyerCount,
            'OfferParts' => $offerCount,
        ]);
    }
}
