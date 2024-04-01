<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Theme::get();
        return view('themes.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('themes.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'html_tag' => 'string|required',
            'font_size' => 'required',
            'font_color' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

       
    
        $theme = new Theme();
        $theme->html_tag = $request->input('html_tag');
        $theme->font_size = $request->input('font_size');
        $theme->font_color = $request->input('font_color');
        $theme->status = $request->input('status');
        $theme->created =  Carbon::parse($theme->created)->format("d-m-Y");
        $theme->modified =  Carbon::parse($theme->modified)->format("d-m-Y");
        $theme->save();
        //dd($theme);
        
        return redirect()->route('themes.index')->with('success', 'Theme added successfully');
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
        $data = Theme::find($id);
        return view("themes.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    
        $theme = Theme::find($id);
        $theme->html_tag = $request->input('html_tag');
        $theme->font_size = $request->input('font_size');
        $theme->font_color = $request->input('font_color');
        $theme->status = $request->input('status');
        $theme->created =  Carbon::parse($theme->created)->format("d-m-Y");
        $theme->modified =  Carbon::parse($theme->modified)->format("d-m-Y");
        $theme->save();
        //dd($theme);
        
        return redirect()->route('themes.index')->with('success', 'Theme updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $theme = Theme::find($id);
        $theme->delete();
        return redirect()->route('themes.index')->with('success', 'Theme deleted successfully');
    }
}
