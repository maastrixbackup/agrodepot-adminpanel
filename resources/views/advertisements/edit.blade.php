<x-app-layout>

    <style>
        .hidden {
            display: none;
        }
    </style>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Update Advertisement</h1>
        </div>
        <div class="col-2"><a href="{{ route('advertises.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('advertises.update',['advertise' => $data->ad_id]) }}" class="row" enctype="multipart/form-data">
            @csrf 
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="title">Title</label>
                    <input type="text" name="title" value="{{ optional($data)->title }}" class="form-control" id="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="ad_type">Ad Type</label>
                    <input type="radio" name="ad_type" value="1" id="bannerRadio" {{ optional($data)->ad_type == 1 ? 'checked' : '' }} onclick="toggleFields()"> Banner
                    <input type="radio" name="ad_type" value="2" id="scriptRadio" {{ optional($data)->ad_type == 2 ? 'checked' : '' }} onclick="toggleFields()"> Script
                    
                    @error('ad_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div id="bannerFields" class="hidden">
                    <label for="bannerName">Banner Name:</label>
                    <input type="text" id="bannerName" name="banner_title" value="{{ optional($data)->banner_title }}"><br>
                    <label for="bannerName">Banner Link:</label>
                    <input type="text" id="bannerLink" name="banner_link" value="{{ optional($data)->banner_link }}"><br>
                    <label for="bannerImage">Banner Image:</label>
                    <input type="file" id="bannerImage" name="banner_image">
                    <img src="{{ asset('uploads/advertisement/' . optional($data)->banner_image) }}" alt="image" height="70px" width="70px"
                   >
                </div>
        
                <div id="scriptFields" class="hidden">
                    <label for="scriptText">Script Text:</label>
                    <textarea id="scriptText" name="ad_script" value="">{{ optional($data)->ad_script }}</textarea>
                </div>
              
                <div>
                    <label for="show_position">Show Position</label>
                    <select name="show_position" class="form-control" id="show_position">
                        <option value="1" {{ optional($data)->show_position == 1 ? 'selected' : '' }}>Top</option>
                        <option value="2" {{ optional($data)->show_position == 2 ? 'selected' : '' }}>Left1</option>
                        <option value="3" {{ optional($data)->show_position == 3 ? 'selected' : '' }}>Left2</option>
                        <option value="4" {{ optional($data)->show_position == 4 ? 'selected' : '' }}>Middle</option>
                    </select>
                    @error('show_position')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="status">Status</label>
                    <select name="status" class="form-control" id="status">
                        <option >Status</option>
                        <option value="1" {{ optional($data)->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ optional($data)->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
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


 
 <script>
    document.addEventListener('DOMContentLoaded', function() {
        var bannerFields = document.getElementById('bannerFields');
        var scriptFields = document.getElementById('scriptFields');
        var bannerRadio = document.getElementById('bannerRadio');
        var scriptRadio = document.getElementById('scriptRadio');
      
        // Initially hide the fields
        bannerFields.classList.add('hidden');
        scriptFields.classList.add('hidden');

        // Check the initial state of ad_type and show the corresponding fields
        if ({{ optional($data)->ad_type }} === 1) {
            bannerRadio.checked = true;
            bannerFields.classList.remove('hidden');
        } else if ({{ optional($data)->ad_type }} === 2) {
            scriptRadio.checked = true;
            scriptFields.classList.remove('hidden');
        }

        // Add event listeners to radio buttons to toggle fields
        bannerRadio.addEventListener('click', function() {
            bannerFields.classList.remove('hidden');
            scriptFields.classList.add('hidden');
        });

        scriptRadio.addEventListener('click', function() {
            scriptFields.classList.remove('hidden');
            bannerFields.classList.add('hidden');
        });
    });
</script>











