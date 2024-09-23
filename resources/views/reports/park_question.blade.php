<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Park Question Reports</h1>
        </div>

    </div>
    <div class="custom-scrollbar">
        <table class="brandsTable table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">SL#</th>
                    <th scope="col">Posted By</th>
                    <th scope="col">Park Type</th>
                    <th scope="col">Park Name</th>
                    <th scope="col">Message</th>
                    <th scope="col">Replied On</th>
                    <th scope="col">Status</th>
                    <th scope="col">Sent Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="brands_sortable">
                @foreach ($data as $index => $menu)
                    <tr id="{{ $menu->qid }}">
                        <td scope="row">{{ $index + 1 }}</td>
                        <td scope="row">{{ optional($menu->User)->first_name }}
                            {{ optional($menu->User)->last_name }}
                        </td>
                        <td scope="row">
                            @if ($menu->park_type == 1)
                                Park Trucks
                            @else
                                Company Parts
                            @endif
                        </td>
                        <td scope="row">{{ optional($menu->salesPark)->park_name }}</td>
                        <td scope="row">{{ $menu->question }}</td>
                        <td scope="row">{{ optional($menu->parkQuestion)->question }}</td>
                        <td scope="row">
                            @if ($menu->status == 1)
                                Active
                            @else
                                Inactive
                            @endif
                        </td>
                        <td scope="row">{{ date('d/m/Y', strtotime($menu->created)) }}</td>
                        <td>
                            <div class="d-flex">
                                <div class="customButtonContainer">

                                    <a class="edit-btn" title="View"
                                        href="{{ url('admin/parkquestion/' . $menu->qid) }}"><i
                                            class="fas fa-eye"></i></a>
                                </div>
                                <div class="customButtonContainer">
                                    <!-- <form method="POST" action="{{ url('admin/parkquestion/' . $menu->qid) }}">@csrf
                                @method('DELETE')<button type="submit"><i class="fas fa-trash"></i></button></form> -->
                                    <button title="Delete" class="dl-btn trash remove-parkquestion"
                                        data-id="{{ $menu->qid }}"
                                        data-action="{{ url('admin/parkquestion/' . $menu->qid) }}"><i
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
            $("body").on("click", ".remove-parkquestion", function() {
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
