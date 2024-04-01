<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Add Brands</h1>
        </div>
        <div class="col-2"><a href="{{ route('brands.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('brands.store') }}" class="row" enctype="multipart/form-data">
            @csrf
            <div class="row form-group">
                <div class="col-lg-6">
                    <div class="form--box">
                        <label for="brand_name">Brand Name</label>
                        <input type="text" name="brand_name" class="form-control" id="brand_name">
                        @error('brand_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form--box">
                        <label for="pImage">Image</label>
                        <input type="file" class="form-control" name="image" id="pImage" accept="image/*">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form--box">
                        <label for="flag">Parent</label>
                        <select name="flag" class="form-control" id="flag">
                            <option value="0">Parent</option>
                            @foreach ($categories as $flag => $catName)
                            <option value="{{ $catName->brand_id }}">
                                {{ $catName->brand_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('flag')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form--box">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" id="status">
                            <option value="">Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form--box">
                        <label for="meta_description">Meta Description</label>
                        <textarea name="meta_description" class="form-control" id="meta_description"></textarea>
                        @error('meta_description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form--box">
                        <label for="meta_keywords">Meta Keywords</label>
                        <textarea name="meta_keywords" class="form-control" id="meta_keywords"></textarea>
                        @error('meta_keywords')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <button class="btn-one" type="submit">Save</button>
                </div>

            </div>
        </form>
    </div>

</x-app-layout>