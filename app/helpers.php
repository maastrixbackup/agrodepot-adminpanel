<?php

use App\Models\MasterUser;
use App\Models\MasterCountry;
use App\Models\MasterLocation;
use App\Models\Notice;
use App\Models\UpgradeMembership;
use App\Models\UserRating;

if (!function_exists('calculateRotationAngle')) {
    function calculateRotationAngle($imgPath)
    {
        // Your logic to calculate rotation angle based on the image path
        $extension = pathinfo($imgPath, PATHINFO_EXTENSION);

        return ($extension == 'png') ? 90 : 0; // Rotate by 90 degrees if it's a PNG, otherwise no rotation
    }
}
if (!function_exists('user_details')) {
    function user_details($user_id)
    {
        $u_name = MasterUser::where('user_id', $user_id)->first();
        return $u_name;
    }
}

if (!function_exists('region_nm')) {
    function region_nm($c_id)
    {
        $country = MasterCountry::where('country_id', $c_id)->first();
        if (!empty($country)) {
            return $country->country_name;
        }
        return null;
    }
}

if (!function_exists('location_nm')) {
    function location_nm($l_id)
    {
        $location = MasterLocation::where('location_id', $l_id)->first();
        if (!empty($location)) {
            return $location->location_name;
        }
        return null;
    }
}

if (!function_exists('Membership')) {
    function Membership($userid)
    {
        $membership = UpgradeMembership::leftJoin('user_memberships', 'user_memberships.memb_id', '=', 'upgrade_membership.member_type')
            ->where('upgrade_membership.user_id', $userid)
            ->orderByDesc('upgrade_membership.upgrade_id')
            ->first();

        return $membership;
    }
}
if (!function_exists('totalNotice')) {
    function totalNotice($noticeType = '')
    {
        $notice = new Notice();
        if ($noticeType !== '') {
            $totNotice = $notice->where('status', 0)
                ->where('user_id', 0)
                ->where('notice_type', $noticeType)
                ->count();
        } else {
            $totNotice = $notice->where('status', 0)
                ->where('user_id', 0)
                ->count();
        }
        return $totNotice;
    }
}
if (!function_exists('userTotalNotice')) {
    function userTotalNotice($userId)
    {
        $totNotice = 0;
        if ($userId !== '') {
            $totNotice += Notice::leftJoin('sales_advertisements as PostAd', 'PostAd.adv_id', '=', 'Notice.postid')
                ->where('Notice.status', 0)
                ->where('Notice.notice_type', 'sales-order')
                ->where('PostAd.user_id', $userId)
                ->count();

            $totNotice += Notice::leftJoin('sales_advertisements as PostAd', 'PostAd.adv_id', '=', 'Notice.postid')
                ->where('Notice.status', 0)
                ->where('Notice.notice_type', 'sales-question')
                ->where('PostAd.user_id', $userId)
                ->count();

            $totNotice += Notice::leftJoin('request_parts as RequestPart', 'RequestPart.request_id', '=', 'Notice.postid')
                ->where('Notice.status', 0)
                ->where('Notice.notice_type', 'bid-offer')
                ->where('RequestPart.user_id', $userId)
                ->count();
        }
        return $totNotice;
    }
}


if (!function_exists('userProfileResult')) {
    function userProfileResult($userid)
    {
        // Fetch all user ratings for the given user ID, ordered by rating_id in descending order
        $allPositiveGrade = UserRating::where('user_id', $userid)
            ->orderBy('rating_id', 'desc')
            ->get();

        $grade = 0;

        // Check if there are any ratings
        if ($allPositiveGrade->isNotEmpty()) {
            // Sum up all the grades
            foreach ($allPositiveGrade as $allPositiveGradeRes) {
                $grade += $allPositiveGradeRes->grade;
            }
            return $grade;
        } else {
            return 0;
        }
    }
}
