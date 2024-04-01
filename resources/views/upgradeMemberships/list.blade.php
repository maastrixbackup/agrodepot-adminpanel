<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Memberships Payments</h1>
        </div>
        
    </div>
    <table class="brandsTable table table-hover" id="cmspageslist">
        <thead>
            <tr>
                <th scope="col">SL#</th>
                <th scope="col">User Name</th>
                <th scope="col">Membership Plan</th>
                <th scope="col">Current Plan</th>
                <th scope="col">Payment Status</th>
                <th scope="col">Transaction ID</th>
                <th scope="col">Status</th>
                <th scope="col">Amount</th>
                <th scope="col">Credits</th>
                <th scope="col">Date</th>
                <th scope="col">Actions</th>    
            </tr>
        </thead>
        <tbody id="brands_sortable">
            @foreach ($data as $index => $menu)
                <tr id="{{ $menu->upgrade_id  }}">
                    <td scope="row">{{ $index + 1 }}</td>
                    <td scope="row">{{ $menu->name }}</td>
                    <td scope="row">{{ $menu->memb_type }}</td>
                    <td scope="row">@if($menu->upgrade_id > 0)
                        <img src="{{ asset('images/success_icon.png') }}" alt="current" />
                    @else
                        <img src="{{ asset('images/cancel_icon.png') }}" alt="Expired" />
                    @endif
                    &nbsp;</td>
                    <td scope="row">@if($menu->payment_status == 1)
                        Paid
                     @else
                        Pending
                     @endif</td>
                  
                    <td scope="row">{{ $menu->transfer_id }}</td>
                    <td scope="row">@if($menu->plan_status == 1)
                        Approved
                     @else
                        Pending
                     @endif</td>
                    <td scope="row">{{ $menu->price}}</td>
                    <td scope="row">{{ $menu->credit}}</td>
                    <td scope="row">{{ $menu->created}}</td>
                    <td>
                        <div class="d-flex">
                            <div class="customButtonContainer">

                                        <a class="mx-2" href="{{ url('admin/upgrade-memberships/' . $menu->upgrade_id) }}"><i class="fas fa-eye"></i></a>
                            </div>
                            <div class="customButtonContainer">
                                <form method="POST" action="{{ url('admin/upgrade-memberships/' . $menu->upgrade_id) }}">@csrf
                                    @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form>
                            </div>
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        $('#cmspageslist').dataTable({
            "bPaginate": false
        });
    </script>
 
</x-app-layout>
