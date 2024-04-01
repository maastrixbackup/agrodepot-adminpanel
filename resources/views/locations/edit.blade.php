<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add Locations</h1>
        </div>
        <div class="col-2"><a href="{{ route('locations.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('locations.update',['location' => $data->location_id])}}" class="row">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="country_id">Select For</label>
                    <select name="country_id" class="form-control">
                    
                    @foreach($locations as $location)
                    <option value="{{ $location->country_id }}" {{ $location->country_id == $data->country_id ? 'selected' : '' }}>
                        {{ $location->country_name }}
                    </option>
                    @endforeach
                    </select>
                    @error('country_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label for="location_name" class="col-sm-4 col-form-label">Caption</label>
                    <textarea class="form-control" name="location_name" id="location_name" placeholder="Description">{{ old('location_name',$data->location_name) }}</textarea>
                    @error('location_name')
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
