<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage News Letter</h1>
        </div>
        <div class="col-2"><a href="{{ route('newsletters.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <div class="custom-scrollbar">
        <table class="brandsTable table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">SL#</th>
                    <th scope="col">Name</th>
                    <th scope="col">E-Mail ID</th>
                    <th scope="col">Status</th>
                    <th scope="col">Subscribe Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="brands_sortable">
                @foreach ($data as $index => $menu)
                    <tr id="{{ $menu->news_letter_id }}">
                        <td scope="row">{{ $index + 1 }}</td>
                        <td scope="row">{{ $menu->news_name }}</td>
                        <td scope="row">{{ $menu->news_email }}</td>
                        <td class="text-capitalize"><select name="status" class="form-select-sm news-select"
                                data-news-id="{{ $menu->news_letter_id }}">
                                <option value="0" {{ $menu->status == '0' ? 'selected' : '' }}>Not Confirmed
                                </option>
                                <option value="1" {{ $menu->status == '1' ? 'selected' : '' }}>Confirmed
                                </option>
                            </select></td>
                        <td scope="row">{{ $menu->created }}</td>
                        <td>
                            <div class="d-flex customButtonContainer">
                                @if ($menu->status == '0')
                                    <form method="POST"
                                        action="{{ route('newsletters.resend', ['id' => $menu->news_letter_id]) }}">
                                        @csrf
                                        <button type="submit" class="edit-btn" title="Resend"><i
                                                class="fas fa-retweet"></i></button>
                                    </form>
                                @endif

                                <a class="edit-btn" title="Edit"
                                    href="{{ url('admin/newsletters/' . $menu->news_letter_id . '/edit') }}"><i
                                        class="fas fa-edit"></i></a>
                                <!-- <form method="POST" action="{{ url('admin/newsletters/' . $menu->news_letter_id) }}">@csrf
                                @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                                <button title="Delete" class="dl-btn trash remove-newsletter"
                                    data-id="{{ $menu->news_letter_id }}"
                                    data-action="{{ url('admin/newsletters/' . $menu->news_letter_id) }}"><i
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
            $("body").on("click", ".remove-newsletter", function() {
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
                var newsId = $(this).data('news-id');
                $.ajax({
                    url: '/admin/newsletters/' + newsId + '/update-status',
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
</x-app-layout>
