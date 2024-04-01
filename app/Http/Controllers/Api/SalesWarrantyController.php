<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesWarranty;

class SalesWarrantyController extends Controller
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
        $objSalesWarrenty = SalesWarranty::where('user_id', $request->user_id)->first();
      
        
        if (!$objSalesWarrenty) {
            $objSalesWarrenty = new SalesWarranty();
            $objSalesWarrenty->created = date('Y-m-d h:m:s');
        }

        $method_return_accepted = $request->method_return_accepted;
        $method_return_accepted_implode = implode(", ", $method_return_accepted);

        $payment_methods = $request->payment_methods;
        $payment_methods_implode = implode(", ", $payment_methods);

        

        $objSalesWarrenty->user_id = $request->user_id;
        $objSalesWarrenty->disclaimer_of_warranty = $request->disclaimer_of_warranty;
        $objSalesWarrenty->discaimer_warranty_mth = $request->discaimer_warranty_mth;
        $objSalesWarrenty->terms_of_warranty = $request->terms_of_warranty;
        $objSalesWarrenty->return_policy = $request->return_policy;

        $objSalesWarrenty->return_policy_days = $request->return_policy_days;
        $objSalesWarrenty->method_return_accepted =  $method_return_accepted_implode;
        $objSalesWarrenty->transportation_cost = $request->transportation_cost;
        $objSalesWarrenty->return_policy_info = $request->return_policy_info;
        $objSalesWarrenty->personal_teaching = $request->personal_teaching;

        $objSalesWarrenty->courier = $request->courier;
        $objSalesWarrenty->courier_cost = $request->courier_cost;
        $objSalesWarrenty->free_courier = $request->free_courier;
        $objSalesWarrenty->romanian_mail = $request->romanian_mail;
        $objSalesWarrenty->romanian_cost = $request->romanian_cost;
        $objSalesWarrenty->free_romanian = $request->free_romanian;

        $objSalesWarrenty->time_required = $request->time_required;
        $objSalesWarrenty->sending_package = $request->sending_package;
        $objSalesWarrenty->payment_methods = $payment_methods_implode;
        $objSalesWarrenty->product_condition = $request->product_condition;
        $objSalesWarrenty->invoice = $request->invoice;
        $objSalesWarrenty->message_response = $request->message_response;
        $objSalesWarrenty->message_content = $request->message_content;

       
        $objSalesWarrenty->modified = date('Y-m-d h:m:s');

        if ($objSalesWarrenty->save()) {
            return response()->json(['message' => 'Data Save Succesfully'], 200);
        } else {
            return response()->json(['message' => 'Something went wrong !! Please Try Again Later .'], 401);
        }
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
