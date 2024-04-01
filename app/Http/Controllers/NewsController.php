<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = News::orderByDesc('news_id')->get();
        return view('news.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'news_title' => 'required',
            'news_content' => 'required',
            'news_img' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $news = new News();
        if ($request->hasFile('news_img')) {
            $image = $request->file('news_img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/news'), $imageName);
            $news->news_img = $imageName;
        }
        $news->news_title = $request->news_title;
        $news->news_content = $request->news_content;
        $news->status = $request->status;
        $news->save();
        return redirect()->route('news.index')->with('success', 'News Story created successfully');
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
        $data = News::find($id);
        return view('news.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $news = News::find($id);
        if ($request->hasFile('news_img')) {
            $previousImagePath = public_path('uploads/news/' . $news->news_img);
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
            $image = $request->file('news_img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/news'), $imageName);
            $news->news_img = $imageName;
        }
        $news->news_title = $request->news_title;
        $news->news_content = $request->news_content;
        $news->status = $request->status;
        $news->save();
        return redirect()->route('news.index')->with('success', 'News Story created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = News::find($id);
        if ($banner->image) {
            $previousImagePath = public_path('uploads/news/' . $banner->news_img);
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }
        $banner->delete();
        return redirect()->route('news.index')->with('success', 'Brand deleted successfully');
    }
}
