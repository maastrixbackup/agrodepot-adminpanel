<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add NewsLetter</h1>
        </div>
        <div class="col-2"><a href="{{ route('newsletters.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('newsletters.store') }}" class="row">
            @csrf
            <div class="col-8 form-group">
                <div>
                    <label for="news_name">News Name</label>
                    <input type="text" name="news_name" class="form-control" id="news_name">
                    @error('news_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="news_email">E-Mail ID</label>
                    <input type="text" name="news_email" class="form-control" id="news_email">
                    @error('news_email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="status">Status</label>
                    <select name ='status' class="form-control" id="status">
                        <option value='1'>Confirmed</option>
                        <option value='0'>Not Confirmed</option>
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
