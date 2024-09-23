<x-app-layout>
    <div class="row">

        <div class="col-8">
            <h1 class="text-center mb-3">Manage Compose Mail</h1>
        </div>
        <div class="col-4 text-end"><a href="{{ route('compose-mail.create') }}" class="btn btn-primary">Compose Mail</a>
        </div>
    </div>
    <div class="custom-scrollbar">
        <table class="brandsTable table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">SL#</th>
                    <th scope="col">User Type</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="brands_sortable">
                @foreach ($data as $index => $menu)
                    <tr id="{{ $menu->news_letter_id }}">
                        <td scope="row">{{ $index + 1 }}</td>
                        <td scope="row">
                            @if ($menu->user_type == 3)
                                Subscriber
                            @elseif($menu->user_type == 2)
                                Seller
                            @elseif($menu->user_type == 1)
                                Buyer
                            @endif
                        </td>
                        <td scope="row">{{ $menu->mail_subject }}</td>
                        <td scope="row">
                            @if ($menu->compose_status == 1)
                                Active
                            @elseif($menu->compose_status == 0)
                                Inactive
                            @endif
                        </td>

                        <td>
                            <div class="d-flex customButtonContainer">
                                <a class="edit-btn" title="Edit"
                                    href="{{ url('admin/compose-mail/' . $menu->compose_id . '/edit') }}"><i
                                        class="fas fa-edit"></i></a>
                                <!-- <form method="POST" action="{{ url('admin/compose-mail/' . $menu->compose_id) }}">@csrf
                                @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                                <button title="Delete" class="dl-btn trash remove-composemail"
                                    data-id="{{ $menu->compose_id }}"
                                    data-action="{{ url('admin/compose-mail/' . $menu->compose_id) }}"><i
                                        class="fas fa-trash"></i></button>
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
            $("body").on("click", ".remove-composemail", function() {
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
