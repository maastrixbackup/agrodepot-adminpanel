<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BidQuestion;
use App\Models\BidImg;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = BidQuestion::with('receiver')

            ->leftjoin('master_users as ms', 'bid_question.user_id', '=', 'ms.user_id')
            ->leftjoin('bid_offers as bo', 'bid_question.bidid', '=', 'bo.bid_id')
            ->leftjoin('request_accessories as ra', 'bid_question.request_id', '=', 'ra.request_id')
            ->select('bid_question.*', 'ms.first_name', 'bo.piece', 'ra.description as desc')
            ->paginate(10);

        return view("reports.ask_seller", compact("data"));
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
        $image = BidImg::find($id);

        // if (!$image) {
        //     abort(404); // Image not found
        // }

        return view('reports.view_seller', compact('image'));
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
        $seller = BidQuestion::find($id);
        $seller->delete();
        return redirect()->route('sellers.index')->with('success', 'Sellers deleted successfully');
    }

    public function updateStatus(Request $request, $sellId)
    {
        $seller = BidQuestion::find($sellId);
        $seller->status = $request->input('status');
        $seller->save();

        return response()->json(['message' => 'Status updated successfully', 'status' => $seller->status]);
    }
}
