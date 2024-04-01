<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Admin</h1>
        </div>
        <div class="col-2"><a href="{{ route('admin-users.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <table class="table table-hover" id="cmspageslist">
        <thead>
            <tr>
                <th scope="col">SL#</th>
                <th scope="col">Full Name</th>
                <th scope="col">Mail</th>
                <th scope="col">User ID</th>
                <th scope="col">Active ?</th>
                <th scope="col">Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $menu)


            <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td class="text-capitalize">{!! $menu->full_name !!}</td>
                <td class="text-capitalize">{!! $menu->mail_id !!}</td>
                <td class="text-capitalize">{!! $menu->user_id !!}</td>
                <td class="text-capitalize">@if($menu->is_active == 1)
                    Active
                    @else
                    Inactive
                    @endif
                <td class="text-capitalize">{!! $menu->created_at !!}</td>
                <td>
                    <div class="d-flex">
                        <div class="customButtonContainer"><a class="mx-2" href="{{ url('admin/admin-users/' . $menu->uid . '/edit') }}"><i class="fas fa-edit"></i></a>
                            <a class="mx-2" href="{{ url('admin/admin-users/' . $menu->uid) }}"><i class="fas fa-eye"></i></a>
                        </div>
                        <div class="customButtonContainer">
                            <!-- <form method="POST" action="{{ url('admin/admin-users/' . $menu->uid) }}">@csrf
                                    @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                            <button title="Delete" class="trash remove-adminuser" data-id="{{ $menu->uid }}" data-action="{{ url('admin/admin-users/' . $menu->uid) }}"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-adminuser", function() {
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