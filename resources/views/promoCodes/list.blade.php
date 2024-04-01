<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Promo codes</h1>
        </div>
        <div class="col-2"><a href="{{ route('promo-codes.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <table class="table table-hover" id="cmspageslist">
        <thead>
            <tr>
                <th scope="col">SL#</th>
                <th scope="col">Title</th>
                <th scope="col">Code</th>
                <th scope="col">Expiry</th>
                <th scope="col">Active</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($promo as $index => $menu)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td class="text-capitalize">{!! $menu->title !!}</td>
                    <td class="text-capitalize">{!! $menu->code !!}</td>
                    <td class="text-capitalize">{!! $menu->expiry_date !!}</td>
                    <td class="text-capitalize">{{ $menu->status == 1 ?"Active":"In-active" }}</td>
                    <td>
                        <div class="d-flex">
                            <div class="customButtonContainer"><a class="mx-2"
                                    href="{{ url('admin/promo-codes/' . $menu->id . '/edit') }}"><i
                                        class="fas fa-edit"></i></a>

                            </div>
                            <div class="customButtonContainer">
                                <!-- <form method="POST" action="{{ url('admin/promo-codes/' . $menu->id) }}">@csrf
                                    @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                                <button title="Delete" class="trash remove-pages" data-id="{{ $menu->id }}"
                                    data-action="{{ url('admin/promo-codes/' . $menu->id) }}"><i
                                        class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-pages", function() {
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
