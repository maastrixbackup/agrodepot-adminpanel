<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Update Logo</h1>
        </div>
        <div class="col-2"><a href="{{ route('locations.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
       
        <form method="POST" action="{{ route('logo.update', ['logo' => $data->id]) }}" class="row" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="country_id">Logo Title</label>
                    <input type="text" name="logo_title" value="{{$data->logo_title}}" class="form-control">
                    @error('country_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label for="logo_image" class="col-sm-4 col-form-label">Image</label>
                    <input type="file" name="logo_image" class="form-control">
                    
                    <img src="{{ asset('uploads/site_logo/' . $data->logo_image) }}" alt="logo Image" style="max-width: 200px; max-height: 200px;">
                    @error('logo_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button class="btn btn-primary customSaveButton" type="submit">Update</button>
        </form>

    </div>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>

 

</x-app-layout>
