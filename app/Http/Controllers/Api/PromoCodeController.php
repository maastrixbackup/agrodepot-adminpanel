<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function apply(Request $request)
    {
        $totalPrice = (int)$request->totalPrice;
        $newPrice = 0;
        $enteredCode = $request->code;
        $code = PromoCode::where('code', $enteredCode)->first();

        if (!$code) {
            return response()->json(['message' => 'Promo code not valid', 'status' => 'error']);
        }

        if ($code->type == 1) {
            $discount = ($code->value / 100) * $totalPrice;
            $newPrice = $totalPrice - $discount;
        } else {
            $newPrice = $totalPrice - $code->value;
        }

        return response()->json(['newPrice' => $newPrice, 'status' => 'success', "promoCode" => $enteredCode]);
    }

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
