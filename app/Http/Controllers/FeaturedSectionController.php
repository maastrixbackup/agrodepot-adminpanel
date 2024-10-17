<?php

namespace App\Http\Controllers;

use App\Models\FeaturedSection;
use Illuminate\Http\Request;

class FeaturedSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = FeaturedSection::latest()->get();
        return view("featured_section.list", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd('ok');
        return view("featured_section.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'english_title' => 'required',
            'romanian_title' => 'required',
            'link' => 'required',
            'image' => 'required', // Added image validation rule
        ]);
        try {
            $fSection = new FeaturedSection();
            $fSection->english_title = trim($request->english_title);
            $fSection->romanian_title = trim($request->romanian_title); // Corrected the typo
            $fSection->link = $request->link;
            $fSection->status = $request->status;

            // Handle the image file upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/featuredContent/'), $filename);
                // Save the filename in the database
                $fSection->image = $filename;
            }

            $fSection->save();
            return redirect()->route('feature-section.index')->with('success', 'Featured Section Added');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage()); // Changed to 'error' for error messages
        }
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
        // dd($id);
        $data = FeaturedSection::where("id", $id)->first();
        return view('featured_section.edit', compact('data'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fSection = FeaturedSection::find($id);
        try {
            $fSection->english_title = trim($request->english_title);
            $fSection->romanian_title = trim($request->romanian_title); // Corrected the typo
            $fSection->link = $request->link;
            $fSection->status = $request->status;

            // Handle the image file upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/featuredContent/'), $filename);
                // Save the filename in the database

                // Check if the provider has an existing image
                if (!empty($fSection->image)) {
                    $existingFilePath = public_path('uploads/featuredContent/') . $fSection->image;
                    if (file_exists($existingFilePath)) {
                        // Delete the file if it exists
                        unlink($existingFilePath);
                    }
                }

                $fSection->image = $filename;
            }
            $fSection->image = $fSection->image;

            $fSection->save();
            return redirect()->route('feature-section.index')->with('success', 'Featured Section Updated');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage()); // Changed to 'error' for error messages
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            FeaturedSection::find($id)->delete();
            return redirect()->route('feature-section.index')->with('success', 'Featured Section Deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
