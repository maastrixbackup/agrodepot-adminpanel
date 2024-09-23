<x-app-layout>
    {{-- <style>
        .table-scroll {
            width: 100%;
            overflow-x: auto;
            position: relative;
        }

        .scroll-btns {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        .scroll-btn {
            position: fixed;
            top: 84%;
            background-color: #f15a29;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 2;
            width: 45px;
            height: 45px;
            border-radius: 50%;
        }

        .scroll-right {
            right: 0;
        }
    </style> --}}
    <div class="row">

        <div class="col-8">
            <h1 class="text-center mb-3">Manage Sales</h1>
        </div>
        <div class="col-1">
            <a href="{{ route('export.sales') }}" class="btn btn-primary" data-toggle="tooltip" title="Export to Excel">
                <i class="fas fa-file-excel"></i>
            </a>
        </div>
        <div class="col-1">
            <button class="btn btn-secondary" onclick="window.print()">
                <i class="fas fa-print"></i>
            </button>
        </div>
        <div class="col-2"><a href="{{ route('sales.create') }}" class="btn btn-primary">Create new</a></div>
    </div>

    <div class="">
        <form method="GET" action="" id="search-form" name="searchform"
            style="
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
    <button class="scroll-btn scroll-left" onclick="scrollTable(-1)">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="scroll-btn scroll-right" onclick="scrollTable(1)">
        <i class="fas fa-chevron-right"></i>
    </button>
    <div class="table-scroll custom-scrollbar" id="table-container">
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
                        d.brand_id = $('#brand_id').val(),
                            d.sub_brand_id = $('#sub_brand_id').val(),
                            d.cat_id = $('#p_cat_id').val(),
                            d.sub_cat_id = $('#sub_cat_id').val()
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

        // function scrollTable(direction) {
        //     const container = document.getElementById('table-container');
        //     const scrollAmount = 100; // Adjust this value for more or less scroll
        //     container.scrollLeft += direction * scrollAmount;
        // }
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
