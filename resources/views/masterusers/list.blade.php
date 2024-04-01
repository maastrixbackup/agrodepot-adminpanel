<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Users</h1>
        </div>
        <div class="col-2"><a href="{{ route('users.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <div>
        <h3 style='display:inline;'>Total User: {{$totalUser}}</h3>&nbsp;&nbsp;&nbsp;
        <h3 style='color:red;display:inline;'>Total Buyer: {{$totalBuyer}}
        </h3>&nbsp;&nbsp;&nbsp;
        <h3 style='color:green;display:inline;'>Total Seller: {{$totalSeller}} </h3>&nbsp;&nbsp;&nbsp;

    </div>
    <table class="brandsTable table table-hover" id="cmspageslist">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Telephone</th>
                <th scope="col">User Type</th>
                <th scope="col">Status</th>
                <th scope="col">Set Premium</th>
                <th scope="col">Registration Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody id="brands_sortable">
            @foreach ($data as $index => $menu)
            <tr id="{{ $menu->user_id }}">
                <td scope="row">{{ $index + 1 }}</td>
                <td scope="row">{{ $menu->first_name }}{{ $menu->last_name }}</td>
                <td scope="row">{{ $menu->email }}</td>
                <td scope="row">{{ $menu->telephone1 }}</td>
                <td scope="row">{{ optional($menu->userType)->user_type }}</td>
                <td scope="row">{{ $menu->is_active }}</td>
                <td scope="row">{{ $menu->is_premium }}</td>
                <td scope="row">{{ $menu->created_at }}</td>

                <td>
                    <div class="d-flex">
                        <div class="customButtonContainer"><a class="mx-2" href="{{ url('admin/users/' . $menu->user_id . '/edit') }}"><i class="fas fa-edit"></i></a>
                        </div>
                        <div class="customButtonContainer">
                            <!-- <form method="POST" action="{{ url('admin/users/' . $menu->user_id) }}">@csrf
                                @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                            <button title="Delete" class="trash remove-masteruser" data-id="{{ $menu->user_id }}" data-action="{{ url('admin/users/' . $menu->user_id) }}"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $data->onEachSide(3)->links() }}

    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-masteruser", function() {
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
        $('#cmspageslist').dataTable({
            "bPaginate": false
        });
    </script>
</x-app-layout>