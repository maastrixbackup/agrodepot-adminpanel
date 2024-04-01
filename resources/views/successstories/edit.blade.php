<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Edit Success Story</h1>
        </div>
        <div class="col-2"><a href="{{ route('success-stories.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('success-stories.update', ['success_story' => $data->success_id]) }}"
            class="row" enctype="multipart/form-data">

            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <label for="input40" class="col-sm-4 col-form-label">User</label>
                <select name="user_id" value="{{ $data->user_id }}" class="form-control form-select">
                    <option value="">Select a user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->user_id }}" @if ($user->user_id == $data->user_id) selected @endif>{{ $user->first_name }}
                            {{ $user->last_name }}</option>
                    @endforeach
                </select>
                @error('user')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <div>
                    <label for="bannerTitle1" class="col-sm-4 col-form-label">Description</label>
                    <textarea class="ckeditor form-control" name="content" id="bannerTitle1" placeholder="Description">{{ $data->content }}</textarea>
                    @error('content')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <label for="input40" class="col-sm-4 col-form-label">User</label>
                <select value={{ $data->status }} name="status" class="form-control form-select">
                    <option @if (1 == $data->status) selected @endif value="1">Active</option>
                    <option @if (0 == $data->status) selected @endif value="0">Inctive</option>

                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button class="btn btn-primary customSaveButton" type="submit">Save</button>
        </form>

    </div>

</x-app-layout>
