<?php

namespace App\Http\Controllers;

use App\Models\SalesBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = SalesBrand::orderBy('ordering', 'ASC')->get();
        return view("brands.list", compact("data"));
    }

    public function getBrands(Request $request)
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

        $totalRecords = SalesBrand::select('count(*) as allcount')->count();
        $brandRecords = SalesBrand::orderBy('brand_id', 'desc')->select('sales_brands.*');

        if (isset($searchValue)) {
            $brandRecords = $brandRecords->where('brand_name', 'like', '%' . $searchValue . '%');
        }

        // Fetch records\
        $totalRecordswithFilter = $brandRecords->count();
        $brandRecords = $brandRecords->skip($row)->take($rowperpage)->get();
        $i = 1;
        foreach ($brandRecords as $key => $record) {
            $btns = '';
            $delete_btn = url('admin/brands', $record->brand_id);
            $edit_btn = url('admin/brands', $record->brand_id . '/edit');

            $btns .= '<a class="edit-btn" href="' . $edit_btn . '"><i class="fas fa-edit"></i></a>';
            $btns .= '<button title="Delete" class="dl-btn trash remove-category" data-id="' . $record->brand_id . ' " data-action="' . $delete_btn . '"><i class="fas fa-trash"></i></button>';

            $action = '<div class="d-flex customButtonContainer">' . $btns . '</div>';

            if ($record->image) {
                $logopath = asset('/uploads/brand/' . $record->image);
                $logo = '<img src="' . $logopath . '" alt="" srcset="" style="height: 100px;width: 100px;
            ">';
            } else {
                $logopath = asset('/uploads/no-image.jpg');
                $logo = '<img src="' . $logopath . '" alt="" srcset="" style="height: 100px;width: 100px;
                ">';
            }

            $status = '<select name="status" class="form-select-sm" onchange="BrandStatusUpdate(this)" data-cat-id="' . $record->brand_id . '">
            <option value="1" ' . ($record->status == '1' ? 'selected' : '') . '>Active</option>
            <option value="0" ' . ($record->status == '0' ? 'selected' : '') . '>Inactive</option>
          </select>';





            $data[] = array(
                "id" =>  $record->id ? $record->id : "NA",
                "brand_name" =>  $record->brand_name ? $record->brand_name : "NA",
                "logo" => $logo,
                "parent" => optional($record->parent)->brand_name,
                "status" => $status,
                "created_date" =>  $record->created ? date("d-m-Y", strtotime($record->created)) : "NA",
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
        $categories = SalesBrand::where('flag', '=', 0)->get();
        return view("brands.add", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required',
            'image' => 'required',
            'flag' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $banner = new SalesBrand();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/brand'), $imageName);
            $banner->image = $imageName;
        }
        $banner->brand_name = $request->brand_name;
        $banner->flag = $request->flag;
        if ($request->status) {
            $banner->status = $request->status;
        } else {
            $banner->status = 1; // Set default value to 1 if no option is selected
        }
        $banner->meta_description = $request->meta_description;
        $banner->meta_keywords = $request->meta_keywords;
        $banner->save();
        return redirect()->route('brands.index')->with('success', 'Brand added successfully');
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
        $data = SalesBrand::find($id);
        $categories = SalesBrand::where('flag', '=', 0)->get();
        return view("brands.edit", compact("data", "categories"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required',
            'flag' => 'required',
            'status' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $banner = SalesBrand::find($id);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/brand'), $imageName);
            $banner->image = $imageName;
        }
        $banner->brand_name = $request->brand_name;
        $banner->flag = $request->flag;
        $banner->status = $request->status;
        $banner->meta_description = $request->meta_description;
        $banner->meta_keywords = $request->meta_keywords;
        $banner->save();
        return redirect()->route('brands.index')->with('success', 'Brand added successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = SalesBrand::find($id);
        if ($banner->image) {
            $previousImagePath = public_path('uploads/brand/' . $banner->image);
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }
        $banner->delete();
        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully');
    }
    public function updateStatus(Request $request, $catId)
    {
        $category = SalesBrand::find($catId);
        $category->status = $request->input('status');
        $category->save();

        return response()->json(['message' => 'Status updated successfully', 'status' => $category->status]);
    }
    public function updateOrdering(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $key => $value) {
            $brand = SalesBrand::find($value);
            $brand->ordering = $key;
            $brand->save();
        }


        // return response()->json(['message' => 'Status updated successfully', 'status' => $category->status]);
    }
}
