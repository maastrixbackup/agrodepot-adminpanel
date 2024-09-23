<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Users</h1>
        </div>
        <div class="col-2"><a href="{{ route('themes.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <div class="custom-scrollbar">
        <table class="brandsTable table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">Theme</th>
                    <th scope="col">Tag</th>
                    <th scope="col">Font Size</th>
                    <th scope="col">Font Color</th>
                    <th scope="col">Created</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="brands_sortable">
                @foreach ($data as $index => $menu)
                    <tr id="{{ $menu->theme_id }}">
                        <td scope="row">{{ $index + 1 }}</td>
                        <td scope="row">{{ $menu->html_tag }}</td>
                        <td scope="row">{{ $menu->font_size }}</td>
                        <td scope="row">{{ $menu->font_color }}</td>
                        <td scope="row">{{ $menu->created }}</td>

                        <td>
                            <div class="d-flex">
                                <div class="customButtonContainer">
                                    <a class="edit-btn" title="Edit"
                                        href="{{ url('admin/themes/' . $menu->theme_id . '/edit') }}"><i
                                            class="fas fa-edit"></i>
                                    </a>
                                </div>
                                <div class="customButtonContainer">
                                    <!-- <form method="POST" action="{{ url('admin/themes/' . $menu->theme_id) }}">@csrf
                                    @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                                    <button title="Delete" class="dl-btn trash remove-themes"
                                        data-id="{{ $menu->theme_id }}"
                                        data-action="{{ url('admin/themes/' . $menu->theme_id) }}"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        let table = new DataTable('#cmspageslist');
    </script>

    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-themes", function() {
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
</x-app-layout>
