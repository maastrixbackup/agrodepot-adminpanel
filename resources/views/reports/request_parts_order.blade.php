<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Request Parts Reports</h1>
        </div>

    </div>
    <div class="custom-scrollbar">
        <table class="brandsTable table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">SL#</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Order By</th>
                    <th scope="col">Bidder</th>
                    <th scope="col">Request Parts</th>
                    <th scope="col">Price</th>
                    <th scope="col">Telephone</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ordered Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="brands_sortable">
                @foreach ($data as $index => $menu)
                    <tr id="{{ $menu->request_id }}">
                        <td scope="row">{{ $index + 1 }}</td>
                        <td scope="row">{{ $menu->orderid }}</td>
                        <td scope="row">{{ optional($menu->user)->first_name }}
                            {{ optional($menu->user)->last_name }}
                        </td>
                        <td scope="row">{{ $menu->first_name }} {{ $menu->last_name }}</td>
                        <td scope="row">{{ $menu->name_piece }}</td>
                        <td scope="row">{{ $menu->totprice }}</td>
                        <td scope="row">{{ $menu->phone }}</td>
                        <td scope="row">
                            @if ($menu->status == 0)
                                Confirmed Order
                            @endif
                        </td>

                        <td scope="row">{{ date('d/m/Y', strtotime($menu->created)) }}</td>
                        <td>
                            <div class="d-flex customButtonContainer">
                                <!-- <form method="POST" action="{{ url('admin/requestparts/' . $menu->id) }}">@csrf
                                @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->

                                <a class="edit-btn" title="View" data-toggle="modal" data-target="#parts_order"
                                    href="{{ url('admin/requestparts/' . $menu->id) }}"><i class="fas fa-eye"></i></a>
                                <button title="Delete" class="dl-btn trash remove-requestparts"
                                    data-id="{{ $menu->id }}"
                                    data-action="{{ url('admin/requestparts/' . $menu->id) }}"><i
                                        class="fas fa-trash"></i></button>
                            </div>

                        </td>
                    </tr>
                @endforeach



            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-requestparts", function() {
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

                        $('body').html(
                            "<form class='form-inline remove-form' method='post' action='" +
                            action + "'></form>");
                        $('body').find('.remove-form').append(
                            '<input name="_method" type="hidden" value="DELETE">');
                        $('body').find('.remove-form').append(
                            '<input name="_token" type="hidden" value="' + token + '">');
                        $('body').find('.remove-form').append(
                            '<input name="id" type="hidden" value="' + id + '">');
                        $('body').find('.remove-form').submit();
                    }
                });
            });
        });
    </script>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>
</x-app-layout>
