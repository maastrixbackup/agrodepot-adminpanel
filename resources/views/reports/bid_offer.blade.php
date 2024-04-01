<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Bid Offers</h1>
        </div>

    </div>
    <table class="brandsTable table table-hover" id="cmspageslist">
        <thead>
            <tr>
                <th scope="col">SL#</th>
                <th scope="col">Bid By</th>
                <th scope="col">Piesa</th>
                <th scope="col">Price with vat</th>
                <th scope="col">Delivery</th>
                <th scope="col">Payment Methods</th>
                <th scope="col">Status</th>
                <th scope="col">Bid Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody id="brands_sortable">
            @foreach ($data as $index => $menu)
            <tr id="{{ $menu->bid_id  }}">
                <td scope="row">{{ $index + 1 }}</td>
                <td scope="row">{{ $menu->first_name }} {{ $menu->last_name }}</td>
                <td scope="row">{{ $menu->piece }}</td>
                <td scope="row">{{ $menu->price}} {{ $menu->currency}}</td>
                <td scope="row">

                    @php
                    $delivery = [];
                    @endphp

                    @if ($menu->personal_teaching == 1)
                    @php $delivery[] = 'Personal Teaching'; @endphp
                    @endif

                    @if ($menu->courier == 1 || $menu->free_courier == 1)
                    @if ($menu->free_courier == 1 && $menu->courier == 0)
                    @php $delivery[] = 'Free delivery by courier'; @endphp
                    @endif
                    @if ($menu->free_courier == 0 && $menu->courier == 1)
                    @php $delivery[] = 'Courier(' . $menu->courier_cost . ')'; @endphp
                    @endif
                    @endif

                    @if ($menu->roman_mail == 1 || $menu->free_roman_mail == 1)
                    @if ($menu->free_roman_mail == 1 && $menu->roman_mail == 0)
                    @php $delivery[] = 'Free delivery by Romanian mail'; @endphp
                    @endif
                    @if ($menu->free_roman_mail == 0 && $menu->roman_mail == 1)
                    @php $delivery[] = 'Romanian Mail(' . $menu->roman_mail_cost . ')'; @endphp
                    @endif
                    @endif

                    @if (!empty($delivery))
                    {{ implode(", ", $delivery) }}
                    @endif
                </td>
                <td scope="row">{{ $menu->payment_method}}</td>
                <td class="text-capitalize"><select name="status" class="form-select-sm bid-select" data-bid-id="{{ $menu->bid_id }}">
                        <option value="0" {{ $menu->sts == '0' ? 'selected' : '' }}>Approved</option>
                        <option value="1" {{ $menu->sts == '1' ? 'selected' : '' }}>Winning
                        </option>
                        <option value="2" {{ $menu->sts == '2' ? 'selected' : '' }}>Cancel
                        </option>
                    </select></td>
                <td scope="row">{{ $menu->created}}</td>
                <td>
                    <div class="d-flex">
                        <div class="customButtonContainer">

                            <a class="mx-2" href="{{ url('admin/bidoffer/' . $menu->bid_id) }}"><i class="fas fa-eye"></i></a>


                        </div>
                        <div class="customButtonContainer">
                            <a class="mx-2" href="{{ route('getParts', ['Id' => $menu->bid_id]) }}"><i class="fas fa-eye"></i></a>
                        </div>
                        <div class="customButtonContainer">
                            <!-- <form method="POST" action="{{ url('admin/bidoffer/' . $menu->bid_id) }}">@csrf
                                @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                            <button title="Delete" class="trash remove-bidoffer" data-id="{{ $menu->bid_id }}" data-action="{{ url('admin/bidoffer/' . $menu->bid_id) }}"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-bidoffer", function() {
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
                var bidId = $(this).data('bid-id');
                $.ajax({
                    url: '/admin/bidoffer/' + bidId + '/update-status',
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
    </script>
    <script>
        $('#cmspageslist').dataTable({
            "bPaginate": false
        });
    </script>

    {{$data->links()}}

</x-app-layout>