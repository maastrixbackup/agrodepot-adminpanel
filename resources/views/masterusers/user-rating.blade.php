@php
    if (!empty($memdetails)) {
        $memplan = $memdetails->memb_type;
        $memimg = asset('uploads/memberplanimg/' . $memdetails->plan_img);
    } else {
        $memplan = '';
        $memimg = asset('uploads/memberplanimg/no_plan.png');
    }
    $percentcount = 0;
    $totgrade = 0;
    $productdescribedval = 0;
    $communicationval = 0;
    $deliverytimeval = 0;
    $cost_of_transportval = 0;
    if (!empty($userRatings)) {
        foreach ($userRatings as $ratingpercent) {
            $productdescribedval += $ratingpercent['UserRating']['productdescribedval'];
            $communicationval += $ratingpercent['UserRating']['communicationval'];
            $deliverytimeval += $ratingpercent['UserRating']['deliverytimeval'];
            $cost_of_transportval += $ratingpercent['UserRating']['cost_of_transportval'];
            if ($ratingpercent['UserRating']['grade'] == 1) {
                $percentcount++;
                $totgrade += $ratingpercent['UserRating']['grade'];
            }
            if ($ratingpercent['UserRating']['grade'] == -1) {
                $totgrade += $ratingpercent['UserRating']['grade'];
                $percentcount--;
            }
        }
    }
@endphp

@php
    if ($userRatings) {
        if (count($userRatings) > 0) {
            $avg_percent = ($percentcount / count($userRatings)) * 100;
            $totproductdescription = $productdescribedval / count($userRatings);
            $totcommunicationval = $communicationval / count($userRatings);
            $totdeliverytimeval = $deliverytimeval / count($userRatings);
            $totcost_of_transportval = $cost_of_transportval / count($userRatings);
        } else {
            $avg_percent = 0;
            $totproductdescription = 0;
            $totcommunicationval = 0;
            $totdeliverytimeval = 0;
            $totcost_of_transportval = 0;
        }
    } else {
        $avg_percent = 0;
        $totproductdescription = 0;
        $totcommunicationval = 0;
        $totdeliverytimeval = 0;
        $totcost_of_transportval = 0;
    }
@endphp



