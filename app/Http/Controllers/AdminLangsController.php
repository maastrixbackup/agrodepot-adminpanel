<?php

namespace App\Http\Controllers;

use App\Models\AdminLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminLangsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = AdminLang::get();
        return view("adminLangs.list", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("adminLangs.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'en_label' => 'required',
            'roman_label' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $language = new AdminLang();
        $language->en_label = $request->input('en_label');
        $language->roman_label = $request->input('roman_label');
        $language->save();
        return redirect()->route('admin-langs.index')->with('success', 'Language added successfully');
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
        $data = AdminLang::find($id);
        return view("adminLangs.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'en_label' => 'required',
            'roman_label' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $language = AdminLang::find($id);
        $language->en_label = $request->input('en_label');
        $language->roman_label = $request->input('roman_label');
        $language->save();
        return redirect()->route('admin-langs.index')->with('success', 'Banner saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
