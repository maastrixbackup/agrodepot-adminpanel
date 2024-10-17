<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Banner::get();
        return view("banners.list", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("banners.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banner_title' => 'required',
            'banner_caption' => 'required',
            'banner_img' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $banner = new Banner();
        if ($request->hasFile('banner_img')) {
            $image = $request->file('banner_img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/banner'), $imageName);
            $banner->banner_img = $imageName;
        }
        $banner->banner_title = $request->input('banner_title');
        $banner->banner_caption = $request->input('banner_caption');
        $banner->link = $request->input('link');
        $banner->save();
        return redirect()->route('banners.index')->with('success', 'Banner added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $banner = Banner::find($id);

        return view('banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = Banner::find($id);
        return view("banners.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->except('banner_img'), [
            'banner_title' => 'required',
            'banner_caption' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $banner = Banner::find($id);
        if ($request->hasFile('banner_img')) {
            if ($banner->banner_img) {
                $previousImagePath = public_path('uploads/banner/' . $banner->banner_img);
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }
            $image = $request->file('banner_img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/banner'), $imageName);
            $banner->banner_img = $imageName;
        }

        $banner->update($request->except('banner_img'));
        $banner->save();
        return redirect()->route('banners.index')->with('success', 'Banner saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::find($id);
        if ($banner->banner_img) {
            $previousImagePath = public_path('uploads/banner/' . $banner->banner_img);
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }
        $banner->delete();
        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully');
    }
}
