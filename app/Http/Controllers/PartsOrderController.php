<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PartsOrder;
use Illuminate\Support\Facades\DB;
class PartsOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PartsOrder::with('user')
        ->leftjoin('bid_offers as bo','parts_order.bid_id','=','bo.bid_id')
        ->leftjoin('master_users as ms','bo.user_id','=','ms.user_id')
        ->leftjoin('request_accessories as ra','ra.part_id','=','parts_order.parts_id')
        ->select('parts_order.*','bo.first_name','bo.last_name','ra.name_piece')
        ->paginate(10);
        return view("reports.request_parts_order", compact("data"));
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

        $order = PartsOrder::find($id);
        return view("reports.parts_order_show", compact("order"));
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
        $parts = PartsOrder::find($id);
        $parts->delete();
        return redirect()->route('request_parts_order.index')->with('success', 'parts deleted successfully');
    }
}
