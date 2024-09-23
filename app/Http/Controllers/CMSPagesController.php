<?php

namespace App\Http\Controllers;

use App\Models\cmsPage;
use Illuminate\Http\Request;

class CMSPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view("cmsPages.list");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $data = cmsPage::where("title", $id)->first();
        $fieldData = json_decode($data->fields);
        return view('cmsPages.' . $id . '.index', compact('data', 'fieldData'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cmsPageData = cmsPage::where("title", $id)->first();

        $allData = $request->except(['_token', '_method']);

        $files = $request->allFiles();

        foreach ($files as $key => $file) {
            if ($file->isValid()) {
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = $key . '.' . $fileExtension;

                $file->move(public_path('images'), $fileName);

                $allData[$key] = $fileName;
            } else {
                unset($allData[$key]);
            }
        }
        if (!empty($allData)) {
            $cmsPageData->fields = json_encode(array_merge(json_decode($cmsPageData->fields, true), $allData));
            $cmsPageData->save();
        }
        return redirect()->route('cms-pages.index')->with('success', 'Updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
