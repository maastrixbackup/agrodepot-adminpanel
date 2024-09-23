<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'AgroDepo') }}</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.css') }}"> -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/scrollbar.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owlcarousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vector-map.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <!--<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link id="color" rel="stylesheet" href="{{ asset('css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="{{ asset('js/jquery.tablednd.1.0.5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckfinder/ckfinder.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckeditor/plugins/colorbutton/plugin.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckeditor/plugins/button/plugin.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckeditor/plugins/panelbutton/plugin.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckeditor/plugins/imageuploader/plugin.js') }}"></script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/10.7.0/css/jquery.fileupload.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/10.7.0/js/vendor/jquery.ui.widget.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/10.7.0/js/jquery.iframe-transport.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/10.7.0/js/jquery.fileupload.min.js"></script>

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">



    <!-- Scripts -->
</head>


<body class="font-sans antialiased">
    <div class="loader-wrapper">
        <div class="loader">
            <div class="inner_loader"></div>
        </div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <div class="page-header row">
            <div class="header-logo-wrapper col-auto">
                <div class="logo-wrapper"><a href="index.html"><img class="img-fluid for-light"
                            src="{{ asset('images/logo.png') }}" alt=""><img class="img-fluid for-dark"
                            src="{{ asset('images/argodepo.png') }}" alt=""></a>
                </div>
            </div>
            <div class="col-4 col-xl-4 page-title head-left">
                <h4 class="f-w-700"> Agro Depot</h4>
                <div class="toggle-sidebar">
                    <div class="db-tog"><i class="fas fa-bars"></i></div>
                    <div class="dn-tog"><i class="fas fa-times"></i></div>

                </div>
                <nav>
                    <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
                        <li class="breadcrumb-item"><a href="index.html"> <i data-feather="home"> </i></a></li>
                        <li class="breadcrumb-item f-w-400">Dashboard</li>
                        <li class="breadcrumb-item f-w-400 active">Ecommerce</li>
                    </ol>
                </nav>
            </div>
            <!-- Page Header Start-->
            <div class="header-wrapper col m-0">
                <div class="row">
                    <form class="form-inline search-full col" action="#" method="get">
                        <div class="form-group w-100">
                            <div class="Typeahead Typeahead--twitterUsers">
                                <div class="u-posRelative">
                                    <input class="demo-input Typeahead-input form-control-plaintext w-100"
                                        type="text" placeholder="Search Mofi .." name="q" title=""
                                        autofocus="">
                                    <div class="spinner-border Typeahead-spinner" role="status"><span
                                            class="sr-only">Loading...</span></div><i class="close-search"
                                        data-feather="x"></i>
                                </div>
                                <div class="Typeahead-menu"></div>
                            </div>
                        </div>
                    </form>
                    <div class="header-logo-wrapper col-auto p-0">
                        <div class="logo-wrapper"><a href="index.html"><img class="img-fluid"
                                    src="{{ asset('images/logo.png') }}" alt=""></a></div>
                    </div>
                    <div class="nav-right col-xxl-8 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
                        <ul class="nav-menus">
                            <li> <span class="header-search">
                                    <svg>
                                        <use href="{{ asset('images/icon-sprite.svg#search') }}"></use>
                                    </svg>
                                    {{-- <li>
                                <div class="form-group w-100">
                                    <div class="Typeahead Typeahead--twitterUsers">
                                        <div class="u-posRelative d-flex align-items-center">
                                            <svg>
                                                <use href="{{ asset('images/icon-sprite.svg#search') }}"></use>
                                            </svg>
                                            <input class="demo-input py-0 Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Mofi .." name="q" title="">
                                        </div>
                                    </div>
                                </div>
                            </li> --}}
                            <li class="onhover-dropdown">
                                <div class="notification-box align-items-center"><i class="far fa-bell"
                                        style="font-size: 19px;"></i><span
                                        class="badge rounded-pill badge-primary">{{ totalNotice() }}
                                    </span>
                                </div>
                                <div class="onhover-show-div">
                                    <ul>
                                        <li class="header">You have {{ totalNotice() }} notifications</li>
                                        <li class="notification-card">
                                            <a href="#" onclick="return updateStatus('register');">
                                                <i class="fas fa-user-friends"></i> {{ totalNotice('register') }} new
                                                members joined
                                            </a>
                                        </li>
                                        <li class="notification-card">
                                            <a href="#" onclick="return updateStatus('sales-add');">
                                                <i class="fal fa-chart-bar"></i> {{ totalNotice('sales-add') }} New
                                                sales ads
                                            </a>
                                        </li>
                                        <li class="notification-card">
                                            <a href="#" onclick="return updateStatus('park-question');">
                                                <i class="far fa-question-circle"></i>
                                                {{ totalNotice('park-question') }}
                                                Park Question
                                            </a>
                                        </li>
                                        <li class="notification-card">
                                            <a href="#" onclick="return updateStatus('sales-modified');">
                                                <i class="fal fa-chart-bar"></i> {{ totalNotice('sales-modified') }}
                                                Modified sales ads
                                            </a>
                                        </li>
                                        <li class="notification-card">
                                            <a href="#" onclick="return updateStatus('request-parts');">
                                                <i class="fas fa-cogs"></i> </i> {{ totalNotice('request-parts') }}
                                                New Request Parts
                                            </a>
                                        </li>
                                        <li class="notification-card">
                                            <a href="#" onclick="return updateStatus('request-modified');">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                {{ totalNotice('request-modified') }}
                                                Modified Request Parts
                                            </a>
                                        </li>
                                        <li class="notification-card">
                                            <a href="#" onclick="return updateStatus('sales-question');">
                                                <i class="fas fa-comments"></i></i>
                                                {{ totalNotice('sales-question') }}
                                                Sales Comment
                                            </a>
                                        </li>
                                        <li class="notification-card">
                                            <a href="#" onclick="return updateStatus('sales-order');">
                                                <i class="fas fa-shopping-cart"></i> {{ totalNotice('sales-order') }}
                                                Sales Ordered
                                            </a>
                                        </li>
                                        <li class="notification-card">
                                            <a href="#" onclick="return updateStatus('request-question');">
                                                <i class="fas fa-users"></i> {{ totalNotice('request-question') }}
                                                Parts Comment
                                            </a>
                                        </li>
                                        <li class="notification-card">
                                            <a href="#" onclick="return updateStatus('bid-offer');">
                                                <i class="fas fa-users"></i> {{ totalNotice('bid-offer') }} Offer
                                                parts bid
                                            </a>
                                        </li>
                                        <li class="notification-card">
                                            <a href="#" onclick="return updateStatus('buyer-rate');">
                                                <i class="fas fa-users"></i> {{ totalNotice('buyer-rate') }} Rating
                                                From Seller
                                            </a>
                                        </li>
                                        <li class="notification-card">
                                            <a href="#" onclick="return updateStatus('seller-rate');">
                                                <i class="fas fa-users"></i> {{ totalNotice('seller-rate') }}
                                                Rating From Buyer
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="notify" onclick="updateAllNotifications()">All Notification</div>
                                </div>
                            </li>
                            {{-- <li class="onhover-dropdown">
                                <div class="notification-box">
                                    <i class="far fa-bell"></i><span class="badge rounded-pill badge-primary">4
                                    </span>
                                </div> --}}

                            {{-- <li class="onhover-dropdown">
                                <div class="notification-box">
                                    <i class="far fa-envelope"></i><span class="badge rounded-pill badge-info">3
                                    </span>
                                </div>

                            </li> --}}
                            {{-- <li class="cart-nav onhover-dropdown">
                                <div class="cart-box">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                            </li> --}}
                            <li class="profile-nav onhover-dropdown px-0 py-0">
                                <div class="d-flex profile-media align-items-center"><img class="img-30"
                                        src="{{ asset('images/profile.png') }}" alt="">
                                    <div class="flex-grow-1"><span>{{ Auth::user()->name }}<i class="fa fa-angle-down"></i></span>
                                        <p class="mb-0 font-outfit"> </p>
                                    </div>
                                </div>
                                <ul class="profile-dropdown onhover-show-div">
                                    <li><a href="{{ route ('profile.edit')}}"><i data-feather="user"></i><span>Profile
                                            </span></a></li>
                                    {{-- <li><a href="letter-box.html"><i data-feather="mail"></i><span>Inbox</span></a>
                                    </li>
                                    <li><a href="task.html"><i data-feather="file-text"></i><span>Taskboard</span></a>
                                    </li>
                                    <li><a href="edit-profile.html"><i data-feather="settings"></i><span>Settings</span></a></li> --}}

                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                this.closest('form').submit();" class="logout-btn"><i
                                                    class="fas fa-sign-out-alt"></i>
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </li>
                            </li>
                        </ul>
                        </li>
                        </ul>
                    </div>
                    <script class="result-template" type="text/x-handlebars-template">
                        <div class="ProfileCard u-cf">
              <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
              <div class="ProfileCard-details">
              <div class="ProfileCard-realName">{{ Auth::user()->name }}</div>
              </div>
              </div>
            </script>
                    <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
                </div>
            </div>
            <!-- Page Header Ends                              -->
        </div>
        <script>
            function updateStatus(noticetype) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('notice.status') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: 'noticetype=' + noticetype,
                    success: function(data) {
                        if (data.status === 'success') {
                            // Update the notification count
                            $('.badge').text(data.totalNotice);
                            // No notification found or successfully handled
                            switch (noticetype) {
                                case 'register':
                                    window.location = "{{ url('admin/users') }}";
                                    break;
                                case 'sales-add':
                                    window.location = "{{ url('admin/sales') }}";
                                    break;
                                case 'sales-modified':
                                    window.location = "{{ url('admin/sales') }}";
                                    break;
                                case 'request-parts':
                                    window.location = "{{ url('admin/request-parts') }}";
                                    break;
                                case 'request-modified':
                                    window.location = "{{ url('admin/request-parts') }}";
                                    break;
                                case 'sales-question':
                                    window.location = "{{ url('admin/reports') }}";
                                    break;
                                case 'sales-order':
                                    window.location = "{{ url('admin/saleorder') }}";
                                    break;
                                case 'bid-offer':
                                    window.location = "{{ url('admin/bidoffer') }}";
                                    break;
                                case 'park-question':
                                    window.location = "{{ url('admin/parkquestion') }}";
                                    break;
                                case 'buyer-rate':
                                case 'seller-rate':
                                    if (data.message) {
                                        window.location = data.message;
                                    } else {
                                        alert('No user ID found.');
                                    }
                                    break;
                                default:
                                    window.location = "{{ url('admin') }}";
                                    break;
                            }
                        } else {
                            alert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error occurred: ' + error);
                    }
                });
            }
        </script>

        <script>
            function updateAllNotifications() {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('notice.status.all') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            // Update the notification count
                            $('.badge').text(
                                0); // Assuming you want to set the count to zero after updating all notifications
                            // Reload the current page
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error occurred: ' + error);
                    }
                });
            }
        </script>
