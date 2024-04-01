<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterCountry;
use App\Models\MasterLocation;
use App\Models\UpgradeMembership;
use Illuminate\Http\Request;
use App\Models\UserRating;
use App\Models\SalesAdvertisement;
use App\Models\MasterUser;
use App\Models\UserMembership;
use Carbon\Carbon; // Import Carbon for date manipulation

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $details_reviews = [];
        $all_rating_received = [];
        $received_the_seller = [];
        $received_as_buyer = [];
        $user_id = $request->userId;
        $user = [];

        // Get all ratings for the user
        $userRatings = UserRating::where('user_id', $user_id)->orderBy('rating_id', 'desc')->get();


        // Get ratings where the user is a buyer
        $raceiveAsBuyer = UserRating::where('user_id', $user_id)
            ->where('rating_type', 2)
            ->orderBy('rating_id', 'desc')
            ->get();
        // Get ratings where the user is a seller
        $receivedTheSeller = UserRating::where('user_id', $user_id)
            ->where('rating_type', 1)
            ->orderBy('rating_id', 'desc')
            ->get();

        // Count positive, neutral, and negative grades for all ratings
        $allPositiveGrade = UserRating::where('user_id', $user_id)
            ->where('grade', 1)
            ->count();

        $allNeutralGrade = UserRating::where('user_id', $user_id)
            ->where('grade', 0)
            ->count();

        $allNegativeGrade = UserRating::where('user_id', $user_id)
            ->where('grade', -1)
            ->count();

        // Get current date and date for the last 6 months and last month
        $currentDate = Carbon::now();
        $last6Months = Carbon::now()->subMonths(6);
        $lastMonth = Carbon::now()->subMonth();
        $lastYear = Carbon::now()->subYear();
        // Count positive, neutral, and negative grades for last year
        $lastYearPositiveGrade = UserRating::where('user_id', $user_id)
            ->where('grade', 1)
            ->whereBetween('created', [$lastYear, $currentDate])
            ->count();

        $lastYearNeutralGrade = UserRating::where('user_id', $user_id)
            ->where('grade', 0)
            ->whereBetween('created', [$lastYear, $currentDate])
            ->count();

        $lastYearNegativeGrade = UserRating::where('user_id', $user_id)
            ->where('grade', -1)
            ->whereBetween('created', [$lastYear, $currentDate])
            ->count();

        // Count positive, neutral, and negative grades for last 6 months
        $last6MonthsPositiveGrade = UserRating::where('user_id', $user_id)
            ->where('grade', 1)
            ->whereBetween('created', [$last6Months, $currentDate])
            ->count();

        $last6MonthsNeutralGrade = UserRating::where('user_id', $user_id)
            ->where('grade', 0)
            ->whereBetween('created', [$last6Months, $currentDate])
            ->count();

        $last6MonthsNegativeGrade = UserRating::where('user_id', $user_id)
            ->where('grade', -1)
            ->whereBetween('created', [$last6Months, $currentDate])
            ->count();

        // Count positive, neutral, and negative grades for last month
        $lastMonthPositiveGrade = UserRating::where('user_id', $user_id)
            ->where('grade', 1)
            ->whereBetween('created', [$lastMonth, $currentDate])
            ->count();

        $lastMonthNeutralGrade = UserRating::where('user_id', $user_id)
            ->where('grade', 0)
            ->whereBetween('created', [$lastMonth, $currentDate])
            ->count();

        $lastMonthNegativeGrade = UserRating::where('user_id', $user_id)
            ->where('grade', -1)
            ->whereBetween('created', [$lastMonth, $currentDate])
            ->count();

        $percentcount = 0;
        $totgrade = 0;
        $productdescribedval = 0;
        $communicationval = 0;
        $deliverytimeval = 0;
        $cost_of_transportval = 0;
        if (!empty($userRatings)) {
            foreach ($userRatings as $ratingpercent) {
                $productdescribedval += $ratingpercent->productdescribedval;
                $communicationval += $ratingpercent->communicationval;
                $deliverytimeval += $ratingpercent->deliverytimeval;
                $cost_of_transportval += $ratingpercent->cost_of_transportval;
                if ($ratingpercent->grade == 1) {
                    $percentcount++;
                    $totgrade += $ratingpercent->grade;
                }
                if ($ratingpercent->grade == -1) {
                    $totgrade += $ratingpercent->grade;
                    $percentcount--;
                }
            }
        }

        if (!empty($userRatings) && count($userRatings) != 0) {
            $avg_percent = number_format($percentcount / count($userRatings) * 100, 2);
            $totproductdescription = (count($userRatings) > 0)  ? $productdescribedval / count($userRatings) : 0;
            $totcommunicationval = (count($userRatings) > 0)  ? $communicationval / count($userRatings) : 0;
            $totdeliverytimeval = (count($userRatings) > 0)  ? $deliverytimeval / count($userRatings) : 0;
            $totcost_of_transportval = (count($userRatings) > 0)  ? $cost_of_transportval / count($userRatings) : 0;
        } else {
            $avg_percent = 0;
            $totproductdescription = 0;
            $totcommunicationval = 0;
            $totdeliverytimeval = 0;
            $totcost_of_transportval = 0;
        }

        $details_reviews['product_as_described'] =  number_format($totproductdescription, 2);
        $details_reviews['comm_with_seller'] = number_format($totcommunicationval, 2);
        $details_reviews['delivery_time'] = number_format($totdeliverytimeval, 2);
        $details_reviews['shipping_cost'] = number_format($totcost_of_transportval, 2);


        if (!empty($userRatings)) {
            foreach ($userRatings as $key => $userRatingRes) {

                $totuserrating = $userRatingRes->productdescribedval + $userRatingRes->communicationval + $userRatingRes->deliverytimeval + $userRatingRes->cost_of_transportval;
                $avgrating = $totuserrating / 4;
                $advid = $userRatingRes->adv_id;
                $postAdRes = SalesAdvertisement::where('adv_id', $advid)->first();

                $ads_userid = !empty($postAdRes) ? $postAdRes->user_id : 0;

                $user = MasterUser::where('user_id', $ads_userid)->first();

                $rating_type = ($userRatingRes->rating_type == 1) ? "Buyer" : "Seller";

                $rateuserid = $userRatingRes->from_user_id;

                $rateuser =  MasterUser::where('user_id', $rateuserid)->first();


                $all_rating_received[$key]['opinion']    =      !empty($postAdRes) ? $postAdRes->adv_name : "";
                $all_rating_received[$key]['slug']    =    !empty($postAdRes) ?  $postAdRes->slug :  "";
                $all_rating_received[$key]['sales_clerk']    =    !empty($user) ? $user->first_name . ' ' . $user->last_name : "";
                $all_rating_received[$key]['sales_clerk_id']    =    !empty($user) ?  $user->user_id : "";
                $all_rating_received[$key]['received_at']    =      $rateuser->first_name . ' ' . $rateuser->last_name;
                $all_rating_received[$key]['assessment']    =      $avgrating;
                $all_rating_received[$key]['grade']    =     $userRatingRes->grade;
                $all_rating_received[$key]['rating_type']    =     $rating_type;
                $all_rating_received[$key]['date']    =   $userRatingRes->created;
            }
        }



        if (!empty($receivedTheSeller)) {
            foreach ($receivedTheSeller as $key => $userRatingRes) {

                $totuserrating = $userRatingRes->productdescribedval + $userRatingRes->communicationval + $userRatingRes->deliverytimeval + $userRatingRes->cost_of_transportval;
                $avgrating = $totuserrating / 4;
                $advid = $userRatingRes->adv_id;

                $postAdRes = SalesAdvertisement::where('adv_id', $advid)->first();

                $ads_userid = $postAdRes->user_id;

                $user = MasterUser::where('user_id', $ads_userid)->first();

                $rating_type = ($userRatingRes->rating_type == 1) ? "Buyer" : "Seller";

                $rateuserid = $userRatingRes->from_user_id;

                $rateuser =  MasterUser::where('user_id', $rateuserid)->first();


                $received_the_seller[$key]['opinion']    =     $postAdRes->adv_name;
                $received_the_seller[$key]['sales_clerk']    =     $user->first_name . ' ' . $user->last_name;

                $received_the_seller[$key]['slug']    =     $postAdRes->slug;
                $received_the_seller[$key]['sales_clerk_id']    =     $user->user_id;

                $received_the_seller[$key]['received_at']    =      $rateuser->first_name . ' ' . $rateuser->last_name;
                $received_the_seller[$key]['assessment']    =      $avgrating;
                $received_the_seller[$key]['grade']    =     $userRatingRes->grade;
                $received_the_seller[$key]['rating_type']    =     $rating_type;
            }
        }

        if (!empty($raceiveAsBuyer)) {
            foreach ($raceiveAsBuyer as $key => $userRatingRes) {

                $totuserrating = $userRatingRes->productdescribedval + $userRatingRes->communicationval + $userRatingRes->deliverytimeval + $userRatingRes->cost_of_transportval;
                $avgrating = $totuserrating / 4;
                $advid = $userRatingRes->adv_id;
                $postAdRes = SalesAdvertisement::where('adv_id', $advid)->first();

                $ads_userid =  !empty($postAdRes) ? $postAdRes->user_id : 0;



                $rating_type = ($userRatingRes->rating_type == 1) ? "Buyer" : "Seller";

                $rateuserid = $userRatingRes->from_user_id;

                $rateuser =  MasterUser::where('user_id', $rateuserid)->first();


                $received_as_buyer[$key]['opinion']    =     !empty($postAdRes) ? $postAdRes->adv_name : "";
                $received_as_buyer[$key]['sales_clerk']    =     !empty($user) ?  $user->first_name . ' ' . $user->last_name : "";
                $received_as_buyer[$key]['slug']    =      !empty($postAdRes) ? $postAdRes->slug : "";
                $received_as_buyer[$key]['sales_clerk_id']    =     !empty($user) ? $user->user_id : "";
                $received_as_buyer[$key]['received_at']    =      $rateuser->first_name . ' ' . $rateuser->last_name;
                $received_as_buyer[$key]['assessment']    =      $avgrating;
                $received_as_buyer[$key]['grade']    =     $userRatingRes->grade;
                $received_as_buyer[$key]['rating_type']    =     $rating_type;
            }
        }
        $user = MasterUser::where('user_id', $user_id)->first();
        if ($user) {
            $userCountry = MasterCountry::find($user->country_id);
            $userLocation = MasterLocation::find($user->locality_id);
            if ($userCountry)
                $user->countryName = $userCountry->country_name;
            if ($userCountry)
                $user->locality = $userLocation->location_name;
            $filePath = public_path('uploads/profileimg/' . $user->profile_img);

            if (file_exists($user->profile_img) && $user->profile_img != "") {
                $user->dp = asset('uploads/profileimg/' . $user->profile_img);
            } else {
                $user->dp  = asset('uploads/no-img.png');
            }
        }
        $userMembership = UpgradeMembership::where('user_id', $user_id)->first();
        if ($userMembership) {
            $membershipType = UserMembership::where('memb_id', $userMembership->member_type)->first();
            $userMembership["type"] = $membershipType->memb_type;
            $filePath = public_path('uploads/memberplanimg/' . $membershipType->plan_img);

            if (file_exists($filePath) && $membershipType->plan_img != "") {
                $userMembership["image"] = asset('uploads/memberplanimg/' . $membershipType->plan_img);
            } else {
                $userMembership["image"]  = asset('uploads/memberplanimg/no_plan.png');
            }
        }
        if ($user) {
            $user->membership = $userMembership;
        }



        // Return data if needed

        return response()->json([
            'detailsReviews'  => $details_reviews,
            'all_rating_received'  => $all_rating_received,
            'raceiveAsBuyer' => $received_as_buyer,
            'receivedTheSeller' => $received_the_seller,
            'allPositiveGrade' => $allPositiveGrade,
            'allNeutralGrade' => $allNeutralGrade,
            'allNegativeGrade' => $allNegativeGrade,
            'lastYearPositiveGrade' => $lastYearPositiveGrade,
            'lastYearNeutralGrade' => $lastYearNeutralGrade,
            'lastYearNegativeGrade' => $lastYearNegativeGrade,
            'last6MonthsPositiveGrade' => $last6MonthsPositiveGrade,
            'last6MonthsNeutralGrade' => $last6MonthsNeutralGrade,
            'last6MonthsNegativeGrade' => $last6MonthsNegativeGrade,
            'lastMonthPositiveGrade' => $lastMonthPositiveGrade,
            'lastMonthNeutralGrade' => $lastMonthNeutralGrade,
            'lastMonthNegativeGrade' => $lastMonthNegativeGrade,
            'user' => $user,
            'overallUserRating' => $avg_percent
        ]);
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
}
