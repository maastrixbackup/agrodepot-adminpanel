<?php

namespace App\Http\Controllers;
// require_once __DIR__ . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';

use App\Models\MasterUser;
use App\Models\PostadImg;
use App\Models\SalesAdvertisement;
use App\Models\SalesBrand;
use App\Models\SalesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Src\Drivers\Imagick\Driver;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sales = SalesAdvertisement::orderBy('adv_id', 'DESC')->paginate(20);
        foreach ($sales as $key => $value) {
            $image = PostadImg::where('post_ad_id', $value->adv_id)->first();
            if ($image) {
                $filePath = public_path('uploads/postad/' . $image->img_path);

                if (file_exists($filePath) && $image->img_path != "") {
                    $path = public_path('uploads/postad/100X100_' . $image->img_path);

                    if (file_exists($path)) {
                        $value['image'] = asset('uploads/postad/100X100_' . $image->img_path);
                    } else {
                        $value['image'] = asset('uploads/postad/' . $image->img_path);
                    }
                } else {
                    $value['image'] = '';
                }
            } else {
                $value['image'] = '';
            }
            $time = strtotime($value->created);
            $newformat = date('Y-m-d', $time);
            $value['createdOn'] = $newformat;
        }
        return view("sales.list", compact('sales'));
    }

    public function getSales(Request $request)
    {
        // dd($request->all());
        ## Read value
        $draw = $request->get('draw');
        $row = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        $columnIndex = $request['order'][0]['column']; // Column index
        $columnName = $request['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $request['order'][0]['dir']; // asc or desc
        $searchValue = $request['search']['value']; // Search value
        // $searchtxt = $request->searchtxt;

        ## Read value

        $data = array();

        $totalRecords = SalesAdvertisement::select('count(*) as allcount')->count();
        $salesRecords = SalesAdvertisement::orderBy('adv_id', 'desc')->select('sales_advertisements.*');

        if (isset($searchValue)) {
            $salesRecords = $salesRecords->where('adv_name', 'like', '%' . $searchValue . '%');
        }

        // Fetch records\
        $totalRecordswithFilter = $salesRecords->count();
        $salesRecords = $salesRecords->skip($row)->take($rowperpage)->get();
        $i = 1;
        foreach ($salesRecords as $key => $record) {
            $btns = '';
            $delete_btn = route('sales.destroy', $record->adv_id);
            $edit_btn = route('sales.edit', $record->adv_id);

            $btns .= '<a class="edit-btn" href="' . $edit_btn . '"><i class="fas fa-edit"></i></a>';
            $btns .= '<button title="Delete" class="dl-btn trash remove-sales" data-id="' . $record->adv_id . '" data-action="' . $delete_btn . '"><i class="fas fa-trash"></i></button>';

            $action = '<div class="d-flex customButtonContainer">' . $btns . '</div>';

            $image = PostadImg::where('post_ad_id', $record->adv_id)->first();

            // Initialize image path to empty string
            $imagePath = '';

            // Check if image record exists and the image file exists
            if ($image && $image->img_path != "") {
                // Construct the file path to the image
                $filePath = public_path('uploads/postad/' . $image->img_path);

                // Check if the image file exists
                if (file_exists($filePath)) {
                    // If a thumbnail exists, use it; otherwise, use the original image
                    $thumbnailPath = public_path('uploads/postad/100X100_' . $image->img_path);
                    $imagePath = file_exists($thumbnailPath) ? 'uploads/postad/100X100_' . $image->img_path : 'uploads/postad/' . $image->img_path;
                }
            }

            // Add image HTML to data array
            // $imageHtml = $imagePath ? '<img src="' . asset($imagePath) . '" alt="Image" style="height: 100px;width: 150px;">' : '';
            $imageHtml = $imagePath ? '<img src="' . asset($imagePath) . '" alt="Image" style="height: 100px; width: 100px;">' : '<img src="' . asset('uploads/no-image.jpg') . '" alt="No Image" style="height: 100px; width: 100px;">';

            $price = $record->currency . $record->currency;

            if ($record->is_promote == 1) {
                $is_promoted = '<a target="_blank" title="Click here to view promoted details">Promoted</a>';
            } else {
                $is_promoted = 'Not Promoted';
            }

            $status = '<select name="adv_status" class="form-select-sm select" onchange="salesstatusUpdate(this)" data-adv-id="' . $record->adv_id . '">
            <option value="1" ' . ($record->adv_status == '1' ? 'selected' : '') . '>Active</option>
            <option value="0" ' . ($record->adv_status == '0' ? 'selected' : '') . '>Inactive</option>
          </select>';






            $data[] = array(
                "id" =>  $record->id ? $record->id : "NA",
                "adv_name" =>  $record->adv_name ? $record->adv_name : "NA",
                "posted_by" => optional($record->user)->first_name,
                "image" => $imageHtml,
                "price" => $price,
                "quantity" => $record->quantity ? $record->quantity : "NA",
                "category" => optional($record->category)->category_name,
                "sub_category" => optional($record->category)->categoryName ? $record->category->categoryName->category_name : "N/A",
                "is_promoted" => $is_promoted,
                "status" => $status,
                "created_date" =>  $record->created ? date("y-m-d", strtotime($record->created)) : "NA",
                "action" =>  $action

            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "data" => $data
        );

        echo json_encode($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $users = MasterUser::where('is_active', 1)->get();
        $categories = SalesCategory::where('flag', 0)->get();
        $brands = SalesBrand::where('flag', 0)->select('brand_id', 'brand_name')->get();
        $image = SalesAdvertisement::select('adv_img')->first();
        return view('sales.add', compact('users', 'categories', 'brands', 'image'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getSubCategories(Request $request, $catId)
    {
        $subcategories = SalesCategory::where('flag', $catId)->get();
        return response()->json(['data' => $subcategories]);
    }
    public function getModels(Request $request, $Id)
    {
        $models = SalesBrand::where('flag', $Id)->get();
        return response()->json(['data' => $models]);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'category_id' => 'required',
            // 'sub_cat_id' => 'required',
            'adv_name' => 'required',
            'adv_img.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'adv_brand_id' => 'required',
            'product_cond' => 'required',
            'price' => 'required',
            'currency' => 'required',
            'quantity' => 'required',
            'payment_mode' => 'required',
        ], [
            'adv_img.*.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.'
        ]);


        if ($validator->fails()) {
            // dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // echo'hii';exit;

        $sale = new SalesAdvertisement();
        $brandData = $request->input('adv_brand_id');
        $modelData = $request->input('adv_model_id');

        // Check if the input is an array
        if (is_array($brandData)) {
            $brandIds = array_keys($brandData);
        } else {
            // Handle the case when input is not an array
            $brandIds = [];
        }

        if (is_array($modelData)) {
            $modelIds = array_keys($modelData);
        } else {
            // Handle the case when input is not an array
            $modelIds = [];
        }

        $brandString = implode(',', $brandIds);
        $modelString = implode(',', $modelIds);


        $originalString = $request->input('adv_name');
        $sale->user_id = $request->input('user_id');
        $sale->category_id = $request->input('category_id');
        $sale->adv_details = $request->input('adv_details');
        $sale->adv_name = $request->input('adv_name');
        $sale->adv_status = $request->input('status');
        $sale->sub_cat_id = $request->input('sub_cat_id');
        $baseSlug = Str::slug($originalString);
        $slug = $baseSlug;
        $count = 1;

        // Check if the slug already exists in the database
        while (SalesAdvertisement::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $sale->slug = $slug;
        $sale->adv_model_id = $modelString;
        $sale->adv_brand_id = $brandString;
        $sale->product_cond = $request->input('product_cond');
        $sale->currency = $request->input('currency');
        $sale->quantity = $request->input('quantity');
        $sale->payment_mode = $request->input('payment_mode');
        $sale->personal_teaching = $request->has('personal_teaching') ? $request->input('personal_teaching') : 0;
        $sale->courier = $request->has('courier') ? $request->input('courier') : 0;
        $sale->courier_cost = $request->has('courier_cost') ? $request->input('courier_cost') : 0;
        $sale->free_courier = $request->has('free_courier') ? $request->input('free_courier') : 0;
        $sale->romanian_mail = $request->has('romanian_mail') ? $request->input('romanian_mail') : 0;
        $sale->romanian_mail_cost = $request->has('romanian_mail_cost') ? $request->input('romanian_mail_cost') : 0;
        $sale->free_romanian_mail = $request->has('free_romanian_mail') ? $request->input('free_romanian_mail') : 0;

        $sale->b2bprice = $request->input('b2bprice');
        $sale->price = $request->input('price');
        $sale->time_required = $request->input('time_required');
        $sale->adv_status = $request->input('adv_status');
        $sale->availability = 'null';
        $sale->warranty = 'null';
        $sale->invoice = 'null';
        $sale->meta_title = 'null';
        $sale->meta_desc = 'null';
        $sale->meta_keywords = 'null';
        $sale->created =  Carbon::parse($sale->created)->format("d-m-Y");
        $sale->modified = Carbon::parse($sale->modified)->format("d-m-Y");
        $sale->save();
        if ($request->hasFile('adv_img')) {
            $images = $request->file('adv_img');
            $imageNames = [];

            foreach ($images as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();

                // Save the original image
                $image->move(public_path('uploads/postad/'), $imageName);
                $imageNames[] = $imageName;

                // Save the rotated image if there is rotation data
                if ($request->has('rotation_data')) {
                    $rotatedImage = $this->rotateImage($image, $request->input('rotation_data'));
                    $rotatedImageName = time() . '_rotated_' . $rotatedImage->getClientOriginalName();
                    $rotatedImage->move(public_path('uploads/postad/'), $rotatedImageName);
                    $imageNames[] = $rotatedImageName;
                }

                // Save image details to the database
                $saleImage = new PostadImg();
                $saleImage->post_ad_id = $sale->adv_id;
                $saleImage->user_id = $sale->user_id;
                $saleImage->img_path = $imageName;
                $saleImage->save();
            }
        }


        return redirect()->route('sales.index')->with('success', 'Sale added successfully');
    }

    private function rotateImage($image, $rotationData)
    {
        $degrees = intval($rotationData); // Get the rotation angle from rotation data
        $imagePath = $image->getPathname(); // Get the path of the image file

        // Create an image resource from the file
        $imageResource = imagecreatefromstring(file_get_contents($imagePath));

        // Rotate the image
        $rotatedImageResource = imagerotate($imageResource, $degrees, 0);

        // Save the rotated image to a temporary file
        $rotatedImagePath = tempnam(sys_get_temp_dir(), 'rotated_image_');
        imagejpeg($rotatedImageResource, $rotatedImagePath);

        // Free up memory by destroying image resources
        imagedestroy($imageResource);
        imagedestroy($rotatedImageResource);

        // Create a new instance of UploadedFile with the rotated image
        $rotatedImage = new \Illuminate\Http\UploadedFile($rotatedImagePath, $image->getClientOriginalName());

        return $rotatedImage; // Return the rotated image
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
        $data = SalesAdvertisement::find($id);
        $users = MasterUser::where('is_active', 1)->get();
        $categories = SalesCategory::where('flag', 0)->get();
        $brands = SalesBrand::where('flag', 0)->get();
        // $selectedBrands = SalesBrand::whereIn('brand_id',explode(",",$data->adv_brand_id))->get();
        $subcategories = SalesCategory::where('flag', $data->category_id)->get();
        $selectedModels = SalesBrand::whereIn('brand_id', explode(",", $data->adv_model_id))->get();
        $images = PostadImg::where('post_ad_id', $data->adv_id)->get();
        //dd($image);


        // $rotations = [];
        // foreach ($image as $img) {
        //     $rotations[$img->imgid] = $this->calculateRotationAngle($img->img_path);
        // }
        // dd($models);
        return view("sales.edit", compact("data", "users", "categories", "images", "brands", "subcategories", 'selectedModels'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // return response()->json($request->all());

        // $validator = Validator::make($request->all(), [
        //     'user_id' => 'required',
        //     'category_id' => 'required',
        //     'sub_cat_id' => 'required',
        //     'adv_img.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'adv_name' => 'required',
        //     'adv_details' => 'required',
        //     'adv_status' => 'required',
        //     'adv_brand_id' => 'required',
        //     'adv_model_id' => 'required',
        //     'product_cond' => 'required',
        //     'payment_mode' => 'required',
        //     'price' => 'required',
        //     'currency' => 'required',
        //     'quantity' => 'required',
        //     'time_required' => 'required',
        //     'price' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        $sale = SalesAdvertisement::find($id);
        $brandData = $request->input('adv_brand_id');
        $modelData = $request->input('adv_model_id');

        $brandIds = array_keys($brandData);
        $modelIds = array_keys($modelData);

        $brandString = implode(',', $brandIds);
        $modelString = implode(',', $modelIds);



        $sale->user_id = $request->input('user_id');
        $sale->category_id = $request->input('category_id');
        $sale->adv_details = $request->input('adv_details');
        $sale->adv_name = $request->input('adv_name');
        $sale->adv_status = $request->input('status');
        $sale->sub_cat_id = $request->input('sub_cat_id');
        $sale->slug = 'null';
        $sale->adv_model_id = $modelString;
        $sale->adv_brand_id = $brandString;
        $sale->product_cond = $request->input('product_cond');
        $sale->currency = $request->input('currency');
        $sale->quantity = $request->input('quantity');
        $sale->payment_mode = $request->input('payment_mode');
        $sale->personal_teaching = $request->input('personal_teaching');
        $sale->courier = $request->input('courier');
        $sale->courier_cost = $request->input('courier_cost');
        $sale->free_courier = $request->input('free_courier');
        $sale->romanian_mail = $request->input('romanian_mail');
        $sale->romanian_mail_cost = $request->input('romanian_mail_cost');
        $sale->free_romanian_mail = $request->input('free_romanian_mail');
        $sale->price = $request->input('price');
        $sale->b2bprice = $request->input('b2bprice');
        $sale->time_required = $request->input('time_required');
        $sale->adv_status = $request->input('adv_status');
        $sale->availability = 'null';
        $sale->warranty = 'null';
        $sale->invoice = 'null';
        $sale->meta_title = 'null';
        $sale->meta_desc = 'null';
        $sale->meta_keywords = 'null';
        $sale->created =  Carbon::parse($sale->created)->format("d-m-Y");
        $sale->modified = Carbon::parse($sale->modified)->format("d-m-Y");
        $sale->save();


        if ($request->hasFile('adv_img')) {
            $images = $request->file('adv_img');
            $imageNames = [];
            foreach ($images as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();

                //dd($imageName);
                $image->move(public_path('uploads/postad/'), $imageName);
                $imageNames[] = $imageName;


                $saleImage = new PostadImg();
                $saleImage->post_ad_id = $sale->adv_id;

                $saleImage->user_id = $sale->user_id;
                $saleImage->img_path = $imageName;
                $saleImage->save();
            }
        }

        return redirect()->route('sales.index')->with('success', 'Sale Updated successfully');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = SalesAdvertisement::find($id);
        $this->deleteImage($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully');
    }


    public function deleteImage($imageId)
    {
        $image = PostadImg::find($imageId);

        if ($image) {
            // Delete the file from the file system
            $filePath = public_path('uploads/postad/' . $image->img_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete the database record
            $image->delete();

            return response()->json(['success' => true], 200);
        }

        return response()->json(['success' => false], 404);
    }

    public function updateStatus(Request $request, $Id)
    {
        $sale = SalesAdvertisement::find($Id);
        $sale->adv_status = $request->input('adv_status');
        $sale->save();

        return response()->json(['message' => 'Status updated successfully', 'status' => $sale->adv_status]);
    }

    // public function rotateImage(Request $request)
    // {
    //     $imageData = $request->input('imageData');

    //     // Example code to rotate image using Intervention Image
    //     $image = Image::make($imageData);
    //     $image->rotate(90);
    //     $rotatedImageData = $image->encode('data-url')->encoded;

    //     return response()->json(['rotatedImageData' => $rotatedImageData]);
    // }
}
