<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Edit SEO Fields</h1>
        </div>
        <div class="col-2"><a href="{{ route('seofields.index') }}" class="btn btn-primary">Go back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('seofields.update',['seofield' => $data->seo_id ]) }}" class="row">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="page_name">Page Name</label>
                    <input type="text" name="page_name" class="form-control" id="page_name"
                        value="{{ optional($data)->page_name }}">
               
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
                    <textarea name="meta_keyword" class="form-control" id="meta_keyword">{{ optional($data)->meta_keyword }}</textarea>
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
