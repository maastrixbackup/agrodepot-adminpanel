<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Add Amounts</h1>
        </div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('credits.update',['credit' => $data->credit_id ]) }}" class="row">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="credits">Credit</label>
                    <input type="text" name="credits" class="form-control" id="credits">
                    @error('credits')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button class="btn btn-primary customSaveButton" type="submit">Save</button>
        </form>
    </div>

</x-app-layout>
