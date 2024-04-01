<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeoField;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SeoField::get();
        return view("seoFields.list", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("seoFields.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //dd($request->all());

        $validator = Validator::make($request->all(), [
            'page_name' => 'string|required',
            'meta_title' => 'required',
            'meta_desc' => 'required',
            'meta_keyword' => 'required',


        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $seofield = new SeoField();
        $seofield->page_name = $request->input('page_name');
        $seofield->meta_title = $request->input('meta_title');
        $seofield->meta_desc = $request->input('meta_desc');
        $seofield->meta_keyword = $request->input('meta_keyword');
        $seofield->created =  Carbon::parse($seofield->created)->format("d-m-Y");
        $seofield->modified = Carbon::parse($seofield->modified)->format("d-m-Y");
        $seofield->save();

        return redirect()->route('seofields.index')->with('success', 'Seo fields added successfully');

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
        $data = SeoField::find($id);
        return view("seoFields.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $seofield = SeoField::find($id);
        $seofield->page_name = $request->input('page_name');
        $seofield->meta_title = $request->input('meta_title');
        $seofield->meta_desc = $request->input('meta_desc');
        $seofield->meta_keyword = $request->input('meta_keyword');
        $seofield->created =  Carbon::parse($seofield->created)->format("d-m-Y");
        $seofield->modified = Carbon::parse($seofield->modified)->format("d-m-Y");
        $seofield->save();


        return redirect()->route('seofields.index')->with('success', 'SEO Fields updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
