<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Advertisement::get();
        return view("advertisements.list", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        return view('advertisements.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|required',
            'ad_type' => 'required',
            'show_position' => 'required',
            'status' => 'required',
            
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $advertise = new Advertisement();
       
        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/advertisement'), $imageName);
            $advertise->banner_image = $imageName;
        }
       
        $advertise->title = $request->input('title');
      
        $advertise->ad_type = $request->input('ad_type');
        $advertise->banner_title = $request->input('banner_title');
        $advertise->banner_link = $request->input('banner_link');
       
        $advertise->ad_script = $request->input('ad_script');
      
        $advertise->show_position = $request->input('show_position');
        $advertise->created = Carbon::parse($advertise->created)->format("d-m-Y");
        $advertise->modified = Carbon::parse($advertise->modified)->format("d-m-Y");
        $advertise->status = $request->input('status')? 1 : 0;
      
        $advertise->save();

       // dd( $advertise);

        return redirect()->route('advertises.index')->with('success', 'Sale added successfully');
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
        $data = Advertisement::find($id);
        return view("advertisements.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $advertise = Advertisement::find($id);
        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/advertisement'), $imageName);
            $advertise->banner_image = $imageName;
        }

        $advertise->title = $request->input('title');
        $advertise->ad_type = $request->input('ad_type');
        $advertise->banner_title = $request->input('banner_title');
        $advertise->banner_link = $request->input('banner_link');
        $advertise->ad_script = $request->input('ad_script');
        $advertise->show_position = $request->input('show_position');
        $advertise->created = Carbon::parse($advertise->created)->format("d-m-Y");
        $advertise->modified = Carbon::parse($advertise->modified)->format("d-m-Y");
        $advertise->status = $request->input('status')? 1 : 0;
        $advertise->save();
        return redirect()->route('advertises.index')->with('success', 'Advertise saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $advertise = Advertisement::find($id);
        if ($advertise->banner_image) {
            $previousImagePath = public_path('uploads/advertisement/' . $advertise->banner_image);
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }
        $advertise->delete();
        return redirect()->route('advertises.index')->with('success', 'Advertisement deleted successfully');
    }


    public function updateStatus(Request $request, $advId)
    {
        $advertise = Advertisement::find($advId);
        $advertise->status = $request->input('status');
        $advertise->save();

        return response()->json(['message' => 'Status updated successfully', 'status' => $advertise->status]);
    }

}
