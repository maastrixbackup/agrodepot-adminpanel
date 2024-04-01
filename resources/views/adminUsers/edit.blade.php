<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Edit Brands</h1>
        </div>
        <div class="col-2"><a href="{{ route('admin-users.index') }}" class="btn btn-primary">Go back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('admin-users.update',['admin_user' => $data->uid]) }}" class="row">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="full_name">Brand Name</label>
                    <input type="text" name="full_name" class="form-control" id="full_name"
                        value="{{ optional($data)->full_name }}">
               
                </div>
                <div>
                    <label for="mail_id">E-Mail ID</label>
                    <input type="text" name="mail_id" class="form-control" id="mail_id" value="{{ optional($data)->mail_id }}">
                 
                </div>
                <div>
                    <label for="user_id">User ID</label>
                    <input type="text" name="user_id" class="form-control" id="user_id"  value="{{ optional($data)->user_id }}">
                 
                </div>
                <div>
                    <label for="pass">Password</label>
                    <input type="password" name="pass" class="form-control" id="pass"  value="{{ optional($data)->pass }}">
                 
                </div>
                
                <div>
                    <label for="status">Status</label>
                    <input type="checkbox" name="status" id="status" value="1" @if(old('status', optional($data)->is_active) == 1) checked @endif>
                    @error('status')
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
