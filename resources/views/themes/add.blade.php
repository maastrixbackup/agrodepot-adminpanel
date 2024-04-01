<x-app-layout>

    <style>
        /* Add some styling to position the color picker */
        #colorPicker {
          position: absolute;
          display: none;
        }
      </style>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add Theme</h1>
        </div>
        <div class="col-2"><a href="{{ route('themes.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('themes.store') }}" class="row" enctype="multipart/form-data">
            @csrf
            <div class="col-8 form-group">
                <div>
                    <label for="html_tag">Select Tags</label>
                    <select name="html_tag" class="form-control" id="html_tag">
                        <option value="">select</option>
                        <option value="p">Paragraph</option>
                        <option value="a">Anchor</option>
                        <option value="li">Listing</option>
                        <option value="div">Division</option>
                        <option value="h1">Heading 1</option>
                        <option value="h2">Heading 2</option>
                        <option value="h3">Heading 3</option>
                        <option value="h4">Heading 4</option>
                        <option value="h5">Heading 5</option>
                        <option value="h6">Heading 6</option>
                        <option value="body">Body</option>
                        <option value="*">all</option>
                    </select>
                   
                    @error('html_tag')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="font_size">Font Size</label>
                    <select name="font_size" class="form-control" id="font_size">
                        <option value="">select</option>
                        <option value="9px">9px</option>
                        <option value="10px">10px</option>
                        <option value="12px">12px</option>
                        <option value="14px">14px</option>
                        <option value="16px">16px</option>
                        <option value="18px">18px</option>
                        <option value="24px">24px</option>
                        <option value="36px">36px</option>
                        <option value="small">small</option>
                        <option value="medium">medium</option>
                        <option value="large">Large</option>
                        <option value="smaller">smaller</option>
                        <option value="larger">larger</option>
                    </select>
                   
                    @error('font_size')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="font_color" class="col-sm-4 col-form-label">Font Color</label>
                    <input type="text" name="font_color" class="form-control" id="colorInput" onclick="showColorPicker()">
                    <input type="color" id="colorPicker" style="position: absolute; display: none;" onchange="updateColor()">
                    @error('font_color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="font_size">Font Size</label>
                    <select name="status" class="form-control" id="status">
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

<script>
    function showColorPicker() {
      // Display the color picker when the input field or button is clicked
      document.getElementById('colorPicker').style.display = 'block';
    }

    function updateColor() {
    
      var selectedColor = document.getElementById('colorPicker').value;
      document.getElementById('colorInput').value = selectedColor.substring(1);
   
      document.getElementById('colorPicker').style.display = 'none';
    }
  </script>
 

</x-app-layout>
