<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add Language</h1>
        </div>
        <div class="col-2"><a href="{{ route('admin-langs.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('admin-langs.store') }}" class="row">
            @csrf
            <div class="col-8 form-group">
                <div>
                    <label for="en_label">English label</label>
                    <!--  <input type="text" name="en_label" class="form-control" id="en_label"
                        value="{{ old('en_label') }}"> -->
                    <textarea class="ckeditor form-control" name="en_label" id="en_label" placeholder="Description">{{ old('en_label')}}</textarea>
                    @error('en_label')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div>
                    <label for="roman_label">Romanian Label</label>
                    <!--  <input type="text" name="roman_label" class="form-control" id="roman_label"
                        value="{{ old('roman_label') }}"> -->
                    <textarea class="ckeditor form-control" name="roman_label" id="roman_label" placeholder="Description">{{ old('en_label') }}</textarea>
                    @error('roman_label')
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