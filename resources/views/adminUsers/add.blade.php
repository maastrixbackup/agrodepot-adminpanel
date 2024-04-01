<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add Language</h1>
        </div>
        <div class="col-2"><a href="{{ route('admin-users.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('admin-users.store') }}" class="row">
            @csrf
            <div class="col-8 form-group">
                <div>
                    <label for="full_name">Full Name</label>
                    <input type="text" name="full_name" class="form-control" id="full_name">
                    @error('full_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="mail_id">E-Mail ID</label>
                    <input type="text" name="mail_id" class="form-control" id="mail_id">
                    @error('mail_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="user_id">User ID</label>
                    <input type="text" name="user_id" class="form-control" id="user_id">
                    @error('user_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="pass">Password</label>
                    <input type="password" name="pass" class="form-control" id="pass">
                    @error('pass')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="status">Is Active</label>
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" id="status" value=1>
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
