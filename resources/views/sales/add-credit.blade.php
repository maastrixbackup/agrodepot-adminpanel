<x-app-layout>
    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add Credits</h1>
        </div>
        <div class="col-2"><a href="{{ route('usercredits') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{route('save-credit')}}" class="row" enctype="multipart/form-data">
            @csrf
            <div class="col-10 form-group">
                <div class="mt-2">
                    <label for="user_id">Enter User Email</label>
                    <input type="text" name="user_id" class="form-control" id="user_id"
                        value="{{ old('user_id') }}" onkeyup="autocomplet()">
                    @error('user_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <ul class="auto-data" id="user_list_id"></ul>
                </div>

                <div class="mt-2">
                    <label for="credits">Enter Credit amount</label>
                    <input type="text" name="credits" class="form-control" id="credits"
                        value="{{ old('credits') }}">
                    @error('credits')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button class="btn btn-primary customSaveButton" type="submit">Save</button>
        </form>

    </div>
    <script type="text/javascript">
        function autocomplet() {
            var min_length = 0; // min characters to display the autocomplete
            var keyword = $('#user_id').val(); // Corrected id to 'user_id'
            if (keyword.length >= min_length) {
                $.ajax({
                    url: "{{ route('autocomplete') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        keyword: keyword
                    },
                    success: function(data) {
                        //alert(data);
                        $('#user_list_id').show();
                        $('#user_list_id').html(data);
                    }
                });
            } else {
                $('#user_list_id').hide();
            }
        }

        function set_item(item) {
            // change input value
            $('#user_id').val(item);
            // hide proposition list
            $('#user_list_id').hide();
        }
    </script>
    <style>
        ul.auto-data li {
            padding: 7px 3px;
            border-bottom: 1px solid #c1c1c1;
            background-color: #e9e9e9;
            cursor: pointer;
        }
    </style>
</x-app-layout>
