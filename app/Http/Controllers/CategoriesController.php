<?php

namespace App\Http\Controllers;

use App\Models\SalesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $parent = [];
        $parent += SalesCategory::where('flag', 0)->pluck('category_name', 'category_id')->toArray();
        if (empty($parent)) {
            $parent = ['' => '-No Parent-'];
        }

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

        $category = new SalesCategory();
        $category->category_name = $request->input('category_name');
        $category->flag = $request->input('flag');

        $baseSlug = Str::slug($request->input('category_name'));
        $slug = $baseSlug;
        $count = 1;

        // Check if the slug already exists in the database
        while (SalesCategory::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $category->slug = $slug;
        $category->status = $request->input('status');
        $category->meta_description = $request->input('meta_description');
        $category->meta_keywords = $request->input('meta_keywords');
        $category->modified = Carbon::now();
        $category->save();
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

        $inputSlug = $request->input('slug');
        $baseSlug = Str::slug($request->input('category_name'));

        // Check if the input slug matches the current category's slug
        if ($category->slug !== $inputSlug) {
            // If a different slug is provided, check if it's unique
            $slug = $inputSlug;
            $count = 1;

            while (SalesCategory::where('slug', $slug)->where('category_id', '!=', $id)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }

            $category->slug = $slug;
        } else {
            // If the same slug is provided, keep it as is
            $category->slug = $inputSlug;
        }

        $category->status = $request->input('status');
        $category->meta_description = $request->input('meta_description');
        $category->meta_keywords = $request->input('meta_keywords');
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
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
        try {
            // Find the category by ID
            $category = SalesCategory::find($catId);

            // Check if category exists
            if (!$category) {
                return response()->json([
                    'message' => 'Category not found.',
                ]);
            }

            // Update the status
            $category->status = $request->input('status');
            $category->save();

            return response()->json([
                'message' => 'Status updated successfully',
                'status' => $category->status
            ]);
        } catch (\Throwable $th) {
            // Return an error response with the appropriate status code
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
            ]);
        }
    }

    public function generateSlugsForAll()
    {
        // Fetch all categories that have a null or empty slug
        $categories = SalesCategory::whereNull('slug')->orWhere('slug', '')->get();

        foreach ($categories as $category) {
            $baseSlug = Str::slug($category->category_name);
            $slug = $baseSlug;
            $count = 1;

            // Ensure the slug is unique within the SalesCategory table
            while (SalesCategory::where('slug', $slug)->where('category_id', '!=', $category->category_id)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }

            // Update the category with the new unique slug
            $category->slug = $slug;
            $category->save();
        }

        return response()->json('Slugs generated successfully for all categories');
        // return redirect()->route('categories.index')->with('success', 'Slugs generated successfully for all categories');
    }


    public function deleteAllSlugs()
    {
        // Update all rows to set the slug column to null where slug is not null
        SalesCategory::whereNotNull('slug')->update(['slug' => null]);

        return response()->json('All slugs have been deleted successfully');
        // return redirect()->route('categories.index')->with('success', 'All slugs have been deleted successfully');
    }
}
