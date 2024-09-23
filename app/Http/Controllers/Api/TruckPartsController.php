<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterUser;
use App\Models\ParkQuestion;
use Illuminate\Http\Request;
use App\Models\SalesPark;
use App\Models\MasterCountry;
use  App\Models\MasterLocation;
use App\Models\SalesBrand;
use App\Models\ParkImg;
use App\Models\ParksquestionImage;

class TruckPartsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index1()
    {
        $truckRes = SalesPark::where('add_type', 1)->where('status', 1)->orderBy('park_id', 'desc')->get();
        $results = [];
        if (!empty($truckRes)) {
            foreach ($truckRes as $truckResult) {
                $user_id = $truckResult->user_id;
                $park_name = $truckResult->park_name;
                $description = (strlen($truckResult->description) > 105) ? substr($truckResult->description, 0, 105) . '...' : $truckResult->description;
                $brand_id = $truckResult->brand_id;
                $comp_name = $truckResult->comp_name;
                $logo = $truckResult->logo;
                $country_id = $truckResult->country_id;
                $masterCountry = MasterCountry::where('country_id', $country_id)->first();
                if (!empty($masterCountry)) {
                    $country_name = $masterCountry->country_name;
                }
                $location_id = $truckResult->location_id;
                $masterLocation = MasterLocation::where('location_id', $location_id)->first();
                if (!empty($masterLocation)) {
                    $location_name = $masterLocation->location_name;
                }
                $vat = $truckResult->vat;
                //  $totpostad = $this->custom->dezPostAdsCount('user_id', $user_id); // Replace $this->custom with appropriate reference
                // $totrequestparts = $this->custom->dezRequestPartCount('user_id', $user_id); // Replace $this->custom with appropriate reference
                $brandname = '';

                if ($brand_id != '') {
                    $brandarr = explode(',', $brand_id);
                    foreach ($brandarr as $singbid) {
                        $salesBrand = SalesBrand::where('brand_id', $singbid)->first();

                        if ($salesBrand) {
                            $brandname .=  $salesBrand->brand_name;
                        }
                    }
                }
                $slug = $truckResult->slug;
                //$memdetail = $this->custom->BapCustUniMembership($user_id); // Replace $this->custom with appropriate reference
                $parkUrl = url('pages/parks/' . $slug); // Generate park URL using Laravel's url() helper
                $logo_path = asset('files/company_logo/' . ($truckResult->logo_exists ? '133X100_' : '') . $logo); // Check if logo exists and generate logo path accordingly

                $results[] = [
                    'user_id' => $user_id,
                    'park_name' => $park_name,
                    'description' => $description,
                    'comp_name' => $comp_name,
                    'countryname' => $country_name,
                    'locationname' => $location_name,
                    'vat' => $vat,
                    //'totpostad' => $totpostad,
                    //'totrequestparts' => $totrequestparts,
                    'brandname' => $brandname,
                    'slug' => $slug,
                    //'memdetail' => $memdetail,
                    'parkUrl' => $parkUrl,
                    'logo_path' => $logo_path
                ];
            }

            return response()->json(["data" => $results], 200);
        }
    }
    public function addParkQuestion(Request $request)
    {
        $userId= $request->user_id;
        $park_id= $request->park_id;
        $park_type= $request->park_type;
        $question= $request->message;
        $parent= $request->parent;
        $parkQues = new ParkQuestion();
        $parkQues->user_id = $userId;
        $parkQues->park_id = $park_id;
        $parkQues->park_type = $park_type;
        $parkQues->question = $question;
        $parkQues->parent = $parent;
        $parkQues->status = 1;
        $parkQues->save();
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {

                $imageName = time() . '_' . $image->getClientOriginalName();


                $image->move(public_path('uploads/parkquestion/'), $imageName);
                $saleImage = new ParksquestionImage();
                $saleImage->qid = $parkQues->qid ;
                $saleImage->postid = $parkQues->park_id;
                $saleImage->img_file = $imageName;
                $saleImage->save();
            }
        }
        return response()->json([
            'status' => 'success',
            'message' =>'Request question submitted'
        ]);
    }
    public function questionsList($adv_id)
    {
        //
        $question = ParkQuestion::where('park_id', $adv_id)->where("parent", 0)->get();
        if ($question) {
            foreach ($question as $key => $value) {
                $questionImages = ParksquestionImage::where('qid', $value->qid)->get();
                // $replies = SalesQuestion::where('parent', $value->question_id)->get();
                // foreach ($replies as $key => $value1) {
                //     $user = MasterUser::where('user_id', $value1->user_id)->first();
                //     $value1['userName'] = $user->first_name . " " . $user->last_name;
                // }
                $user = MasterUser::where('user_id', $value->user_id)->first();
                foreach ($questionImages as $key => $value2) {
                    $filePath = public_path('uploads/parkquestion/' . $value2->img_file);
                    if (file_exists($filePath) && $value2->img_file != "") {
                        $value2['img_file'] = asset('uploads/parkquestion/' . $value2->img_file);
                    }
                }
                $value['images'] = $questionImages;
                $value['userName'] = $user->first_name . " " . $user->last_name;
                // $value['replies'] = $replies;
            }
        }
        return response()->json(['questions' => $question], 200);
    }

    public function index()
    {
        $companyParks = SalesPark::where("status", 1)->where("add_type", 1)->orderBy("park_id", "DESC")->get();
        if (!empty($companyParks)) {
            foreach ($companyParks as $key => $value) {
                $filePath = public_path('uploads/company_logo/' . $value->logo);

                if (file_exists($filePath) && $value->logo != "") {
                    $value['imageUrl'] = asset('uploads/company_logo/' . $value->logo);
                } else {
                    $value['imageUrl'] = asset('uploads/brand/noimage.jpg');
                }
                $brandIds = explode(",", $value->brand_id);
                $brands = SalesBrand::whereIn("brand_id", $brandIds)->select("brand_name")->get();
                $value['brands'] = $brands;
            }
        }
        return response()->json($companyParks);
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
    public function show(string $slug)
    {
        //
        $companyParks = SalesPark::where("slug", $slug)->first();
        $companyParks = [];
        if (!empty($companyParks)) {
            $parkImages = ParkImg::where("park_id", $companyParks->park_id)->get();
            foreach ($parkImages as $key => $value1) {
                $filePath = public_path('uploads/parkimg/' . $value1->img_path);

                if (file_exists($filePath) && $value1->img_path != "") {
                    $value1['imageUrl'] = asset('uploads/parkimg/' . $value1->img_path);
                } else {
                    $value1['imageUrl'] = asset('uploads/brand/noimage.jpg');
                }
            }
            $companyParks["parkImages"] = $parkImages;
        }


        return response()->json($companyParks);
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
