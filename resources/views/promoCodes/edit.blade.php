<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Edit Promo Code</h1>
        </div>
        <div class="col-2"><a href="{{ route('promo-codes.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('promo-codes.update',['promo_code' => $code->id]) }}" class="row">
            @csrf
            @method('PATCH')
            <div class="col-8 form-group">
                <div>
                    <label for="page_name">Promo code title</label>
                    <input type="text" name="title" class="form-control" id="title" value={{ $code->title }}>
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="page_name">Promo code</label>
                    <input type="text" name="code" class="form-control" id="code" value={{ $code->code }}>
                    @error('code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form--box">
                            <label for="status">Type</label>
                            <select name="type" class="form-control" id="status">
                                <option value="">-Type-</option>
                                <option {{ $code->type == 1 ? 'selected' : '' }} value="1">Percentage</option>
                                <option {{ $code->type == 2 ? 'selected' : '' }} value="2">Fixed</option>
                            </select>
                            @error('type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="page_name">Discount amount / %</label>
                        <input type="text" name="value" class="form-control" id="title"
                            value={{ $code->value }}>
                        @error('value')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="page_name">Expiry Date</label>
                        <input type="date" name="expiry_date" class="form-control" id="title"
                            value={{ $code->expiry_date }}>
                        @error('expiry_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <div class="form--box">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" id="status" value={{ $code->status }}>
                                <option value="">Status</option>
                                <option {{ $code->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                <option {{ $code->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary customSaveButton" type="submit">Save</button>
        </form>

    </div>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>

</x-app-layout>
