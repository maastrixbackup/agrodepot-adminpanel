<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 footer-copyright d-flex flex-wrap align-items-center justify-content-between">
                <p class="mb-0 f-w-600">Copyright 2023 © Agro Depot </p>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
<!-- Bootstrap js-->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
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
{{-- <script src="{{ asset('js/apex-chart.js') }}"></script> --}}
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

<script>
    setTimeout(function() {
        document.querySelector('.alert').style.display = 'none';
    }, 5000); // 5000 milliseconds (5 seconds), adjust as needed
</script>
<!-- <script>
    // Get all sidebar-list items
    const sidebarListItems = document.querySelectorAll('.sidebar-list');

    // Loop through each sidebar-list item
    sidebarListItems.forEach(item => {
        // Add click event listener
        item.addEventListener('click', function() {
            // Remove 'active' class from all sidebar-list items
            sidebarListItems.forEach(item => {
                item.classList.remove('active');
            });

            // Add 'active' class to the clicked sidebar-list item
            this.classList.add('active');

            // Toggle 'open' class for submenu availability
            const submenu = this.querySelector('.sidebar-submenu');
            if (submenu) {
                this.classList.toggle('open');
            }
        });
    });
</script> -->
<!-- <style>
    .sidebar-submenu {
        display: none;
    }

    .open .sidebar-submenu {
        display: block;
    }

    .active {
        background-color: #ccc;
        /* Change as needed */
    }
</style> -->
<!-- <script>
    function toggleSubMenu(element) {
        element.parentNode.classList.toggle('open');
    }

    function setActive(link) {
        // Remove 'active' class from all links within the submenu
        var submenuLinks = link.parentNode.parentNode.querySelectorAll('a');
        submenuLinks.forEach(function(item) {
            item.classList.remove('active');
        });

        // Add 'active' class to the clicked link
        link.classList.add('active');
    }
</script> -->