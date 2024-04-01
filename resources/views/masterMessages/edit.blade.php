<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Edit Messages</h1>
        </div>
        <div class="col-2"><a href="{{ route('messages.index') }}" class="btn btn-primary">Go back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('messages.update',['message' => $data->msg_id]) }}" class="row">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="msg_name">Message Name</label>
                    <input type="text" name="msg_name" class="form-control" id="msg_name"
                        value="{{ optional($data)->msg_name }}">
               
                </div>
                <div>
                    <label for="pass">Message</label>
                    <textarea name="msg" class="form-control" id="msg">{{ optional($data)->msg }}</textarea>
                    @error('msg')
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
