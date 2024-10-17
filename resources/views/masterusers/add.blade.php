<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Add Users</h1>
        </div>
        <div class="col-2"><a href="{{ route('users.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('users.store') }}" class="row">
            @csrf
            <div class="col-8 form-group">
                <div>
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" id="first_name">
                    @error('first_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control" id="last_name">
                    @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="text" name="password" class="form-control" id="password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email">Phone </label>
                    <input type="text" name="telephone1" class="form-control" id="email">
                    @error('telephone1')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- <div>
                    <label for="email">Phone 2</label>
                    <input type="text" name="telephone2" class="form-control" id="email">
                    @error('telephone2')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email">Phone 3</label>
                    <input type="text" name="telephone3" class="form-control" id="email">
                    @error('telephone3')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email">Phone 4</label>
                    <input type="text" name="telephone4" class="form-control" id="email">
                    @error('telephone4')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}


                <div>
                    <label for="country">District</label>
                    <select name="country" class="form-control" id="country">
                        <option value="">-Choose Country-</option>
                        @foreach($countries as $id => $name)

                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('country')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="city">City</label>
                    <select name="city" class="form-control" id="location">
                        <option value="">-Choose Town-</option>

                    </select>
                    @error('city')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="user_type">User Type</label>
                    <select name="user_type" class="form-control" id="user_type">
                        <option>--select user--</option>
                        @foreach($users as $ut_id => $user_type)
                        <option value="{{ $ut_id }}">{{ $user_type }}</option>
                        @endforeach
                    </select>
                    @error('user_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="status">Status</label>
                    <select name="status" class="form-control" id="status">
                        <option disabled selected>Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            <div class="col-4">
            </div>
            <button class="btn btn-primary customSaveButton" type="submit">Save</button>
        </form>
    </div>

</x-app-layout>
<script>
    $(document).ready(function () {
        $('#country').on('change', function () {
            var countryId = $(this).val();
            if (countryId) {
                $.ajax({
                    url: '/admin/get-cities/' + countryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {

                        var res = data.data;
                        $('#location').empty();
                        //var cleanedName = value.location_name.trim();
                        $('#location').append('<option value="">- Choose Location -</option>');
                        $.each(res, function (key, value) {
                            //console.log(key);
                            console.log(value);
                            $('#location').append('<option value="' + value.location_id + '">' + value.location_name + '</option>');
                        });
                    }
                });
            } else {
                $('#location').empty();
                $('#location').append('<option value="">- Choose Location -</option>');
            }
        });
    });
</script>
