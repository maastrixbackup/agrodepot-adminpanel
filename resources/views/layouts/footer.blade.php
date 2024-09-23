<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 footer-copyright d-flex flex-wrap align-items-center justify-content-between">
                <p class="mb-0 f-w-600">Copyright {{ date('Y') }} © Agro Depot </p>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>
<!-- Bootstrap js-->
<!--<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>-->
<!-- feather icon js-->
<script src="{{ asset('js/feather.min.js') }}"></script>
<script src="{{ asset('js/feather-icon.js') }}"></script>
<!-- scrollbar js-->
<script src="{{ asset('js/simplebar.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('js/config.js') }}"></script>
<!-- Plugins JS start-->
<script src="{{ asset('js/sidebar-menu.js') }}"></script>
<!-- <script src="{{ asset('js/sidebar-pin.js') }}"></script> -->
<!-- <script src="{{ asset('js/slick.min.js') }}"></script> -->
<!-- <script src="{{ asset('js/slick.js') }}"></script> -->
<!-- <script src="{{ asset('js/header-slick.js') }}"></script> -->
<script src="{{ asset('js/raphael.js') }}"></script>
<script src="{{ asset('js/morris.js') }}"></script>
<!-- <script src="{{ asset('js/prettify.min.js') }}"></script> -->
<script src="{{ asset('js/apex-chart.js') }}"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<!-- <script src="{{ asset('js/stock-prices.js') }}"></script> -->
<!-- <script src="{{ asset('js/moment.min.js') }}"></script> -->
<!-- <script src="{{ asset('js/facePrint.js') }}"></script> -->
<!-- <script src="{{ asset('js/testHelper.js') }}"></script> -->
<!-- <script src="{{ asset('js/custom-transition-texture.js') }}"></script> -->
<!-- <script src="{{ asset('js/symbols.js') }}"></script> -->
<!-- <script src="{{ asset('js/slick.min.js') }}"></script> -->
<!-- <script src="{{ asset('js/slick-theme.js') }}"></script> -->
<script src="{{ asset('js/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('js/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- <script src="{{ asset('js/jquery-jvectormap-us-aea-en.js') }}"></script> -->
<!-- <script src="{{ asset('js/jquery-jvectormap-uk-mill-en.js') }}"></script> -->
<!-- <script src="{{ asset('js/jquery-jvectormap-au-mill.js') }}"></script> -->
<!-- <script src="{{ asset('js/jquery-jvectormap-chicago-mill-en.js') }}"></script> -->
<!-- <script src="{{ asset('js/jquery-jvectormap-in-mill.js') }}"></script> -->
<!-- <script src="{{ asset('js/jquery-jvectormap-asia-mill.js') }}"></script> -->
<!-- calendar js-->
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/datatable.custom.js') }}"></script>
<script src="{{ asset('js/datatable.custom1.js') }}"></script>
<script src="{{ asset('js/datepicker.js') }}"></script>
<script src="{{ asset('js/datepicker.en.js') }}"></script>
<script src="{{ asset('js/datepicker.custom.js') }}"></script>
<script src="{{ asset('js/jquery.barrating.js') }}"></script>
<script src="{{ asset('js/rating-script.js') }}"></script>
<script src="{{ asset('js/owl.carousel.js') }}"></script>
<script src="{{ asset('js/map-vector.js') }}"></script>
<script src="{{ asset('js/countdown.js') }}"></script>
<script src="{{ asset('js/dashboard_3.js') }}"></script>
<script src="{{ asset('js/ecommerce.js') }}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/customizer.js') }}"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
    function scrollTable(direction) {
        const container = document.getElementById('table-container');
        const scrollAmount = 100; // Adjust this value for more or less scroll
        container.scrollLeft += direction * scrollAmount;
    }
    document.addEventListener("DOMContentLoaded", function() {
        const breadcrumbCurrent = document.getElementById('breadcrumb-current');
        const breadcrumbTrail = document.getElementById('breadcrumb-trail');
        const sidebarLinks = document.querySelectorAll('#sidebar-menu .sidebar-link');
        const currentUrl = window.location.href;

        sidebarLinks.forEach(link => {
            if (currentUrl.includes(link.href)) {
                const menuItemText = link.querySelector('span').textContent;

                // Check if the current page is the dashboard
                if (menuItemText.trim() === 'Dashboard') {
                    // Remove the second breadcrumb item if it exists
                    const secondBreadcrumb = breadcrumbTrail.querySelector(
                        '.breadcrumb-item:nth-child(2)');
                    if (secondBreadcrumb) {
                        secondBreadcrumb.remove();
                    }
                    // Set the current breadcrumb item text to "Dashboard"
                    breadcrumbCurrent.textContent = 'Dashboard';
                } else {
                    breadcrumbCurrent.textContent = menuItemText;
                }
            }
        });
    });
