<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Icons</h1>
        </div>
        <div class="col-2"><a href="{{ route('seofields.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <div class="custom-scrollbar">
        <table class="brandsTable table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Social Name</th>
                    <th scope="col">Social Image</th>
                    <th scope="col">Social Link</th>
                    <th scope="col">Order No</th>
                    <th scope="col">Created</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="brands_sortable">
                @foreach ($data as $index => $menu)
                    <tr id="{{ $menu->social_id }}">
                        <td scope="row">{{ $index + 1 }}</td>
                        <td scope="row">{{ $menu->social_name }}</td>
                        <td scope="row"><img src="{{ asset('uploads/socialicon/' . $menu->social_img) }}"
                                height="30px" width="30px"></td>
                        <td scope="row">{{ $menu->social_link }}</td>
                        <td scope="row">{{ $menu->orderno }}</td>
                        <td scope="row">{{ $menu->created }}</td>
                        <td>
                            <div class="d-flex customButtonContainer">
                                <a class="edit-btn" title="Edit"
                                    href="{{ url('admin/socialicons/' . $menu->social_id . '/edit') }}"><i
                                        class="fas fa-edit"></i></a>
                                <!-- <form method="POST" action="{{ url('admin/socialicons/' . $menu->social_id) }}">@csrf
                                    @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                                <a class="edit-btn" title="View"
                                    href="{{ url('admin/socialicons/' . $menu->social_id) }}"><i
                                        class="fas fa-eye"></i></a>

                                <button title="Delete" class="dl-btn trash remove-socialicons"
                                    data-id="{{ $menu->social_id }}"
                                    data-action="{{ url('admin/socialicons/' . $menu->social_id) }}"><i
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
            $("body").on("click", ".remove-socialicons", function() {
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
