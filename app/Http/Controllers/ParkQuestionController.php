<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkQuestion;
use App\Models\ParkImg;
use Illuminate\Support\Facades\DB;

class ParkQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ParkQuestion::get();
        return view("reports.park_question", compact("data"));
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
        $images = DB::table('park_question as pq')
        ->leftjoin('park_imgs as pi','pq.park_id','=','pi.park_id')
        ->select('img_path')
        ->where('pq.qid',$id)
        ->get();

       
    
        return view('reports.park_show', compact('images'));
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
        $park = ParkQuestion::find($id);
        
        $park->delete();
        return redirect()->route('parkquestion.index')->with('success', 'ParkQuestion deleted successfully');
    }
}
