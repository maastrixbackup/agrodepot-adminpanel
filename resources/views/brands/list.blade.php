<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Brands</h1>
        </div>
        <div class="col-2" style="text-align:right;"><a href="{{ route('brands.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <table class="brandsTable table table-hover" id="cmspageslist">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Brand Name</th>
                <th scope="col">Logo</th>
                <th scope="col">Parent</th>
                <th scope="col">Status</th>
                <th scope="col">Created</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
    </table>
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
                    url: "{{ url('admin/get-brands') }}",
                    data: function(d) {
                        // d.customer_id = $('#customer_id').val(),
                        //     d.first_name = $('#first_name').val(),
                        //     d.status = $('#p_status').val(),
                        //     d.min = $('#min').val(),
                        //     d.max = $('#max').val()
                    },
                },
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'brand_name'
                    },
                    {
                        data: 'logo'
                    },
                    {
                        data: 'parent'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'created_date'
                    },
                    {
                        data: 'action'
                    },
                ],

            });


            $("#search-form").submit(function(e) {
                e.preventDefault();
                table.draw();
            });

        });
    </script>

    <script type="text/javascript">
        $(function() {
            $(".brandsTable tbody").tableDnD({
                onDragClass: "myDragClass",
                onDrop: () => {
                    var orders = $.tableDnD.serialize();
                    var arrorder = orders.split("&");

                    // Extract and display the IDs
                    var idsInOrder = arrorder.map(function(item) {
                        return item.split("=")[1];
                    });
                    $.ajax({
                        url: '/admin/brands/update-ordering',
                        method: 'POST',
                        data: {
                            ids: idsInOrder
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('AJAX success:', response);
                        },
                        error: function(error) {
                            console.error('AJAX error:', error);
                        }
                    });

                    console.log('IDs in Order:', idsInOrder);
                }
            });
        });
    </script>
    <script>
        function BrandStatusUpdate(selectElement) {
            var statusValue = selectElement.value;
            var catId = selectElement.dataset.catId;

            $.ajax({
                url: '/admin/brands/' + catId + '/update-status',
                method: 'POST',
                data: {
                    status: statusValue
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
        }
    </script>

    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-category", function() {
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
</x-app-layout>