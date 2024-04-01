<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add Icons</h1>
        </div>
        <div class="col-2"><a href="{{ route('socialicons.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('socialicons.store') }}" class="row" enctype="multipart/form-data">
            @csrf
            <div class="col-8 form-group">
                <div>
                    <label for="social_name">Social Name</label>
                    <input type="text" name="social_name" class="form-control" id="social_name"
                        value="{{ old('social_name') }}">
                    @error('social_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="input40" class="col-sm-4 col-form-label">Social Image</label>
                    <input type="file" class="form-control" name="social_img" id="social_img" accept="image/*">
                    @error('social_img')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="social_link">Social Link</label>
                    <input type="text" name="social_link" class="form-control" id="social_link"
                        value="{{ old('social_link') }}">
                    @error('social_link')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="orderno">Orderno</label>
                    <input type="text" name="orderno" class="form-control" id="orderno"
                        value="{{ old('orderno') }}">
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
