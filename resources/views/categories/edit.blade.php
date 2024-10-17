<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Edit Category</h1>
        </div>
        <div class="col-2"><a href="{{ route('categories.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <h3>Edit Category</h3>
        <form method="POST" action="{{ route('categories.update', ['category' => $data->category_id]) }}" class="row"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="category_name">Category Name</label>
                    <input type="text" name="category_name" class="form-control" id="category_name"
                        value="{{ optional($data)->category_name }}">
                    @error('category_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" class="form-control" id="slug"
                        value="{{ optional($data)->slug }}">
                    @error('slug')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="flag">Parent</label>
                    <select name="flag" class="form-control" id="flag">
                        <option value="0">-No Parent-</option>
                        @foreach ($categories as $flag => $catName)
                            <option value="{{ $catName->category_id }}"
                                {{ optional($data)->flag == $catName->category_id ? 'selected' : '' }}>
                                {{ $catName->category_name }}
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
                        <option value="123" {{ optional($data)->status == '123' ? 'selected' : '' }}>Status</option>
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
    <script>
        let table = new DataTable('#cmspageslist');
    </script>

</x-app-layout>
