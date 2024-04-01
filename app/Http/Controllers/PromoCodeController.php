<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $promo = PromoCode::all();
        return view("promoCodes.list", compact("promo"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("promoCodes.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $promoCode = new PromoCode();
        $promoCode->title = $request->title;
        $promoCode->code = $request->code;
        $promoCode->type = $request->type;
        $promoCode->value = $request->value;
        $promoCode->expiry_date = $request->expiry_date;
        $promoCode->status = $request->status;
        $promoCode->save();
        return redirect()->route('promo-codes.index')->with('success', 'Promo code added successfully');
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
        $code = PromoCode::find($id);

        return view("promoCodes.edit", compact("code"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $promoCode = PromoCode::find($id);
        $promoCode->title = $request->title;
        $promoCode->code = $request->code;
        $promoCode->type = $request->type;
        $promoCode->value = $request->value;
        $promoCode->expiry_date = $request->expiry_date;
        $promoCode->status = $request->status;
        $promoCode->save();

        return Redirect::route('promo-codes.index')->with('status', 'profile-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = PromoCode::find($id);

        $page->delete();
        return redirect()->route('promo-codes.index')->with('success', 'Promo code deleted successfully');
    }
}
