<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Advertisement</h1>
        </div>
        <div class="col-2"><a href="{{ route('advertises.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <table class="table table-hover" id="cmspageslist">
        <thead>
            <tr>
                <th scope="col">SL#</th>
                <th scope="col">Title</th>
                <th scope="col">Ad Type</th>
                <th scope="col">Show Position</th>
                <th scope="col">Status</th>
                <th scope="col">Created</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $menu)
            <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td class="text-capitalize">{!! $menu->title !!}</td>
                <td class="text-capitalize"> @if($menu->ad_type == 1)
                    Banner
                    @else
                    Script
                    @endif
                </td>
                <td class="text-capitalize">
                    @if($menu->show_position == 1)
                    Top
                    @elseif($menu->show_position == 2)
                    left1
                    @elseif($menu->show_position == 3)
                    left2
                    @elseif($menu->show_position == 4)
                    Middle
                    @else
                    Unknown Position
                    @endif
                </td>
                <td class="text-capitalize"><select name="status" class="form-select-sm ad-select" data-ad-id="{{ $menu->ad_id }}">
                        <option value="1" {{ $menu->status == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $menu->status == '0' ? 'selected' : '' }}>Inactive
                        </option>
                    </select></td>
                <td class="text-capitalize">{!! $menu->created !!}</td>
                <td>
                    <div class="d-flex">
                        <div class="customButtonContainer"><a class="mx-2" href="{{ url('admin/advertises/' . $menu->ad_id . '/edit') }}"><i class="fas fa-edit"></i></a>

                        </div>
                        <div class="customButtonContainer">
                            <!-- <form method="POST" action="{{ url('admin/advertises/' . $menu->ad_id) }}">@csrf
                                    @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->

                            <button title="Delete" class="trash remove-advertise" data-id="{{ $menu->ad_id }}" data-action="{{ url('admin/advertises/' . $menu->ad_id) }}"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>
    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-advertise", function() {
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
                var advId = $(this).data('ad-id');
                $.ajax({
                    url: '/admin/advertises/' + advId + '/update-status',
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