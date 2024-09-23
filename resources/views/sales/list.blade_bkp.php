<x-app-layout>
    <style>
        .table-scroll {
            width: 100%;
            overflow: auto;
        }
    </style>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Sales</h1>
        </div>
        <div class="col-2"><a href="{{ route('sales.create') }}" class="btn btn-primary">Create new</a></div>
    </div>

    <div class="">
        <form action="{{ route('sales.index') }}" method="GET" style="
            margin-bottom: 15px;
        ">
            <div class="row sale-man">
                <div class="col-3">
                    Brand :
                    <select id='brand_id' name='brand_id' onchange='getSubBrand()'
                        class="form-select input-sm pull-right">
                        <option value='' {{ @$brand_id == '' ? 'selected' : '' }}>-Select-</option>
                        @foreach ($brand as $key => $val)
                            <option value='{{ $key }}'
                                {{ $key == @$brand_id && @$brand_id != '' ? 'selected' : '' }}>{{ $val }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <select name="sub_brand_id" id="sub_brand_id" class="form-select input-sm pull-right">
                        <option value="">-Select-</option>
                        @if (!empty($sub_brand_id) || !empty($brand_id))
                            @foreach ($sub_brand as $k => $v)
                                <option value="{{ $k }}" {{ $k == $sub_brand_id ? 'selected' : '' }}>
                                    {{ $v }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-3">
                    Category:
                    <select id='cat_id' name='cat_id' onchange='getSubCat()'
                        class="form-select input-sm pull-right">
                        <option value='' {{ @$cat_id == '' ? 'selected' : '' }}>-Select-</option>
                        @foreach ($category as $key => $val)
                            <option value='{{ $key }}'
                                {{ $key == @$cat_id && @$cat_id != '' ? 'selected' : '' }}>{{ $val }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <select name="sub_cat_id" id="sub_cat_id" class="form-select input-sm pull-right">
                        <option value="">-Select-</option>
                        @if (!empty($sub_cat_id) || !empty($cat_id))
                            @foreach ($sub_cat as $k => $v)
                                <option value="{{ $k }}" {{ $k == $sub_cat_id ? 'selected' : '' }}>
                                    {{ $v }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-2">
                    <button type="submit" class="btn btn-info px-5">Search</button>
                </div>
                <div class="col-2">
                    <input type="reset" value="Reset" class="btn btn-info px-5">
                </div>
            </div>
        </form>
    </div>
    <div class="table-scroll">
        <table class="brandsTable table table-hover" id="saleslist">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Posted By</th>
                    <th scope="col">Image</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Category</th>
                    <th scope="col">Sub Category</th>
                    <th scope="col">Is promoted?</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            // alert(234);

            var table = $('#saleslist').DataTable({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                processing: true,
                serverSide: true,
                serverMethod: 'get',
                ajax: {
                    url: "{{ url('admin/get-sales') }}",
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
                        data: 'adv_name'
                    },
                    {
                        data: 'posted_by'
                    },
                    {
                        data: 'image'
                    },
                    {
                        data: 'price'
                    },
                    {
                        data: 'quantity'
                    },
                    {
                        data: 'category'
                    },
                    {
                        data: 'sub_category'
                    },
                    {
                        data: 'is_promoted'
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
    <script>
        $(document).ready(function() {
            $("body").on("click", ".remove-sales", function() {
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
        function salesstatusUpdate(selectElement) {
            var nameValue = selectElement.value;
            var Id = selectElement.dataset.advId;

            $.ajax({
                url: '/admin/sales/' + Id + '/update-status',
                method: 'POST',
                data: {
                    adv_status: nameValue
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
        }
    </script>
    <script>
        $('#cmspageslist').dataTable({
            "bPaginate": false
        });

        function getSubBrand() {
            var brand_id = $("#brand_id").val();
            var url = "{{ route('subbrand') }}"; // Use route helper to generate URL
            $.get(url, {
                brand_id: brand_id
            }, function(response) {
                $("#sub_brand_id").html(response.options);
            });
        }

        function getSubCat() {
            var cat_id = $("#cat_id").val();
            var url = "{{ route('subcat') }}"; // Use route helper to generate URL
            $.get(url, {
                cat_id: cat_id
            }, function(response) {
                $("#sub_cat_id").html(response.options);
            });
        }
    </script>
</x-app-layout>
