<x-app-layout>
    <style>
        .table-scroll {
            width: 100%;
            overflow: auto;
        }
    </style>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Sales</h1>
        </div>
        <div class="col-2"><a href="{{ route('memberships.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <div class="table-scroll">
        <table class="brandsTable table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Membership Type</th>
                    <th scope="col">Price</th>
                    <th scope="col">Credits</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="brands_sortable">
                @foreach ($data as $index => $menu)
                <tr id="{{ $menu->memb_id }}">
                    <td scope="row">{{ $index + 1 }}</td>
                    <td scope="row">{{ $menu->memb_type }}</td>
                    <td scope="row">{{ $menu->price }}</td>
                    <td scope="row">{{ $menu->credits }}</td>
                    <td scope="row"><select name="status" class="form-select-sm act-select" data-mem-id="{{ $menu->memb_id }}">
                            <option value="1" {{ $menu->status == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $menu->status == '0' ? 'selected' : '' }}>Inactive
                            </option>
                        </select></td>
                    <td scope="row">{{ $menu->created }}</td>

                    <td>
                        <div class="d-flex">
                            <div class="customButtonContainer"><a class="mx-2" href="{{ url('admin/memberships/' . $menu->memb_id . '/edit') }}"><i class="fas fa-edit"></i></a>
                            </div>
                            <div class="customButtonContainer">
                                <!-- <form method="POST" action="{{ url('admin/memberships/' . $menu->memb_id) }}">@csrf
                                    @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                                <button title="Delete" class="trash remove-membership" data-id="{{ $menu->memb_id }}" data-action="{{ url('admin/memberships/' . $menu->memb_id) }}"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $('#cmspageslist').dataTable({
            "bPaginate": false
        });
    </script>


    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-membership", function() {
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
                var memId = $(this).data('mem-id');
                $.ajax({
                    url: '/admin/memberships/' + memId + '/update-status',
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
</x-app-layout>