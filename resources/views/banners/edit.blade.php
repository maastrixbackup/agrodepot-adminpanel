<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Edit Banner</h1>
        </div>
        <div class="col-2"><a href="{{ route('banners.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <h3>Edit Banner</h3>
        <form method="POST" action="{{ route('banners.update',['banner' => $data->banner_id]) }}" class="row" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="banner_title">Banner Title</label>
                    <input value="{{ optional($data)->banner_title }}" type="text" name="banner_title"
                        class="form-control" id="banner_title">
                </div>
                <div>
                    <label for="input40" class="col-sm-4 col-form-label">Image</label>
                    <img src="{{ asset('uploads/banner/' . optional($data)->banner_img) }}" alt="image"
                        id="pImage" style="width:100%">
                    <input type="file" class="form-control" name="banner_img" id="banner_img" accept="image/*">
                </div>
                <div>
                    <label for="bannerTitle1" class="col-sm-4 col-form-label">Caption</label>
                    <textarea class="ckeditor form-control" name="banner_caption" id="bannerTitle1" placeholder="Description">{{ optional($data)->banner_caption }}</textarea>
                </div>
            </div>
            <div class="col-4">
                <label for="status">Status</label>
                <select class="form-control form-select" name="status" id="status">
                    <option value="123" {{ $data->status == '123' ? 'selected' : '' }}>Status</option>
                    <option value="1" {{ $data->status == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $data->status == '0' ? 'selected' : '' }}>Inactive</option>
                </select>


            </div>
            <button class="btn btn-primary customSaveButton" type="submit">Save</button>
        </form>
    </div>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>

</x-app-layout>
