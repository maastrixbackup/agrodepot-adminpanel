<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserMembership;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = UserMembership::get();
        return view("memberships.list", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("memberships.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

     //dd($request->all());
        $validator = Validator::make($request->all(), [
            'memb_type' => 'string|required',
            'price' => 'required',
            'credits' => 'required',
            'status' => 'required',
            'plan_img' => 'required',
           
            
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $membership = new UserMembership();
        if ($request->hasFile('plan_img')) {
            $image = $request->file('plan_img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/memberplanimg'), $imageName);
            $membership->plan_img =  $imageName;
            
        }

        
        $membership->memb_type = $request->input('memb_type');
        $membership->price = $request->input('price');
        $membership->credits = $request->input('credits');
        $membership->created = Carbon::parse($membership->created)->format("d-m-Y");
        $membership->modified = Carbon::parse($membership->modified)->format("d-m-Y");
        $membership->status = $request->input('status')? 1 : 0;
        $membership->save();

        return redirect()->route('memberships.index')->with('success', 'Membership added successfully');
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
        $data = UserMembership::find($id);
        return view("memberships.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $membership = UserMembership::find($id);
        if ($request->hasFile('plan_img')) {
            $image = $request->file('plan_img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/memberplanimg'), $imageName);
            $membership->plan_img =  $imageName;
            
        }
        $membership->memb_type = $request->input('memb_type');
        $membership->price = $request->input('price');
        $membership->credits = $request->input('credits');
        $membership->created = Carbon::parse($membership->created)->format("d-m-Y");
        $membership->modified = Carbon::parse($membership->modified)->format("d-m-Y");
        $membership->status = $request->input('status')? 1 : 0;
        $membership->save();
        //dd($membership);
        return redirect()->route('memberships.index')->with('success', 'membership updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $membership = UserMembership::find($id);
        if ( $membership->plan_img) {
            $previousImagePath = public_path('uploads/memberplanimg/' .  $membership->plan_img);
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }
        $membership->delete();
        return redirect()->route('memberships.index')->with('success', 'Membership deleted successfully');
    }

    public function updateStatus(Request $request, $memId)
    {
        $membership = UserMembership::find($memId);
        $membership->status = $request->input('status');
        $membership->save();

        return response()->json(['message' => 'Status updated successfully', 'status' => $membership->status]);
    }
}
