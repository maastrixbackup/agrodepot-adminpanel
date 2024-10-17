<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Categories</h1>
        </div>
        <div class="col-2"><a href="{{ route('categories.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <div class="">
        <form action="{{ route('categories.index') }}" method="GET" style="
            margin-bottom: 15px;
        ">
            <div class="row align-items-center">
                <div class="col-3">
                    <select name="flag" id="prnt_cat_id" class="form-select input-sm pull-right">
                        <option {{ empty($par_ct) ? 'selected=selected disabled' : '' }}>-Select-
                        </option>
                        @if ($parent)
                            @foreach ($parent as $key => $val)
                                <option value='{{ $key }}' {{ $key == $par_ct ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-info px-5">Search</button>
                </div>
                <div class="col-2">
                    <input type="reset" value="Reset" id="resetBtnn" class="btn btn-info px-5">
                </div>
            </div>
        </form>
    </div>
    <div class="custom-scrollbar">
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
                        <td class="">{{ $menu->slug }}</td>
                        <td>

                            <select name="status" class="form-select-sm status-select"
                                data-cat-id="{{ $menu->category_id }}">
                                <option value="1" {{ $menu->status == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $menu->status == '0' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </td>
                        <td class="text-capitalize">{{ $menu->meta_description }}</td>
                        <td class="text-capitalize">{{ $menu->meta_keywords }}</td>
                        <td class="text-capitalize">{{ date('d/m/Y', strtotime($menu->created)) }}</td>
                        <td>
                            <div class="d-flex customButtonContainer">
                                <a class="edit-btn" title="Edit"
                                    href="{{ url('admin/categories/' . $menu->category_id . '/edit') }}"><i
                                        class="fas fa-edit"></i></a>
                                <a class="edit-btn" title="View"
                                    href="{{ url('admin/categories/' . $menu->category_id) }}"><i
                                        class="fas fa-eye"></i></a>
                                <button title="Delete" class="dl-btn trash remove-categories"
                                    data-id="{{ $menu->category_id }}"
                                    data-action="{{ url('admin/categories/' . $menu->category_id) }}"><i
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

            // Enable the reset button if the 'flag' select has a value
            // let pCat = $('select[name="flag"]').val();
            // if (pCat == null) {
            //     $('#resetBtnn').attr('disabled', true);
            // } else {
            //     $('#resetBtnn').attr('disabled', false);

            // }
            // $('select[name="flag"]').on('change', function() {
            //     let pCat = $('select[name="flag"]').val();
            //     if (pCat == null) {
            //         $('#resetBtnn').attr('disabled', true);
            //     } else {
            //         $('#resetBtnn').attr('disabled', false);

            //     }
            // });

        });
        // Event handler for reset button to reset form and redirect
        $('input[type="reset"]').on("click", function() {
            const newURL = window.location.origin + "/admin/categories";

            // Replace the current URL in the browser's address bar
            window.history.replaceState(null, "", newURL);

            // Reset the selected form fields
            $('select[name="flag"]').val('');
            let pCat = $('select[name="flag"]').val();
            if (pCat == null) {
                $('#resetBtnn').attr('disabled', true);
            } else {
                $('#resetBtnn').attr('disabled', false);

            }
            // Optionally redirect to the new URL after 1 second
            setTimeout(function() {
                window.location.href = newURL;
            }, 1000);
        });

        // AJAX call to update the category status when the select changes
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
                    $('.page-body').prepend(
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        response.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>'
                    );
                    // Automatically close the success message after 5 seconds
                    setTimeout(function() {
                        $('.alert-success').alert('close');
                    }, 5000);
                },
                error: function(error) {
                    console.error('AJAX error:', error);
                    // Check if responseJSON is available before accessing message
                    if (error.responseJSON && error.responseJSON.message) {
                        alert(error.responseJSON.message);
                    } else {
                        alert('An unexpected error occurred.');
                    }
                }
            });
        });
    </script>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>

</x-app-layout>
