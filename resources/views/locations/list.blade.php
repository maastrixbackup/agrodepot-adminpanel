<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Locations</h1>
        </div>
        <div class="col-2"><a href="{{ route('locations.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <table class="brandsTable table table-hover" id="cmspageslist">
        <thead>
            <tr>
                <th scope="col">SL#</th>
                <th scope="col">County</th>
                <th scope="col">Location</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody id="brands_sortable">
            @foreach ($data as $index => $menu)
            <tr id="{{ $menu->location_id  }}">
                <td scope="row">{{ $index + 1 }}</td>
                <td scope="row">{{ $menu->country->country_name }}</td>
                <td scope="row">{{ $menu->location_name }}</td>
                <td>
                    <div class="d-flex">
                        <div class="customButtonContainer"><a class="mx-2" href="{{ url('admin/locations/' . $menu->location_id . '/edit') }}"><i class="fas fa-edit"></i></a>
                        </div>
                        <div class="customButtonContainer">
                            <!-- <form method="POST" action="{{ url('admin/locations/' . $menu->location_id) }}">@csrf
                                @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                            <button title="Delete" class="trash remove-location" data-id="{{ $menu->location_id }}" data-action="{{ url('admin/locations/' . $menu->location_id) }}"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-location", function() {
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
        let table = new DataTable('#cmspageslist');
    </script>


</x-app-layout>