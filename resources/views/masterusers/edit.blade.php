<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Edit User</h1>
        </div>
        <div class="col-2"><a href="{{ route('users.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
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
                    <input value="{{ optional($data)->last_name }}" type="text" name="last_name" class="form-control"
                        id="last_name">
                    @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email">Email</label>
                    <input value="{{ optional($data)->email }}" type="text" name="email" class="form-control"
                        id="email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="pass">Password</label>
                    <input value="{{ optional($data)->pass }}" type="text" name="pass" class="form-control"
                        id="pass">
                    @error('pass')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="pass">Phone 1</label>
                    <input value="{{ optional($data)->telephone1 }}" type="text" name="telephone1"
                        class="form-control" id="telephone1">
                    @error('telephone1')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="telephone2">Phone 2</label>
                    <input value="{{ optional($data)->telephone2 }}" type="text" name="telephone2"
                        class="form-control" id="telephone2">
                    @error('telephone2')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="telephone3">Phone 3</label>
                    <input value="{{ optional($data)->telephone3 }}" type="text" name="telephone3"
                        class="form-control" id="telephone3">
                    @error('telephone3')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="telephone4">Phone 4</label>
                    <input value="{{ optional($data)->telephone4 }}" type="text" name="telephone4"
                        class="form-control" id="telephone4">
                    @error('telephone4')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="country">District</label>
                    <select name="country" class="form-control" id="country">
                        <option value="">-Choose Country-</option>
                        @foreach ($countries as $id => $name)
                            <option value="{{ $id }}" {{ $id == $data->country_id ? 'selected' : '' }}>
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
                        <option>Status</option>
                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button class="btn btn-primary customSaveButton" type="submit">Save</button>
        </form>
    </div>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>

</x-app-layout>
