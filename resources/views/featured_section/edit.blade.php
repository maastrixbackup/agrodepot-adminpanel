<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add Section</h1>
        </div>
        <div class="col-2"><a href="{{ route('feature-section.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" enctype="multipart/form-data" action="{{ route('feature-section.update', $data->id) }}"
            class="row">
            @csrf
            @method('put')
            <div class="col-8 form-group">
                <div>
                    <label for="category_name">English Title</label>
                    <input type="text" name="english_title" class="form-control" id="english_title"
                        value="{{ $data->english_title }}">
                    @error('english_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="category_name">Romanian Title</label>
                    <input type="text" name="romanian_title" class="form-control" id="romanian_title"
                        value="{{ $data->romanian_title }}">
                    @error('romanian_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="slug">Link 2</label>
                    @php
                        $cat = \App\Models\SalesCategory::all();
                    @endphp
                    <select name="link" id="link" class="form-control">
                        <option value="" disabled selected>Select</option>
                        @foreach ($cat as $c)
                            <option value="{{ $c->category_id }}" {{ $c->category_id == $data->link ? 'selected' : '' }}>
                                {{ $c->category_name }}</option>
                        @endforeach
                    </select>
                    @error('link')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="slug">Image</label>
                    <input type="file" name="image" class="form-control" value="{{ old('image') }}">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="status">Status</label>
                    <select class="form-control form-select" name="status" data-id="status"
                        value="{{ old('status') }}">
                        <option value="1"{{ $data->status == 1 ? 'selcted' : '' }}>Active</option>
                        <option value="0" {{ $data->status == 0 ? 'selcted' : '' }}>Inactive</option>
                    </select>
                    @error('status')
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
