<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Sales order</h1>
        </div>

    </div>
    <button class="scroll-btn scroll-left" onclick="scrollTable(-1)">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="scroll-btn scroll-right" onclick="scrollTable(1)">
        <i class="fas fa-chevron-right"></i>
    </button>
    <div class="custom-scrollbar" id="table-container">
        <table class="brandsTable table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">SL#</th>
                    <th scope="col">Ordered By</th>
                    <th scope="col">Ordered To</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Sales Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Delivery Status</th>
                    <th scope="col">Ordered Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="brands_sortable">
                @foreach ($data as $index => $menu)
                <tr id="{{ $menu->id  }}">
                    <td scope="row">{{ $index + 1 }}</td>
                    <td scope="row">{{ $menu->first_name }} {{ $menu->last_name }}</td>
                    <td scope="row">{{ optional(optional($menu->salesAdvertisement)->user)->first_name }}
                        {{ optional(optional($menu->salesAdvertisement)->user)->last_name }}
                    </td>
                    <td scope="row">{{ $menu->orderid}}</td>
                    <td scope="row">{{ $menu->adv_name}}</td>
                    <td scope="row">{{ $menu->qty}}</td>
                    <td scope="row">{{ $menu->totprice}}RON</td>
                    <td class="text-capitalize"><select name="status" class="form-select-sm order-select" data-ord-id="{{ $menu->id }}">
                            <option value="0" {{ $menu->status == '0' ? 'selected' : '' }}>New order</option>
                            <option value="1" {{ $menu->status == '1' ? 'selected' : '' }}>confirmed order
                            </option>
                            <option value="2" {{ $menu->status == '2' ? 'selected' : '' }}>completed order
                            </option>
                            <option value="3" {{ $menu->status == '3' ? 'selected' : '' }}>shipped order
                            </option>
                            <option value="4" {{ $menu->status == '4' ? 'selected' : '' }}>cancel Order
                            </option>
                        </select></td>
                    <td class="text-capitalize"><select name="delivery_status" class="form-select-sm delivery-select" data-del-id="{{ $menu->id }}">
                            <option value="0" {{ $menu->delivery_status == '0' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ $menu->delivery_status == '1' ? 'selected' : '' }}>Delivered
                            </option>
                        </select></td>

                    <td scope="row">{{ date('d/m/Y', strtotime($menu->created)) }}</td>
                    <td>
                        <div class="d-flex">
                            <div class="customButtonContainer">

                                <a class="edit-btn" title="Order Details" href="{{ url('admin/saleorder/' . $menu->id) }}"><i class="fas fa-eye"></i></a>
                            </div>
                            <div class="customButtonContainer">

                                <a class="edit-btn" title="Sales Details" href="{{ route('getOrders', ['Id' => $menu->id]) }}"><i class="fas fa-info-circle"></i></a>
                            </div>
                            <div class="customButtonContainer">
                                <!-- <form method="POST" action="{{ url('admin/saleorder/' . $menu->id) }}">@csrf
                                @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                                <button title="Delete" class="dl-btn trash remove-saleorder" data-id="{{ $menu->id }}" data-action="{{ url('admin/saleorder/' . $menu->id) }}"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-saleorder", function() {
                var current_object = $(this);
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this data!",
                    type: "error",
                    showCancelButton: true,
                    dangerMode: true,
                    cancelButtonClass: '#DD6B55',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Delete!',
                }, function(result) {
                    if (result) {
                        var action = current_object.attr('data-action');
                        var token = jQuery('meta[name="csrf-token"]').attr('content');
                        var id = current_object.attr('data-id');

                        $('body').html("<form class='form-inline remove-form' method='post' action='" + action + "'></form>");
                        $('body').find('.remove-form').append('<input name="_method" type="hidden" value="DELETE">');
                        $('body').find('.remove-form').append('<input name="_token" type="hidden" value="' + token + '">');
                        $('body').find('.remove-form').append('<input name="id" type="hidden" value="' + id + '">');
                        $('body').find('.remove-form').submit();
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('select[name="status"]').on('change', function() {
                var nameValue = $(this).val();
                var Id = $(this).data('ord-id');
                $.ajax({
                    url: '/admin/saleorder/' + Id + '/update-status',
                    method: 'POST',
                    data: {
                        status: nameValue
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('AJAX success:', response);
                        // Show success message in page body
                        $('.page-body').prepend('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            response.message +
                            '</div>');
                        // Automatically close the success message after 5 seconds
                        setTimeout(function() {
                            $('.alert-success').alert('close');
                        }, 5000);
                    },
                    error: function(error) {
                        console.error('AJAX error:', error);
                        // Show error message in alert
                        alert(error.responseJSON.message);
                    }
                });
            });
        });
        $(document).ready(function() {
            $('select[name="delivery_status"]').on('change', function() {
                var nameValue = $(this).val();
                var dId = $(this).data('del-id');
                $.ajax({
                    url: '/admin/saleorder/' + dId + '/update-deliverystatus',
                    method: 'POST',
                    data: {
                        delivery_status: nameValue
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('AJAX success:', response);
                        // Show success message in page body
                        $('.page-body').prepend('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            response.message +
                            '</div>');
                        // Automatically close the success message after 5 seconds
                        setTimeout(function() {
                            $('.alert-success').alert('close');
                        }, 5000);
                    },
                    error: function(error) {
                        console.error('AJAX error:', error);
                        // Show error message in alert
                        alert(error.responseJSON.message);
                    }
                });
            });
        });
    </script>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>
</x-app-layout>