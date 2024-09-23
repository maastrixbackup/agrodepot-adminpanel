<?php

namespace App\Http\Controllers;

use App\Models\AdminLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use NumberFormatter;

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

        $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);

        $language = new AdminLang();
        $language->en_label = $request->input('en_label');
        $language->roman_label = $request->input('roman_label');

        $language->save();

        $numberString = $formatter->format($language->lid);

        $numberString = str_replace([' ', '-'], '', $numberString);

        $language->numberstring = $numberString;

        if ($language->save()) {
            \Log::info("Stored admin_lang id {$language->id} with numberstring {$numberString} successfully");
        } else {
            \Log::error("Failed to store admin_lang id {$language->id} with numberstring {$numberString}");
        }

        return redirect()->route('admin-langs.index')->with('success', 'Language added successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Debug statement to ensure the method is being called
        \Log::info('show method called');

        // Create the NumberFormatter instance
        $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);

        // Chunk through the admin_langs table
        AdminLang::chunk(100, function ($adminLangs) use ($formatter) {
            foreach ($adminLangs as $adminLang) {
                // Convert number to string
                $numberString = $formatter->format($adminLang->lid);

                // Remove spaces and hyphens
                $numberString = str_replace([' ', '-'], '', $numberString);

                // Debug statement to see the converted string
                \Log::info("Converted {$adminLang->lid} to {$numberString}");

                // Update the numberstring field and check the result
                $adminLang->numberstring = $numberString;

                // Debug statement to check if the update was successful
                if ($adminLang->save()) {
                    \Log::info("Updated admin_lang id {$adminLang->id} successfully");
                } else {
                    \Log::error("Failed to update admin_lang id {$adminLang->id}");
                }
            }
        });

        // Return a response or view as needed
        return response()->json(['message' => 'Number strings updated successfully']);
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
    public function convert()
    {
    }
}
