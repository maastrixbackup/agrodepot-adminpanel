<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminPage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = AdminPage::get();
        return view("pages.list", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'page_name' => 'string|required',
            'page_title' => 'required',
            'meta_title' => 'required',
            'meta_desc' => 'required',
            'meta_keywords' => 'required',
            'page_desc' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $page = new AdminPage();
        $originalString = $request->input('page_name');
        $page->page_name = $request->input('page_name');
        $page->page_slug = Str::slug($originalString);

        $page->page_title = $request->input('page_title');
        $page->meta_title = $request->input('meta_title');
        $page->meta_desc = $request->input('meta_desc');
        $page->meta_keywords = $request->input('meta_keywords');
        $page->page_desc = $request->input('page_desc');
        $page->created = Carbon::parse($page->created)->format("d-m-Y");
        $page->modified = Carbon::parse($page->modified)->format("d-m-Y");
        $page->is_active = $request->input('status') ? 1 : 0;

        $page->save();

        return redirect()->route('pages.index')->with('success', 'Sale added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $adminpage = AdminPage::find($id);

        return view('pages.show', compact('adminpage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = AdminPage::find($id);
        return view("pages.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $page = AdminPage::find($id);
        $originalString = $request->input('page_name');
        $page->page_name = $request->input('page_name');
        $page->page_slug = Str::slug($originalString);

        $page->page_title = $request->input('page_title');
        $page->meta_title = $request->input('meta_title');
        $page->meta_desc = $request->input('meta_desc');
        $page->meta_keywords = $request->input('meta_keywords');
        $page->page_desc = $request->input('page_desc');
        $page->created = Carbon::parse($page->created)->format("d-m-Y");
        $page->modified = Carbon::parse($page->modified)->format("d-m-Y");
        $page->is_active = $request->input('status') ? 1 : 0;
        $page->save();
        return redirect()->route('pages.index')->with('success', 'AdminUser updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = AdminPage::find($id);

        $page->delete();
        return redirect()->route('pages.index')->with('success', 'AdminPage deleted successfully');
    }
}
