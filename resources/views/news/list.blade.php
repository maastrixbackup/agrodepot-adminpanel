<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">Manage News</h1>
        </div>
        <div class="col-2"><a href="{{ route('news.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <div class="custom-scrollbar">
        <table class="table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Image</th>
                    <th scope="col">Status</th>
                    <th scope="col">Posted On</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $menu)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>

                        <td class="text-capitalize">{{ $menu->news_title }}</td>
                        <td class="tableImgLogo"><img src="{{ asset('uploads/news/' . $menu->news_img) }}"
                                alt="">
                        </td>
                        <td class="text-capitalize">
                            @if ($menu->status == 1)
                                Active
                            @else
                                Inactive
                            @endif
                        </td>
                        <td class="text-capitalize">{{ $menu->created }}</td>
                        <td>
                            <div class="d-flex customButtonContainer">
                                <!-- <form method="POST" action="{{ url('admin/news/' . $menu->news_id) }}">@csrf
                                @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                                <a class="edit-btn" title="Edit"
                                    href="{{ url('admin/news/' . $menu->news_id . '/edit') }}"><i
                                        class="fas fa-edit"></i>
                                </a>
                                <a class="edit-btn" title="View" href="{{ url('admin/news/' . $menu->news_id) }}"><i
                                        class="fas fa-eye"></i></a>


                                <button title="Delete" class="dl-btn trash remove-news" data-id="{{ $menu->news_id }}"
                                    data-action="{{ url('admin/news/' . $menu->news_id) }}"><i
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
            $("body").on("click", ".remove-news", function() {
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
