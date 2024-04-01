<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Categories</h1>
        </div>
        <div class="col-2"><a href="{{ route('categories.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <table class="table table-hover" id="cmspageslist">
        <thead>
            <tr>
                <th scope="col">SL#</th>
                <th scope="col">Category Name</th>
                <th scope="col">Parent</th>
                <th scope="col">Slug</th>
                <th scope="col" style="width: 200px;">Status</th>
                <th scope="col">Meta Description</th>
                <th scope="col">Meta Keywords</th>
                <th scope="col">Created</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $menu)
            <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td class="text-capitalize">{{ $menu->category_name }}</td>
                <td class="text-capitalize">{{ optional($menu->categoryName)->category_name }}</td>
                <td class="text-capitalize">{{ $menu->slug }}</td>
                <td>

                    <select name="status" class="form-select-sm status-select" data-cat-id="{{ $menu->category_id }}">
                        <option value="1" {{ $menu->status == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $menu->status == '0' ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </td>
                <td class="text-capitalize">{{ $menu->meta_description }}</td>
                <td class="text-capitalize">{{ $menu->meta_keywords }}</td>
                <td class="text-capitalize">{{ $menu->created }}</td>
                <td>
                    <div class="customButtonContainer"><a class="mx-2" href="{{ url('admin/categories/' . $menu->category_id . '/edit') }}"><i class="fas fa-edit"></i></a>
                    </div>
                    <!-- <form action="{{ url('admin/categories/' . $menu->category_id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-danger" onclick="return confirm('Are you sure you want to delete this category?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form> -->
                    <button title="Delete" class="btn btn-link text-danger trash remove-categories" data-id="{{ $menu->category_id }}" data-action="{{ url('admin/categories/' . $menu->category_id) }}"><i class="fas fa-trash"></i></button>
                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-categories", function() {
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
                var catId = $(this).data('cat-id');
                $.ajax({
                    url: '/admin/categories/' + catId + '/update-status',
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
    <script>
        let table = new DataTable('#cmspageslist');
    </script>

</x-app-layout>