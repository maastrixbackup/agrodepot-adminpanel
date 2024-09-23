<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Edit Pages</h1>
        </div>
        <div class="col-2"><a href="{{ route('pages.index') }}" class="btn btn-primary">Go back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('pages.update',['page' => $data->pid]) }}" class="row">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="page_name">Page Name</label>
                    <input type="text" name="page_name" class="form-control" id="page_name"
                        value="{{ optional($data)->page_name }}">
               
                </div>
                <div>
                    <label for="page_title">Page Title</label>
                    <input type="text" name="page_title" class="form-control" id="page_title" value="{{ optional($data)->page_title }}">
                 
                </div>
                <div>
                    <label for="meta_title">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" id="meta_title"  value="{{ optional($data)->meta_title }}">
                 
                </div>
                <div>
                    <label for="pass">Meta Description</label>
                    <textarea name="meta_desc" class="form-control" id="meta_desc">{{ optional($data)->meta_desc }}</textarea>
                    @error('meta_desc')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="pass">Meta Keywords</label>
                    <textarea name="meta_keywords" class="form-control" id="meta_keywords">{{ optional($data)->meta_keywords }}</textarea>
                    @error('meta_keywords')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="page_desc">Page Content</label>
                    <textarea name="page_desc" class="ckeditor form-control" id="page_desc">{{ optional($data)->page_desc }}</textarea>
                    @error('page_desc')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                
                <div>
                    <label for="status">Status</label>
                    <input type="checkbox" name="status" id="status" value="1" @if(old('status', optional($data)->is_active) == 1) checked @endif>
                    @error('status')
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
