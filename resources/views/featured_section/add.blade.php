<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add Section</h1>
        </div>
        <div class="col-2"><a href="{{ route('feature-section.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form enctype="multipart/form-data" method="POST" action="{{ route('feature-section.store') }}" class="row">
            @csrf
            <div class="col-8 form-group">
                <div>
                    <label for="category_name">English Title</label>
                    <input type="text" name="english_title" class="form-control" id="english_title"
                        value="{{ old('english_title') }}">
                    @error('english_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="category_name">Romanian Title</label>
                    <input type="text" name="romanian_title" class="form-control" id="romanian_title"
                        value="{{ old('romanian_title') }}">
                    @error('romanian_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="slug">Link 2</label>
                    {{-- <input type="text" name="link" class="form-control" id="link"
                        value="{{ old('link') }}"> --}}
                    @php
                        $cat = \App\Models\SalesCategory::all();
                    @endphp
                    <select name="link" id="link" class="form-control">
                        <option value="" disabled selected>Select</option>
                        @foreach ($cat as $c)
                            <option value="{{ $c->category_id }}">
                                {{ $c->category_name }}</option>
                        @endforeach
                    </select>
                    @error('link')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="slug">Image</label>
                    <input accept="image/*" type="file" name="image" class="form-control"
                        value="{{ old('image') }}">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="status">Status</label>
                    <select class="form-control form-select" name="status" data-id="status"
                        value="{{ old('status') }}">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    @error('status')
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
