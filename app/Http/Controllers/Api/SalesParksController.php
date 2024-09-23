<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterUser;
use App\Models\ParkImg;
use App\Models\RequestAccessory;
use App\Models\RequestImg;
use App\Models\RequestPart;
use App\Models\ParkQuestion;
use App\Models\SalesPark;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        // Validate the incoming request data
        $validatedData = $request->validate([
            'park_name' => 'required|string',
            'comp_name' => 'required|string',
            'vat' => 'required|string',
            'country_id' => 'required|integer',
            'location_id' => 'required|string',
            'postal_code' => 'required|string',
            'street' => 'required|string',
            'nr' => 'required|string',
            'other_add' => 'nullable|string',
            'phone' => 'nullable|string',
            'fax' => 'nullable|string',
            'email' => 'nullable|email',
            'description' => 'nullable|string',
            'warranty_detail' => 'nullable|string',
            'brand_id' => 'required|array', // Change to array since you're expecting multiple brand_ids
            'brand_id.*' => 'required|integer', // Validate each brand_id as integer
            'contact_person' => 'nullable|string',
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // adjust max size as needed
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // for multiple images
        ]);

        // Create a SalesPark object
        $objsalespark = new SalesPark();

        $objsalespark->fill($validatedData);

        // Convert brand_ids array to a comma-separated string
        $brandIdsString = implode(',', $validatedData['brand_id']);
        // Set the brand_ids field as a comma-separated string
        $objsalespark->brand_id = $brandIdsString;

        $objsalespark->add_type = 2;
        $objsalespark->user_id = $request->user_id;
        $objsalespark->slug = Str::slug($validatedData['park_name']);
        $objsalespark->status = 1;
        $objsalespark->created = Carbon::now();
        $objsalespark->modified = Carbon::now();

        if ($request->hasFile('logo')) {
            $logoImage = $request->file('logo');
            $logoImageName = time() . '_' . $logoImage->getClientOriginalName();
            $logoImage->move(public_path('files/company_logo'), $logoImageName);
            $objsalespark->logo = $logoImageName;
        }

        $objsalespark->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('files/parkimg'), $imageName);
                $imagePaths[] = $imageName;

                $parkImg = new ParkImg();
                $parkImg->park_id = $objsalespark->park_id;
                $parkImg->img_path = $imageName;
                $parkImg->save();
            }
        }

        $responseData = [
            "message" => "Sales parts successfully Added",
            "data" => $objsalespark
        ];

        return response()->json($responseData, 200);
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
    public function edit(Request $request, $id)
    {
        $salesPark = SalesPark::find($id);

        if (!$salesPark) {
            return response()->json([
                "message" => "Sales Park not found"
            ], 404);
        }

        $formattedData = [
            'park_name' => $salesPark->park_name,
            'comp_name' => $salesPark->comp_name,
            'vat' => $salesPark->vat,
            'country_id' => $salesPark->country_id,
            'location_id' => $salesPark->location_id,
            'postal_code' => $salesPark->postal_code,
            'street' => $salesPark->street,
            'nr' => $salesPark->nr,
            'other_add' => $salesPark->other_add,
            'phone' => $salesPark->phone,
            'fax' => $salesPark->fax,
            'email' => $salesPark->email,
            'description' => $salesPark->description,
            'warranty_detail' => $salesPark->warranty_detail,
            'brand_id' => explode(',', $salesPark->brand_id), // Convert comma-separated string back to array
            'contact_person' => $salesPark->contact_person,
            'logo' => $salesPark->logo ? asset('files/company_logo/' . $salesPark->logo) : null,
            'images' => [], // Initialize empty array for images
            // Add other fields as needed
        ];

        // Fetch images associated with the sales park
        $parkImages = ParkImg::where('park_id', $id)->get();

        foreach ($parkImages as $parkImage) {
            $imagePath = public_path('files/parkimg/' . $parkImage->img_path);
            if (file_exists($imagePath) && $parkImage->img_path != "") {
                // Construct the image array with imgid, img_path, and image URL
                $formattedImage = [
                    'img_id' => $parkImage->img_id,
                    'img_path' => $parkImage->img_path,
                    'image' => asset('files/parkimg/' . $parkImage->img_path)
                ];
                // Add the image array to the images array in formattedData
                $formattedData['images'][] = $formattedImage;
            } else {
                // If image not found, add placeholder image URL
                $formattedData['images'][] = [
                    'img_id' => null,
                    'img_path' => null,
                    'image' => asset('files/parkimg/noimage.jpg')
                ];
            }
        }

        return response()->json([
            "message" => "Sales Park found",
            "data" => $formattedData
        ], 200);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->park_id;
        // Find the SalesPark instance by ID
        $salesPark = SalesPark::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'park_id' => 'required|integer',
            'park_name' => 'required|string',
            'comp_name' => 'required|string',
            'vat' => 'required|string',
            'country_id' => 'required|integer',
            'location_id' => 'required|string',
            'postal_code' => 'required|string',
            'street' => 'required|string',
            'nr' => 'required|string',
            'other_add' => 'nullable|string',
            'phone' => 'nullable|string',
            'fax' => 'nullable|string',
            'email' => 'nullable|email',
            'description' => 'nullable|string',
            'warranty_detail' => 'nullable|string',
            'brand_id' => 'required|array', // Change to array since you're expecting multiple brand_ids
            'brand_id.*' => 'required|integer', // Validate each brand_id as integer
            'contact_person' => 'nullable|string',
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // adjust max size as needed
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // for multiple images
        ]);

        // Update the SalesPark instance with validated data
        $salesPark->fill($validatedData);

        // Convert brand_ids array to a comma-separated string
        $brandIdsString = implode(',', $validatedData['brand_id']);
        // Set the brand_ids field as a comma-separated string
        $salesPark->brand_id = $brandIdsString;

        // Set additional fields
        $salesPark->slug = Str::slug($validatedData['park_name']);
        $salesPark->modified = Carbon::now();

        // Process the logo file if present
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');

            // Generate a unique file name
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Move the uploaded image to the storage directory
            $image->move(public_path('files/company_logo'), $imageName);

            // Assign the image name to the SalesPark instance
            $salesPark->logo = $imageName;
        }

        // Update existing images and add new ones
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('files/parkimg'), $imageName);

                // Create a new ParkImg instance
                $parkImg = new ParkImg();
                $parkImg->park_id = $salesPark->park_id;
                $parkImg->img_path = $imageName;
                $parkImg->save();
            }
        }

        // Delete images that are not included in the update request
        if ($request->has('images')) {
            $imageIds = [];
            $images = $request->images;
            foreach ($images as $key => $value) {
                if (is_array($value))
                    array_push($imageIds, $value['img_id']);
            }

            // Get images associated with the park
            $prvImages = ParkImg::where('park_id', $id)->whereNotIn('img_id', $imageIds)->get();

            // Delete the associated images
            foreach ($prvImages as $prvImage) {
                $imagePath = public_path('files/parkimg/') . $prvImage->img_path;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $prvImage->delete();
            }
        }

        // Save the updated SalesPark instance
        $salesPark->save();

        // Prepare response data
        $responseData = [
            "message" => "Sales Park updated successfully",
            "data" => $salesPark
        ];

        // Return success response
        return response()->json($responseData, 200);
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
