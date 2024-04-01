<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Edit Banner</h1>
        </div>
        <div class="col-2"><a href="{{ route('admin-langs.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <h3>Edit Banner</h3>
        <form method="POST" action="{{ route('admin-langs.update',  $data->lid ) }}" class="row">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="en_label">English label</label>
                    <textarea class="ckeditor form-control" name="en_label" id="en_label" placeholder="Description">{{ optional($data)->en_label ?? null }}</textarea>
                </div>
                <div>
                    <label for="roman_label">Romanian Label</label>
                    <textarea class="ckeditor form-control" name="roman_label" id="roman_label" placeholder="Description">{{ optional($data)->roman_label ?? null }}</textarea>
                </div>


            </div>

            <button class="btn btn-primary customSaveButton" type="submit">Save</button>
        </form>
    </div>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>

</x-app-layout>