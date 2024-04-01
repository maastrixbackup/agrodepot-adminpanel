<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add News</h1>
        </div>
        <div class="col-2"><a href="{{ route('news.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('news.store') }}" class="row" enctype="multipart/form-data">
            @csrf
            <div class="col-10 form-group">
                <div>
                    <label for="banner_title">Title</label>
                    <input type="text" name="news_title" class="form-control" id="news_title" value="{{ old('news_title') }}">
                    @error('news_title')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="news_content" class="col-sm-4 col-form-label">Caption</label>
                    <textarea class="ckeditor form-control" name="news_content" id="news_content" placeholder="Description">{{ old('news_content') }}</textarea>
                    @error('news_content')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="input40" class="col-sm-4 col-form-label">Image</label>
                    <input type="file" class="form-control" name="news_img" id="news_img" accept="image/*">
                    @error('news_img')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="input40" class="col-sm-4 col-form-label">Status</label>
                    <select name="status" class="form-control form-select">
                        <option value="1">Active</option>
                        <option value="0">Inctive</option>

                    </select>
                </div>

            </div>
            <button class="btn btn-primary customSaveButton" type="submit">Save</button>
        </form>

    </div>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>

</x-app-layout>