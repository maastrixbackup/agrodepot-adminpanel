<div class="modal" id="parts_order">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Order Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
         <table class="table table-bordered">
            <thead>
                <tr>
                   <td>Order ID</td>
                   <td>{{$order->orderid}}</td>
                 </tr>
                 
               </thead>
            <tbody>
                <tr>
                    <td>Bidder</td>
                    <td>{{ optional($data->user)->first_name}} {{  optional($data->user)->last_name}}</td>
                </tr>
                <tr>
                    <td>Shipping Name</td>
                    <td>{{$data->fname }}{{$data->lname }}</td>
                </tr>
                <tr>
                    <td>County</td>
                    <td>{{$data->county }}</td>
                </tr>
                <tr>
                    <td>Location</td>
                    <td>{{$data->location }}</td>
                </tr>
                <tr>
                    <td>Postal Code</td>
                    <td>{{$data->postcode }}</td>
                </tr>
                <tr>
                    <td>Delivery Method</td>
                    <td>@if($partsOrder['delivery_method'] == "Personal Teaching")
                        @if($personal_teaching == 1)
                            Personal Teaching
                        @endif
                    @elseif($partsOrder['delivery_method'] == "courier")
                        @if($courier == 1 || $free_courier == 1)
                            @php
                                if($free_courier == 1) {
                                    $cost = 'free shipping';
                                } else {
                                    $cost = $courier_cost . ' RON';
                                }
                            @endphp
                            Courier({{ $cost }})
                        @endif
                    @elseif($partsOrder['delivery_method'] == "roman")
                        @if($romanian_mail == 1 || $free_romanian_mail == 1)
                            @php
                                if($free_romanian_mail == 1) {
                                    $rcost = 'free shipping';
                                } else {
                                    $rcost = $romanian_mail_cost . ' RON';
                                }
                            @endphp
                            Romanian Mail({{ $rcost }})
                        @endif
                    @endif
                    </td>
                </tr>
                <tr>
                    <td>Delivery Address</td>
                    <td>{{$data->delivery_add }}</td>
                </tr>
            </tbody>
         </table>
        </div>
  
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
  
      </div>
    </div>
</div>
