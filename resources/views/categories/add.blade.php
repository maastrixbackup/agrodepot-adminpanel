

<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add Language</h1>
        </div>
        <div class="col-2"><a href="{{ route('categories.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('categories.store') }}" class="row">
            @csrf
            <div class="col-8 form-group">
                <div>
                     <label for="category_name">Category Name</label>
                    <input type="text" name="category_name" class="form-control" id="category_name"
                        value="{{ old('category_name') }}">
                    @error('category_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" class="form-control" id="slug"
                        value="{{ old('slug') }}">
                    @error('slug')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="flag">Parent</label>
                        <select name="flag" class="form-control" id="flag"
                        value="{{ old('flag') }}">

                        @foreach ($categories as $flag => $catName)
                            <option value="{{ $catName->category_id }}">{{ $catName->category_name}}</option>
                        @endforeach
                    </select>
                    @error('flag')
               
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="status">Status</label>
                        <select class="form-control form-select" name="status" data-id="status" value="{{ old('status') }}">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>



                <p>{{ $item->name }} - Status: <span class="status">{{ $item->status }}</span></p>
        <button class="btn btn-toggle" data-item-id="{{ $item->id }}">
            {{ $item->status === 'active' ? 'Deactivate' : 'Activate' }}
        </button>
                <div>
                    <label for="meta_description">Meta Description</label>
                        <textarea name="meta_description" class="form-control" id="meta_description">{{ old('meta_description') }}</textarea>
                    @error('meta_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="meta_keywords">Meta Keywords</label>
                        <textarea name="meta_keywords" class="form-control" id="meta_keywords">{{ old('meta_keywords') }}</textarea>
                    @error('meta_keywords')
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
