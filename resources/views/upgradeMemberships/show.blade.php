<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Admin User Detail</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Transaction ID</td>
                <td>{{ $randomKey }}</td>
                  
            </tr>
            <tr>
                <td>Member Type</td>
                <td>{{$membership->memb_type}}</td>
            </tr>
            <tr>
                <td>Payment Method</td>
                <td>{{$membership->payment_method}}</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>{{$membership->name}}</td>
            </tr>
            <tr>
                <td>Email Address</td>
                <td>{{$membership->email}}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>{{$membership->phone}}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>{{$membership->address}}</td>
            </tr>
            <tr>
                <td>County</td>
                <td>{{$membership->county}}</td>
            </tr>
            <tr>
                <td>City</td>
                <td>{{$membership->city}}</td>
            </tr>
            <tr>
                <td>Zip</td>
                <td>{{$membership->zip}}</td>
            </tr>

            <tr>
                <td>Payment Status</td>
                <td>@if($membership->payment_status == 1)
                    Paid
                 @else
                    Pending
                 @endif</td>
            </tr>
            <tr>
                <td>Amount</td>
                <td>{{$membership->price}}</td>
            </tr>
            <tr>
                <td>Credits</td>
                <td>{{$membership->credit}}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>@if($membership->plan_status == 1)
                    Approved
                 @else
                    Pending
                 @endif</td>
            </tr>
            <tr>
                <td>Date</td>
                <td>{{$membership->created}}</td>
            </tr>
        </thead>
       
    </table>
    

</x-app-layout>
