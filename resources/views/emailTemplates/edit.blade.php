<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add Banner</h1>
        </div>
        <div class="col-2"><a href="{{ route('templates.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('templates.update',['template' => $data->compose_id])}}" class="row" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="email_of">Select For</label>
                    <select name="email_of" class="form-control" value="{{ old('email_of') }}">
                        <option value="1" {{ $data->email_of == '1' ? 'selected' : '' }}>Register for User</option>
                        <option value="2" {{ $data->email_of == '2' ? 'selected' : '' }}>Forgot password</option>
                        <option value="3"  {{ $data->email_of == '3' ? 'selected' : '' }}>User Past Ad Order</option>
                        <option value="4"  {{ $data->email_of == '4' ? 'selected' : '' }}>User Register for Admin</option>
                        <option value="5"  {{ $data->email_of == '5' ? 'selected' : '' }}> Admin Past Ad Order</option>
                        <option value="6"  {{ $data->email_of == '6' ? 'selected' : '' }}>Seller Past Ad Order</option>
                        <option value="7"  {{ $data->email_of == '7' ? 'selected' : '' }}>Parts Request Question(parent)</option>
                        <option value="8"  {{ $data->email_of == '8' ? 'selected' : '' }}>Parts Request Question(sub question)</option>
                        <option value="9"  {{ $data->email_of == '9' ? 'selected' : '' }}>Bid Offer</option>
                        <option value="10"  {{ $data->email_of == '10' ? 'selected' : '' }}>Sales Question</option>
                        <option value="11"  {{ $data->email_of == '11' ? 'selected' : '' }}>Parts Order to User</option>
                        <option value="12"  {{ $data->email_of == '12' ? 'selected' : '' }}>Parts Order to Bidder</option>
                        <option value="13"  {{ $data->email_of == '13' ? 'selected' : '' }}>Parts Order to Admin</option>
                        <option value="14"  {{ $data->email_of == '14' ? 'selected' : '' }}>Subscribe Alert for ad</option>
                        <option value="15"  {{ $data->email_of == '15' ? 'selected' : '' }}>Subscribe Alert for Request Parts</option>
                    </select> 
                       
                    @error('email_of')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="mail_subject">Mail Subject</label>
                    <input type="text" name="mail_subject" class="form-control" id="mail_subject"
                        value="{{ old('mail_subject',$data->mail_subject) }}">
                    @error('mail_subject')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="mail_body" class="col-sm-4 col-form-label">Caption</label>
                    <textarea class="ckeditor form-control" name="mail_body" id="mail_body" placeholder="Description">{{ old('mail_body',$data->mail_body) }}</textarea>
                    @error('mail_body')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="status">Status</label>
                    <select class="form-control form-select" name="compose_status" id="compose_status">
                        <option value="1" {{ $data->compose_status == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $data->compose_status == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('compose_status')
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
