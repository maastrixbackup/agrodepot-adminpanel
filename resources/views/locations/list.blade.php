<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">Manage Locations</h1>
        </div>
        <div class="col-2"><a href="{{ route('locations.create') }}" class="btn btn-primary">Create new</a></div>
    </div>

    <div class="">
        <form id="filter-form" style="margin-bottom: 15px;">
            <div class="row align-items-center">
                <div class="col-3">
                    <select name="country_id" id="country_id" class="form-select input-sm pull-right">
                        <option value=''>-Select-</option>
                        @foreach ($country_data as $option)
                            <option value='{{ $option->country_id }}'>{{ $option->country_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <button type="submit" id="search-btn" class="btn btn-info px-5">Search</button>
                </div>
                <div class="col-2">
                    <button type="reset" id="reset-btn" class="btn btn-info px-5">Reset</button>
                </div>
            </div>
        </form>
    </div>

    <div class="custom-scrollbar">
        <table class="table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">SL#</th>
                    <th scope="col">Country</th>
                    <th scope="col">Location</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            // alert(234);

            var table = $('#cmspageslist').DataTable({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                processing: true,
                serverSide: true,
                serverMethod: 'get',
                ajax: {
                    url: "{{ url('admin/get-locations') }}",
                    data: function(d) {
                        d.country_id = $('#country_id').val()
                    },
                },
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'country'
                    },
                    {
                        data: 'location_name'
                    },
                    {
                        data: 'action'
                    },
                ],

            });


            $("#filter-form").submit(function(e) {
                e.preventDefault();
                table.draw();
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-location", function() {
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
</x-app-layout>
