<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Edit User</h1>
        </div>
        <div class="col-2"><a href="{{ route('users.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <div class="row">
            <div class="col-md-7">
                <h3>Edit User</h3>
                <form method="POST" action="{{ route('users.update', ['user' => $data->user_id]) }}" class="row"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-8 form-group">
                        <div>
                            <label for="first_name">First Name</label>
                            <input value="{{ optional($data)->first_name }}" type="text" name="first_name"
                                class="form-control" id="first_name">
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="last_name">Last Name</label>
                            <input value="{{ optional($data)->last_name }}" type="text" name="last_name"
                                class="form-control" id="last_name">
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="email">Email</label>
                            <input value="{{ optional($data)->email }}" type="text" name="email"
                                class="form-control" id="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="pass">Phone </label>
                            <input value="{{ optional($data)->telephone1 }}" type="text" name="telephone1"
                                class="form-control" id="telephone1">
                            @error('telephone1')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- <div>
                            <label for="telephone2">Phone 2</label>
                            <input value="{{ optional($data)->telephone2 }}" type="hidden" name="telephone2"
                                class="form-control" id="telephone2">
                            @error('telephone2')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="telephone3">Phone 3</label>
                            <input value="{{ optional($data)->telephone3 }}" type="hidden" name="telephone3"
                                class="form-control" id="telephone3">
                            @error('telephone3')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="telephone4">Phone 4</label>
                            <input value="{{ optional($data)->telephone4 }}" type="hidden" name="telephone4"
                                class="form-control" id="telephone4">
                            @error('telephone4')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> --}}

                        <div>
                            <label for="country">District</label>
                            <select name="country" class="form-control" id="country">
                                <option value="">-Choose Country-</option>
                                @foreach ($countries as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ $id == $data->country_id ? 'selected' : '' }}>
                                        {{ $name }}
                                @endforeach
                            </select>
                            @error('country')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="city">City</label>
                            <select name="city" class="form-control" id="city">
                                <option value="">-Choose Town-</option>
                                @foreach ($city as $location)
                                    <option value="{{ $location->location_id }}"
                                        {{ $location->location_id == $data->locality_id ? 'selected' : '' }}>
                                        {{ $location->location_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="user_type">User Type</label>
                            <select name="user_type" class="form-control" id="user_type">
                                <option>--select user--</option>
                                <option value="1" {{ 1 == $data->user_type_id ? 'selected' : '' }}>
                                    Buyer</option>
                                <option value="2" {{ 2 == $data->user_type_id ? 'selected' : '' }}>
                                    Seller</option>
                                <option value="3" {{ 3 == $data->user_type_id ? 'selected' : '' }}>
                                    B2B</option>
                            </select>
                            @error('user_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="status">Status</label>
                            <select name="status" class="form-control" id="status">
                                <option disabled selected>Status</option>
                                <option value="1" {{ $data->is_active == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $data->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button class="btn btn-primary mt-1 ustomSaveButton" type="submit">Save</button>
                    </div>

                </form>
            </div>
            <div class="col-md-5">
                <h3>Change Pasword</h3>
                <span id="resp"></span>
                <form id="passwordForm" action="" method="POST">
                    @csrf
                    <div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="" id="u_id" value="{{ $data->user_id }}">
                        <label for="pass">Password</label>
                        <input type="password" name="pass" class="form-control" id="pass" required>
                        <span class="invalid-feedback">Please enter a valid password.</span>
                    </div>
                    <div>
                        <label for="c_pass">Confirm Password</label>
                        <input type="password" name="c_pass" class="form-control" id="c_pass" readonly required>
                        <span class="invalid-feedback">Please confirm your password.</span>
                        <span id="alert"></span>
                    </div>
                    <button type="submit" class="btn btn-primary" id="updateBtn">Update</button>
                </form>

            </div>
        </div>
    </div>
    <script>
        let table = new DataTable('#cmspageslist');
        $('#pass').on('keyup', function() {
            let pass = $('#pass').val();
            if (pass === '') {
                $('#c_pass').attr('readonly', true).val('');
            } else {
                $('#c_pass').attr('readonly', false);
            }
        });

        $('#c_pass').on('keyup', function() {
            let pass = $('#pass').val();
            let cpass = $('#c_pass').val();
            let al = $('#alert').html('');
            if (cpass == '') {
                // $('#alert').html('Password not matched').removeClass('text-success').addClass('text-danger');
                $('#c_pass').addClass('is-invalid');
            } else {
                // $('#alert').html('Password matched').removeClass('text-danger').addClass('text-success');
                $('#c_pass').removeClass('is-invalid');
            }
            if (pass === cpass) {
                // $('#alert').html('Password matched').removeClass('text-danger').addClass('text-success');
                // console.log('Password matched');
            } else {
                // $('#alert').html('Password not matched').removeClass('text-success').addClass('text-danger');
                // console.log('Password not matched');
            }
        });



        $('#updateBtn').on('click', function(event) {
            event.preventDefault(); // Prevent default form submission

            let pass = $('#pass').val();
            let cpass = $('#c_pass').val();
            let uId = $('#u_id').val();
            let isValid = true;

            // Validate password fields
            if (pass === '') {
                $('#pass').addClass('is-invalid');
                isValid = false;
            } else {
                $('#pass').removeClass('is-invalid');
            }

            if (cpass === '' || pass !== cpass) {
                alert('Password and Confirm Password Not Matched');
                $('#c_pass').addClass('is-invalid');
                $('#c_pass').val('');
                isValid = false;
            } else {
                $('#c_pass').removeClass('is-invalid');
            }

            // If the form is valid, submit via AJAX
            if (isValid) {
                $.ajax({
                    url: '/admin/users/' + uId + '/update-password',
                    type: 'POST',
                    data: {
                        password: pass,
                        id: uId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status) {
                            $('#resp').html('Password updated successfully')
                                .removeClass('text-danger')
                                .addClass('text-success');

                            $('#pass').val('');
                            $('#c_pass').val('').attr('readonly', true);
                        } else {
                            alert('Error:', response.message);
                            $('#pass').val('');
                            $('#c_pass').val('').attr('readonly', true);
                        }
                    },
                    error: function(error) {
                        $('#alert').html(error)
                            .removeClass('text-success')
                            .addClass('text-danger');
                    }
                });
            }
        });
    </script>

</x-app-layout>
