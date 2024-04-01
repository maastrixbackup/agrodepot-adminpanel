<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterUser;
use App\Models\SalesBrand;
use App\Models\UserRating;
use App\Models\SalesQuestion;
use App\Models\SalesAdvertisement;
use App\Models\SubscribeAlert;
use App\Models\SalesCategory;
use App\Models\MasterCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Mail\NewB2BUserMail;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh', 'logout', 'updatePass']]);
    }

    public function register(Request $request)
    {

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:master_users',
            'password' => 'required|string|min:6',
            'user_type_id' => 'required',
            'telephone1' => 'required',
            'telephone2' => 'required',
            'telephone3' => 'required',
            'telephone4' => 'required',
            'country_id' => 'required',
            'locality_id' => 'required',
            // 'confirm_password' => 'required|string|min:6',

        ]);


        $user_type_id = ($request->user_type_id == 1) ? (($request->buyer_type == 1) ? 3 : 1) : $request->user_type_id;
        $is_active = 1;
      

        if ($request->buyer_type == 1) {
            $is_active = 0;
        }
        $user = MasterUser::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'pass' => md5($request->password),
            'user_type_id' => $user_type_id,
            'telephone1' => $request->telephone1,
            'telephone2' => $request->telephone2,
            'telephone3' => $request->telephone3,
            'telephone4' => $request->telephone4,
            'country_id' => $request->country_id,
            'locality_id' => $request->locality_id,
            'is_active' => $is_active,
        ]);

        
        $route =  url('admin/users/' . $user->user_id . '/edit') ;
        $AccountLink = '<a href="'.$route.'">here</a>';
        if ($request->buyer_type == 1) {
           

            $emailTemplate = EmailTemplate::where('email_of', 16)->first()->mail_body;
            $emailTemplate = str_replace("{AccountLink}", $AccountLink, $emailTemplate);
            $body =  $emailTemplate;

            $body = [
                'body' => $body
            ];

            Mail::to('info@piesemasiniagricole.ro')->send(new NewB2BUserMail($body));
        }

        $token = Auth::guard('api')->login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = MasterUser::where('email', $request->input('email'))->first();

        if ($user->is_active != 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Account not active yet.Please contact support.',
            ], 401);
        }
        if (!$user || md5($request->input('password')) !== $user->pass) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = Auth::guard('api')->login($user);

        $user = Auth::guard('api')->user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }


    public function updatePass()
    {
        foreach (MasterUser::all() as $user) {
            if (Hash::needsRehash($user->pass)) { // Check if password needs rehashing
                $user->update(['password' => Hash::make($user->pass)]);
            }
        }
    }
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }


    // public function refresh()
    // {
    //     return response()->json([
    //         'status' => 'success',
    //         'user' => Auth::guard('api')->user(),
    //         'authorisation' => [
    //             'token' => Auth::guard('api')->refresh(),
    //             'type' => 'bearer',
    //         ]
    //     ]);
    // }
    public function refresh(Request $request)
    {
        $token = $request->bearerToken(); // Get the token from the request

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token not provided'
            ], 401); // Unauthorized
        }

        try {
            $refreshedToken = Auth::guard('api')->refresh(); // Refresh the token

            return response()->json([
                'status' => 'success',
                'authorisation' => [
                    'token' => $refreshedToken,
                    'type' => 'bearer',
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token could not be refreshed'
            ], 401); // Unauthorized
        }
    }

    public function userDetails($id)
    {
        $user = MasterUser::find($id);
        $filePath = public_path('uploads/profileimg/' . $user->profile_img);

        if (file_exists($filePath) && $user->profile_img != "") {
            $user['profilePic'] = asset('uploads/profileimg/' . $user->profile_img);
        } else {
            $user['profilePic'] = null;
        }
        return response()->json($user);
    }
    public function updateProfile(Request $request)
    {

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required',
            'user_type_id' => 'required',
            'telephone1' => 'required',
            'telephone2' => 'required',
            'telephone3' => 'required',
            'telephone4' => 'required',
            'country_id' => 'required',
            'locality_id' => 'required',
        ]);

        $user = MasterUser::find($request->user_id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        // $user->pass = md5($request->password);
        $user->user_type_id = $request->user_type_id;
        $user->telephone1 = $request->telephone1;
        $user->telephone2 = $request->telephone2;
        $user->telephone3 = $request->telephone3;
        $user->telephone4 = $request->telephone4;
        $user->country_id = $request->country_id;
        $user->locality_id = $request->locality_id;
        $user->other_add = $request->other_add;
        $user->postal_code = $request->postal_code;
        if ($request->file('profilePic')) {
            $previousImagePath = public_path('uploads/banner/' . $user->profile_img);
            if ($user->profile_img && file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
            $image = $request->file('profilePic');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/profileimg'), $imageName);
            $user->profile_img = $imageName;
        }
        $user->save();


        return response()->json([
            'status' => 'success',
            'message' => 'User Updated successfully',
            'user' => $user
        ]);
    }

    public function myRequestParts(Request $request, $userid)
    {
        $data = [];
        $resolved_data = [];
        $cancelled_data = [];


        $active_request = [];
        $resolved_request = [];
        $cancellation_request = [];
        $data = \DB::table('request_parts')
            ->leftJoin('request_accessories', 'request_accessories.request_id', '=', 'request_parts.request_id')
            ->select('request_parts.request_id', 'request_parts.user_id', 'request_parts.created', 'request_parts.brand_id', 'request_parts.model_id', 'request_accessories.slug', 'request_accessories.name_piece', 'request_accessories.offerno', 'request_accessories.part_id')
            ->where('request_accessories.status', 1)
            ->where('request_parts.status', 1)
            ->where('request_parts.user_id', $userid)
            ->orderBy('request_parts.request_id', 'desc')
            ->get();

        $resolved_data = \DB::table('request_parts')
            ->leftJoin('request_accessories', 'request_accessories.request_id', '=', 'request_parts.request_id')
            ->select('request_parts.request_id', 'request_parts.user_id', 'request_parts.created', 'request_parts.brand_id', 'request_parts.model_id', 'request_accessories.slug', 'request_accessories.name_piece', 'request_accessories.offerno', 'request_accessories.part_id')
            ->where('request_accessories.status', 2)
            ->where('request_parts.status', 1)
            ->where('request_parts.user_id', $userid)
            ->orderBy('request_parts.request_id', 'desc')
            ->get();

        $cancelled_data = \DB::table('request_parts')
            ->leftJoin('request_accessories', 'request_accessories.request_id', '=', 'request_parts.request_id')
            ->select('request_parts.request_id', 'request_parts.user_id', 'request_parts.created', 'request_parts.brand_id', 'request_parts.model_id', 'request_accessories.slug', 'request_accessories.name_piece', 'request_accessories.offerno', 'request_accessories.part_id')
            ->where('request_accessories.status', 0)
            ->where('request_parts.status', 3)
            ->where('request_parts.user_id', $userid)
            ->orderBy('request_parts.request_id', 'desc')
            ->get();

        if ($data) {
            foreach ($data as $key => $detail) {
                $active_request[$key]['request_id'] = $detail->request_id;
                $active_request[$key]['created'] = $detail->created;
                $active_request[$key]['slug'] = $detail->slug;
                $active_request[$key]['name_piece'] = $detail->name_piece;
                $active_request[$key]['part_id'] = $detail->part_id;
                $active_request[$key]['user_id'] = $detail->user_id;
                $active_request[$key]['offerno'] = $detail->offerno;
                $brand = SalesBrand::where('brand_id', $detail->brand_id)->first(['brand_name']);

                if (!empty($brand)) {
                    $brand_name =  $brand->brand_name;
                } else {
                    $brand_name =  '';
                }

                $model = SalesBrand::where('brand_id', $detail->model_id)->first(['brand_name']);

                if (!empty($model)) {
                    $model_name =  $model->brand_name;
                } else {
                    $model_name =  '';
                }
                $active_request[$key]['brand_name'] = $brand_name;
                $active_request[$key]['model_name'] = $model_name;
            }
        }

        if ($resolved_data) {
            foreach ($resolved_data as $key => $detail) {
                $resolved_request[$key]['request_id'] = $detail->request_id;
                $resolved_request[$key]['created'] = $detail->created;
                $resolved_request[$key]['slug'] = $detail->slug;
                $resolved_request[$key]['name_piece'] = $detail->name_piece;
                $resolved_request[$key]['part_id'] = $detail->part_id;
                $resolved_request[$key]['user_id'] = $detail->user_id;
                $resolved_request[$key]['offerno'] = $detail->offerno;
                $brand = SalesBrand::where('brand_id', $detail->brand_id)->first(['brand_name']);

                if (!empty($brand)) {
                    $brand_name =  $brand->brand_name;
                } else {
                    $brand_name =  '';
                }

                $model = SalesBrand::where('brand_id', $detail->model_id)->first(['brand_name']);

                if (!empty($model)) {
                    $model_name =  $model->brand_name;
                } else {
                    $model_name =  '';
                }
                $resolved_request[$key]['brand_name'] = $brand_name;
                $resolved_request[$key]['model_name'] = $model_name;
            }
        }

        if ($cancelled_data) {
            foreach ($cancelled_data as $key => $detail) {
                $cancellation_request[$key]['request_id'] = $detail->request_id;
                $cancellation_request[$key]['created'] = $detail->created;
                $cancellation_request[$key]['slug'] = $detail->slug;
                $cancellation_request[$key]['name_piece'] = $detail->name_piece;
                $cancellation_request[$key]['part_id'] = $detail->part_id;
                $cancellation_request[$key]['user_id'] = $detail->user_id;
                $cancellation_request[$key]['offerno'] = $detail->offerno;
                $brand = SalesBrand::where('brand_id', $detail->brand_id)->first(['brand_name']);

                if (!empty($brand)) {
                    $brand_name =  $brand->brand_name;
                } else {
                    $brand_name =  '';
                }

                $model = SalesBrand::where('brand_id', $detail->model_id)->first(['brand_name']);

                if (!empty($model)) {
                    $model_name =  $model->brand_name;
                } else {
                    $model_name =  '';
                }
                $cancellation_request[$key]['brand_name'] = $brand_name;
                $cancellation_request[$key]['model_name'] = $model_name;
            }
        }


        return response()->json(['active_data' => $active_request, 'resolved_data' => $resolved_request, 'cancelled_data' => $cancellation_request]);
    }

    public function myPurchases(Request $request, $userid)
    {
        $data = [];
        $purchase_data = [];
        \DB::enableQueryLog();
        $data = \DB::table('sales_order')
            ->leftJoin('sales_advertisements as PostAd', 'PostAd.adv_id', '=', 'sales_order.adv_id')
            ->select('PostAd.adv_id', 'PostAd.user_id', 'PostAd.adv_name', 'PostAd.slug', 'PostAd.currency', 'sales_order.orderid', 'PostAd.price', 'sales_order.qty', 'sales_order.created', 'sales_order.id')
            ->where('sales_order.user_id', $userid)
            ->orderBy('sales_order.orderid', 'desc')
            ->limit(10)
            ->get();
        //  dd(\DB::getQueryLog());
        if ($data) {
            foreach ($data as $key => $detail) {
                $user = MasterUser::where('user_id', $detail->user_id)->first();
                $purchase_data[$key]['user_id'] =  isset($user->user_id) ? $user->user_id : "";
                $purchase_data[$key]['first_name'] = isset($user->first_name) ? $user->first_name : "";
                $purchase_data[$key]['last_name'] = isset($user->last_name) ? $user->last_name : "";

                $purchase_data[$key]['phone_no'] = isset($user->telephone1) ? $user->telephone1 : "";
                $purchase_data[$key]['email'] = isset($user->email) ? $user->email : "";
                $purchase_data[$key]['postal_code'] = isset($user->postal_code) ? $user->postal_code : "";
                $purchase_data[$key]['address'] = isset($user->other_add) ? $user->other_add : "";

                $purchase_data[$key]['adv_name'] = $detail->adv_name;
                $purchase_data[$key]['adv_id'] = $detail->adv_id;
                $purchase_data[$key]['slug'] = $detail->slug;
                $purchase_data[$key]['orderid'] = $detail->orderid;
                $purchase_data[$key]['price'] = $detail->price;
                $purchase_data[$key]['currency'] = $detail->currency;
                $purchase_data[$key]['qty'] = $detail->qty;
                $purchase_data[$key]['sales_order_id'] = $detail->id;
                $purchase_data[$key]['created_date'] = $detail->created;
                $grade = 0;
                if (!empty($user->user_id)) {
                    $allpositivegrade = UserRating::where('user_id', $user->user_id)
                        ->orderBy('rating_id', 'desc')
                        ->get();

                    $grade = 0;

                    if ($allpositivegrade->isNotEmpty()) {
                        foreach ($allpositivegrade as $rating) {
                            $grade += $rating->grade;
                        }
                    }
                }

                $purchase_data[$key]['rating'] =  $grade;
                // $resolved_request[$key]['model_name'] = $model_name;
            }
        }

        return response()->json(['data' => $purchase_data]);
    }

    public function myQuestions(Request $request, $userid)
    {
        $questions = SalesQuestion::where('user_id', $userid)
            ->where('parent', 0)
            ->orderBy('question_id', 'desc')
            ->get();
        $qs_data = [];
        if ($questions) {
            foreach ($questions as $key => $detail) {
                $advDetail = SalesAdvertisement::where('adv_id', $detail->adv_id)->first();
                if (!empty($advDetail->user_id)) {
                    $userdetail = MasterUser::where('user_id', $advDetail->user_id)->first();
                }
                $qs_data[$key]['user_id'] =  isset($userdetail->user_id) ? $userdetail->user_id : "";
                $qs_data[$key]['first_name'] = isset($userdetail->first_name) ? $userdetail->first_name : "";
                $qs_data[$key]['last_name'] = isset($userdetail->last_name) ? $userdetail->last_name : "";

                $qs_data[$key]['phone_no'] = isset($userdetail->telephone1) ? $userdetail->telephone1 : "";
                $qs_data[$key]['email'] = isset($userdetail->email) ? $userdetail->email : "";
                $qs_data[$key]['address'] = isset($userdetail->other_add) ? $userdetail->other_add : "";

                $qs_data[$key]['adv_name'] = isset($advDetail->adv_name) ? $advDetail->adv_name : "";
                $qs_data[$key]['slug'] = isset($advDetail->slug) ? $advDetail->slug : "";
                $qs_data[$key]['adv_id'] = $detail->adv_id;
                $qs_data[$key]['question'] = $detail->question;
                $qs_data[$key]['question_id'] = $detail->question_id;
                $qs_data[$key]['created_date'] = $detail->created;

                $grade = 0;
                if (!empty($userdetail->user_id)) {
                    $allpositivegrade = UserRating::where('user_id', $userdetail->user_id)
                        ->orderBy('rating_id', 'desc')
                        ->get();

                    $grade = 0;

                    if ($allpositivegrade->isNotEmpty()) {
                        foreach ($allpositivegrade as $rating) {
                            $grade += $rating->grade;
                        }
                    }
                }

                $qs_data[$key]['rating'] =  $grade;
            }
        }

        return response()->json(['data' => $qs_data]);
    }

    public function askQuestion(Request $request, $userid)
    {
        $data = [];
        $questions = SalesAdvertisement::where('user_id', $userid)->get();

        // dd($questions);
        if ($questions) {
            foreach ($questions as $key => $detail) {
                $advDetail = SalesQuestion::where('adv_id', $detail->adv_id)->where('parent', 0)->get();
                foreach ($advDetail as $key => $value) {
                    $user = MasterUser::find($value->user_id);
                    $product = SalesAdvertisement::find($value->adv_id);
                    if ($value) {
                        $value["user"] = $user;
                        $value["product"] = $product;
                        $data[$key] = $value;
                    }
                }
            }
        }
        // dd($data);
        return response()->json(['data' => $data]);
    }
    public function replies(Request $request, $questionId)
    {
        $data = [];
        $question = SalesQuestion::where('question_id', $questionId)->first();
        $replies = SalesQuestion::where('parent', $questionId)->get();
        foreach ($replies as $key => $value) {
            $user = MasterUser::find($value->user_id);
            $replies[$key]["user"] = $user;
        }

        // dd($questions);
        $user = MasterUser::find($question->user_id);
        $product = SalesAdvertisement::find($question->adv_id);
        $question["user"] = $user;
        $question["product"] = $product;
        $question["replies"] = $replies;
        // dd($data);
        return response()->json(['data' => $question]);
    }

    public function changePassword(Request $request)
    {
        // dd(1);
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'current_password' => 'required',
            'new_password' => 'required|different:current_password',
            'retype_new_password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $currentpassword = $request->current_password;
        $newpassword = $request->new_password;
        $confirmpassword = $request->retype_new_password;
        if ($request->user_id) {
            $chk_user =  MasterUser::find($request->user_id);
            // $check = Hash::check($currentpassword, $chk_user->password);
            $check = (md5($currentpassword) === $chk_user->pass);
            if ($check) {
                if ($newpassword == $confirmpassword) {
                    // MasterUser::where('id', $request->user_id)->update(['password' => Hash::make($newpassword)]);
                    MasterUser::where('user_id', $request->user_id)->update(['pass' => md5($newpassword)]);
                    return response()->json([
                        'message' => 'Password Changed Successfully.',
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'New password and confirm password are not same',
                    ], 400);
                }
            } else {
                return response()->json(['message' => 'The Current Password you have entered is not correct'], 400);
            }
        } else {
            return response()->json([
                'message' => 'Sorry !! We could not found this user in our system.',
            ], 400);
        }
    }

    public function changeEmailAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'email' => 'required|unique:master_users',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $new_email = $request->email;

        $chk_user =  MasterUser::find($request->user_id);
        if ($chk_user) {
            MasterUser::where('user_id', $request->user_id)->update(['email' => $new_email]);
            return response()->json([
                'message' => 'Email Changed Successfully.',
            ], 200);
        } else {
            return response()->json([
                'message' => 'User does not exist.',
            ], 400);
        }
    }


    // public function auto_parts_request(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|integer',
    //         'brands' => 'nullable|array',
    //         'categories' => 'nullable|array',
    //         'countries' => 'nullable|array',
    //     ]);

    //     $user_id = $request->user_id;
    //     $brands = $request->input('brands', []);
    //     $categories = $request->input('categories', []);
    //     $countries = $request->input('countries', []);

    //     // Delete existing subscriptions for the user
    //     SubscribeAlert::where('user_id', $user_id)->delete();

    //     // Save new subscriptions
    //     foreach ($brands as $brand) {
    //         SubscribeAlert::create([
    //             'user_id' => $user_id,
    //             'type' => 'brand_list',
    //             'value' => $brand,
    //         ]);
    //     }

    //     foreach ($categories as $category) {
    //         SubscribeAlert::create([
    //             'user_id' => $user_id,
    //             'type' => 'category',
    //             'value' => $category,
    //         ]);
    //     }

    //     foreach ($countries as $country) {
    //         SubscribeAlert::create([
    //             'user_id' => $user_id,
    //             'type' => 'country',
    //             'value' => $country,
    //         ]);
    //     }

    //     return response()->json(['message' => 'Subscribe Alert successfully submited'], 200);
    // }

    public function auto_parts_request(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer'
        ]);
        $request->all();


        $user_id = $request->user_id;
        // $brand_list = $request->input('brand_list', []) ?? [];
        $brand_list = is_array($request->brand_list) ? $request->brand_list : [$request->brand_list];
        // $categories = $request->input('categories', []) ?? [];
        $categories = is_array($request->categories) ? $request->categories : [$request->categories];

        // $countries = $request->input('countries', []) ?? [];
        $countries = is_array($request->countries) ? $request->countries : [$request->countries];

        // dd($countries);


        $data = SubscribeAlert::create([
            'user_id' => $user_id,
            'brand_list' => implode(",", $brand_list),
            'categories' => implode(",", $categories),
            'couties' => implode(",", $countries),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription alert saved successfully',
            'user' => $data,
        ]);
    }

    public function show_auto_parts_request(Request $request, $userid)
    {

        $alertres = SubscribeAlert::where('user_id', $userid)->first();

        if (!$alertres) {
            return response()->json(['message' => 'Subscription alert not found'], 404);
        }

        $brands = SalesBrand::whereIn('brand_id', explode(",", $alertres->brand_list))->pluck('brand_name')->toArray();
        $categories = SalesCategory::whereIn('category_id', explode(",", $alertres->categories))->pluck('category_name')->toArray();
        $countries = MasterCountry::whereIn('country_id', explode(",", $alertres->couties))->pluck('country_name')->toArray();

        $data = [
            'user_id' => $alertres->user_id,
            'brand_list' => $brands,
            'categories' => $categories,
            'countries' => $countries
        ];

        return response()->json(['data' => $data], 200);
    }
}
