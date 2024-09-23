<x-app-layout>
    <div class="row">
        <div class="col-8">
            <h1 class="text-center mb-3">Manage Users</h1>
        </div>
        <div class="col-2"><a href="{{ route('users.create') }}" class="btn btn-primary">Create new</a></div>
        <div class="col-1">
            <a href="{{ route('export.users') }}" class="btn btn-primary" data-toggle="tooltip" title="Export to Excel">
                <i class="fas fa-file-excel"></i>
            </a>
        </div>
    </div>

    <div class="count-class">
        <div class="row">
            <div class="col-lg-4 col-md-4 ">
                <div class=" count_class_box">
                    <img src="{{asset('/images/group.png')}}" alt="">
                    <h3 >Total User: <span>{{ $totalUser }}</span></h3>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 ">
                <div class=" count_class_box">
                    <img src="{{asset('/images/buyer.png')}}" alt="">
                    <h3 >Total Buyer: <span>{{ $totalBuyer }}</span></h3>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 ">
                <div class=" count_class_box">
                    <img src="{{asset('/images/businessman.png')}}" alt="">
                    <h3 >Total Seller: <span>{{ $totalUser }}</span></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <form action="{{ route('users.index') }}" method="GET" style="
        margin-bottom: 15px;
    ">
            <div class="row align-items-center">
                <div class="col-3">
                    <select name="user_type" id="user_type" class="form-select input-sm pull-right">
                        @php
                            $userTypes = ['1' => 'Buyer', '2' => 'Seller'];
                        @endphp
                        @foreach ($userTypes as $key => $val)
                            <option value="{{ $key }}"
                                {{ isset($user_type) && $key == $user_type ? 'selected' : '' }}>
                                {{ $val }}
                            </option>
                        @endforeach
                        <option value="3" {{ !isset($user_type) || $user_type == 3 ? 'selected' : '' }}>All user
                            Type</option>
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
    <div class="custom-scrollbar" id="table-container">
        <table class="brandsTable table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telephone</th>
                    <th scope="col">User Type</th>
                    <th scope="col">Status</th>
                    <th scope="col">Set Premium</th>
                    <th scope="col">Registration Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="brands_sortable">
                @foreach ($data as $index => $menu)
                    @php
                        $memberdetails = App\Models\UpgradeMembership::leftJoin(
                            'user_memberships',
                            'user_memberships.memb_id',
                            '=',
                            'upgrade_membership.member_type',
                        )
                            ->where('upgrade_membership.user_id', $menu->user_id)
                            ->select('user_memberships.*', 'upgrade_membership.*')
                            ->orderByDesc('upgrade_membership.upgrade_id')
                            ->first();
                    @endphp

                    <tr id="{{ $menu->user_id }}">
                        <td scope="row">{{ $index + 1 }}</td>
                        <td scope="row">{{ $menu->first_name }}{{ $menu->last_name }}</td>
                        <td scope="row">{{ $menu->email }}</td>
                        <td scope="row">{{ $menu->telephone1 }}</td>
                        <td scope="row">{{ optional($menu->userType)->user_type }}</td>
                        <td scope="row"><select name="is_active" class="form-select-sm usr-act-select"
                                data-user-id="{{ $menu->user_id }}">
                                <option value="1" {{ $menu->is_active == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $menu->is_active == '0' ? 'selected' : '' }}>Inactive
                                </option>
                            </select></td>
                        <td scope="row">
                            <select name="is_premium" id="is_premium" class="form-select-sm usr-select"
                                onchange="changeMembership(this.value, {{ $menu->user_id }});">
                                <option value="">Select Membership</option>
                                @foreach ($userMembership as $userMembershipRes)
                                    <option value="{{ $userMembershipRes->memb_id }}"
                                        @if (!empty($memberdetails) && $memberdetails->memb_id == $userMembershipRes->memb_id) selected @endif>
                                        {{ stripslashes($userMembershipRes->memb_type) }}
                                    </option>
                                @endforeach
                            </select>

                        </td>
                        {{-- <td scope="row">{{ $menu->is_premium }}</td> --}}
                        <td scope="row">{{ $menu->created_at }}</td>

                        <td>
                            <div class="d-flex customButtonContainer">
                                <a class="edit-btn" title="Edit"
                                    href="{{ url('admin/users/' . $menu->user_id . '/edit') }}"><i
                                        class="fas fa-edit"></i>
                                </a>
                                <a class="edit-btn" title="View" href="{{ url('admin/users/' . $menu->user_id) }}"><i
                                        class="fas fa-eye"></i></a>

                                <a class="edit-btn" title="Rating"
                                    href="{{ route('users.rating', $menu->user_id) }}"><i class="fas fa-star"></i>
                                </a>
                                <button title="Delete" class="dl-btn trash remove-masteruser"
                                    data-id="{{ $menu->user_id }}"
                                    data-action="{{ url('admin/users/' . $menu->user_id) }}"><i
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
            $("body").on("click", ".remove-masteruser", function() {
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
            $('select[name="is_active"]').on('change', function() {
                var nameValue = $(this).val();
                var userId = $(this).data('user-id');
                $.ajax({
                    url: '/admin/users/' + userId + '/update-status',
                    method: 'POST',
                    data: {
                        is_active: nameValue
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
    <script type="text/javascript">
        function changeMembership(changeval, uid) {
            //var uid=$("#uid").val();
            $.ajax({
                type: 'POST',
                url: "{{ route('users.upgrademember', ['uid' => ':uid']) }}".replace(':uid', uid),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: 'uid=' + uid + '&memid=' + changeval,
                success: function(data) {
                    if (data.trim() === '1') { // Trim the response and compare with '1'
                        alert("Membership Upgrade successfully");
                    } else {
                        alert("Upgrading Failed");
                    }
                }


            });
        }
    </script>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>
</x-app-layout>
