<x-app-layout>

    <style>
        /*#image-preview {*/
        /*    display: flex;*/
        /*    flex-wrap: wrap;*/
        /*}*/

        /*.preview-container {*/
        /*    position: relative;*/
        /*    margin: 5px;*/
        /*}*/

        /*.preview-container .preview-image {*/
        /*    width: 200px;*/
        /*    height: 200px;*/
        /*}*/

        /*.close-icon {*/
        /*    position: absolute;*/
        /*    top: 0;*/
        /*    right: 0;*/
        /*    cursor: pointer;*/
        /*    background-color: white;*/
        /*    padding: 2px;*/
        /*}*/

        /*.rotate-buttons {*/
        /*    position: absolute;*/
        /*    bottom: 0;*/
        /*    left: 50%;*/
        /*    transform: translateX(-50%);*/
        /*    display: flex;*/
        /*    justify-content: space-between;*/
        /*    width: 100%;*/
        /*}*/

        /*.rotate-icon {*/
        /*    cursor: pointer;*/
        /*    background-color: white;*/
        /*    padding: 2px;*/
        /*}*/

        /*.rotate-buttons i:nth-last-child(1) {*/
        /*    margin-right: 0;*/
        /*}*/

        /*.image-preview-container {*/
        /*    position: relative;*/
            /* overflow: hidden; */
        /*}*/

        /*.rotate-buttons i {*/
        /*    margin-right: 15px;*/
        /*    background: #016f0f;*/
        /*    width: 30px;*/
        /*    height: 30px;*/
        /*    display: inline-flex;*/
        /*    align-items: center;*/
        /*    justify-content: center;*/
        /*    font-size: 18px;*/
        /*    color: #fff;*/
        /*    cursor: pointer;*/
        /*    transition: 0.5s ease;*/
        /*    border: 2px solid gray;*/
        /*    border-radius: 6px;*/
        /*}*/

        /*.rotate-buttons i:hover {*/
        /*    background: #ee5b2b;*/
        /*}*/

        /*.hidden {*/
        /*    display: none;*/
        /*}*/

        /*.images-container img {*/
        /*    height: 100px !important;*/
        /*    width: 100px !important;*/
        /*    display: block;*/
        /*}*/

        /*img#modal-image-preview {*/
        /*    height: 250px;*/
        /*    width: 250px;*/
        /*    position: relative;*/
        /*    left: 20%;*/
        /*}*/

        /* .cropper-canvas {
            height: 979px !important;
            transform: none !important;
        }

        .cropper-container img {
            width: 100% !important;
        }

        .cropper-container {
            height: 980px !important;
        } */
        
        
        /*** new ***/
        
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
        border: 2px solid #f00; /* Change border color to highlight */
        /* Add any other styles to highlight the active thumbnail */
    }
    </style>
    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Add News</h1>
        </div>
        <div class="col-2"><a href="{{ route('sales.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('sales.store') }}" class="row" enctype="multipart/form-data">
            @csrf
            <div class="col-10 form-group">
                <div>
                    <label for="input40" class="col-sm-4 col-form-label">Select User</label>
                    <select name="user_id" class="form-control form-select">
                        <option value="">Select a user</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-6"><label for="input40" class="col-sm-4 col-form-label">Select a Category</label>
                        <select name="category_id" class="form-control form-select">
                            <option value="">Select a Category</option>
                            @foreach ($categories as $user)
                                <option value="{{ $user->category_id }}">{{ $user->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6"><label for="input40" class="col-sm-4 col-form-label">Select a Sub
                            Category</label>
                        <select name="sub_cat_id" id="sub_cat_id" class="form-control form-select">
                            <option value="">Select a Sub-Category</option>
                        </select>
                        <div class="subcats"></div>
                    </div>

                </div>
                <div class="mt-2">
                    <label for="adv_name">Name of the song</label>
                    <label for="adv_name">Use a title as suggestive and completely.
                        eg BMW 3 Series E46 front bumper year in 2001 with projectors and green grid.</label>
                    <input type="text" name="adv_name" class="form-control" id="adv_name"
                        value="{{ old('adv_name') }}">
                    @error('adv_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="news_content">Details about the song sold</label><br>
                    <label for="news_content">Describe as detailed piece on sale. The
                        more customers,
                        the chances of selling increase exponentially.</label>
                    <textarea class="ckeditor form-control" name="adv_details" id="adv_details" placeholder="Description">{{ old('adv_details ') }}</textarea>
                    <!-- @error('adv_details ')
    <span class="text-danger">{{ $message }}</span>
@enderror -->
                </div>

                <div class="img-prev-container">
                    {{-- <input type="file" name="files[]" id="fileupload" multiple> --}}
                    <div id="files"></div>
                    <label for="input40" class="col-sm-4 col-form-label">Image (Rotate images by clicking on them.)</label>
                    <!--<input type="file" class="form-control" name="adv_img[]" id="adv_img" accept="image/*" multiple-->
                    <!--    onchange="previewImages()">-->
                    <!--@error('adv_img')-->
                    <!--    <span class="text-danger">{{ $message }}</span>-->
                    <!--@enderror-->
                    <input type="file" id="images" name="images[]" class="images form-control" multiple accept="image/*">
                    <input type="hidden" id="rotation-angle" name="rotation_angle[]"> <!-- Add hidden input for rotation angle -->
                            <!-- Hidden inputs for thumbnail images -->
                     


                </div>
                
                <div id="image-preview"></div>

                <!-- Modal for image rotation and cropping -->
                <!-- <div class="modal" id="imageModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Rotate Image</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="image-container">
                                    <img id="modal-image-preview" alt="Image Preview">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="rotate-buttons">
                                    <button type="button" class="rotate-button" data-degrees="-90"><i class="fas fa-undo"></i></button>
                                    <button type="button" class="rotate-button" data-degrees="90"><i class="fas fa-redo"></i></button>
                                    <button type="button" id="saveButton"><i class="far fa-save"></i> Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->








                <!-- <div id="image-preview"></div> -->

                <div class="row" id="brandModelRow_0">
                    <div class="col-6"><label for="input40" class="col-sm-4 col-form-label">Select a Brand</label>
                        <select name="adv_brand_id" id="adv_brand_id" class="form-control form-select">
                            <option value="">choose brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->brand_id }}">{{ $brand->brand_name }}
                                </option>
                            @endforeach

                        </select>
                        @error('adv_brand_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6"><label for="input40" class="col-sm-4 col-form-label">Select Model</label>
                        <select name="adv_model_id" id="adv_model_id" class="form-control form-select">
                            <option value="">choose Model</option>
                        </select>


                    </div>

                    <div class="col-2">
                        <button class="add-more-btn" type="button" onclick="addBrandModelRow()">Add</button>

                    </div>
                </div>

                <div id="brandModelContainer"></div>


                <div>
                    <label for="input40" class="col-sm-4 col-form-label">Product Condition</label>
                    <select name="product_cond" class="form-control form-select">
                        <option value="">Select</option>
                        <option value="new">New</option>
                        <option value="old">Old</option>
                    </select>
                    @error('product_cond')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="mt-2 col-3">
                        <label for="price">Price</label>
                        <input type="text" name="price" class="form-control" id="price"
                            value="{{ old('price') }}">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-2 col-3">
                        <label for="price">B2B Price</label>
                        <input type="text" name="b2bprice" class="form-control" id="price"
                            value="{{ old('b2bprice') }}">
                        @error('b2bprice')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class='col-6'>
                        <label for="input40" class="col-sm-4 col-form-label">Currency</label>
                        <select name="currency" class="form-control form-select">
                            <option value="">Select</option>
                            <option value="RON">RON</option>
                        </select>
                        @error('currency')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-2">
                    <label for="quantity">Number Of Pieces</label>
                    <input type="text" name="quantity" class="form-control" id="quantity"
                        value="{{ old('quantity') }}">
                    @error('quantity')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2 ">
                    <label for="payment_mode">Payment Methods</label><br>
                    <input type="checkbox" checked name="payment_mode" id="payment_mode" value="Cash on delivery">
                    Cash on
                    delivery
                    <input type="checkbox" checked name="payment_mode[]" id="payment_mode" value="Upon delivery">
                    Upon
                    delivery
                    <input type="checkbox" checked name="payment_mode[]" id="payment_mode" value="Wire Transfer">
                    Wire
                    Transfer
                    <input type="checkbox" checked name="payment_mode[]" id="payment_mode" value="Banking Card">
                    Banking
                    Card
                    <input type="checkbox" checked name="payment_mode[]" id="payment_mode" value="Others"> Others
                    @error('payment_mode')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2 check-box-delivery">
                    <label for="delivery">Method Of Delivery</label><br>
                    <input type="checkbox" checked name="personal_teaching" id="personal_teaching"
                        value="1">Personal
                    Teaching<br>
                    <input type="checkbox" checked name="courier" id="courier" value="1">Courier Delivery
                    Cost
                    <input type="text" name="courier_cost" class="" id="courier_cost" value=""> RON
                    <input type="checkbox" checked name="free_courier" id="free_courier" value="1">Free
                    delivery by
                    courier<br>
                    <input type="checkbox" checked name="romanian_mail" id="romanian_mail" value="1"> Romanian
                    Mail
                    Delivery Cost
                    <input type="text" name="romanian_mail_cost" id="romanian_mail_cost" value=""> RON
                    <input type="checkbox" checked name="free_romanian_mail" id="free_romanian_mail" value="1">
                    Free
                    Shipping by Mail
                </div>
                <div class='col-6'>
                    <label for="input40" class="col-sm-4 col-form-label">Time Required</label>
                    <select name="time_required" class="form-control" id="ManageSaleTimeRequired"
                        required="required">
                        <option value="1">1 Day</option>
                        <option value="2">2 Days</option>
                        <option value="3">3 Days</option>
                        <option value="4">4 Days</option>
                        <option value="5">5 Days</option>
                        <option value="10">10 Days</option>
                        <option value="15">15 Days</option>
                        <option value="30">30 Days</option>
                    </select>

                    <!-- @error('time_required')
    <span class="text-danger">{{ $message }}</span>
@enderror -->
                </div>

                <div>
                    <label for="input40" class="col-sm-4 col-form-label">Status</label>
                    <select name="adv_status" class="form-control form-select">
                        <option value="1">Active</option>
                        <option value="0">Inctive</option>

                    </select>

                    <!-- @error('adv_status')
    <span class="text-danger">{{ $message }}</span>
@enderror -->
                </div>

            </div>
            <button class="btn btn-primary customSaveButton" type="submit">Save</button>
        </form>

    </div>
    
     <div class="modal previw-mod fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-primary" id="rotate-left"><i class="fas fa-undo"></i></button>
                    <button type="button" class="btn btn-primary" id="rotate-right"><i class="fas fa-redo"></i></button>
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
                <label for="input40" class="col-sm-4 col-form-label">Enter Brand</label>
                <input type="text" name="adv_brand_id[${b}][]" value="${a}" class="form-control" placeholder="Enter Brand">
            </div>
            <div class="col-6">
                <label for="input40" class="col-sm-4 col-form-label">Enter Model</label>
                <input type="text" name="adv_model_id[${d}][]" value=${c} class="form-control" placeholder="Enter Model">
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

    <!-- <script>
        // Keep track of rotation data for each image
        var rotationData = {};

        document.getElementById('adv_img').addEventListener('change', function() {
            var files = this.files;

            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                var img = new Image();
                img.classList.add('image-preview');
                img.alt = "Image Preview";

                var container = document.createElement('div');
                container.classList.add('image-container', 'col-4', 'mt-3'); // Add col-4 class here
                container.appendChild(img);

                var imagesContainer = document.querySelector('.images-container');
                imagesContainer.appendChild(container);

                reader.onload = (function(image, container, file) {
                    return function(e) {
                        image.src = e.target.result;

                        // Add click event listener to open modal
                        image.addEventListener('click', function() {
                            document.getElementById('modal-image-preview').src = image.src;
                            $('#imageModal').modal('show');

                            // Set current image being edited in modal
                            currentModalImage = image;

                            // Set rotation data for current image
                            var rotation = rotationData[file.name] || 0;
                            $('#modal-image-preview').attr('data-rotation', rotation);
                            rotateImageInModal(rotation); // Apply rotation to modal preview
                        });
                    };
                })(img, container, files[i]);

                reader.readAsDataURL(files[i]);
            }
        });

        // Add event listener for save button in modal
        document.getElementById('saveButton').addEventListener('click', function() {
            var img = document.getElementById('modal-image-preview');
            var rotatedImage = rotateImage(img);

            // Get file name of current image
            var fileName = currentModalImage.src.split('/').pop();

            // Replace original image with rotated image
            currentModalImage.src = rotatedImage.src;

            // Update all image previews with the rotated image
            $('.image-preview').each(function() {
                if (this.src.endsWith(fileName)) {
                    this.src = rotatedImage.src;
                }
            });

            // Close the modal
            $('#imageModal').modal('hide');

            // Save rotation data for the current image
            rotationData[fileName] = parseFloat(img.getAttribute('data-rotation'));
        });

        // Add event listeners for rotation buttons
        var rotateButtons = document.querySelectorAll('.rotate-button');
        rotateButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var degrees = parseInt(this.getAttribute('data-degrees'));
                rotateImageInModal(degrees);
            });
        });

        // Function to rotate the image preview in modal
        function rotateImageInModal(degrees) {
            var img = document.getElementById('modal-image-preview');
            var currentRotation = parseFloat(img.getAttribute('data-rotation') || 0);
            var newRotation = currentRotation + degrees;

            img.style.transform = 'rotate(' + newRotation + 'deg)';
            img.setAttribute('data-rotation', newRotation);
        }

        // Function to rotate the image
        function rotateImage(img) {
            var currentRotation = parseFloat(img.getAttribute('data-rotation') || 0);
            var newRotation = currentRotation + 90; // Rotate the image clockwise by 90 degrees

            img.style.transform = 'rotate(' + newRotation + 'deg)';
            img.setAttribute('data-rotation', newRotation);

            // Clone the image to avoid altering the original
            var clonedImage = img.cloneNode(true);
            clonedImage.setAttribute('data-rotation', newRotation); // Set rotation attribute on cloned image
            return clonedImage;
        }
    </script> -->
    <!-- Cropper.js JavaScript -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        $(document).ready(function() {
            var $image = $('#adv_img');
            var $croppedImage = $('#cropped_image');

            $image.on('change', function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = $('<img>').attr('src', e.target.result);
                    $('.images-container').append(img);
                    img.cropper({
                        aspectRatio: 16 / 9,
                        crop: function(event) {
                            var data = event.detail;
                        }
                    });
                };
                reader.readAsDataURL(file);
            });

            $('#rotate-left').on('click', function() {
                $('.images-container img').cropper('rotate', -90);
            });

            $('#rotate-right').on('click', function() {
                $('.images-container img').cropper('rotate', 90);
            });
        });
    </script> -->
 

</x-app-layout>

   
   