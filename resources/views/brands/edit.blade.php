<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Edit Brands</h1>
        </div>
        <div class="col-2"><a href="{{ route('brands.index') }}" class="btn btn-primary">Go back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('brands.update',['brand' => $data->brand_id]) }}" class="row"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="brand_name">Brand Name</label>
                    <input type="text" name="brand_name" class="form-control" id="brand_name"
                        value="{{ optional($data)->brand_name }}">
                    @error('brand_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-6 mt-3">
                    <label for="pImage" class="col-sm-4 col-form-label">Image</label>
                    <img src="{{ asset('uploads/brand/' . optional($data)->image) }}" alt="image" id="pImage">
                    <input type="file" class="form-control" name="image" id="pImage" accept="image/*">
                </div>

                <div>
                    <label for="flag">Parent</label>
                    <select name="flag" class="form-control" id="flag">
                        @foreach ($categories as $flag => $catName)
                            <option value="0">Parent</option>
                            <option value="{{ $catName->brand_id }}"
                                {{ optional($data)->parent == $catName ? 'selected' : '' }}>
                                {{ $catName->brand_name }}
                            </option>
                        @endforeach


                    </select>
                    @error('flag')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="status">Status</label>
                    <select name="status" class="form-control" id="status">
                        <option {{ optional($data)->status == '123' ? 'selected' : '' }}>Status</option>
                        <option value="1" {{ optional($data)->status == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ optional($data)->status == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="meta_description">Meta Description</label>
                    <textarea name="meta_description" class="form-control" id="meta_description">{{ optional($data)->meta_description }}</textarea>
                    @error('meta_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="meta_keywords">Meta Keywords</label>
                    <textarea name="meta_keywords" class="form-control" id="meta_keywords">{{ optional($data)->meta_keywords }}</textarea>
                    @error('meta_keywords')
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
