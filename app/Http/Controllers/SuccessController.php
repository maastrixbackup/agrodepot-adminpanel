<?php

namespace App\Http\Controllers;

use App\Models\MasterUser;
use App\Models\SuccessStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuccessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = SuccessStory::orderByDesc('success_id')->get();
        return view('successstories.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $users = MasterUser::where('is_active', 1)->get();
        return view('successstories.add', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'user' => 'required',
            'content' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $successStory = new SuccessStory();
        $successStory->user_id = $request->user_id;
        $successStory->content = $request->content;
        $successStory->status = $request->status;
        $successStory->submit_from = 1;

        $successStory->save();
        return redirect()->route('success-stories.index')->with('success', 'Success Story created successfully');
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
        $users = MasterUser::where('is_active', 1)->get();
        $data = SuccessStory::find($id);
        return view('successstories.edit', compact('users', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $successStory = SuccessStory::find($id);
        $successStory->user_id = $request->user_id;
        $successStory->content = $request->content;
        $successStory->status = $request->status;

        $successStory->save();
        return redirect()->route('success-stories.index')->with('success', 'Success Story saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $successStory = SuccessStory::find($id);
        $successStory->delete();
        return redirect()->route('success-stories.index')->with('success', 'Success Story deleted successfully');
    }
}
