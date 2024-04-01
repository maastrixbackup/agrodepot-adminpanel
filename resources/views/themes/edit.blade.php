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
        <form method="POST" action="{{ route('themes.update',['theme' => $data->theme_id ])}}" class="row" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8 form-group">
                <div>
                    <label for="html_tag">Select Tags</label>
                    <select name="html_tag" class="form-control" id="html_tag">
                        <option value="">select</option>
                        <option value="p" {{ $data->html_tag == 'p' ? 'selected' : '' }}>Paragraph</option>
                        <option value="a" {{ $data->html_tag == 'a' ? 'selected' : '' }}>Anchor</option>
                        <option value="li" {{ $data->html_tag == 'li' ? 'selected' : '' }}>Listing</option>
                        <option value="div" {{ $data->html_tag == 'div' ? 'selected' : '' }}>Division</option>
                        <option value="h1" {{ $data->html_tag == 'h1' ? 'selected' : '' }}>Heading 1</option>
                        <option value="h2" {{ $data->html_tag == 'h2' ? 'selected' : '' }}>Heading 2</option>
                        <option value="h3" {{ $data->html_tag == 'h3' ? 'selected' : '' }}>Heading 3</option>
                        <option value="h4" {{ $data->html_tag == 'h4' ? 'selected' : '' }}>Heading 4</option>
                        <option value="h5" {{ $data->html_tag == 'h5' ? 'selected' : '' }}>Heading 5</option>
                        <option value="h6" {{ $data->html_tag == 'h6' ? 'selected' : '' }}>Heading 6</option>
                        <option value="body" {{ $data->html_tag == 'body' ? 'selected' : '' }}>Body</option>
                        <option value="*" {{ $data->html_tag == '*' ? 'selected' : '' }}>all</option>
                    </select>
                   
                    @error('html_tag')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="font_size">Font Size</label>
                    <select name="font_size" class="form-control" id="font_size">
                        <option value="">select</option>
                        <option value="9px" {{ $data->font_size == '9px' ? 'selected' : '' }}>9px</option>
                        <option value="10px" {{ $data->font_size == '10px' ? 'selected' : '' }}>10px</option>
                        <option value="12px" {{ $data->font_size == '12px' ? 'selected' : '' }}>12px</option>
                        <option value="14px" {{ $data->font_size == '14px' ? 'selected' : '' }}>14px</option>
                        <option value="16px" {{ $data->font_size == '16px' ? 'selected' : '' }}>16px</option>
                        <option value="18px" {{ $data->font_size == '18px' ? 'selected' : '' }}>18px</option>
                        <option value="24px" {{ $data->font_size == '24px' ? 'selected' : '' }}>24px</option>
                        <option value="36px" {{ $data->font_size == '36px' ? 'selected' : '' }}>36px</option>
                        <option value="small" {{ $data->font_size == 'small' ? 'selected' : '' }}>small</option>
                        <option value="medium" {{ $data->font_size == 'medium' ? 'selected' : '' }}>medium</option>
                        <option value="large" {{ $data->font_size == 'large' ? 'selected' : '' }}>Large</option>
                        <option value="smaller" {{ $data->font_size == 'smaller' ? 'selected' : '' }}>smaller</option>
                        <option value="larger" {{ $data->font_size == 'larger' ? 'selected' : '' }}>larger</option>
                    </select>
                   
                    @error('font_size')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="font_color" class="col-sm-4 col-form-label">Font Color</label>
                    <input type="text" name="font_color" class="form-control" id="colorInput" value="{{ $data->font_color }}" onclick="showColorPicker()">
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
      document.getElementById('colorPicker').style.display = 'block';
    }

    function updateColorPicker() {
      var colorInputValue = document.getElementById('colorInput').value;
      document.getElementById('colorPicker').value = '#' + colorInputValue;

     
    }

    function updateColor() {
    
      var selectedColor = document.getElementById('colorPicker').value;
      document.getElementById('colorInput').value = selectedColor.substring(1);
   
      document.getElementById('colorPicker').style.display = 'none';
    }
  </script>
 

</x-app-layout>
