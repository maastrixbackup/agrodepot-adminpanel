<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\NewsLetter;
use App\models\NewsletterTemplate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class NewsLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = NewsLetter::paginate(10);
        return view("newsLetters.list", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("newsLetters.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'news_name' => 'string|required',
            'news_email' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $newsletter = new NewsLetter();
        $newsletter->news_name = $request->input('news_name');
        $newsletter->news_email = $request->input('news_email');
        $newsletter->status = $request->input('status');
        $newsletter->created = Carbon::parse($newsletter->created)->format("d-m-Y");
       
        $newsletter->status = $request->input('status')? 1 : 0;
        $newsletter->save();

        //dd($newsletter);

        return redirect()->route('newsletters.index')->with('success', 'NewsLetter added successfully');
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
        $data = NewsLetter::find($id);
        return view("newsLetters.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $newsletter = NewsLetter::find($id);
        $newsletter->news_name = $request->input('news_name');
        $newsletter->news_email = $request->input('news_email');
        $newsletter->created = Carbon::parse($newsletter->created)->format("d-m-Y");
        $newsletter->status = $request->input('status')? 1 : 0;
        $newsletter->save();
        //dd($newsletter);
        return redirect()->route('newsletters.index')->with('success', 'NewsLetter updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = NewsLetter::find($id);
        $user->delete();
        return redirect()->route('newsletters.index')->with('success', 'NewsLetter deleted successfully');
    }

    public function updateStatus(Request $request, $Id)
    {
        $newsletter = NewsLetter::find($Id);
        $newsletter->status = $request->input('status');
        $newsletter->save();

        return response()->json(['message' => 'Status updated successfully', 'status' => $newsletter->status]);
    }

   
}
