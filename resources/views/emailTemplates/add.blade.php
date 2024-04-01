<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add Banner</h1>
        </div>
        <div class="col-2"><a href="{{ route('templates.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('templates.store') }}" class="row">
            @csrf
            <div class="col-8 form-group">
                <div>
                    <label for="email_of">Select For</label>
                    <select name="email_of" class="form-control" value="{{ old('email_of') }}">
                        <option value="">Select</option>
                        <option value="1">Register for User</option>
                        <option value="2">Forgot password</option>
                        <option value="3">User Past Ad Order</option>
                        <option value="4">Admin Past Ad Order</option>
                        <option value="5">User Register for Admin</option>
                        <option value="6">Seller Past Ad Order</option>
                        <option value="7">Parts Request Question(parent)</option>
                        <option value="8">Parts Request Question(sub question)</option>
                        <option value="9">Bid Offer</option>
                        <option value="10">Sales Question</option>
                        <option value="11">Parts Order to User</option>
                        <option value="12">Parts Order to Bidder</option>
                        <option value="13">Parts Order to Admin</option>
                        <option value="14">Subscribe Alert for ad</option>
                        <option value="15">Subscribe Alert for Request Parts</option>
                    </select> 
                       
                    @error('email_of')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="mail_subject">Mail Subject</label>
                    <input type="text" name="mail_subject" class="form-control" id="mail_subject"
                        value="{{ old('mail_subject') }}">
                    @error('mail_subject')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="mail_body" class="col-sm-4 col-form-label">Caption</label>
                    <textarea class="ckeditor form-control" name="mail_body" id="mail_body" placeholder="Description">{{ old('mail_body') }}</textarea>
                    @error('mail_body')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="status">Status</label>
                    <select name="status" class="form-control" id="status">
                        <option >Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
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
