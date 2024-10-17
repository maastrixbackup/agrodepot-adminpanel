<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Featured section</h1>
        </div>
        <div class="col-2" style="text-align:right;"><a href="{{ url('admin/feature-section/create') }}"
                class="btn btn-primary">Create new</a></div>
    </div>
    <div class="custom-scrollbar">
        <table class="table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">English Title</th>
                    <th scope="col">Romanian Title</th>
                    <th scope="col">Link</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $menu)
                    <tr>
                        <td scope="row">{{ $index + 1 }}</td>
                        <td class="text-capitalize">{{ $menu->english_title }}</td>
                        <td class="text-capitalize">{{ $menu->romanian_title }}</td>
                        <td class="text-capitalize">{{ $menu->link }}</td>
                        <td class="text-capitalize"><img src="{{ asset('uploads/featuredContent/' . $menu->image) }}"
                                alt="{{ $menu->image }}" width="100%" height="100%"> </td>
                        <td>
                            <div class="d-flex customButtonContainer">
                                <a href="{{ url('/admin/feature-section/' . $menu->id . '/edit') }}" class="edit-btn"><i
                                        class="fas fa-edit"></i></a>
                                <button class="dl-btn trash remove-section" data-id="{{ $menu->id }}"
                                    data-action="{{ url('admin/feature-section/' . $menu->id) }}"><i
                                        class="fas fa-trash text-danger"></i></button>

                                        {{-- <button title="Delete" class="dl-btn trash remove-section"
                                    data-id="{{ $menu->category_id }}"
                                    data-action="{{ url('admin/categories/' . $menu->id) }}"><i
                                        class="fas fa-trash"></i></button> --}}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-section", function() {
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
