<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Credits</h1>
        </div>
        <div class="col-2"><a href="{{ route('admin-users.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <div class="custom-scrollbar">
        <table class="table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">SL#</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Last Transaction ID</th>
                    <th scope="col">Total Credits</th>
                    <th scope="col">Credits Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $menu)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td class="text-capitalize">{!! $menu->first_name !!}</td>
                        <td class="text-capitalize">{!! $menu->transfer_id !!}</td>
                        <td class="text-capitalize">{!! $menu->credits !!}</td>
                        <td class="text-capitalize">{!! $menu->created !!}</td>
                        <td>
                            <div class="d-flex customButtonContainer">
                                <!-- <form method="POST" action="{{ url('admin/credits/' . $menu->credit_id) }}">@csrf
                                @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                                <a class="edit-btn" title="Add Credits"
                                    href="{{ url('admin/credits/' . $menu->credit_id . '/edit') }}"><i
                                        class="fas fa-plus"></i></a>

                                <a class="edit-btn" title="All Credits List"
                                    href="{{ url('admin/credits/' . $menu->user_id) }}"><i class="fas fa-list"></i></a>

                                <button title="Delete" class="dl-btn trash remove-credits"
                                    data-id="{{ $menu->credit_id }}"
                                    data-action="{{ url('admin/credits/' . $menu->credit_id) }}"><i
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
            $("body").on("click", ".remove-credits", function() {
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
