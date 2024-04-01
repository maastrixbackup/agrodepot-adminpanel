<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">Sales Order Details</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Order ID</td>
                <td>{{ $data->orderid }} </td>
                  
            </tr>
            <tr>
                <td>Ordered By</td>
                <td>{{ $data->first_name }} {{ $data->last_name }}</td>
            </tr>
            <tr>
                <td>Sales Name</td>
                <td>{{ $data->adv_name}}</td>
            </tr>
            <tr>
                <td>Quantity</td>
                <td>{{ $data->qty}}</td>
            </tr>
            <tr>
                <td>Price</td>
                <td>{{ $data->totprice}}</td>
            </tr>
            <tr>
                <td>Delivery Method</td>
                <td>{{ $data->delivery_method}}</td>
            </tr>
            <tr>
                <td>Billing Details
                </td>
                <td>{{ $data->validity}}</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>{{ $data->fname}} {{ $data->lname}}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>{{ $data->phone}}</td>
            </tr>
            <tr>
                <td>Country</td>
                <td>{{ $data->county}}</td>
            </tr>
            <tr>
                <td>City</td>
                <td>{{ $data->location}}</td>
            </tr>
            <tr>
                <td>Post Code</td>
                <td>{{ $data->postcode}}</td>
            </tr>
            <tr>
                <td>Delivery Address</td>
                <td>{{ $data->delivery_add}}</td>
            </tr>
            <tr>
                <td>Notes Command</td>
                <td>{{ $data->note_command}}</td>
            </tr>
            <tr>
                <td>Delivery Status</td>
                <td>@if($data->delivery_status == 1)
                    Delivered
                 @else
                    Pending
                 @endif</td>
            </tr>
            <tr>
                <td>Ordered Date</td>
                <td>{{ $data->created}}</td>
            </tr>
        </thead>
       
    </table>
    

</x-app-layout>
