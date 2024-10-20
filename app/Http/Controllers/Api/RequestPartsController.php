<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterCountry;
use App\Models\MasterLocation;
use App\Models\MasterUser;
use App\Models\RequestAccessory;
use App\Models\RequestImg;
use App\Models\RequestPart;
use App\Models\RequestQuestion;
use App\Models\RequestquestionImage;
use App\Models\BidOffer;
use App\Models\BidQuestion;
use App\Models\Notice;
use App\Models\PartsOrder;
use App\Models\SalesAdvertisement;
use App\Models\SalesBrand;
use App\Models\SalesPark;
use App\Models\SalesQuestion;
use App\Models\UserRating;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RequestPartsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $pageno = $request->pageNo ?? 1;
    //     $postsPerPage = $request->postsPerPage ?? 10;
    //     $toSkip = (int)$postsPerPage * (int)$pageno - (int)$postsPerPage;
    //     $brand = $request->brand;
    //     $model = $request->model;
    //     $searchTxt = $request->searchTxt;
    //     $status = $request->status;
    //     $sort = $request->sort;
    //     $activeRequest = RequestPart::leftJoin('request_accessories', 'request_accessories.request_id', '=', 'request_parts.request_id')
    //         ->whereIn('request_accessories.status', [1, 2])
    //         ->whereIn('request_parts.status', [1, 2])
    //         ->select('request_parts.*', 'request_accessories.*')
    //         ->orderByDesc('request_parts.request_id');
    //     if ($brand) {
    //         $activeRequest->whereHas('brand', function ($query) use ($brand) {
    //             $query->where('brand_name', 'LIKE', '%' . $brand . '%');
    //         });
    //     }

    //     if ($model) {
    //         $activeRequest->whereHas('model', function ($query) use ($model) {
    //             $query->where('brand_name', 'LIKE', '%' . $model . '%');
    //         });
    //     }

    //     if ($searchTxt) {
    //         $activeRequest->where(function ($query) use ($searchTxt) {
    //             $query->where('request_parts.version', 'LIKE', '%' . $searchTxt . '%')
    //                 ->orWhere('request_parts.engines', 'LIKE', '%' . $searchTxt . '%')
    //                 ->orWhere('brand.brand_name', 'LIKE', '%' . $searchTxt . '%') // Filter by brand name
    //                 ->orWhere('model.brand_name', 'LIKE', '%' . $searchTxt . '%'); // Filter by model name
    //         });
    //     }
    //     if ($status !== null) {
    //         $activeRequest->where('request_parts.status', $status);
    //     }

    //     // Sorting
    //     if ($sort) {
    //         if ($sort === 'created_asc') {
    //             $activeRequest->orderBy('request_parts.created', 'asc');
    //         } elseif ($sort === 'created_desc') {
    //             $activeRequest->orderBy('request_parts.created', 'desc');
    //         }
    //     } else {
    //         $activeRequest->orderByDesc('request_parts.request_id');
    //     }
    //     $count = $activeRequest->count();
    //     $data = $activeRequest->skip($toSkip)->take($postsPerPage)
    //         ->get();
    //     foreach ($data as $key => $value) {
    //         $value['countryName'] = MasterCountry::find($value->county) ? MasterCountry::find($value->county)->country_name : "";
    //         $value['locationName'] = MasterLocation::find($value->city) ? MasterLocation::find($value->city)->location_name : "";
    //         // **
    //         $image = RequestImg::where("parts_id", $value->part_id)->first();
    //         $value['imageUrl'] = asset('uploads/brand/noimage.jpg');
    //         if ($image) {
    //             $filePath = public_path('uploads/requestpart/' . $image->img_path);

    //             if (file_exists($filePath) && $image->img_path != "")
    //                 $value['imageUrl'] = asset('uploads/requestpart/' . $image->img_path);
    //         }
    //         $value['brandName'] = SalesBrand::find($value->brand_id) ? SalesBrand::find($value->brand_id)->brand_name : "";
    //         $value['modelName'] = SalesBrand::find($value->model_id) ? SalesBrand::find($value->model_id)->brand_name : "";
    //         $date = Carbon::parse($value['created']);

    //         $value['createdDate'] = $date->format('Y-m-d');
    //     }
    //     return response()->json(["data" => $data, "count" => $count], 200);
    // }

    public function index(Request $request)
    {
        $pageno = $request->pageNo ?? 1;
        $postsPerPage = $request->postsPerPage ?? 10;
        $toSkip = (int)$postsPerPage * (int)$pageno - (int)$postsPerPage;
        $brand = $request->brand;
        $model = $request->model;
        $searchTxt = $request->searchTxt;
        $status = $request->status;
        $sort = $request->sort;
        $activeRequest = RequestPart::leftJoin('request_accessories', 'request_accessories.request_id', '=', 'request_parts.request_id')
            ->whereIn('request_accessories.status', [1, 2])
            ->whereIn('request_parts.status', [1, 2])
            ->select('request_parts.*', 'request_accessories.*')
            ->orderByDesc('request_parts.request_id');
        if ($brand) {
            $activeRequest->where(function ($query) use ($brand) {
                $query->where('brand_id', 'LIKE', '%' . $brand . '%');
            });
        }

        if ($model) {
            $activeRequest->where(function ($query) use ($model) {
                $query->where('model_id', 'LIKE', '%' . $model . '%');
            });
        }

        if ($searchTxt) {
            $activeRequest->where(function ($query) use ($searchTxt) {
                $query->where('request_accessories.name_piece', 'LIKE', '%' . $searchTxt . '%')
                    ->orWhere('request_accessories.description', 'LIKE', '%' . $searchTxt . '%');
            });
        }
        if ($status !== null) {
            $activeRequest->where('request_parts.status', $status);
        }

        // Sorting
        if ($sort) {
            if ($sort === 'created_asc') {
                $activeRequest->orderBy('request_parts.created', 'asc');
            } elseif ($sort === 'created_desc') {
                $activeRequest->orderBy('request_parts.created', 'desc');
            }
        } else {
            $activeRequest->orderByDesc('request_parts.request_id');
        }
        $count = $activeRequest->count();
        $data = $activeRequest->skip($toSkip)->take($postsPerPage)
            ->get();
        foreach ($data as $key => $value) {
            $value['countryName'] = MasterCountry::find($value->county) ? MasterCountry::find($value->county)->country_name : "";
            $value['locationName'] = MasterLocation::find($value->city) ? MasterLocation::find($value->city)->location_name : "";
            // **
            $image = RequestImg::where("parts_id", $value->part_id)->first();
            $value['imageUrl'] = asset('uploads/brand/noimage.jpg');
            if ($image) {
                $filePath = public_path('uploads/requestpart/' . $image->img_path);

                if (file_exists($filePath) && $image->img_path != "")
                    $value['imageUrl'] = asset('uploads/requestpart/' . $image->img_path);
            }
            $value['brandName'] = SalesBrand::find($value->brand_id) ? SalesBrand::find($value->brand_id)->brand_name : "";
            $value['modelName'] = SalesBrand::find($value->model_id) ? SalesBrand::find($value->model_id)->brand_name : "";
            $date = Carbon::parse($value['created']);

            $value['createdDate'] = $date->format('Y-m-d');
        }
        return response()->json(["data" => $data, "count" => $count], 200);
    }



    public function add_reply(Request $request)
    {
        $reply = new RequestQuestion();
        $reply->parent = $request->parent;
        $reply->user_id = $request->user_id;
        $reply->parts_id = $request->parts_id;
        $reply->description = $request->description;
        $reply->request_id = $request->request_id;
        $reply->save();
        return response()->json(["data" => $data], 200);
    }
    public function view_reply(Request $request, $qid)
    {
        $data = RequestQuestion::where("parent", $qid)->get();
        return response()->json(["data" => $data], 200);
    }
    public function requestPartsDetails($slug)
    {
        $reqAcc = RequestAccessory::where('slug', $slug)->leftJoin('request_parts', 'request_accessories.request_id', '=', 'request_parts.request_id')
            ->select('request_parts.*', 'request_accessories.*')->first();
        $reqAcc['countryName'] = MasterCountry::find($reqAcc->county) ? MasterCountry::find($reqAcc->county)->country_name : "";
        $reqAcc['locationName'] = MasterLocation::find($reqAcc->city) ? MasterLocation::find($reqAcc->city)->location_name : "";
        $images = RequestImg::where("parts_id", $reqAcc->request_id)->get();
        foreach ($images as $key => $value) {
            $value['imageUrl'] = asset('uploads/brand/noimage.jpg');
            $filePath = public_path('uploads/requestpart/' . $value->img_path);

            if (file_exists($filePath) && $value->img_path != "") {
                $value['imageUrl'] = asset('uploads/requestpart/' . $value->img_path);
                $value['image'] = asset('uploads/requestpart/' . $value->img_path);
            }
        }
        $reqAcc['brandName'] = SalesBrand::find($reqAcc->brand_id) ? SalesBrand::find($reqAcc->brand_id)->brand_name : "";
        $reqAcc['modelName'] = SalesBrand::find($reqAcc->model_id) ? SalesBrand::find($reqAcc->model_id)->brand_name : "";
        $reqAcc['user'] = MasterUser::find($reqAcc->user_id);
        $reqAcc['images'] = $images;
        $dateTime = Carbon::parse($reqAcc['user']->created);
        $diff = $dateTime->diffForHumans();
        $reqAcc['user']['timeDiff'] = $diff;
        return response()->json(["data" => $reqAcc], 200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function addQuestions(Request $req)
    {
        $requestQuestion = new RequestQuestion();
        $requestQuestion->parent = $req->parent;
        $requestQuestion->user_id = $req->user_id;

        $requestAccessory = RequestAccessory::where("request_id", $req->request_id)->first();
        if ($requestAccessory) {
            $requestQuestion->parts_id = $requestAccessory->part_id;
        } else {
            $requestQuestion->parts_id = null;
        }

        $requestQuestion->request_id = $req->request_id;
        $requestQuestion->description = $req->description;

        if ($requestQuestion->save()) {
            if ($req->hasFile('images')) {
                $images = $req->file('images');

                foreach ($images as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/requestquestion/'), $imageName);
                    $saleImage = new RequestquestionImage();
                    $saleImage->qid = $requestQuestion->question_id;
                    $saleImage->requestid = $req->request_id;
                    $saleImage->parts_id = $requestQuestion->parts_id;
                    $saleImage->img_file = $imageName;
                    $saleImage->save();
                }
            }
            return response()->json(['msg' => 'Request Parts Question Added Successfully']);
        } else {
            return response()->json(['msg' => 'Failed to add request parts question'], 500);
        }
    }

    public function offerStore(Request $req)
    {

        $bidOffer = new BidOffer();
        $bidOffer->user_id = $req->user_id;
        $bidOffer->request_id = $req->request_id;
        $bidOffer->um = $req->um;
        $bidOffer->offers = $req->offers;
        $bidOffer->availbility =  $req->availbility;
        $bidOffer->free_roman_mail = $req->free_roman_mail;
        $bidOffer->free_courier =  $req->free_courier;
        $bidOffer->time_required =  $req->time_required;
        $bidOffer->terms_of_delivery = $req->terms_of_delivery;
        $bidOffer->payment_method = $req->payment_method;
        $bidOffer->status = $req->status;
        $bidOffer->comment = $req->comment;
        $bidOffer->parts_id = $req->request_id;
        $bidOffer->piece = $req->piece;
        $bidOffer->currency = $req->currency;
        $bidOffer->warranty = $req->warranty;
        $bidOffer->courier = $req->courier;
        $bidOffer->personal_teaching = $req->personal_teaching;
        $bidOffer->courier_cost = $req->courier_cost;
        $bidOffer->roman_mail = $req->roman_mail;
        $bidOffer->validity = $req->validity;
        $bidOffer->price = $req->price;
        $bidOffer->created =  Carbon::parse($bidOffer->created)->format("d-m-Y");
        $bidOffer->modified = Carbon::parse($bidOffer->modified)->format("d-m-Y");

        if ($bidOffer->save()) {
            if ($req->hasFile('images')) {
                $images = $req->file('images');

                foreach ($images as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/requestpart/'), $imageName);
                    $bidImg = new RequestImg();
                    $bidImg->parts_id = $bidOffer->parts_id;
                    // $bidImg->requestid = $req->request_id;
                    // $bidImg->parts_id = $req->parts_id;
                    $bidImg->img_path = $imageName;
                    $bidImg->save();
                }
            }
        }

        return response()->json([
            "message" => "Bid offer successfully inserted",
            "data" => $bidOffer
        ], 200);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $parts = new RequestPart();

        $parts->brand_id = $request->brand_id;
        $parts->model_id = $request->model_id;
        $parts->want_song = $request->want_song;
        $parts->version =  $request->version;
        $parts->yr_of_manufacture = $request->yr_of_manufacture;
        $parts->engines =  $request->engines;
        $parts->vehicle_identy_no =  $request->vehicle_identy_no;
        $parts->county = $request->county;
        $parts->city = $request->city;
        $parts->user_id = $request->user_id;
        $parts->status = 1;
        $parts->save();

        if ($parts->save()) {
            // Create a notice record for the saved request part
            // $notice = new Notice();
            // $notice->notice_type = 'request-parts';
            // $notice->postid = $parts->request_id;
            // $notice->user_id = 0;
            // $notice->status = 0;
            // $notice->notice_name = 'Request Parts';
            // $notice->save();

            $notice = new Notice();
            $notice->notice_type = 'request-parts';
            $notice->postid = $parts->user_id;
            $notice->user_id = $request->input('user_id');
            $notice->status = 0;
            $notice->user_status = 0;
            $notice->notice_name = 'Request Parts';
            $notice->save();

            $reqAcc = new RequestAccessory();
            $reqAcc->request_id =  $parts->request_id;
            $reqAcc->name_piece =  $request->name_piece;
            // $reqAcc->slug =   Str::slug($request->name_piece);
            $baseSlug = Str::slug($request->name_piece);
            $slug1 = $baseSlug;
            $count = 1;
            while (RequestAccessory::where('slug', $slug1)->exists()) {
                $slug1 = $baseSlug . '-' . $count;
                $count++;
            }

            $reqAcc->slug = $slug1;
            $reqAcc->description =  $request->description;
            $reqAcc->status =  1;
            $reqAcc->save();

            if ($request->hasFile('images')) {
                $images = $request->file('images');

                foreach ($images as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/requestpart/'), $imageName);

                    $reqImage = new RequestImg();
                    $reqImage->parts_id = $parts->request_id;
                    $reqImage->img_path = $imageName;
                    $reqImage->save();
                }
            }
        }

        return response()->json([
            "message" => "Request parts successfully inserted",
            "data" => $parts
        ], 200);
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
        $reqAcc = RequestAccessory::where("request_id", $id)->first();
        $parts = RequestPart::find($reqAcc->request_id);

        $parts->brand_id = $request->brand_id;
        $parts->model_id = $request->model_id;
        $parts->want_song = $request->want_song;
        $parts->version =  $request->version;
        $parts->yr_of_manufacture = $request->yr_of_manufacture;
        $parts->engines =  $request->engines;
        $parts->vehicle_identy_no =  $request->vehicle_identy_no;
        $parts->county = $request->county;
        $parts->city = $request->city;
        $parts->user_id = $request->user_id;
        $parts->status = 1;
        $parts->save();

        if ($parts->save()) {
            // $reqAcc = new RequestAccessory();
            // $reqAcc->request_id =  $parts->request_id;
            $reqAcc->name_piece =  $request->name_piece;
            // $reqAcc->slug =   Str::slug($request->name_piece);
            // $baseSlug = Str::slug($request->name_piece);
            // $slug1 = $baseSlug;
            // $count = 1;
            // while (RequestAccessory::where('slug', $slug1)->exists()) {
            //     $slug1 = $baseSlug . '-' . $count;
            //     $count++;
            // }

            // $reqAcc->slug = $slug1;
            // Create a notice record for the saved request part
            $notice = new Notice();
            $notice->notice_type = 'request-modified';
            $notice->postid = $parts->request_id;
            $notice->user_id = $request->input('user_id');
            $notice->status = 0;
            $notice->user_status = 0;
            $notice->notice_name = 'Reaquest Modified';
            $notice->save();

            $reqAcc->description =  $request->description;
            $reqAcc->status =  1;
            $reqAcc->save();

            $image = [];
            $images = $request->images;
            foreach ($images as $key => $value) {
                if (is_array($value))
                    array_push($image, $value['img_id']);
            }


            $prv_img = RequestImg::where('parts_id', $parts->request_id)->whereNotIn('img_id', $image)->get();

            foreach ($prv_img as $prvimgDelete) {
                $imagePath = public_path('uploads/requestpart/') . $prvimgDelete->img_path;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $prvimgDelete->delete();
            }

            if ($request->hasFile('images')) {
                $images = $request->file('images');

                foreach ($images as $image) {
                    // dd(1);
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/requestpart/'), $imageName);

                    $reqImage = new RequestImg();
                    $reqImage->parts_id = $parts->request_id;
                    $reqImage->img_path = $imageName;
                    $reqImage->save();
                }
            }


            // return response()->json([
            //     'status' => 'successpp',
            //     'sale' =>  $prv_img,
            //     'message' => $slug ? 'Sales Advertisement updated successfully' : 'Sales Advertisement created successfully'
            // ]);

        }

        return response()->json([
            "message" => "Request parts successfully updated",
            "data" => $parts
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function recent_company_spare_parts(Request $request, $slug)
    {

        $parkdetail = SalesPark::where('slug', $slug)
            ->where('status', 1)
            ->first();
        $recentparts = [];
        if ($parkdetail) {
            $recentparts = SalesPark::where('add_type', $parkdetail->add_type)
                ->where('status', 1)
                ->where('park_id', '!=', $parkdetail->park_id)
                ->orderBy('park_id', 'desc')
                ->limit(3)
                ->get();

            $recentparts_data = [];
            if (!empty($recentparts)) {
                foreach ($recentparts as $key =>  $row) {
                    $park_name = stripslashes($row->park_name);
                    $logo = stripslashes($row->logo);
                    $comp_name = stripslashes($row->comp_name);
                    $slug = stripslashes($row->slug);
                    $description = (strlen($row->description) > 35) ? substr(stripslashes($row->description), 0, 35) . '...' : stripslashes($row->description);

                    if ($logo != '') {
                        if (file_exists('uploads/company_logo/95X56_' . $logo)) {
                            $logo_path = asset('uploads/company_logo/95X56_' . $logo);
                        } else {
                            $logo_path = asset('uploads/company_logo/' . $logo);
                        }
                    }
                    $recentparts_data[$key]['part_name'] =   $park_name;
                    $recentparts_data[$key]['description'] =   $description;
                    $recentparts_data[$key]['slug'] =   $slug;
                    $recentparts_data[$key]['company'] =   $comp_name;
                    $recentparts_data[$key]['image'] =   $logo_path;
                }
            }
        }
        return response()->json(['data' => $recentparts_data]);
    }

    public function askSeller(Request $req, $userid)
    {
        $user_id = $userid;
        $data = [];

        $bidQuestions = BidQuestion::where('status', 1)
            ->where('to_id', $user_id)
            ->orderBy('qid', 'desc')
            ->get();

        if ($bidQuestions->isNotEmpty()) {
            foreach ($bidQuestions as $key => $val) {
                $data[$key]['question_id'] = $val->qid;

                $partsDetail = RequestAccessory::where('part_id', $val->parts_id)->first();

                if (!empty($partsDetail)) {
                    $data[$key]['spare_parts'] = $partsDetail->name_piece;
                } else {
                    $data[$key]['spare_parts'] = 'N/A';
                }


                $user_details = MasterUser::where('user_id', $val->user_id)->first();

                if (!empty($user_details)) {
                    $data[$key]['submited_by'] = $user_details->first_name . ' ' . $user_details->last_name;
                } else {
                    $data[$key]['submited_by'] = 'N/A';
                }


                $parentdetail = BidQuestion::where('qid', $val->parent)->first();
                if (!empty($parentdetail)) {
                    $data[$key]['replied_to'] = nl2br($parentdetail->BidQuestion->description);
                } else {
                    $data[$key]['replied_to'] = "Parent";
                }

                $question = $val->BidQuestion;

                if (!empty($val->description)) {
                    $data[$key]['question'] = $val->description;
                } else {
                    $data[$key]['question'] = 'N/A';
                }

                if (!is_null($val->created)) {
                    $sentDate = date('d-m-Y', strtotime($val->created));
                    $data[$key]['date'] = $sentDate ? $sentDate : 'N/A';
                } else {
                    $data[$key]['date'] = 'N/A';
                }
            }
        }

        return response()->json($data);
    }

    public function askSellerSent(Request $req, $userid)
    {
        $user_id = $userid;
        $data = [];

        $bidQuestions = BidQuestion::where('status', 1)
            ->where('user_id', $user_id)
            ->orderBy('qid', 'desc')
            ->get();

        if ($bidQuestions->isNotEmpty()) {
            foreach ($bidQuestions as $key => $val) {
                $data[$key]['question_id'] = $val->qid;

                $partsDetail = RequestAccessory::where('part_id', $val->parts_id)->first();

                if (!empty($partsDetail)) {
                    $data[$key]['spare_parts'] = $partsDetail->name_piece;
                } else {
                    $data[$key]['spare_parts'] = 'N/A';
                }


                $user_details = MasterUser::where('user_id', $val->user_id)->first();

                if (!empty($user_details)) {
                    $data[$key]['send_to'] = $user_details->first_name . ' ' . $user_details->last_name;
                } else {
                    $data[$key]['send_to'] = 'N/A';
                }


                $parentdetail = BidQuestion::where('qid', $val->parent)->first();
                if (!empty($parentdetail)) {
                    $data[$key]['replied_to'] = nl2br($parentdetail->BidQuestion->description);
                } else {
                    $data[$key]['replied_to'] = "Parent";
                }

                $question = $val->BidQuestion;

                if (!empty($val->description)) {
                    $data[$key]['question'] = $val->description;
                } else {
                    $data[$key]['question'] = 'N/A';
                }

                if (!is_null($val->created)) {
                    $sentDate = date('d-m-Y', strtotime($val->created));
                    $data[$key]['date'] = $sentDate ? $sentDate : 'N/A';
                } else {
                    $data[$key]['date'] = 'N/A';
                }
            }
        }

        return response()->json($data);
    }

    public function myQuestionReply(Request $req, $question_id)
    {
        $questionId = $question_id;
        $data = [];

        $salesQuestions = SalesQuestion::where('parent', $questionId)
            ->orderBy('question_id', 'desc')
            ->get();

        if ($salesQuestions->isNotEmpty()) {
            foreach ($salesQuestions as $key => $val) {
                $data[$key]['question_id'] = $val->question_id;

                $advDetail = SalesAdvertisement::where('adv_id', $val->adv_id)->first();

                if (!empty($advDetail)) {
                    $data[$key]['opinion'] = $advDetail->adv_name;
                    $data[$key]['slug'] = $advDetail->slug;
                } else {
                    $data[$key]['opinion'] = 'N/A';
                    $data[$key]['slug'] = 'N/A';
                }

                // Count number of questions for this $question_id
                $questionCount = SalesQuestion::where('parent', $questionId)->count();
                $data[$key]['no_items'] = $questionCount;


                $user_details = MasterUser::where('user_id', $val->user_id)->first();

                if (!empty($user_details)) {
                    $data[$key]['sales_clerk'] = $user_details->first_name . ' ' . $user_details->last_name;
                } else {
                    $data[$key]['sales_clerk'] = 'N/A';
                }


                // $user_rating_sum = UserRating::where('user_id', $val->user_id)->where('grade', 1)->sum('grade');
                // $data[$key]['rating'] = $user_rating_sum ?? 0;

                $total_rating = UserRating::where('user_id', $val->user_id)->count();
                $total_grade_sum = UserRating::where('user_id', $val->user_id)->where('grade', 1)->sum('grade');

                if ($total_rating > 0) {
                    $average_rating_percentage = ($total_grade_sum / $total_rating) * 100;
                } else {
                    $average_rating_percentage = 0;
                }

                $data[$key]['average_rating_percentage'] = $average_rating_percentage;


                // $question = $val->BidQuestion;

                if (!empty($val->question)) {
                    $data[$key]['question'] = $val->question;
                } else {
                    $data[$key]['question'] = 'N/A';
                }

                if (!is_null($val->created)) {
                    $sentDate = date('d-m-Y', strtotime($val->created));
                    $data[$key]['date'] = $sentDate ? $sentDate : 'N/A';
                } else {
                    $data[$key]['date'] = 'N/A';
                }
            }
        }

        return response()->json($data);
    }

    public function requestQuestion(Request $req, $userid)
    {
        $data = [];

        $requestQuestions = RequestQuestion::leftJoin('request_parts', 'request_parts.request_id', '=', 'request_question.request_id')
            ->where('request_parts.user_id', $userid)
            ->where('request_question.parent', 0)
            ->orderByDesc('request_question.question_id')
            ->get();

        // dd($requestQuestions);

        if ($requestQuestions->isNotEmpty()) {
            foreach ($requestQuestions as $key => $val) {
                $data[$key]['question_id'] = $val->question_id;

                $partsdetail = RequestAccessory::where('part_id', $val->request_id)->first();

                if ($partsdetail) { // Check if $partsdetail is set
                    $data[$key]['spare_parts'] = $partsdetail->name_piece;
                } else {
                    $data[$key]['spare_parts'] = 'N/A';
                }

                if (!empty($val->description)) {
                    $data[$key]['question'] = $val->description;
                } else {
                    $data[$key]['question'] = 'N/A';
                }
            }
        }

        return response()->json($data);
    }

    public function deleteRequestQuestion(Request $request)
    {
        $userId = $request->user_id;
        $questionId = $request->question_id;

        $requestQuestion = RequestQuestion::where('question_id', $questionId)->first();

        if ($requestQuestion) {
            $requestQuestion->delete();

            $childQuestions = RequestQuestion::where('parent', $questionId)->get();
            foreach ($childQuestions as $childQuestion) {
                $childQuestion->delete();
            }

            return response()->json(['message' => 'Request Question deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Request Question not found'], 404);
        }
    }

    public function offerMyRequest(Request $req, $userid)
    {
        $data = [];

        $bidOffers = BidOffer::leftJoin('request_parts', 'request_parts.request_id', '=', 'bid_offers.request_id')
            ->where('request_parts.user_id', $userid)
            ->orderByDesc('bid_offers.bid_id')
            ->get();

        if ($bidOffers->isNotEmpty()) {
            foreach ($bidOffers as $key => $val) {
                $data[$key]['bid_id'] = $val->bid_id;

                $partsdetail = RequestAccessory::where('part_id', $val->request_id)->first();

                if ($partsdetail) { // Check if $partsdetail is set
                    $data[$key]['spare_parts_request'] = $partsdetail->name_piece;
                } else {
                    $data[$key]['spare_parts_request'] = 'N/A';
                }

                $data[$key]['name_of_piece'] = $val->piece;

                $conditionsOffer = [
                    'new' => 'Noua',
                    'New' => 'Noua',
                    'used' => 'din dezmembran',
                    'Used' => 'din dezmembran'
                ];

                $data[$key]['you_want_the_song'] = isset($conditionsOffer[$val->offers]) ? $conditionsOffer[$val->offers] : 'N/A';

                $data[$key]['price'] = $val->price;

                $data[$key]['currency'] = $val->currency;

                if ($val->warranty == 'We do not offer warranty') {
                    $data[$key]['guarantee'] = 'Noi nu oferim garanție';
                } else if ($val->warranty == 'Ofer warranty') {
                    $data[$key]['guarantee'] = 'oferta de garanție';
                }

                $data[$key]['validity'] = $val->validity;

                $statuses = [0 => 'aprobata', 1 => 'castigatoare', 2 => 'anula'];
                $data[$key]['status'] = isset($statuses[$val->status]) ? $statuses[$val->status] : 'Unknown';
            }
        }

        return response()->json($data);
    }

    public function supplyDemand(Request $request)
    {
        $data = [];

        $request->validate([
            'user_id' => 'required'
        ]);

        $userid = $request->user_id;
        $status = $request->status;

        if (!empty($status) && ($status == 0 || $status == 2)) {
            $andwhr = [
                ['request_parts.user_id', '=', $request->user_id],
                ['bid_offers.status', '=', $status],
                ['request_accessories.status', 2],
                ['request_parts.status', 1]
            ];
        } elseif (!empty($status) && ($status == 1 || $status == 2)) {
            $andwhr = [
                ['request_parts.user_id', '=', $request->user_id],
                ['bid_offers.status', '=', $status],
                ['request_parts.status', 1]
            ];
        } else {
            $andwhr = [
                ['request_parts.user_id', '=', $request->user_id]
            ];
        }

        $requestParts = RequestPart::select('request_parts.*', 'request_accessories.*', 'bid_offers.*')
            ->join('request_accessories', 'request_accessories.request_id', '=', 'request_parts.request_id')
            ->join('bid_offers', 'bid_offers.parts_id', '=', 'request_accessories.part_id')
            ->where($andwhr)
            ->orderByDesc('request_parts.created')
            ->get();


        if ($requestParts->isNotEmpty()) {
            foreach ($requestParts as $key => $val) {
                $data[$key]['request_id'] = $val->request_id;

                $user_details = MasterUser::where('user_id', $val->user_id)->first();

                if (!empty($user_details)) {
                    $data[$key]['offer_via'] = $user_details->first_name . ' ' . $user_details->last_name;
                } else {
                    $data[$key]['offer_via'] = 'N/A';
                }

                $data[$key]['demand_slug'] = $val->slug;

                $brand = SalesBrand::where('brand_id', $val->brand_id)->first(['brand_name']);

                $data[$key]['brand_name'] = $brand ? $brand->brand_name : 'N/A';

                $sub_brands = SalesBrand::where('flag', $val->model_id)->pluck('brand_name', 'brand_id')->toArray();

                $data[$key]['model_name'] = array_key_exists($val->model_id, $sub_brands) ? $sub_brands[$val->model_id] : 'N/A';

                $data[$key]['offer_name'] = $val->piece;
                $data[$key]['price_offer'] = $val->price;
                $data[$key]['want_the_song'] = $val->offers;
                $data[$key]['guarantee'] = $val->warranty;

                $date = $val->created_at ? $val->created_at->format("F d, Y") : 'N/A';
                $data[$key]['date'] = $date;
            }
        }

        return response()->json($data);
    }
    public function deleteRequestPart(Request $request)
    {
        $reqPart = RequestPart::find($request->reqId);
        try {
            if ($reqPart) {
                $reqAcc =  RequestAccessory::where("request_id", $reqPart->request_id)->first();
                if ($reqAcc) {
                    $images = RequestImg::where("parts_id", $reqAcc->request_id)->get();
                    foreach ($images as $key => $value) {
                        $filePath = public_path('uploads/requestpart/' . $value->img_path);
                        if (file_exists($filePath))
                            unlink($filePath);
                        $value->delete();
                    }
                }
                $reqAcc->delete();
                $reqPart->delete();
                return response()->json(['message' => 'Request Part deleted succesfully'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => 'There was some error,please try again later'], 404);
        }
    }

    public function questionsList($request_id)
    {
        $questions = RequestQuestion::where('request_id', $request_id)->get();

        $data = [];

        if ($questions) {
            foreach ($questions as $key => $val) {
                $data[$key]['request_id'] = $val->request_id;

                $user_details = MasterUser::where('user_id', $val->user_id)->first();
                $country_details = MasterCountry::where('country_id', $user_details->country_id)->first();
                $location_details = MasterLocation::where('location_id', $user_details->locality_id)->first();
                $requestquestionimages = RequestquestionImage::where('qid', $val->question_id)->get();

                if (!empty($user_details)) {
                    $data[$key]['userName'] = $user_details->first_name . ' ' . $user_details->last_name;
                } else {
                    $data[$key]['userName'] = 'N/A';
                }

                if (!empty($country_details)) {
                    $data[$key]['country'] = $country_details->country_name;
                } else {
                    $data[$key]['country'] = 'N/A';
                }

                if (!empty($location_details)) {
                    $data[$key]['location'] = $location_details->location_name;
                } else {
                    $data[$key]['location'] = 'N/A';
                }

                $images = [];
                foreach ($requestquestionimages as $image) {
                    $images[] = asset('uploads/requestquestion/' . $image->img_file);
                }
                $replies = RequestQuestion::where('parent', $val->question_id)->get();
                foreach ($replies as $key => $value1) {
                    $user = MasterUser::where('user_id', $value1->user_id)->first();
                    $value1['userName'] = $user->first_name . " " . $user->last_name;
                }

                $data[$key]['replies'] = $replies;
                $data[$key]['images'] = $images;
                $data[$key]['question'] = $val->description;
            }
        }

        return response()->json(["questions" => $data]);
    }

    public function partsOrder(Request $req, $userid)
    {
        $data = [];

        $partsOrders = PartsOrder::where('user_id', $userid)->orderBy('id', 'desc')->get();

        if ($partsOrders->isNotEmpty()) {
            foreach ($partsOrders as $key => $val) {
                $data[$key]['orderid'] = $val->orderid;

                $partsdetail = RequestAccessory::where('part_id', $val->request_id)->first();

                if ($partsdetail) { // Check if $partsdetail is set
                    $data[$key]['demand_parts'] = $partsdetail->name_piece;
                } else {
                    $data[$key]['demand_parts'] = 'N/A';
                }

                $bidDetail = BidOffer::where('bid_id', $partsdetail->bid_id)->first();
                $user_details = MasterUser::where('user_id', $bidDetail->user_id)->first();

                $data[$key]['bidder'] = $user_details->first_name . ' ' . $user_details->last_name;

                $data[$key]['price'] = $val->totprice . ' ' . $bidDetail->currency;

                $data[$key]['telephone'] = $val->phone;

                if ($val->status == '0') {
                    $data[$key]['status'] = 'Confirmed Order';
                }

                $data[$key]['order_from_date'] = date("d-m-Y", strtotime($val->created));
            }
        }

        return response()->json($data);
    }

    public function offerLosing(Request $req, $userid)
    {
        $data = [];

        $offerloosing = DB::table('request_parts')
            ->leftJoin('request_accessories', 'request_accessories.request_id', '=', 'request_parts.request_id')
            ->leftJoin('bid_offers', 'bid_offers.parts_id', '=', 'request_accessories.part_id')
            ->where([
                ['request_accessories.status', '=', 2],
                ['request_parts.status', '=', 1],
                ['request_parts.user_id', '=', $userid]
            ])
            ->whereIn('bid_offers.status', [0, 2])
            ->select('request_parts.*', 'request_accessories.*', 'bid_offers.*')
            ->orderByDesc('request_parts.request_id')
            ->get();

        if ($offerloosing->isNotEmpty()) {
            foreach ($offerloosing as $key => $val) {

                $user_details = MasterUser::where('user_id', $val->user_id)->first();

                $data[$key]['bid_by'] = $user_details->first_name . ' ' . $user_details->last_name;

                $partsdetail = RequestAccessory::where('part_id', $val->request_id)->first();

                if ($partsdetail) { // Check if $partsdetail is set
                    $data[$key]['demand'] = $partsdetail->name_piece;
                } else {
                    $data[$key]['demand'] = 'N/A';
                }

                $brand = SalesBrand::where('brand_id', $val->brand_id)->first(['brand_name']);
                $model = SalesBrand::where('flag', $val->model_id)->first(['brand_name']);

                $data[$key]['brand_name'] = $brand;
                $data[$key]['model_name'] = $model;

                $bidDetail = BidOffer::where('bid_id', $val->bid_id)->first();
                // $user_details = MasterUser::where('user_id', $bidDetail->user_id)->first();

                $data[$key]['we_offer'] = $bidDetail->piece;

                $data[$key]['price_offer'] = $bidDetail->price . ' ' . $bidDetail->currency;

                $data[$key]['you_want_the_song'] = $bidDetail->offers;

                $data[$key]['Guarantee'] = $bidDetail->warranty . ' (' . $bidDetail->validity . ')';

                $created = stripslashes($val->created);

                $data[$key]['date'] = date("F d, Y", strtotime($created));
            }
        }

        return response()->json($data);
    }

    public function offerActive(Request $req, $userid)
    {
        $data = [];

        $offeractive = DB::table('request_parts')
            ->leftJoin('request_accessories', 'request_accessories.request_id', '=', 'request_parts.request_id')
            ->leftJoin('bid_offers', 'bid_offers.parts_id', '=', 'request_accessories.part_id')
            ->where([
                ['request_accessories.status', '=', 1],
                ['request_parts.status', '=', 1],
                ['bid_offers.status', '=', 0],
                ['request_parts.user_id', '=', $userid]
            ])
            ->select('request_parts.*', 'request_accessories.*', 'bid_offers.*')
            ->orderBy('request_parts.request_id', 'desc')
            ->get();

        if ($offeractive->isNotEmpty()) {
            foreach ($offeractive as $key => $val) {

                $user_details = MasterUser::where('user_id', $val->user_id)->first();

                $data[$key]['bid_by'] = $user_details->first_name . ' ' . $user_details->last_name;

                $partsdetail = RequestAccessory::where('part_id', $val->request_id)->first();

                if ($partsdetail) { // Check if $partsdetail is set
                    $data[$key]['demand'] = $partsdetail->name_piece;
                } else {
                    $data[$key]['demand'] = 'N/A';
                }

                $brand = SalesBrand::where('brand_id', $val->brand_id)->first(['brand_name']);
                $model = SalesBrand::where('flag', $val->model_id)->first(['brand_name']);

                $data[$key]['brand_name'] = $brand;
                $data[$key]['model_name'] = $model;

                $bidDetail = BidOffer::where('bid_id', $val->bid_id)->first();
                // $user_details = MasterUser::where('user_id', $bidDetail->user_id)->first();

                $data[$key]['we_offer'] = $bidDetail->piece;

                $data[$key]['price_offer'] = $bidDetail->price . ' ' . $bidDetail->currency;

                $data[$key]['you_want_the_song'] = $bidDetail->offers;

                $data[$key]['Guarantee'] = $bidDetail->warranty . ' (' . $bidDetail->validity . ')';

                $created = stripslashes($val->created);

                $data[$key]['date'] = date("F d, Y", strtotime($created));
            }
        }

        return response()->json($data);
    }

    public function offerInActive(Request $req, $userid)
    {
        $data = [];

        $offerinactive = RequestPart::select('request_parts.*', 'request_accessories.*', 'bid_offers.*')
            ->leftJoin('request_accessories', 'request_accessories.request_id', '=', 'request_parts.request_id')
            ->leftJoin('bid_offers', 'bid_offers.parts_id', '=', 'request_accessories.part_id')
            ->where('request_accessories.status', 1)
            ->where('request_parts.status', 1)
            ->where('bid_offers.status', 2)
            ->where('request_parts.user_id', $userid)
            ->orderBy('request_parts.request_id', 'desc')
            ->paginate();

        if ($offerinactive->isNotEmpty()) {
            foreach ($offerinactive as $key => $val) {

                $user_details = MasterUser::where('user_id', $val->user_id)->first();

                $data[$key]['bid_by'] = $user_details->first_name . ' ' . $user_details->last_name;

                $partsdetail = RequestAccessory::where('part_id', $val->request_id)->first();

                if ($partsdetail) { // Check if $partsdetail is set
                    $data[$key]['demand'] = $partsdetail->name_piece;
                } else {
                    $data[$key]['demand'] = 'N/A';
                }

                $brand = SalesBrand::where('brand_id', $val->brand_id)->first(['brand_name']);
                $model = SalesBrand::where('flag', $val->model_id)->first(['brand_name']);

                $data[$key]['brand_name'] = $brand;
                $data[$key]['model_name'] = $model;

                $bidDetail = BidOffer::where('bid_id', $val->bid_id)->first();
                // $user_details = MasterUser::where('user_id', $bidDetail->user_id)->first();

                $data[$key]['we_offer'] = $bidDetail->piece;

                $data[$key]['price_offer'] = $bidDetail->price . ' ' . $bidDetail->currency;

                $data[$key]['you_want_the_song'] = $bidDetail->offers;

                $data[$key]['Guarantee'] = $bidDetail->warranty . ' (' . $bidDetail->validity . ')';

                $created = stripslashes($val->created);

                $data[$key]['date'] = date("F d, Y", strtotime($created));
            }
        }

        return response()->json($data);
    }
}
