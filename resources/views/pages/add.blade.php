<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add Language</h1>
        </div>
        <div class="col-2"><a href="{{ route('pages.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('pages.store') }}" class="row">
            @csrf
            <div class="col-8 form-group">
                <div>
                    <label for="page_name">Page Name</label>
                    <input type="text" name="page_name" class="form-control" id="page_name">
                    @error('page_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="page_title">Page Title</label>
                    <input type="text" name="page_title" class="form-control" id="page_title">
                    @error('page_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="meta_title">Meta Title</label>
                    <textarea name="meta_title" class="form-control" id="meta_title"></textarea>
                    @error('meta_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="pass">Meta Description</label>
                    <textarea name="meta_desc" class="form-control" id="meta_desc"></textarea>
                    @error('meta_desc')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="pass">Meta Keywords</label>
                    <textarea name="meta_keywords" class="form-control" id="meta_keywords"></textarea>
                    @error('meta_keywords')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="page_desc">Page Content</label>
                    <textarea name="page_desc" class="form-control" id="page_desc"></textarea>
                    @error('page_desc')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="status">Is Active</label>
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" id="status" value=1>
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
