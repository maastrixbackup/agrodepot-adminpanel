<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterUser;
use App\Models\RequestAccessory;
use App\Models\RequestImg;
use App\Models\RequestPart;
use App\Models\ParkQuestion;
use App\Models\SalesPark;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SalesParksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $userid)
    {
        // $userId =  $userid;
        $data = array();
        $truckParks = SalesPark::where('status', 1)
            ->where('add_type', 1)
            ->where('user_id', $userid)
            ->orderBy("park_id", "DESC")
            ->get();
        if (!empty($truckParks)) {
            foreach ($truckParks as $key => $value) {
                $data[$key]['park_id'] = $value->park_id;
                $data[$key]['slug'] = isset($value->slug) ? $value->slug : 'N/A';
                $data[$key]['park_name'] = isset($value->park_name) ? $value->park_name : 'N/A';
                $data[$key]['company_name'] = isset($value->comp_name) ? $value->comp_name : 'N/A';

                $filePath = public_path('files/company_logo/' . optional($value->SalesPark)->logo);

                if (file_exists($filePath) && $value->logo != "") {
                    $data[$key]['company_logo'] = asset('files/company_logo/' . $value->logo);
                } else {
                    $value['company_logo'] = asset('uploads/brand/noimage.jpg');
                    $data[$key]['company_logo'] = asset('uploads/brand/noimage.jpg');
                }
                $data[$key]['created'] = isset($value->created) ? date("F d, Y", strtotime($value->created)) : 'N/A';
            }
        }
        return response()->json($data);
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
            $reqAcc = new RequestAccessory();
            $reqAcc->request_id =  $parts->request_id;
            $reqAcc->name_piece =  $request->name_piece;
            $reqAcc->slug =  Str::slug($request->name_piece);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function questionRec(Request $req, $userid)
    {
        $user_id = $userid;
        $data = [];

        $questionRes = ParkQuestion::leftJoin('sales_parks', 'sales_parks.park_id', '=', 'park_question.park_id')
            ->where('park_question.status', 1)
            ->where('sales_parks.user_id', $user_id)
            ->where('park_question.parent', '<=', 0)
            ->orderByDesc('park_question.qid')
            ->get();

        if ($questionRes->isNotEmpty()) {
            foreach ($questionRes as $key => $val) {
                $data[$key]['question_id'] = $val->qid;
                $data[$key]['received_from'] = 'N/A';
                $data[$key]['park_guy'] = $val->park_type == 1 ? "Parcuri dezmembrări" : "Firme piese";
                $data[$key]['slug'] = 'N/A';
                $data[$key]['park_name'] = 'N/A';
                $data[$key]['message'] = isset($val->question) ? $val->question : 'N/A';
                $data[$key]['replied_to'] = 'N/A';
                $data[$key]['received_date'] = 'N/A';

                $u_name = MasterUser::where('user_id', $val->user_id)->first();
                if ($u_name) {
                    $data[$key]['received_from'] = $u_name->first_name . ' ' . $u_name->last_name;
                }

                $parkDetail = SalesPark::where('park_id', $val->park_id)->first();
                if ($parkDetail) {
                    $data[$key]['slug'] = $parkDetail->slug;
                    $data[$key]['park_name'] = $parkDetail->park_name;
                }

                if ($val->parent) {
                    $repliedDetail = ParkQuestion::where('qid', $val->parent)->first();
                    if ($repliedDetail) {
                        $data[$key]['replied_to'] = $repliedDetail->question;
                    }
                }

                $sentDate = date("d-m-Y", strtotime($val->created));
                $data[$key]['received_date'] = date("F d, Y", strtotime($sentDate));
            }
        }

        return response()->json($data);
    }

    public function sentQuestion(Request $req, $userid)
    {
        $user_id = $userid;
        $data = [];


        $Sentquestion = ParkQuestion::leftJoin('sales_parks', 'sales_parks.park_id', '=', 'park_question.park_id')
            ->where('park_question.status', 1)
            ->where('park_question.user_id', $user_id)
            ->orderBy('park_question.qid', 'desc')
            ->get();

        if ($Sentquestion->isNotEmpty()) {
            foreach ($Sentquestion as $key => $val) {
                $data[$key]['question_id'] = $val->qid;
                $data[$key]['sent'] = 'N/A';
                $data[$key]['park_guy'] = $val->park_type == 1 ? "Parcuri dezmembrări" : "Firme piese";
                $data[$key]['slug'] = 'N/A';
                $data[$key]['park_name'] = 'N/A';
                $data[$key]['message'] = isset($val->question) ? $val->question : 'N/A';
                $data[$key]['replied_to'] = 'N/A';
                $data[$key]['sent_date'] = 'N/A';

                $u_name = MasterUser::where('user_id', $val->user_id)->first();
                if ($u_name) {
                    $data[$key]['sent'] = $u_name->first_name . ' ' . $u_name->last_name;
                }

                $parkDetail = SalesPark::where('park_id', $val->park_id)->first();
                if ($parkDetail) {
                    $data[$key]['slug'] = $parkDetail->slug;
                    $data[$key]['park_name'] = $parkDetail->park_name;
                }

                if ($val->parent) {
                    $repliedDetail = ParkQuestion::where('qid', $val->parent)->first();
                    if ($repliedDetail) {
                        $data[$key]['replied_to'] = $repliedDetail->question;
                    }
                }

                $sentDate = date("d-m-Y", strtotime($val->created));
                $data[$key]['sent_date'] = date("F d, Y", strtotime($sentDate));
            }
        }

        return response()->json($data);
    }


    public function deleteTruckPark(Request $request)
    {
        $userId = $request->user_id;
        $parkid = $request->park_id;

        $salesPark = SalesPark::where('user_id', $userId)
            ->where('park_id', $parkid)
            ->first();

        if ($salesPark) {
            $salesPark->delete();
            return response()->json(['message' => 'Sales Park deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Sales Park not found'], 404);
        }
    }

    public function companyPiecesList(Request $request, $userid)
    {
        // $userId =  $userid;
        $data = array();
        $companypieces = SalesPark::where('status', 1)
            ->where('add_type', 2)
            ->where('user_id', $userid)
            ->orderBy("park_id", "DESC")
            ->get();
        if (!empty($companypieces)) {
            foreach ($companypieces as $key => $value) {
                $data[$key]['park_id'] = $value->park_id;
                $data[$key]['slug'] = isset($value->slug) ? $value->slug : 'N/A';
                $data[$key]['park_name'] = isset($value->park_name) ? $value->park_name : 'N/A';
                $data[$key]['company_name'] = isset($value->comp_name) ? $value->comp_name : 'N/A';

                $filePath = public_path('files/company_logo/' . optional($value->SalesPark)->logo);

                if (file_exists($filePath) && $value->logo != "") {
                    $data[$key]['company_logo'] = asset('files/company_logo/' . $value->logo);
                } else {
                    $value['company_logo'] = asset('uploads/brand/noimage.jpg');
                    $data[$key]['company_logo'] = asset('uploads/brand/noimage.jpg');
                }
                $data[$key]['created'] = isset($value->created) ? date("F d, Y", strtotime($value->created)) : 'N/A';
            }
        }
        return response()->json($data);
    }

    public function deleteCompanyPieces(Request $request)
    {
        $userId = $request->user_id;
        $parkid = $request->park_id;

        $salesPark = SalesPark::where('user_id', $userId)
            ->where('park_id', $parkid)
            ->first();

        if ($salesPark) {
            $salesPark->delete();
            return response()->json(['message' => 'Company Parts deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Company Parts not found'], 404);
        }
    }
}
