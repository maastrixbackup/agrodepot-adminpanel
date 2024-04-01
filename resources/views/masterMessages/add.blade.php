<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add SEO Fields</h1>
        </div>
        <div class="col-2"><a href="{{ route('messages.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('messages.store') }}" class="row">
            @csrf
            <div class="col-8 form-group">
                <div>
                    <label for="msg_name">Message Name</label>
                    <input type="text" name="msg_name" class="form-control" id="msg_name">
                    @error('msg_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="pass">Message</label>
                    <textarea name="msg" class="form-control" id="msg"></textarea>
                    @error('msg')
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
