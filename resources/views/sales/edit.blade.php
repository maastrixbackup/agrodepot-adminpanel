<x-app-layout>

    <style>
        /* #image-preview {
            display: flex;
            flex-wrap: wrap;
        }

        .preview-container {
            position: relative;
            margin: 5px;
        }

        .preview-image {
            max-width: 100px;
            max-height: 100px;
        }

        .close-icon {
            position: absolute;
            top: 0;
            right: 0;
            cursor: pointer;
            background-color: white;
            padding: 2px;
        }

        .rotate-buttons {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .rotate-icon {
            cursor: pointer;
            background-color: white;
            padding: 2px;
        } */

        img {
            display: block;
            max-width: 100%;
        }

        .thumbnail {
            display: inline-block;
            margin: 10px;
            cursor: pointer;
            position: relative;
            /* Added */
        }

        .thumbnail img {
            width: 200px;
            height: auto;
        }

        .thumbnail .close-icon {
            position: absolute;
            top: 5px;
            right: 5px;
            color: red;
            font-size: 18px;
            cursor: pointer;
            z-index: 1000;
        }

        .img-container {
            max-width: 100%;
            max-height: 80vh;
            overflow: auto;
        }

        .modal-lg {
            max-width: 1000px !important;
        }

        .thumbnail.active {
            border: 2px solid #f00;
            /* Change border color to highlight */
            /* Add any other styles to highlight the active thumbnail */
        }
    </style>

    <div class="row">



        <div class="col-10">
            <h1 class="text-center mb-3">Edit User</h1>
        </div>
        <div class="col-2"><a href="{{ route('sales.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <h3>Edit User</h3>
        <form method="POST" action="{{ route('sales.update', ['sale' => $data->adv_id]) }}" class="row"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-10 form-group">

                <div>
                    <label for="input40" class="col-sm-4 col-form-label">Select User</label>
                    <select name="user_id" class="form-control form-select">
                        <option value="">Select a user</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->user_id }}" @if ($user->user_id == $data->user_id) selected @endif>
                                {{ $user->first_name }} {{ $user->last_name }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="row">
                    <div class="col-6"><label for="input40" class="col-sm-4 col-form-label">Select a Category</label>
                        <select name="category_id" class="form-control form-select" id="category">
                            <option value="">Select a user</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}"
                                    @if ($category->category_id == $data->category_id) selected @endif>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-6"><label for="input40" class="col-sm-4 col-form-label">Select a
                            SubCategory</label>
                        <select name="sub_cat_id" id="sub_cat_id" class="form-control form-select">
                            <option value="">Select a Sub-Category</option>
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->category_id }}"
                                    @if ($subcategory->category_id == $data->sub_cat_id) selected @endif>{{ $subcategory->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="mt-2">
                    <label for="adv_name">Name of the song</label>
                    <label for="adv_name">Use a title as suggestive and completely.
                        eg BMW 3 Series E46 front bumper year in 2001 with projectors and green grid.</label>
                    <input type="text" name="adv_name" class="form-control" id="adv_name"
                        value="{{ old('adv_name', $data->adv_name) }}">

                </div>
                <div>
                    <label for="news_content">Details about the song sold</label><br>
                    <label for="news_content">Describe as detailed piece on sale. The
                        more customers,
                        the chances of selling increase exponentially.</label>
                    <textarea class="ckeditor form-control" name="adv_details" id="adv_details" placeholder="Description">{{ old('adv_details', $data->adv_details) }}</textarea>

                </div>
                {{-- <div>
                    <div id="files"></div>
                    <label for="input40" class="col-sm-4 col-form-label">Image</label>

                    <input type="file" class="form-control" name="adv_img[]" id="adv_img"
                        onchange="previewImages()" accept="image/*" multiple>

                    @foreach ($images as $key => $image)
                        <div class="imageContainer">
                            <img src="{{ asset('uploads/postad/' . $image->img_path) }}" height="70px" width="70px">
                            <input type="hidden" name="image[{{ $key }}]" value="{{ $image->imgid }}">
                            <button class="removeImg" type="submit" data-image-id="{{ $image->imgid }}">X</button>
                        </div>
                    @endforeach




                </div> --}}
                <div class="img-prev-container">
                    {{-- <input type="file" name="files[]" id="fileupload" multiple> --}}
                    <div id="files"></div>
                    <label for="input40" class="col-sm-4 col-form-label">Image (Rotate images by clicking on
                        them.)</label>
                    <!--<input type="file" class="form-control" name="adv_img[]" id="adv_img" accept="image/*" multiple-->
                    <!--    onchange="previewImages()">-->
                    <!--@error('adv_img')
    -->
                        <!--    <span class="text-danger">{{ $message }}</span>-->
                        <!--
@enderror-->
                    <input type="file" id="images" name="images[]" class="images form-control" multiple
                        accept="image/*">
                    <input type="hidden" id="rotation-angle" name="rotation_angle[]">
                    @foreach ($images as $key => $image)
                        <div class="imageContainer">
                            <img src="{{ asset('uploads/postad/' . $image->img_path) }}" height="70px" width="70px">
                            <input type="hidden" name="image[{{ $key }}]" value="{{ $image->imgid }}">
                            <button class="removeImg" type="submit" data-image-id="{{ $image->imgid }}">X</button>
                        </div>
                    @endforeach
                    <!-- Add hidden input for rotation angle -->
                    <!-- Hidden inputs for thumbnail images -->



                </div>

                <div id="image-preview"></div>

                <div class="row" id="brandModelRow_0">
                    <div class="col-6"><label for="input40" class="col-sm-4 col-form-label">Select a Brand</label>
                        <select name="adv_brand_id" id="adv_brand_id" class="form-control form-select">
                            <option value="">choose brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->brand_id }}"
                                    @if ($brand->brand_id == $data->adv_brand_id) selected @endif>
                                    {{ $brand->brand_name }}
                                </option>
                            @endforeach

                        </select>

                    </div>
                    <div class="col-6"><label for="input40" class="col-sm-4 col-form-label">Select Model</label>
                        <select name="adv_model_id" id="adv_model_id" class="form-control form-select">
                            <option value="">choose Model</option>

                        </select>
                    </div>



                    <div class="col-2">
                        <button type="button" onclick="addBrandModelRow()">Add</button>

                    </div>

                </div>
                <div class="row">
                    @foreach ($selectedModels as $key => $brand)
                        <div class="row" id="brandModelRow_{{ $key + 1 }}">
                            <div class="col-6">
                                <label for="input40" class="col-sm-4 col-form-label"></label>
                                <input type="text" name="adv_brand_id[{{ $brand->parent->brand_id }}]"
                                    value={{ $brand->parent->brand_name }} class="form-control"
                                    placeholder="Enter Brand">

                            </div>
                            <div class="col-6">
                                <label for="input40" class="col-sm-4 col-form-label"></label>
                                <input type="text" name="adv_model_id[{{ $brand->brand_id }}]"
                                    value={{ $brand->brand_name }} class="form-control" placeholder="Enter Model">
                            </div>

                            <div class="col-2">
                                <button type="button"
                                    onclick="removeBrandModelRow({{ $key + 1 }})">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="brandModelContainer"></div>
                <div>
                    <label for="input40" class="col-sm-4 col-form-label">Product Condition</label>
                    <select name="product_cond" class="form-control form-select">
                        <option value="" @if (empty($data->product_cond)) selected @endif>Select</option>
                        <option value="new" @if ($data->product_cond == 'new') selected @endif>New</option>
                        <option value="old" @if ($data->product_cond == 'old') selected @endif>Old</option>
                    </select>

                </div>
                <div class="row">
                    <div class="mt-2 col-3">
                        <label for="price">Price</label>
                        <input type="text" name="price" class="form-control" id="price"
                            value="{{ old('price', $data->price) }}">

                    </div>
                    <div class="mt-2 col-3">
                        <label for="price">Price</label>
                        <input type="text" name="b2bprice" class="form-control" id="price"
                            value="{{ old('b2bprice', $data->b2bprice) }}">

                    </div>

                    <div class='col-6'>
                        <label for="input40" class="col-sm-4 col-form-label">Currency</label>
                        <select name="currency" class="form-control form-select">
                            <option value="" @if (empty($data->currency)) selected @endif>Select</option>
                            <option value="RON" @if ($data->currency == 'RON') selected @endif>RON</option>
                        </select>

                    </div>
                </div>

                <div class="mt-2">
                    <label for="quantity">Number Of Pieces</label>
                    <input type="text" name="quantity" class="form-control" id="quantity"
                        value="{{ old('quantity', $data->quantity) }}">

                </div>
                <div class="mt-2">
                    <label for="payment_mode">Payment Methods</label><br>
                    <input type="radio" name="payment_mode" id="payment_mode_cod" value="Cash on delivery"
                        @if ($data->payment_mode == 'Cash on delivery') checked @endif> Cash on delivery

                    <input type="radio" name="payment_mode" id="payment_mode_ud" value="Upon delivery"
                        @if ($data->payment_mode == 'Upon delivery') checked @endif> Upon delivery

                    <input type="radio" name="payment_mode" id="payment_mode_wt" value="Wire Transfer"
                        @if ($data->payment_mode == 'Wire Transfer') checked @endif> Wire Transfer

                    <input type="radio" name="payment_mode" id="payment_mode_bc" value="Banking Card"
                        @if ($data->payment_mode == 'Banking Card') checked @endif> Banking Card

                    <input type="radio" name="payment_mode" id="payment_mode_others" value="Others"
                        @if ($data->payment_mode == 'Others') checked @endif> Others


                </div>
                <div class="mt-2">
                    <label for="delivery">Method Of Delivery</label><br>
                    <input type="checkbox" name="personal_teaching" id="personal_teaching" value="1"
                        @if ($data->personal_teaching == 1) checked @endif> Personal Teaching<br>

                    <input type="checkbox" name="courier" id="courier" value="1"
                        @if ($data->courier == 1) checked @endif> Courier Delivery Cost
                    <input type="text" name="courier_cost" id="courier_cost" value="{{ $data->courier_cost }}">
                    RON<br>

                    <input type="checkbox" name="free_courier" id="free_courier" value="1"
                        @if ($data->free_courier == 1) checked @endif> Free delivery by courier<br>

                    <input type="checkbox" name="romanian_mail" id="romanian_mail" value="1"
                        @if ($data->romanian_mail == 1) checked @endif> Romanian Mail Delivery Cost
                    <input type="text" name="romanian_mail_cost" id="romanian_mail_cost"
                        value="{{ $data->romanian_mail_cost }}"> RON<br>

                    <input type="checkbox" name="free_romanian_mail" id="free_romanian_mail" value="1"
                        @if ($data->free_romanian_mail == 1) checked @endif> Free Shipping by Mail<br>

                </div>
                <div class='col-6'>
                    <label for="input40" class="col-sm-4 col-form-label">Time Required</label>
                    <select name="time_required" class="form-control" id="ManageSaleTimeRequired"
                        required="required">
                        <option value="1" @if ($data->time_required == 1) selected @endif>1 Day</option>
                        <option value="2" @if ($data->time_required == 2) selected @endif>2 Days</option>
                        <option value="3" @if ($data->time_required == 3) selected @endif>3 Days</option>
                        <option value="4" @if ($data->time_required == 4) selected @endif>4 Days</option>
                        <option value="5" @if ($data->time_required == 5) selected @endif>5 Days</option>
                        <option value="10" @if ($data->time_required == 10) selected @endif>10 Days</option>
                        <option value="15" @if ($data->time_required == 15) selected @endif>15 Days</option>
                        <option value="30" @if ($data->time_required == 30) selected @endif>30 Days</option>
                    </select>


                </div>

                <div>
                    <label for="input40" class="col-sm-4 col-form-label">Status</label>
                    <select name="adv_status" class="form-control form-select">
                        <option value="1" @if ($data->adv_status == 1) selected @endif>Active</option>
                        <option value="0" @if ($data->adv_status == 0) selected @endif>Inactive</option>
                    </select>


                </div>

            </div>

            <button class="btn btn-primary customSaveButton" type="submit">Save</button>
        </form>
    </div>
    <div class="modal previw-mod fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Rotate Image Before Uploading</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container text-center">
                        <img id="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="rotate-left"><i
                            class="fas fa-undo"></i></button>
                    <button type="button" class="btn btn-primary" id="rotate-right"><i
                            class="fas fa-redo"></i></button>
                    <button type="button" class="btn btn-primary" id="save"> Save</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>

    <script>
        $('[name="category_id"]').change((e) => {
            const catId = e.target.value;
            $.ajax({
                url: `/admin/get-sub-categories/${catId}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    var string = "<option>Select a Sub-Category</option>";
                    response.data.forEach(element => {
                        string +=
                            `<option value="${element.category_id}">${element.category_name}</option>`;
                    });
                    $('#sub_cat_id').html(string);
                },
                error: function(error) {
                    console.error('AJAX error:', error);
                }
            });
        });



        $('[name="adv_brand_id"]').change((e) => {
            const Id = e.target.value;
            $.ajax({
                url: `/admin/get-models/${Id}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    var string = "<option>Select model</option>";
                    response.data.forEach(element => {
                        string +=
                            `<option value="${element.brand_id}">${element.brand_name}</option>`;
                    });
                    $('#adv_model_id').html(string);
                },
                error: function(error) {
                    console.error('AJAX error:', error);
                }
            });
        });
    </script>
    <script>
        $(function() {
            $('#fileupload').fileupload();
        });
    </script>

    <script>
        var brandModelCounter = 1;

        function createBrandModelRow(id, a, b, c, d) {
            return `
        <div class="row" id="brandModelRow_${id}">
            <div class="col-6">
                <label for="input40" class="col-sm-4 col-form-label"></label>
                <input type="text" name="adv_brand_id[${b}]" value="${a}" class="form-control" placeholder="Enter Brand">

            </div>
            <div class="col-6">
                <label for="input40" class="col-sm-4 col-form-label"></label>
                <input type="text" name="adv_model_id[${d}]" value=${c} class="form-control" placeholder="Enter Model">
            </div>
            <div class="col-2">
                <button type="button" onclick="removeBrandModelRow(${id})">Remove</button>
            </div>
        </div>
    `;
        }

        function addBrandModelRow() {
            var container = document.getElementById("brandModelContainer");
            var newRow = document.createElement("div");
            var brandName = $("#adv_brand_id option:selected").text();
            var brandId = $("#adv_brand_id").val();
            var modelName = $("#adv_model_id option:selected").text();
            var modelId = $("#adv_model_id").val();
            newRow.innerHTML = createBrandModelRow(brandModelCounter, brandName, brandId, modelName, modelId);
            container.appendChild(newRow);
            brandModelCounter++;
        }

        function removeBrandModelRow(id) {
            var currentRow = document.getElementById(`brandModelRow_${id}`);
            if (currentRow && currentRow.parentNode) {
                currentRow.parentNode.removeChild(currentRow);
                brandModelCounter--;
            }
        }




        //     function previewNewImage() {
        //     var input = document.getElementById('adv_img');
        //     var newImagePreview = document.getElementById('newImagePreview');

        //     if (input.files && input.files[0]) {
        //         var reader = new FileReader();

        //         reader.onload = function (e) {
        //             newImagePreview.src = e.target.result;
        //         };

        //         reader.readAsDataURL(input.files[0]);
        //     } else {
        //         newImagePreview.src = "";
        //     }
        // }


        // function previewImages() {
        //     var previewDiv = document.getElementById('image-preview');
        //     previewDiv.innerHTML = ''; // Clear existing previews

        //     var input = document.getElementById('adv_img');
        //     var files = input.files;

        //     for (var i = 0; i < files.length; i++) {
        //         var reader = new FileReader();
        //         reader.onload = function(e) {
        //             var container = document.createElement('div');
        //             container.classList.add('preview-container');

        //             var img = document.createElement('img');
        //             img.src = e.target.result;
        //             img.classList.add('preview-image');
        //             img.style.maxWidth = '100px'; // Set max width
        //             img.style.maxHeight = '100px'; // Set max height

        //             var rotateButtons = document.createElement('div');
        //             rotateButtons.classList.add('rotate-buttons');

        //             var rotateLeftIcon = document.createElement('i');
        //             rotateLeftIcon.classList.add('fas', 'fa-undo');
        //             rotateLeftIcon.onclick = function() {
        //                 rotateImage(img, -90); // Rotate left by 90 degrees
        //             };

        //             var rotateRightIcon = document.createElement('i');
        //             rotateRightIcon.classList.add('fas', 'fa-redo');
        //             rotateRightIcon.onclick = function() {
        //                 rotateImage(img, 90); // Rotate right by 90 degrees
        //             };

        //             rotateButtons.appendChild(rotateLeftIcon);
        //             rotateButtons.appendChild(rotateRightIcon);

        //             var closeIcon = document.createElement('i');
        //             closeIcon.classList.add('fas', 'fa-times', 'close-icon');
        //             closeIcon.onclick = function() {
        //                 container.remove(); // Remove the container when the close icon is clicked
        //             };

        //             container.appendChild(img);
        //             container.appendChild(rotateButtons);
        //             container.appendChild(closeIcon);

        //             previewDiv.appendChild(container);
        //         };
        //         reader.readAsDataURL(files[i]);
        //     }
        // }

        // function rotateImage(element, degrees) {
        //     var currentRotation = element.getAttribute('data-rotation') || 0;
        //     var newRotation = parseInt(currentRotation) + degrees;
        //     element.style.transform = 'rotate(' + newRotation + 'deg)';
        //     element.setAttribute('data-rotation', newRotation);
        // }
    </script>
    <script>
        function previewImages() {
            var previewDiv = document.getElementById('image-preview');
            previewDiv.innerHTML = ''; // Clear existing previews

            var input = document.getElementById('adv_img');
            var files = input.files;

            for (var i = 0; i < files.length; i++) {
                (function(index) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var container = document.createElement('div');
                        container.classList.add('preview-container');

                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('preview-image');
                        img.style.maxWidth = '200px'; // Set max width
                        img.style.maxHeight = '200px'; // Set max height

                        var rotateButtons = document.createElement('div');
                        rotateButtons.classList.add('rotate-buttons');

                        var rotateLeftIcon = document.createElement('i');
                        rotateLeftIcon.classList.add('fas', 'fa-undo');
                        rotateLeftIcon.onclick = function() {
                            rotateImage(img, -90); // Rotate left by 90 degrees
                        };

                        var rotateRightIcon = document.createElement('i');
                        rotateRightIcon.classList.add('fas', 'fa-redo');
                        rotateRightIcon.onclick = function() {
                            rotateImage(img, 90); // Rotate right by 90 degrees
                        };

                        rotateButtons.appendChild(rotateLeftIcon);
                        rotateButtons.appendChild(rotateRightIcon);

                        var closeIcon = document.createElement('i');
                        closeIcon.classList.add('fas', 'fa-times', 'close-icon');
                        closeIcon.onclick = function() {
                            container.remove(); // Remove the container when the close icon is clicked
                        };

                        container.appendChild(img);
                        container.appendChild(rotateButtons);
                        container.appendChild(closeIcon);

                        previewDiv.appendChild(container);
                    };
                    reader.readAsDataURL(files[index]);
                })(i);
            }
        }

        function rotateImage(element, degrees) {
            var currentRotation = element.getAttribute('data-rotation') || 0;
            var newRotation = parseInt(currentRotation) + degrees;
            element.style.transform = 'rotate(' + newRotation + 'deg)';
            element.setAttribute('data-rotation', newRotation);
        }
    </script>
    <script>
        $('.removeImg').click(function(e) {
            e.preventDefault();
            $(this).parent('.imageContainer').remove();
        });
    </script>

    <script>
        $('.removeImg').click(function() {
            var imageId = $(this).data('image-id');

            $.ajax({
                url: '/admin/delete-image/' + imageId,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        $(this).closest('.imageContainer').remove();
                    } else {
                        console.error('Image deletion failed');
                    }
                },
                error: function() {
                    console.error('Error in AJAX request');
                }
            });
        });
    </script>






</x-app-layout>
