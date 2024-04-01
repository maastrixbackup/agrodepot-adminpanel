<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialIcon;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ManageSocialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SocialIcon::get();
        return view("socialIcons.list", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("socialIcons.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'social_name' => 'required',
            'social_link' => 'required',
            'social_img' => 'required',
            'orderno' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $icon = new SocialIcon();
        if ($request->hasFile('social_img')) {
            $image = $request->file('social_img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/socialicon'), $imageName);
            $icon->social_img = $imageName;
        }
        $icon->social_name = $request->input('social_name');
        $icon->social_link = $request->input('social_link');
        $icon->orderno = $request->input('orderno');
        $icon->created = Carbon::parse($icon->created)->format("d-m-Y");
        $icon->save();
        //dd($icon);
        return redirect()->route('socialicons.index')->with('success', 'iCON added successfully');
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
        $data = SocialIcon::find($id);
        return view("socialIcons.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $icon = SocialIcon::find($id);
        if ($request->hasFile('social_img')) {
            $image = $request->file('social_img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/socialicon'), $imageName);
            $icon->social_img = $imageName;
        }
        $icon->social_name = $request->input('social_name');
        $icon->social_link = $request->input('social_link');
        $icon->orderno = $request->input('orderno');
        $icon->created = Carbon::parse($icon->created)->format("d-m-Y");
        $icon->save();



        return redirect()->route('socialicons.index')->with('success', 'SocialIcon saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $icon = SocialIcon::find($id);
        if ($icon->social_img) {
            $previousImagePath = public_path('uploads/socialicon/' .$icon->social_img);
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }
       $icon->delete();
        return redirect()->route('socialicons.index')->with('success', 'SocialIcon deleted successfully');
    }
}
