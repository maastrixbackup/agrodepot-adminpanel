<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Edit Social Icon</h1>
        </div>
        <div class="col-2"><a href="{{ route('socialicons.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <h3>Edit Social Icon</h3>
        <form method="POST" action="{{ route('socialicons.update',['socialicon' => $data->social_id]) }}" class="row" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="social_name">Social Name</label>
                    <input value="{{ optional($data)->social_name }}" type="text" name="social_name"
                        class="form-control" id="social_name">
                </div>
                <div>
                    <label for="input40" class="col-sm-4 col-form-label">Social Image</label>
                    <input type="file" class="form-control" name="social_img" id="social_img">
                    <img src="{{ asset('uploads/socialicon/' . optional($data)->social_img) }}" alt="image" height="70px" width="70px">
                    
                    @error('social_img')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="social_link">Social Link</label>
                    <input type="text" name="social_link" class="form-control" id="social_link"
                        value="{{ old('social_link', $data->social_link) }}">
                    @error('social_link')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="orderno">Orderno</label>
                    <input type="text" name="orderno" class="form-control" id="orderno"
                        value="{{ old('orderno', $data->orderno) }}">
                    @error('orderno')
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
