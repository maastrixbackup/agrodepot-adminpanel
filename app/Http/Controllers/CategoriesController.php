<?php

namespace App\Http\Controllers;

use App\Models\SalesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $parent = ['' => '-No Parent-'];
        $parent += SalesCategory::where('flag', 0)->pluck('category_name', 'category_id')->toArray();

        $flag = $request->input('flag', '');
        $query = SalesCategory::query();

        if (!empty($flag)) {
            $query->where('flag', $flag);
        }

        $data = $query->with('categoryName')->get();

        return view('categories.list', [
            'data' => $data,
            'parent' => $parent,
            'par_ct' => $flag,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = SalesCategory::where('flag', '=', 0)->get();
        //dd($categories);
        return view('categories.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
            'slug' => 'required',
            'flag' => 'required',
            'status' => 'required|in:1,0',
            'meta_description' => 'required',
            'meta_keywords' => 'required',

        ]);



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //echo'hii';exit;
        $category = new SalesCategory();
        $category->category_name = $request->input('category_name');
        $category->flag = $request->input('flag');
        $category->slug = $request->input('slug');
        $category->status = $request->input('status') == 'active' ? 1 : 0;
        $category->meta_description = $request->input('meta_description');
        $category->meta_keywords = $request->input('meta_keywords');
        $category->modified = Carbon::now();
        $category->save();
        //dd($category);
        return redirect()->route('categories.index')->with('success', 'Categories added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = SalesCategory::find($id);

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = SalesCategory::find($id);
        $categories = SalesCategory::where('flag', '=', 0)->get();
        return view("categories.edit", compact("data", "categories"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->except('banner_img'), [
            'category_name' => 'required',
            'slug' => 'required',
            'flag' => 'required',
            'status' => 'required|in:1,0',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $category = SalesCategory::find($id);
        $category->category_name = $request->input('category_name');
        $category->flag = $request->input('flag');
        $category->slug = $request->input('slug');
        $category->status = $request->input('status') == 'active' ? 1 : 0;
        $category->meta_description = $request->input('meta_description');
        $category->meta_keywords = $request->input('meta_keywords');
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = SalesCategory::find($id);
        if ($category) {
            $category->delete();

            return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
        } else {
            return redirect()->route('categories.index')->with('error', 'Category not found');
        }
    }

    public function updateStatus(Request $request, $catId)
    {
        $category = SalesCategory::find($catId);
        $category->status = $request->input('status');
        $category->save();

        return response()->json(['message' => 'Status updated successfully', 'status' => $category->status]);
    }
}
