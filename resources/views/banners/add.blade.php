<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add Banner</h1>
        </div>
        <div class="col-2"><a href="{{ route('banners.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('banners.store') }}" class="row" enctype="multipart/form-data">
            @csrf
            <div class="col-8 form-group">
                <div>
                    <label for="banner_title">Banner Title</label>
                    <input type="text" name="banner_title" class="form-control" id="banner_title"
                        value="{{ old('banner_title') }}">
                    @error('banner_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="input40" class="col-sm-4 col-form-label">Image</label>
                    <input type="file" class="form-control" name="banner_img" id="banner_img" accept="image/*">
                    @error('banner_img')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="bannerTitle1" class="col-sm-4 col-form-label">Caption</label>
                    <textarea class="ckeditor form-control" name="banner_caption" id="bannerTitle1" placeholder="Description">{{ old('banner_caption') }}</textarea>
                    @error('banner_caption')
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
