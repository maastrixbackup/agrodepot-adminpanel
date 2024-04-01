<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;

class ManageLogoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = SiteSetting::first();
        return view('logo.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        
       
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
        $data = SiteSetting::find($id);
        return view('logo.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $logo = SiteSetting::find($id);
        if ($request->hasFile('logo_image')) {
            $image = $request->file('logo_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/site_logo'), $imageName);
            $logo->logo_image = $imageName;
        }
        $logo->logo_title = $request->input('logo_title');
      
        $logo->save();
        //dd($logo);

        return redirect()->back()->with('success', 'Logo updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
