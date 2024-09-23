<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserCreditAccount;
use App\Models\UserMembership;
use App\Models\UserTotalCredit;
use App\Models\UpgradeMembership;
use App\Models\TempMembershipDetail;
use App\Models\SalesOrder;
use App\Models\SalesAdvertisement;
use App\Models\ManageMessage;
use App\Models\MasterUser;
use App\Models\MasterCountry;
use App\Models\MasterLocation;
use App\Models\Notice;
use App\Models\UserRating;
use App\Models\SuccessStory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserDashBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function userList(Request $request)
    {
        $data = array();
        $user_list = MasterUser::where('is_active', "1")->get();

        if ($user_list) {
            foreach ($user_list as $key => $list) {
                $data[$key]['user_name'] =  $list->first_name . ' ' . $list->last_name;
                $data[$key]['user_id'] =  $list->user_id;
            }
        } else {
            $data = array();
        }
        return response()->json($data);
    }

    public function accountCredits(Request $request, $userid)
    {
        $data = array();

        $accountCreditsData = UserCreditAccount::where('user_id', $userid)->orderby('credit_id', 'DESC')->get();
        if (!empty($accountCreditsData) && count($accountCreditsData) > 0) {
            foreach ($accountCreditsData as $key => $account_data) {
                $upgrade_memb = UpgradeMembership::where('upgrade_id', $account_data->upgrade_id)->first();
                $membership = UserMembership::where('memb_id', $upgrade_memb->member_type)->first();


                $filePath = public_path('uploads/memberplanimg/' . $membership->plan_img);
                $data[$key]['image'] = file_exists($filePath) && $membership->plan_img != "" ? asset('uploads/memberplanimg/' . $membership->plan_img) : null;

                if ($upgrade_memb !== null && $upgrade_memb->transfer_id) {
                    $data[$key]['last_transaction_id'] =  $upgrade_memb->transfer_id;
                } else {
                    $data[$key]['last_transaction_id'] =  null;
                }

                if ($membership !== null && $membership->memb_type) {
                    $data[$key]['last_membership_plan'] =  $membership->memb_type;
                } else {
                    $data[$key]['last_membership_plan'] =  null;
                }

                $data[$key]['total_credits'] =  $account_data->credits;
            }
        }

        return response()->json($data);
    }

    public function accountHistory(Request $request, $userid)
    {
        $data = array();

        $accountHistoryData = UpgradeMembership::where('user_id', $userid)->orderby('upgrade_id', 'DESC')->get();
        if (!empty($accountHistoryData) && count($accountHistoryData) > 0) {
            foreach ($accountHistoryData as $key => $account_data) {
                // $upgrade_memb = UpgradeMembership::where('upgrade_id', $account_data->upgrade_id)->first();
                $membership = UserMembership::where('memb_id', $account_data->member_type)->first();
                // Date Format


                // $isoTimestamp = $account_data->created;
                // $carbonTimestamp = Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $isoTimestamp);
                // $formatted_Date = $carbonTimestamp->format('Y-m-d');
                $isoTimestamp = $account_data->created;
                $carbonTimestamp = Carbon::parse($isoTimestamp);
                $formatted_Date = $carbonTimestamp->format('d-m-Y');

                $filePath = public_path('uploads/memberplanimg/' . $membership->plan_img);
                $data[$key]['image'] = file_exists($filePath) && $membership->plan_img != "" ? asset('uploads/memberplanimg/' . $membership->plan_img) : null;


                if ($account_data !== null && $account_data->transfer_id) {
                    $data[$key]['transaction_id'] = $account_data->transfer_id;
                } else {
                    $data[$key]['transaction_id'] = null;
                }
                if ($membership !== null && $membership->memb_type) {
                    $data[$key]['membership_plan'] = $membership->memb_type;
                } else {
                    $data[$key]['membership_plan'] = null;
                }
                if ($account_data !== null && $account_data->price) {
                    $data[$key]['amount'] = $account_data->price;
                } else {
                    $data[$key]['amount'] = null;
                }
                if ($account_data !== null && $account_data->credit) {
                    $data[$key]['credits'] =  $account_data->credit;
                } else {
                    $data[$key]['credits'] =  null;
                }
                if ($account_data !== null && $account_data->created) {
                    $data[$key]['date_of_payment'] =  $formatted_Date;
                } else {
                    $data[$key]['date_of_payment'] =  null;
                }
            }
        }

        return response()->json($data);
    }

    public function upgradeMember(Request $request)
    {
        $data = array();
        $upgrade_member = UserMembership::where('status', true)->get();

        foreach ($upgrade_member as $key => $member_data) {
            $filePath = public_path('uploads/memberplanimg/' . $member_data->plan_img);

            $data[$key]['member_title'] =  $member_data->memb_type;
            if (file_exists($filePath) && $member_data->plan_img != "") {
                $data[$key]['member_image'] =  asset('uploads/memberplanimg/' . $member_data->plan_img);
            } else {
                $data[$key]['member_image'] = asset('uploads/brand/noimage.jpg');
            }
            $data[$key]['member_price'] =  $member_data->price;
            $data[$key]['member_credits'] =  $member_data->credits;
            $data[$key]['memb_id'] =  $member_data->memb_id;
        }

        return response()->json($data);
    }

    public function membershipPlan(Request $request)
    {
        $randomId = str_pad(rand(0, pow(10, 8) - 1), 8, '0', STR_PAD_LEFT);
        $billing_details = new TempMembershipDetail();
        $billing_details->randomid = $randomId;
        $billing_details->pmt_from = $request->input('payment_from');

        $billing_details->fname = $request->input('name');
        $billing_details->email = $request->input('email');
        $billing_details->phone = $request->input('phone');
        $billing_details->address = $request->input('address');
        $billing_details->city = $request->input('city');
        $billing_details->state = $request->input('state');
        $billing_details->zip = $request->input('zip');

        $billing_details->copydetails = $request->input('copy_address');
        $billing_details->shipping_fname = $request->input('shipping_name');
        $billing_details->shipping_email = $request->input('shipping_email');
        $billing_details->shipping_phone = $request->input('shipping_phone');
        $billing_details->shipping_address = $request->input('shipping_address');
        $billing_details->shipping_city = $request->input('shipping_city');
        $billing_details->shipping_state = $request->input('shipping_state');
        $billing_details->shipping_zip = $request->input('shipping_zip');


        // $billing_details->created = $request->input('created');
        // $billing_details->modified = $request->input('modified');
        $billing_details->save();

        return response()->json([
            "message" => "Membership plan successfully saved",
            "data" => $billing_details
        ], 200);

        // $data = $request->all();
        // UpgradeMembership::create($data);
    }

    public function membershipConfirmPlan(Request $request)
    {
        $billing_details = new UpgradeMembership();
        $billing_details->user_id = $request->input('user_id');
        $billing_details->price = $request->input('price');
        $billing_details->credit = $request->input('credit');
        $billing_details->member_type = $request->input('membership_plan');
        $billing_details->payment_method = $request->input('payment_type');
        $billing_details->payment_status = $request->input('payment_status');
        $billing_details->transfer_id = $request->input('transfer_id');
        $billing_details->plan_status = $request->input('plan_status');

        $billing_details->name = $request->input('name');
        $billing_details->email = $request->input('email');
        $billing_details->phone = $request->input('phone');
        $billing_details->address = $request->input('address');
        $billing_details->county = $request->input('country');
        $billing_details->city = $request->input('city');
        $billing_details->zip = $request->input('zip');

        $billing_details->shipping_different = $request->input('another_address');
        $billing_details->shipping_name = $request->input('shipping_name');
        $billing_details->shipping_email = $request->input('shipping_email');
        $billing_details->shipping_phone = $request->input('shipping_phone');
        $billing_details->shipping_address = $request->input('shipping_address');
        $billing_details->shipping_county = $request->input('shipping_country');
        $billing_details->shipping_city = $request->input('shipping_city');
        $billing_details->shipping_zip = $request->input('shipping_zip');
        $billing_details->save();

        return response()->json([
            "message" => "Membership plan successfully confirmed",
            "data" => $billing_details
        ], 200);
    }

    public function ratingGivenBuyer(Request $request, $userid)
    {
        $data = array();
        $sales_adv_list = SalesAdvertisement::where('user_id', $userid)->get();

        if ($sales_adv_list->isEmpty()) {
            return response()->json(['message' => 'No data available'], 404);
        }

        $count = 0;
        foreach ($sales_adv_list as $key => $order_list) {
            $sales_order = SalesOrder::where('adv_id', $order_list->adv_id)->first();

            if ($sales_order) {
                $user = MasterUser::where('user_id', $sales_order->user_id)->first();
                $country = MasterCountry::where('country_id', $sales_order->country)->first();
                $location = MasterLocation::where('location_id', $sales_order->location)->first();

                $isoTimestamp = $sales_order->created;
                $carbonTimestamp = Carbon::parse($isoTimestamp);
                $formatted_Date = $carbonTimestamp->format('d-m-Y');

                $data[$count]['advertisement_name'] =  $order_list->adv_name;
                $data[$count]['command_id'] =  $sales_order->orderid;
                $data[$count]['quantity'] =  $sales_order->qty ?? null;
                $data[$count]['price'] =  $sales_order->totprice;
                $data[$count]['ordered_prin'] =  $user->first_name . ' ' . $user->last_name;
                $data[$count]['delivery_name'] =  $sales_order->fname . ' ' . $sales_order->lname;
                $data[$count]['country'] =  $country ? $country->country_name : null;
                $data[$count]['location'] =  $location ? $location->location_name : null;
                $data[$count]['postal_code'] =  $sales_order->postcode;
                $data[$count]['delivery_method'] =  $sales_order->delivery_method;
                $data[$count]['delivery_address'] =  $sales_order->delivery_add;
                $data[$count]['order_date'] =  $formatted_Date;
                $data[$count]['slug'] =  $order_list->slug;
                $count++;
            }
        }

        return response()->json($data);
    }


    // public function ratingGivenSeller(Request $request, $userid)
    // {
    //     $data = array();
    //     $sales_order_list = SalesOrder::where('user_id', $userid)->get();

    //     foreach ($sales_order_list as $key => $order_list) {
    //         $sales_adv = SalesAdvertisement::where('adv_id', $order_list->adv_id)->first();
    //     }

    //     return response()->json($data);

    // }

    public function ratingGivenSeller(Request $request, $userid)
    {
        $data = array();
        $sales_adv_list = SalesAdvertisement::where('user_id', $userid)->get();

        if ($sales_adv_list->isEmpty()) {
            return response()->json(['message' => 'No data found']);
        }
        $count = 0;
        foreach ($sales_adv_list as $key => $order_list) {
            $sales_order = SalesOrder::where('adv_id', $order_list->adv_id)->first();

            if ($sales_order) {
                $user = MasterUser::where('user_id', $sales_order->user_id)->first();
                $country = MasterCountry::where('country_id', $sales_order->country)->first();
                $location = MasterLocation::where('location_id', $sales_order->location)->first();

                $isoTimestamp = $sales_order->created;
                $carbonTimestamp = Carbon::parse($isoTimestamp);
                $formatted_Date = $carbonTimestamp->format('d-m-Y');

                $data[$count]['advertisement_name'] =  $order_list->adv_name;
                $data[$count]['command_id'] =  $sales_order->orderid;
                $data[$count]['quantity'] =  $sales_order->qty;
                $data[$count]['slug'] =  $order_list->slug;
                $data[$count]['price'] =  $sales_order->totprice;
                $data[$count]['ordered_prin'] =  $user->first_name . ' ' . $user->last_name;
                $data[$count]['delivery_name'] =  $sales_order->fname . ' ' . $sales_order->lname;
                $data[$count]['country'] =  $country ? $country->country_name : null;
                $data[$count]['location'] =  $location ? $location->location_name : null;
                $data[$count]['postal_code'] =  $sales_order->postcode;
                $data[$count]['delivery_method'] =  $sales_order->delivery_method;
                $data[$count]['delivery_address'] =  $sales_order->delivery_add;
                $data[$count]['order_date'] =  $formatted_Date;
                $count++;
            }
        }

        return response()->json($data);
    }


    public function messageInbox(Request $request, $userid)
    {
        $data = array();
        $message_inbox = ManageMessage::where('to_user', $userid)->where('status', "1")->get();

        if ($message_inbox) {
            foreach ($message_inbox as $key => $inbox_list) {
                $from_user = MasterUser::where('user_id', $inbox_list->from_user)->first();
                $to_user = MasterUser::where('user_id', $inbox_list->to_user)->first();
                $message_reply = ManageMessage::where('parent', $inbox_list->msg_id)->get();

                $isoTimestamp = $inbox_list->created;
                $carbonTimestamp = Carbon::parse($isoTimestamp);
                $formatted_Date = $carbonTimestamp->format('d-m-Y');

                $data[$key]['submitted_by'] =  $from_user->first_name . ' ' . $from_user->last_name;
                $data[$key]['message'] =  $inbox_list->message;
                $data[$key]['reply'] = $message_reply;
                $data[$key]['order_date'] =  $formatted_Date;
                $data[$key]['message_id'] = $inbox_list->msg_id;
                $data[$key]['from_user_id'] = $from_user->user_id;
            }
        } else {
            $data = array();
        }
        return response()->json($data);
    }
    public function deleteInboxMsg(Request $request, $msgId)
    {
        $message_inbox = ManageMessage::find($msgId);
        try {
            $message_inbox->delete();
            return response()->json(["msg" => "Deleted Succesfully"]);
        } catch (\Throwable $th) {
            return response()->json(["msg" => "There was some error"]);
        }
    }

    public function sentMessage($userid)
    {
        $data = array();
        $from_user = ManageMessage::where('from_user', $userid)->where('status', "1")->orderBy("msg_id","desc")->get();
        foreach ($from_user as $key => $message_list) {
            $sent_to = MasterUser::find($message_list->to_user);
            $repliedTo = ManageMessage::find($message_list->parent);
            $isoTimestamp = $message_list->created;
            $carbonTimestamp = Carbon::parse($isoTimestamp);
            $formatted_Date = $carbonTimestamp->format('d-m-Y');


            $data[$key]['sent_to'] =  $sent_to->first_name . ' ' . $sent_to->last_name;
            $data[$key]['message'] =  $message_list->message;
            $data[$key]['reply'] = $repliedTo ? $repliedTo->message:"";
            $data[$key]['order_date'] =  $formatted_Date;
        }
        // if ($from_user) {
        //     $sent_messages = ManageMessage::where('parent', $from_user->msg_id)->where('status', "1")->get();

        //     foreach ($sent_messages as $key => $message_list) {


        //         $isoTimestamp = $message_list->created;
        //         $carbonTimestamp = Carbon::parse($isoTimestamp);
        //         $formatted_Date = $carbonTimestamp->format('d-m-Y');


        //         $data[$key]['sent_to'] =  $from_user->to_user;
        //         $data[$key]['message'] =  $from_user->message;
        //         $data[$key]['reply'] = $message_list->message;
        //         $data[$key]['order_date'] =  $formatted_Date;
        //     }
        // } else {
        //     // $message = "Data Not Found";
        //     // return response()->json(array('data' => $data, 'message' => $message));
        //     // $data[$key]['sent_to'] = null;
        //     // $data[$key]['message'] = null;
        //     // $data[$key]['reply'] = null;
        //     // $data[$key]['order_date'] = null;
        //     $data = array();
        // }
        return response()->json($data);
    }

    public function archiveMessage($userid)
    {
        $data = array();
        $archive_message = ManageMessage::where('to_user', $userid)->where('status', '!=', '0')->orderBy("msg_id","desc")->get();

        if ($archive_message) {
            foreach ($archive_message as $key => $message_list) {
                $replied_to = ManageMessage::find($message_list->parent);
                $from_user = MasterUser::where('user_id', $message_list->from_user)->first();
                $to_user = MasterUser::where('user_id', $message_list->to_user)->first();

                $isoTimestamp = $message_list->created;
                $carbonTimestamp = Carbon::parse($isoTimestamp);
                $formatted_Date = $carbonTimestamp->format('d-m-Y');

                $data[$key]['submitted_by'] =  $from_user->first_name . ' ' . $from_user->last_name;
                $data[$key]['message'] =  $message_list->message;
                $data[$key]['replied_to'] = $replied_to?$replied_to->message:"";
                if ($message_list->status == "1") {
                    $data[$key]['message_type'] =  "Inbox";
                } else {
                    $data[$key]['message_type'] =  "History Message";
                }
                $data[$key]['order_date'] =  $formatted_Date;
            }
        } else {
            $data = array();
        }
        return response()->json($data);
    }

    public function emailHistory($userid)
    {
        $data = array();
        $email_history = ManageMessage::where('to_user', $userid)->where('status', "2")->get();

        if ($email_history) {
            foreach ($email_history as $key => $message_list) {
                $from_user = MasterUser::where('user_id', $message_list->from_user)->first();


                $isoTimestamp = $message_list->created;
                $carbonTimestamp = Carbon::parse($isoTimestamp);
                $formatted_Date = $carbonTimestamp->format('d-m-Y');

                $data[$key]['submitted_by'] =  $from_user->first_name . ' ' . $from_user->last_name;
                $data[$key]['message'] =  $message_list->message;
                $data[$key]['order_date'] =  $formatted_Date;
            }
        } else {
            $data = array();
        }
        return response()->json($data);
    }

    public function composeMessage(Request $request)
    {
        $send_message = new ManageMessage();
        $send_message->from_user = $request->input('from_user_id');
        $send_message->to_user = $request->input('to_user_id');
        $send_message->message = $request->input('message');
        $send_message->parent = "0";
        $send_message->status = "1";
        $send_message->save();

        return response()->json([
            "message" => "Message sent successfully",
            "data" => $send_message
        ], 200);
    }

    public function replyMessage(Request $request)
    {
        $send_message = new ManageMessage();
        $send_message->from_user = $request->input('from_user_id');
        $send_message->to_user = $request->input('to_user_id');
        $send_message->message = $request->input('message');
        $send_message->parent = $request->input('msg_id');
        $send_message->status = "1";
        $send_message->save();

        return response()->json([
            "message" => "Message sent successfully",
            "data" => $send_message
        ], 200);
    }

    public function myRating($userid)
    {
        $data = array();
        $user_rating = UserRating::where('user_id', $userid)->get();

        if ($user_rating) {
            foreach ($user_rating as $key => $rating_list) {
                $sale_ad = SalesAdvertisement::where('adv_id', $rating_list->adv_id)->first();
                $from_user = MasterUser::where('user_id', $rating_list->from_user_id)->first();

                $data[$key]['rating_type'] =  $rating_list->grade;
                if ($sale_ad) {
                    $data[$key]['opinion'] =  $sale_ad->adv_name;
                    $user = MasterUser::where('user_id', $sale_ad->user_id)->first();
                    $data[$key]['sales_clerk'] = $user->first_name . ' ' . $user->last_name;
                } else {
                    $data[$key]['opinion'] =  null;
                    $data[$key]['sales_clerk'] =  null;
                }
                if ($from_user) {
                    $data[$key]['receive_from'] = $from_user->first_name . ' ' . $from_user->last_name;
                } else {
                    $data[$key]['receive_from'] = null;
                }
                $rating = $rating_list->productdescribedval + $rating_list->communicationval + $rating_list->deliverytimeval + $rating_list->cost_of_transportval;
                $data[$key]['assessment'] = $rating / 4;
                $data[$key]['quality'] =  $rating_list->grade;
            }
        } else {
            $data = array();
        }
        return response()->json($data);
    }

    public function successStoriesList($userid)
    {
        $data = array();
        // $user_rating = SuccessStory::where('user_id', $userid)->get();
        $success_stories = SuccessStory::where('user_id', $userid)->where('submit_from', '1')->get();

        if ($success_stories) {
            foreach ($success_stories as $key => $story) {

                $isoTimestamp = $story->created;
                $carbonTimestamp = Carbon::parse($isoTimestamp);
                $formatted_Date = $carbonTimestamp->format('d-m-Y');

                $data[$key]['story_id'] =  $story->success_id;
                $data[$key]['description'] =  $story->content;
                $data[$key]['status'] = $story->status;
                $data[$key]['posted_date'] =  $formatted_Date;
            }
        } else {
            $data = array();
        }
        return response()->json($data);
    }

    public function addSuccessStory(Request $request)
    {
        $add_story = new SuccessStory();
        $add_story->user_id = $request->input('user_id');
        $add_story->content = $request->input('content');
        $add_story->submit_from = "1";
        $add_story->status = "1";
        $add_story->save();

        return response()->json([
            "message" => "Success story added successfully",
            "data" => $add_story
        ], 200);
    }

    public function editSuccessStory($storyId)
    {
        $success_story = SuccessStory::where('success_id', $storyId)->first();

        if ($success_story) {
            $data['content'] =  $success_story->content;
        } else {
            $data = null;
        }
        return response()->json($data);
    }

    public function updateSuccessStory(Request $request)
    {
        $update_story = SuccessStory::where('success_id', $request->input('story_id'))->first();
        $update_story->content = $request->input('content');
        $update_story->submit_from = "1";
        $update_story->status = "1";
        $update_story->save();

        return response()->json([
            "message" => "Success story updated successfully",
            "data" => $update_story
        ], 200);
    }


    public function fetchBuyerRating(Request $request, $orderId)
    {
        $orderDetail = SalesOrder::find($orderId);

        if (!$orderDetail) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $ratingDetail = UserRating::where('orderid', $orderId)
            ->where('user_id', $orderDetail->user_id)
            ->first();


        return response()->json(['ratingDetail' => $ratingDetail]);
    }

    public function saveBuyerRating(Request $request)
    {
        $salesOrderId = $request->orderid;

        $existingRating = UserRating::where('orderid', $salesOrderId)->exists();

        if ($existingRating) {
            return response()->json(['error' => 'Rating already given for this sales_order'], 400);
        }

        // Retrieve the authenticated user
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'grade' => 'required|in:-1,0,1',
            'how_to_know' => 'nullable|string|max:255',
            'productdescribedval' => 'required|numeric|between:0,5',
            'communicationval' => 'required|numeric|between:0,5',
            'deliverytimeval' => 'required|numeric|between:0,5',
            'cost_of_transportval' => 'required|numeric|between:0,5',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Retrieve order detail
        $orderDetail = SalesOrder::find($salesOrderId);

        $rating = new UserRating();
        $rating->user_id = Auth::id();
        $rating->from_user_id = $user->user_id;
        $rating->orderid = $salesOrderId;
        $rating->adv_id = $orderDetail->adv_id;
        $rating->rating_type = 1;
        $rating->grade = $request->input('grade');
        $rating->how_to_know = $request->input('how_to_know');
        $rating->productdescribedval = $request->input('productdescribedval');
        $rating->communicationval = $request->input('communicationval');
        $rating->deliverytimeval = $request->input('deliverytimeval');
        $rating->cost_of_transportval = $request->input('cost_of_transportval');
        $rating->created = Carbon::now();
        $rating->modified = Carbon::now();

        $rating->save();

        return response()->json(['message' => 'Rating created successfully', 'rating' => $rating], 201);
    }

    public function fetchSellerRating(Request $request, $orderId)
    {
        $orderDetail = SalesOrder::find($orderId);

        if ($orderDetail === null) {
            return response()->json(['error' => 'Sales order not found'], 404);
        }

        $postdetails = SalesAdvertisement::where('adv_id', $orderDetail->adv_id)->first();

        if ($postdetails === null) {
            return response()->json(['error' => 'Sales advertisement not found'], 404);
        }

        $ratingDetail = UserRating::where('orderid', $orderId)
            ->where('user_id', $postdetails->user_id)
            ->first();

        return response()->json(['ratingDetail' => $ratingDetail]);
    }

    public function saveSellerRating(Request $request)
    {
        $orderid = $request->orderid;

        $validator = Validator::make($request->all(), [
            'grade' => 'required|in:-1,0,1',
            'how_to_know' => 'nullable|string|max:255',
            'productdescribedval' => 'required|numeric|between:0,5',
            'communicationval' => 'required|numeric|between:0,5',
            'deliverytimeval' => 'required|numeric|between:0,5',
            'cost_of_transportval' => 'required|numeric|between:0,5',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();

        $orderdetail = SalesOrder::find($orderid);
        if (!$orderdetail) {
            return response()->json(['error' => 'Order detail not found'], 404);
        }

        $userRating = UserRating::where('user_id', Auth::id())
            ->where('orderid', $orderid)
            ->first();

        if ($userRating) {
            return response()->json(['error' => 'You have already rated.'], 400);
        } else {
            $rating = new UserRating();
            $rating->user_id = Auth::id();
            $rating->from_user_id = $user->user_id;
            $rating->orderid = $orderid;
            $rating->adv_id = $orderdetail->adv_id;
            $rating->rating_type = 1;
            $rating->grade = $request->input('grade');
            $rating->how_to_know = $request->input('how_to_know');
            $rating->productdescribedval = $request->input('productdescribedval');
            $rating->communicationval = $request->input('communicationval');
            $rating->deliverytimeval = $request->input('deliverytimeval');
            $rating->cost_of_transportval = $request->input('cost_of_transportval');
            $rating->created = Carbon::now();
            $rating->modified = Carbon::now();

            $rating->save();

            $notice = new Notice();
            $notice->notice_type = 'buyer-rate';
            $notice->postid = $orderdetail->adv_id;
            $notice->notice_name = 'Rating To Buyer';
            $notice->user_id = $user->user_id;
            $notice->save();

            $notice = new Notice();
            $notice->notice_type = 'buyer-rate';
            $notice->postid = $orderdetail->adv_id;
            $notice->notice_name = 'Rating To Buyer';
            $notice->user_id = $orderdetail->user_id;
            $notice->save();

            return response()->json(['success' => 'Rating successfully given to Seller.']);
        }
    }
}
