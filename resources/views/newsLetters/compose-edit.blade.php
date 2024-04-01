<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add News</h1>
        </div>
        <div class="col-2"><a href="{{ route('compose-mail.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('compose-mail.update', ['compose_mail' => $data->compose_id]) }}" class="row">
            @csrf
            @method('PUT')
            <div class="col-10 form-group">
                <div>
                    <label for="user_type"></label>
                    <input type="radio" name="user_type" value="3" id="user_type" {{ $data->user_type == 3 ? 'checked' : '' }}>Subscriber
                    <input type="radio" name="user_type" value="1" id="user_type" {{ $data->user_type == 1 ? 'checked' : '' }}>Buyer
                    <input type="radio" name="user_type" value="2" id="user_type" {{ $data->user_type == 2 ? 'checked' : '' }}>Seller
                    
                    @error('user_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="mail_subject">Mail Subject</label>
                    <input type="text" name="mail_subject" class="form-control" id="mail_subject" value="{{$data->mail_subject}}">
                    @error('mail_subject')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="mail_body">Mail Body</label>
                    <textarea class="ckeditor form-control" name="mail_body" id="mail_body" placeholder="Description">{{$data->mail_body }}</textarea>
                    @error('mail_body')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="input40" class="col-sm-4 col-form-label">Status</label>
                    <select name="status" class="form-control form-select">
                        <option @if (1 == $data->status) selected @endif value="1">Active</option>
                        <option @if (0 == $data->status) selected @endif value="0">Inctive</option>

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
