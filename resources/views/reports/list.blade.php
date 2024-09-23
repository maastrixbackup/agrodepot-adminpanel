<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Ask Question Reports</h1>
        </div>

    </div>
    <div class="custom-scrollbar">
        <table class="brandsTable table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">SL#</th>
                    <th scope="col">Posted By</th>
                    <th scope="col">Sales Name</th>
                    <th scope="col">Question</th>
                    <th scope="col">Parent</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="brands_sortable">
                @foreach ($data as $index => $menu)
                    <tr id="{{ $menu->question_id }}">
                        <td scope="row">{{ $index + 1 }}</td>
                        <td scope="row">{{ $menu->first_name }}</td>
                        <td scope="row">{{ $menu->adv_id }}</td>
                        <td scope="row">{{ $menu->question }}</td>
                        <td scope="row">{{ optional($menu->parentQuestion)->question }}</td>
                        <td class="text-capitalize"><select name="status" class="form-select-sm qus-select"
                                data-qu-id="{{ $menu->question_id }}">
                                <option value="1" {{ $menu->status == '1' ? 'selected' : '' }}>Active</option>
                                <option value="2" {{ $menu->status == '2' ? 'selected' : '' }}>Inactive
                                </option>
                            </select></td>
                        <td scope="row">{{ $menu->created }}</td>
                        <td>
                            <div class="d-flex">
                                <div class="customButtonContainer">

                                    <a class="edit-btn" title="Edit"
                                        href="{{ url('admin/reports/' . $menu->question_id) }}"><i
                                            class="fas fa-eye"></i></a>
                                </div>
                                <div class="customButtonContainer">
                                    <!-- <form method="POST" action="{{ url('admin/reports/' . $menu->question_id) }}">@csrf
                                    @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                                    <button title="Delete" class="dl-btn trash remove-reports"
                                        data-id="{{ $menu->question_id }}"
                                        data-action="{{ url('admin/reports/' . $menu->question_id) }}"><i
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
        $(document).ready(function() {
            $("body").on("click", ".remove-reports", function() {
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
        $(document).ready(function() {
            $('select[name="status"]').on('change', function() {
                var nameValue = $(this).val();
                var qusId = $(this).data('qu-id');
                $.ajax({
                    url: '/admin/reports/' + qusId + '/update-status',
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
                        $('.page-body').prepend(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
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

    <script>
        let table = new DataTable('#cmspageslist');
    </script>

</x-app-layout>