</script>
<script>
    //  $(document).ready(function() {

    //     var cropper;

    //     // Handle file selection for images
    //     $("body").on("change", ".images", function(e) {

    //         var files = e.target.files;

    //         // Loop through selected files
    //         $.each(files, function(index, file) {
    //             var reader = new FileReader();
    //             reader.onload = function(e) {

    //                 var thumbnailElement = $('<div class="thumbnail">');
    //                 var imageElement = $('<img>');
    //                 imageElement.attr('src', e.target.result);
    //                 thumbnailElement.append(imageElement);
    //                 $('.img-prev-container').append(thumbnailElement);

    //                 // Add click event to open modal for each image
    //                 thumbnailElement.click(function() {
    //                     // Remove active class from all thumbnails
    //                     $('.thumbnail').removeClass('active');

    //                     // Add active class to the clicked thumbnail
    //                     thumbnailElement.addClass('active');
    //                     $('#image').attr('src', e.target.result); // Set the source of the image in the modal
    //                     $('#modal').modal('show'); // Show the modal
    //                     initializeCropper(); // Initialize Cropper after modal is shown
    //                 });
    //             };
    //             reader.readAsDataURL(file);
    //         });
    //     });

    //     // Initialize Cropper
    //     function initializeCropper() {
    //         if (cropper) {
    //             cropper.destroy();
    //         }
    //         cropper = new Cropper(document.getElementById('image'), {
    //             viewMode: 1,
    //             autoCropArea: 1,
    //             background: false,
    //             movable: false,
    //             zoomable: false,
    //             rotatable: true,
    //             scalable: false,
    //         });
    //     }

    //     // Handle Rotate Left button click
    //     $('#rotate-left').click(function() {
    //         cropper.rotate(-90);
    //     });

    //     // Handle Rotate Right button click
    //     $('#rotate-right').click(function() {
    //         cropper.rotate(90);
    //     });

    //     // Handle Crop & Save button click
    //     $('#crop').click(function() {
    //         // Get cropped canvas
    //         var canvas = cropper.getCroppedCanvas();

    //         // Convert canvas to image
    //         var croppedImage = canvas.toDataURL('image/jpeg');

    //         // Perform actions with cropped image (e.g., send it to the server via AJAX)
    //         console.log(croppedImage);

    //         // Update the thumbnail image source on the main page with the cropped image
    //         $('.thumbnail.active img').attr('src', croppedImage);

    //         // Close modal
    //         $('#modal').modal('hide');


    //     });
    // });


    $(document).ready(function() {
        var cropper;

        // Handle file selection for images
        $("body").on("change", ".images", function(e) {

            var files = e.target.files;

            // Loop through selected files
            $.each(files, function(index, file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var thumbnailElement = $('<div class="thumbnail">');
                    var imageElement = $('<img>');
                    var inputhiddenElement = $('<input>');
                    var closeIcon = $(
                        '<i class="fa fa-times-circle close-icon"></i>'); // Add close icon
                    imageElement.attr('src', e.target.result);
                    thumbnailElement.append(imageElement);
                    inputhiddenElement.attr('type', 'hidden');
                    inputhiddenElement.attr('name', 'thumbnail_images[]');
                    inputhiddenElement.attr('value', e.target.result);
                    thumbnailElement.append(inputhiddenElement);
                    thumbnailElement.append(closeIcon); // Append close icon
                    $('.img-prev-container').append(thumbnailElement);




                    // Add click event to open modal for each image
                    thumbnailElement.click(function() {
                        // Remove active class from all thumbnails
                        $('.thumbnail').removeClass('active');

                        // Add active class to the clicked thumbnail
                        thumbnailElement.addClass('active');
                        $('#image').attr('src', e.target
                            .result); // Set the source of the image in the modal
                        $('#modal').modal('show'); // Show the modal
                    });

                    // Close icon click event to remove thumbnail
                    closeIcon.click(function(e) {
                        e
                            .stopPropagation(); // Prevent modal from opening when clicking close icon
                        thumbnailElement.remove();
                    });
                };
                reader.readAsDataURL(file);
            });
        });

        // Initialize Cropper inside modal's shown event
        $('#modal').on('shown.bs.modal', function() {
            initializeCropper();
        });

        // Initialize Cropper
        function initializeCropper() {
            if (cropper) {
                cropper.destroy();
            }
            cropper = new Cropper(document.getElementById('image'), {
                viewMode: 1,
                autoCrop: false, // Disable auto-cropping
                background: false,
                movable: false,
                zoomable: false,
                rotatable: true,
                scalable: false,
            });
        }

        // Handle Rotate Left button click
        $('#rotate-left').click(function() {
            cropper.rotate(-90);
            updateThumbnails();
        });

        // Handle Rotate Right button click
        $('#rotate-right').click(function() {
            cropper.rotate(90);
            updateThumbnails();
        });
        var rotationAngles = [];
        // Handle Save button click
        $('#save').click(function() {
            // Get rotated canvas
            var canvas = cropper.getCroppedCanvas({
                width: $('#image').width(),
                height: $('#image').height()
            });

            // Convert canvas to image
            var rotatedImage = canvas.toDataURL('image/jpeg');

            // Update the thumbnail image source on the main page with the rotated image
            $('.thumbnail.active img').attr('src', rotatedImage);
            $('.thumbnail.active input').attr('value', rotatedImage);


            // Close modal
            $('#modal').modal('hide');
        });

        // Update all thumbnails with their rotated versions
        // Update all thumbnails with their rotated versions
        function updateThumbnails() {
            $('.thumbnail img').each(function() {
                var index = $(this).closest('.thumbnail').index();
                var imageData = cropper.getImageData();
                var canvas = cropper.getCroppedCanvas({
                    width: imageData.naturalWidth, // Use natural width and height
                    height: imageData.naturalHeight
                });
                var rotatedImage = canvas.toDataURL('image/jpeg');
                $('.thumbnail').eq(index).find('img').attr('src', rotatedImage);
            });
        }

        // Update modal size based on the size of the rotated image
        function updateModalSize() {
            var imageData = cropper.getImageData();
            var aspectRatio = imageData.naturalWidth / imageData.naturalHeight;
            var maxWidth = $(window).width() * 0.8;
            var maxHeight = $(window).height() * 0.8;

            var modalWidth, modalHeight;
            if (aspectRatio > 1) {
                modalWidth = Math.min(maxWidth, imageData.naturalWidth);
                modalHeight = modalWidth / aspectRatio;
            } else {
                modalHeight = Math.min(maxHeight, imageData.naturalHeight);
                modalWidth = modalHeight * aspectRatio;
            }

            $('.modal-dialog').css({
                'max-width': modalWidth + 'px',
                'max-height': modalHeight + 'px'
            });
        }


    });
</script>

<script>
    setTimeout(function() {
        document.querySelector('.alert').style.display = 'none';
    }, 5000); // 5000 milliseconds (5 seconds), adjust as needed
</script>
<script>
    $(document).ready(function() {
        const currentUrl = window.location.href;
        const $sidebarLinks = $("#simple-bar .sidebar-link");

        if ($sidebarLinks.length === 0) {
            console.error("No sidebar links found with the selector '#simple-bar .sidebar-link'");
            return;
        }

        $sidebarLinks.each(function() {
            const link = $(this);
            if (currentUrl.includes(link.attr("href"))) {
                link.parent().addClass("active");
            }
            const uls = link.parent().children("ul");
            if (uls.length == 1) {
                const $ul = $(uls[0]);
                const $a = $ul.find(`a[href="${currentUrl}"]`);
                if ($a.length > 0) {
                    $a.addClass("active");
                    link.parent().addClass("active");
                    $ul.css("display", "block");
                }
            }
        });
    });
</script>
