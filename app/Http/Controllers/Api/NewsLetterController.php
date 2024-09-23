<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Models\NewsLetter;
use Carbon\Carbon;
use App\Mail\NewsLetterSubscription;

class NewsLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'user_name' => 'required|string|max:150',
            'email' => 'required|string|email|max:150',
        ]);

        $existingNewsletter = NewsLetter::where('news_email', $request->input('email'))->first();

        if ($existingNewsletter) {
            return response()->json([
                'success' => false,
                'message' => 'Email is already subscribed to the newsletter.',
            ], 409); // 409 Conflict
        }

        $newsletter = NewsLetter::create([
            'news_name' => $request->input('user_name'),
            'news_email' => $request->input('email'),
            'status' => 0,
            'created' => Carbon::now(),
        ]);

        Mail::to($request->input('email'))->send(new NewsLetterSubscription($request->input('user_name')));

        return response()->json([
            'success' => true,
            'message' => 'Newsletter subscription created successfully.',
            'data' => $newsletter,
        ], 201);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