<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">User Rating</h1>
        </div>
    </div>
    <div id="mess834359" class="message_top">
        <div style="height:50px;" class="paid_seller">
            <div><img width="40" height="40" src="{{ $memimg }}">
            </div>
            <div style="position:relative; margin-left:50px; top:-40px;" class="seller_wrapper">
                <div class="seller_type">
                    <font>
                        <font>From {{ $memplan }}</font>
                    </font>
                </div>
                <div class="username"> <a title="View profile Otomobil" href="#">
                        <font>
                            <font>{{ $user->first_name . ' ' . $user->last_name }}</font>
                        </font>
                    </a> </div>
                <span class="seller_chat chat_online">
                    <font>
                        <font> &nbsp; </font>
                    </font>
                </span>
                <div class="clearing"></div>
                <span class="user_stars"> <a title="View profile Otomobil" href="#"> <span
                            class="user_star stars_purple"></span>
                        <font>
                            <font>{{ $totgrade }}</font>
                        </font>
                    </a> </span> <span class="user_ribbon"> <a title="View profile Otomobil" href="#"> <span
                            class="ribbon_percent">
                            <font>
                                <font>{{ number_format($avg_percent, 2) }}% </font>
                            </font>
                        </span> <span class="ribbon_label">
                            <font>
                                <font>Positive Feedback</font>
                            </font>
                        </span> <span class="ribbon_info"> </span> </a> </span>
                <div class="clearing"> </div>
            </div>
        </div>
        <div class="seller_company">
            <div class="company_info">
                <div class="company_data">
                    <div class="company_location"> <span> </span>
                        <font>
                            <font> {{ $city }}, {{ $countyname }}</font>
                        </font>
                    </div>
                </div>
            </div>
            @if ($user['profile_img'] != '')
                <div class="company_logo">
                    <a title="{{ stripslashes($user['first_name']) . ' ' . stripslashes($user['last_name']) }}"
                        href="#">
                        <img height="54"
                            alt="{{ stripslashes($user['first_name']) . ' ' . stripslashes($user['last_name']) }}"
                            src="{{ asset('files/profileimg/' . $user['profile_img']) }}">
                    </a>
                </div>
            @else
                <div class="company_logo">
                    <a title="{{ stripslashes($user['first_name']) . ' ' . stripslashes($user['last_name']) }}"
                        href="#">
                        <img height="54"
                            alt="{{ stripslashes($user['first_name']) . ' ' . stripslashes($user['last_name']) }}"
                            src="{{ asset('images/noimage.jpg') }}">
                    </a>
                </div>
            @endif


        </div>
        <div class="clearing"> </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <table class="brandsTable table table-hover" id="cmspageslist">
                <thead>
                    <tr class="tbl_header">
                        <th class="first">Ratings</th>
                        <th>Last Month </th>
                        <th>Last 6 Month</th>
                        <th>Last Year</th>
                        <th>All</th>
                    </tr>

                </thead>
                <tbody>
                    <tr class="tbl_data">
                        <td class="tb-rate-head" style="font-weight: bold;"><i class="fas fa-thumbs-up"></i>Positive
                        </td>
                        <td align="center">{{ $lastmthpositivegrade }}</td>
                        <td align="center">{{ $last6mthpositivegrade }}</td>
                        <td align="center">{{ $lastyrpositivegrade }}</td>
                        <td align="center">{{ $allpositivegrade }}</td>
                    </tr>
                    <tr class="tbl_data">
                        <td class="tb-rate-head tb-rate-neut-head" style="font-weight: bold;"><i
                                class="fas fa-plug"></i>Neutral</td>
                        <td align="center">{{ $lastmthneutralgrade }}</td>
                        <td align="center">{{ $last6mthneutralgrade }}</td>
                        <td align="center">{{ $lastyrneutralgrade }}</td>
                        <td align="center">{{ $allneutralgrade }}</td>
                    </tr>
                    <tr class="tbl_data">
                        <td class="tb-rate-head tb-rate-neg-head" style="font-weight: bold;"><i
                                class="fas fa-thumbs-down"></i>Negative</td>
                        <td align="center">{{ $lastmthnegativegrade }}</td>
                        <td align="center">{{ $last6mthnegativegrade }}</td>
                        <td align="center">{{ $lastyrnegativegrade }}</td>
                        <td align="center">{{ $allnegativegrade }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="col-lg-6">
            <table class="brandsTable table" id="cmspageslist">
                <tbody>
                    <tr class="tbl_header">
                        <td class="first">Detailed Ratings</td>
                        <td></td>
                        <td>Rating-uri</td>
                    </tr>
                    <tr>
                        <td>Product as described</td>
                        <td>
                            @if (!empty($totproductdescription))
                                @for ($description = 1; $description <= round($totproductdescription); $description++)
                                    @if ($description > $totproductdescription)
                                        <img border="0" src="{{ asset('images/star-small-halfactive.png') }}"
                                            alt="rating" />
                                    @else
                                        <img border="0" src="{{ asset('images/star-small-active.png') }}"
                                            alt="rating" />
                                    @endif
                                @endfor
                            @endif
                            @if (round($totproductdescription) < 5)
                                @for ($desc = 5; round($totproductdescription) < $desc; $desc--)
                                    <img border="0" src="{{ asset('images/star-small-inactive.png') }}">
                                @endfor
                            @endif
                        </td>
                        <td align="center">{{ $totproductdescription }}</td>
                    </tr>
                    <tr>
                        <td>Communication with the seller</td>
                        <td>
                            @if (!empty($totcommunicationval))
                                @for ($communication = 1; $communication <= round($totcommunicationval); $communication++)
                                    @if ($communication > $totcommunicationval)
                                        <img border="0" src="{{ asset('images/star-small-halfactive.png') }}"
                                            alt="rating" />
                                    @else
                                        <img border="0" src="{{ asset('images/star-small-active.png') }}"
                                            alt="rating" />
                                    @endif
                                @endfor
                            @endif
                            @if (round($totcommunicationval) < 5)
                                @for ($commu = 5; round($totcommunicationval) < $commu; $commu--)
                                    <img border="0" src="{{ asset('images/star-small-inactive.png') }}">
                                @endfor
                            @endif
                        </td>
                        <td align="center">{{ $totcommunicationval }}</td>
                    </tr>
                    <tr>
                        <td>Delivery Time</td>
                        <td>
                            @if (!empty($totdeliverytimeval))
                                @for ($delivery = 1; $delivery <= round($totdeliverytimeval); $delivery++)
                                    @if ($delivery > $totdeliverytimeval)
                                        <img border="0" src="{{ asset('images/star-small-halfactive.png') }}"
                                            alt="rating" />
                                    @else
                                        <img border="0" src="{{ asset('images/star-small-active.png') }}"
                                            alt="rating" />
                                    @endif
                                @endfor
                            @endif
                            @if (round($totdeliverytimeval) < 5)
                                @for ($deli = 5; round($totdeliverytimeval) < $deli; $deli--)
                                    <img border="0" src="{{ asset('images/star-small-inactive.png') }}">
                                @endfor
                            @endif
                        </td>
                        <td align="center">{{ $totdeliverytimeval }}</td>
                    </tr>
                    <tr>
                        <td>Transport Cost</td>
                        <td>
                            @if (!empty($totcost_of_transportval))
                                @for ($cost_trans = 1; $cost_trans <= round($totcost_of_transportval); $cost_trans++)
                                    @if ($cost_trans > $totcost_of_transportval)
                                        <img border="0" src="{{ asset('images/star-small-halfactive.png') }}"
                                            alt="rating" />
                                    @else
                                        <img border="0" src="{{ asset('images/star-small-active.png') }}"
                                            alt="rating" />
                                    @endif
                                @endfor
                            @endif
                            @if (round($totcost_of_transportval) < 5)
                                @for ($cost = 5; round($totcost_of_transportval) < $cost; $cost--)
                                    <img border="0" src="{{ asset('images/star-small-inactive.png') }}">
                                @endfor
                            @endif
                        </td>
                        <td align="center">{{ $totcost_of_transportval }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
    <div class="custom-scrollbar">
        <table class="brandsTable table table-hover" id="cmspageslist">
            <thead>
                <tr class="titlepanel">
                    <th scope="col">Qualifying</th>
                    <th scope="col">Notice</th>
                    <th scope="col">Sell ​​Clerk</th>
                    <th scope="col">Received</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody id="brands_sortable">
                @forelse ($userRatings as $userRatingRes)
                    <tr class="tbl_data">
                        <td>
                            <div class="tbl_data_sign">
                                @if ($userRatingRes['UserRating']['grade'] == 1)
                                    <span class="fdbk_sign positive"></span>
                                @elseif ($userRatingRes['UserRating']['grade'] == 0)
                                    <span class="fdbk_sign neutral"></span>
                                @elseif ($userRatingRes['UserRating']['grade'] == -1)
                                    <span class="fdbk_sign negative"></span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <a href="javascript:void(0);"
                                onclick="saveView({{ $userRatingRes['UserRating']['adv_id'] }}, '{{ $base_url . 'pages/sales-details/' . $userRatingRes['PostAd']['slug'] }}');"
                                target="_blank">{{ $userRatingRes['PostAd']['adv_name'] }}</a>
                        </td>
                        <td>
                            <a href="{{ $base_url . 'admin/ManageUsers/rating/' . $userRatingRes['PostAd']['user_id'] }}"
                                target="_blank">{{ $userRatingRes['User']['first_name'] . ' ' . $userRatingRes['User']['last_name'] }}</a>
                        </td>
                        <td align="center">
                            {{ $userRatingRes['UserRating']['rating_type'] == 1 ? 'Buyer' : 'Seller' }}:
                            <a href="{{ $base_url . 'admin/ManageUsers/rating/' . $userRatingRes['UserRating']['from_user_id'] }}"
                                target="_blank">{{ $userRatingRes['RatedUser']['first_name'] . ' ' . $userRatingRes['RatedUser']['last_name'] }}</a>
                        </td>
                        <td align="center">{{ date('d/m/Y', strtotime($userRatingRes['UserRating']['created'])) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">No Result Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="row">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                    type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">All Ratings
                    Received</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                    type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Received as
                    a
                    seller</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane"
                    type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Received as
                    a
                    buyer</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                tabindex="0">
                <table class="brandsTable table table-hover">
                    <thead>
                        <tr class="listing_header">
                            <th width="30%">Notice</th>
                            <th align="center" width="20%">Sell Clerk</th>
                            <th align="center" width="20%">Received</th>
                            <th align="center" width="20%">
                                <font>
                                    <font>Ratings</font>
                                </font>
                            </th>
                            <th align="center" width="10%">
                                <font>
                                    <font>Grade</font>
                                </font>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($userRatings as $rating)
                            <?php
                            $totalRating = $rating['UserRating']['productdescribedval'] + $rating['UserRating']['communicationval'] + $rating['UserRating']['deliverytimeval'] + $rating['UserRating']['cost_of_transportval'];
                            $averageRating = $totalRating / 4;
                            ?>
                            <tr class="tbl_data">
                                <td>
                                    <?php
                                    $advId = $rating['UserRating']['adv_id'];
                                    $advDetail = $this->Custom->BapCustUniAdvDetail($advId);
                                    ?>
                                    <a href="javascript:void(0);"
                                        onclick="saveView(<?php echo $advId; ?>,'<?php echo $base_url . 'pages/sales-details/' . $advDetail['PostAd']['slug']; ?>');"
                                        target="_blank">{{ $advDetail['PostAd']['adv_name'] }}</a>
                                </td>
                                <td>
                                    <?php
                                    $adsUserId = $advDetail['PostAd']['user_id'];
                                    $adUser = $this->Custom->user_details($adsUserId);
                                    ?>
                                    <a href="{{ $base_url . 'admin/ManageUsers/rating/' . $adsUserId }}"
                                        target="_blank">{{ $adUser['first_name'] }} {{ $adUser['last_name'] }}</a>
                                </td>
                                <td align="center">
                                    {{ $rating['UserRating']['rating_type'] == 1 ? 'Buyer' : 'Seller' }}:
                                    <?php
                                    $rateUserId = $rating['UserRating']['from_user_id'];
                                    $rateUser = $this->Custom->user_details($rateUserId);
                                    ?>
                                    <a href="{{ $base_url . 'admin/ManageUsers/rating/' . $rateUserId }}"
                                        target="_blank">{{ $rateUser['first_name'] }}
                                        {{ $rateUser['last_name'] }}</a>
                                </td>
                                <td align="center">
                                    @if (!empty($averageRating))
                                        @for ($i = 1; $i <= round($averageRating); $i++)
                                            @if ($i > $averageRating)
                                                <img border="0"
                                                    src="{{ $base_url }}/images/star-small-halfactive.png"
                                                    alt="rating" />
                                            @else
                                                <img border="0"
                                                    src="{{ $base_url }}/images/star-small-active.png"
                                                    alt="rating" />
                                            @endif
                                        @endfor
                                    @endif
                                    @if (round($averageRating) < 5)
                                        @for ($j = 5; $j > round($averageRating); $j--)
                                            <img border="0"
                                                src="{{ $base_url }}/images/star-small-inactive.png">
                                        @endfor
                                    @endif
                                </td>
                                <td>
                                    <div class="tbl_data_sign">
                                        @if ($rating['UserRating']['grade'] == 1)
                                            <span class="fdbk_sign positive"></span>
                                        @elseif ($rating['UserRating']['grade'] == 0)
                                            <span class="fdbk_sign neutral"></span>
                                        @elseif ($rating['UserRating']['grade'] == -1)
                                            <span class="fdbk_sign negative"></span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">No Result Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                tabindex="0">
                <table class="brandsTable table table-hover">
                    <thead>
                        <tr class="listing_header">
                            <th width="30%">Notice</th>
                            <th align="center" width="20%">Sell Clerk</th>
                            <th align="center" width="20%">Received</th>
                            <th align="center" width="20%">
                                <font>
                                    <font>Ratings</font>
                                </font>
                            </th>
                            <th align="center" width="10%">
                                <font>
                                    <font>Grade</font>
                                </font>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($receivedtheseller as $receivedthesellerRes)
                            <?php
                            $thesellerrating = $receivedthesellerRes['UserRating']['productdescribedval'] + $receivedthesellerRes['UserRating']['communicationval'] + $receivedthesellerRes['UserRating']['deliverytimeval'] + $receivedthesellerRes['UserRating']['cost_of_transportval'];
                            $selleravgrating = $thesellerrating / 4;
                            ?>
                            <tr class="tbl_data">
                                <td>
                                    <?php
                                    $selleradvid = $receivedthesellerRes['UserRating']['adv_id'];
                                    $selleradvdetail = $this->Custom->BapCustUniAdvDetail($selleradvid);
                                    ?>
                                    <a href="javascript:void(0);"
                                        onclick="saveView({{ $selleradvid }}, '{{ $base_url . 'pages/sales-details/' . $selleradvdetail['PostAd']['slug'] }}');"
                                        target="_blank">{{ $selleradvdetail['PostAd']['adv_name'] }}</a>
                                </td>
                                <td>
                                    <?php
                                    $sellerads_userid = $selleradvdetail['PostAd']['user_id'];
                                    $sellerad_user = $this->Custom->user_details($sellerads_userid);
                                    ?>
                                    <a href="{{ $base_url . 'admin/ManageUsers/rating/' . $sellerads_userid }}"
                                        target="_blank">{{ $sellerad_user['first_name'] . ' ' . $sellerad_user['last_name'] }}</a>
                                </td>
                                <td align="center">
                                    {{ $receivedthesellerRes['UserRating']['rating_type'] == 1 ? 'Buyer' : 'Seller' }}:
                                    <?php
                                    $sellerrateuserid = $receivedthesellerRes['UserRating']['from_user_id'];
                                    $sellerrateuser = $this->Custom->user_details($sellerrateuserid);
                                    ?>
                                    <a href="{{ $base_url . 'admin/ManageUsers/rating/' . $sellerrateuserid }}"
                                        target="_blank">{{ $sellerrateuser['first_name'] . ' ' . $sellerrateuser['last_name'] }}</a>
                                </td>
                                <td align="center">
                                    @if (!empty($selleravgrating))
                                        @for ($sellersingrating = 1; $sellersingrating <= round($selleravgrating); $sellersingrating++)
                                            @if ($sellersingrating > $selleravgrating)
                                                <img border="0"
                                                    src="{{ $base_url }}/images/star-small-halfactive.png"
                                                    alt="rating" />
                                            @else
                                                <img border="0"
                                                    src="{{ $base_url }}/images/star-small-active.png"
                                                    alt="rating" />
                                            @endif
                                        @endfor
                                        @if (round($selleravgrating) < 5)
                                            @for ($sellersingavg = 5; round($selleravgrating) < $sellersingavg; $sellersingavg--)
                                                <img border="0"
                                                    src="{{ $base_url }}/images/star-small-inactive.png">
                                            @endfor
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <div class="tbl_data_sign">
                                        @if ($receivedthesellerRes['UserRating']['grade'] == 1)
                                            <span class="fdbk_sign positive"></span>
                                        @elseif ($receivedthesellerRes['UserRating']['grade'] == 0)
                                            <span class="fdbk_sign neutral"></span>
                                        @elseif ($receivedthesellerRes['UserRating']['grade'] == -1)
                                            <span class="fdbk_sign negative"></span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">No Result Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                tabindex="0">
                <table class="brandsTable table table-hover">
                    <thead>
                        <tr class="listing_header">
                            <th width="30%">Notice</th>
                            <th align="center" width="20%">Sell Clerk</th>
                            <th align="center" width="20%">Received</th>
                            <th align="center" width="20%">
                                <font>
                                    <font>Ratings</font>
                                </font>
                            </th>
                            <th align="center" width="10%">
                                <font>
                                    <font>Grade</font>
                                </font>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($raceiveasbuyer as $raceiveasbuyerRes)
                            @php
                                $totbuyerrating =
                                    $raceiveasbuyerRes['UserRating']['productdescribedval'] +
                                    $raceiveasbuyerRes['UserRating']['communicationval'] +
                                    $raceiveasbuyerRes['UserRating']['deliverytimeval'] +
                                    $raceiveasbuyerRes['UserRating']['cost_of_transportval'];
                                $buyeravgrating = $totbuyerrating / 4;
                            @endphp
                            <tr class="tbl_data">
                                <td>
                                    @php
                                        $buyeradvid = $raceiveasbuyerRes['UserRating']['adv_id'];
                                        $buyeradvdetail = $this->Custom->BapCustUniAdvDetail($buyeradvid);
                                    @endphp
                                    <a href="javascript:void(0);"
                                        onclick="saveView({{ $buyeradvid }},'{{ $base_url . 'pages/sales-details/' . $buyeradvdetail['PostAd']['slug'] }}');"
                                        target="_blank">{{ $buyeradvdetail['PostAd']['adv_name'] }}</a>
                                </td>
                                <td>
                                    @php
                                        $buyerads_userid = $buyeradvdetail['PostAd']['user_id'];
                                        $buyerad_user = $this->Custom->user_details($buyerads_userid);
                                    @endphp
                                    <a href="{{ $base_url . 'admin/ManageUsers/rating/' . $buyerads_userid }}"
                                        target="_blank">{{ $buyerad_user['first_name'] . ' ' . $buyerad_user['last_name'] }}</a>
                                </td>
                                <td align="center">
                                    {{ $raceiveasbuyerRes['UserRating']['rating_type'] == 1 ? 'Buyer' : 'Seller' }}:
                                    @php
                                        $buyerrateuserid = $raceiveasbuyerRes['UserRating']['from_user_id'];
                                        $buyerrateuser = $this->Custom->user_details($buyerrateuserid);
                                    @endphp
                                    <a href="{{ $base_url . 'admin/ManageUsers/rating/' . $buyerrateuserid }}"
                                        target="_blank">{{ $buyerrateuser['first_name'] . ' ' . $buyerrateuser['last_name'] }}</a>
                                </td>
                                <td align="center">
                                    @if (!empty($buyeravgrating))
                                        @for ($buyersingavgrating = 1; $buyersingavgrating <= round($buyeravgrating); $buyersingavgrating++)
                                            @if ($buyersingavgrating > $buyeravgrating)
                                                <img border="0"
                                                    src="{{ $base_url }}/images/star-small-halfactive.png"
                                                    alt="rating" />
                                            @else
                                                <img border="0"
                                                    src="{{ $base_url }}/images/star-small-active.png"
                                                    alt="rating" />
                                            @endif
                                        @endfor
                                    @endif
                                    @if (round($buyeravgrating) < 5)
                                        @for ($buyersingavg = 5; round($buyeravgrating) < $buyersingavg; $buyersingavg--)
                                            <img border="0"
                                                src="{{ $base_url }}/images/star-small-inactive.png">
                                        @endfor
                                    @endif
                                </td>
                                <td>
                                    <div class="tbl_data_sign">
                                        @if ($raceiveasbuyerRes['UserRating']['grade'] == 1)
                                            <span class="fdbk_sign positive"></span>
                                        @elseif ($raceiveasbuyerRes['UserRating']['grade'] == 0)
                                            <span class="fdbk_sign neutral"></span>
                                        @elseif ($raceiveasbuyerRes['UserRating']['grade'] == -1)
                                            <span class="fdbk_sign negative"></span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">No Result Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <style>
        tr.tbl_header {
            font-size: 16px;
            font-weight: bold;
            border-color: black !important;
            border-bottom: 2px solid;
        }
    </style>
</x-app-layout>
