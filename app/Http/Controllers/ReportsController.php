<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesQuestion;
use App\Models\SalesquestionImage;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SalesQuestion::with('parentQuestion')
              ->leftjoin('master_users as ms','sales_questions.user_id','=','ms.user_id')
              ->select('sales_questions.*','ms.first_name')
              ->where('sales_questions.parent', '=', 0)
              ->get();
        return view("reports.list", compact("data"));
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
        $image = SalesquestionImage::find($id);

        if (!$image) {
            abort(404); // Image not found
        }
    
        return view('reports.show', compact('image'));
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
        $report = SalesQuestion::find($id);
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'Reports deleted successfully');
    }

    public function updateStatus(Request $request, $qusId)
    {
        $category = SalesQuestion::find($qusId);
        $category->status = $request->input('status');
        $category->save();

        return response()->json(['message' => 'Status updated successfully', 'status' => $category->status]);
    }
}
