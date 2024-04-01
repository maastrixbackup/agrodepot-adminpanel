<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Edit NewsLetters</h1>
        </div>
        <div class="col-2"><a href="{{ route('newsletters.index') }}" class="btn btn-primary">Go back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('newsletters.update',['newsletter' => $data->news_letter_id ]) }}" class="row">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="news_name">News Name</label>
                    <input type="text" name="news_name" class="form-control" id="news_name"
                        value="{{ optional($data)->news_name }}">
               
                </div>
                <div>
                    <label for="Email">E-Mail ID</label>
                    <input type="text" name="news_email" class="form-control" id="news_email" value="{{ optional($data)->news_email }}">
                 
                </div>
                <div class="col-4">
                    <label for="status">Status</label>
                    <select class="form-control form-select" name="status" id="status">
                        <option value="1" {{ $data->status == '1' ? 'selected' : '' }}>Confirmed</option>
                        <option value="0" {{ $data->status == '0' ? 'selected' : '' }}>Not Confirmed</option>
                    </select>
                </div>
            </div>
            <div class="col-4">
            </div>
            <button class="btn btn-primary customSaveButton" type="submit">Save</button>
        </form>
    </div>

</x-app-layout>
