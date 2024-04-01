<x-app-layout>

    <style>
        .hidden {
            display: none;
        }
    </style>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Add Advertisement</h1>
        </div>
        <div class="col-2"><a href="{{ route('advertises.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('advertises.store') }}" class="row" enctype="multipart/form-data">
            @csrf
            <div class="col-8 form-group">
                <div>
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="ad_type">Ad Type</label>
                    <input type="radio" name="ad_type" value="1" id="bannerRadio" onclick="toggleFields()"> Banner
                    <input type="radio" name="ad_type" value="2" id="scriptRadio" onclick="toggleFields()"> Script
                    
                    @error('ad_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div id="bannerFields" class="hidden">
                    <label for="bannerName">Banner Name:</label>
                    <input type="text" id="bannerName" name="banner_title"><br>
                    <label for="bannerName">Banner Link:</label>
                    <input type="text" id="bannerLink" name="banner_link"><br>
                    <label for="bannerImage">Banner Image:</label>
                    <input type="file" id="bannerImage" name="banner_image">
                </div>
        
                <div id="scriptFields" class="hidden">
                    <label for="scriptText">Script Text:</label>
                    <textarea id="scriptText" name="ad_script"></textarea>
                </div>
              
                <div>
                    <label for="show_position">Show Position</label>
                    <select name="show_position" class="form-control" id="show_position">
                        <option value="">show position</option>
                        <option value="1">Top</option>
                        <option value="2">left1</option>
                        <option value="3">left2</option>
                        <option value="4">Middle</option>
                    </select>
                    @error('show_position')
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
            <div class="col-4">



            </div>
            <button class="btn btn-primary customSaveButton" type="submit">Save</button>
        </form>
    </div>
</x-app-layout>

<script>
    function toggleFields() {
            var bannerFields = document.getElementById('bannerFields');
            var scriptFields = document.getElementById('scriptFields');

            var bannerRadio = document.getElementById('bannerRadio');
            var scriptRadio = document.getElementById('scriptRadio');
          
          

            if (bannerRadio.checked) {
                bannerFields.classList.remove('hidden');
                scriptFields.classList.add('hidden');
            } else if (scriptRadio.checked) {
                scriptFields.classList.remove('hidden');
                bannerFields.classList.add('hidden');
            }
        }

        // Initially hide the fields
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('bannerFields').classList.add('hidden');
            document.getElementById('scriptFields').classList.add('hidden');
        });
</script>
