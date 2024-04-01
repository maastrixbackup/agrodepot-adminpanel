<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Edit Brands</h1>
        </div>
        <div class="col-2"><a href="{{ route('memberships.index') }}" class="btn btn-primary">Go back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('memberships.update',['membership' => $data->memb_id ]) }}" class="row" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="memb_type">Member Type</label>
                    <input type="text" name="memb_type" class="form-control" id="memb_type"
                        value="{{ optional($data)->memb_type }}">
               
                </div>
                <div>
                    <label for="Price">Price</label>
                    <input type="text" name="price" class="form-control" id="Price" value="{{ optional($data)->price }}">
                 
                </div>
                <div>
                    <label for="credits">Credits</label>
                    <input type="text" name="credits" class="form-control" id="credits"  value="{{ optional($data)->credits }}">
                 
                </div>
                <div class="col-4">
                    <label for="status">Status</label>
                    <select class="form-control form-select" name="status" id="status">
                        <option value="1" {{ $data->status == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $data->status == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div>
                    <label for="plan_img">Membership Image</label>
                    <input type="file" name="plan_img" class="form-control" id="plan_img">
                    <img src="{{ asset('uploads/memberplanimg/' . optional($data)->plan_img) }}" alt="image" id="pImage" height='70px' width='70px'>
                    @error('plan_img')
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
