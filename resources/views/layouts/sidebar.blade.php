{{ request()->url('admin/brands') }}
<div class="sidebar-wrapper" data-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"><a href="{{ url('admin/dashboard') }}"><img class="img-fluid" src="{{ asset('images/argodepo.png') }}" alt=""></a>

            <!-- <div class="toggle-sidebar">
            <i class="fas fa-bars"></i>
          </div> -->
        </div>
        <div class="logo-icon-wrapper"><a href="{{ url('admin/dashboard') }}"><img class="img-fluid" src="{{ asset('images/logo-icon.png') }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="index.html"><img class="img-fluid" src="{{ asset('images/logo-icon.png') }}" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li class="pin-title sidebar-main-title">
                        <div>
                            <h6>Pinned</h6>
                        </div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <!-- <h6 class="lan-1">General</h6> -->
                        </div>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)">

                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-home-lg-alt"></i>
                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>
                            </svg><span class="lan-3">Dashboard </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a class="lan-4" href="index.html">Default</a></li>
                            <li><a class="lan-5" href="dashboard-02.html">Project</a></li>
                            <li><a href="dashboard-03.html">Ecommerce</a></li>
                            <li><a href="dashboard-04.html">Education</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i class="fal fa-chart-bar"></i>
                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>
                            </svg>
                            <span>Brands</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li class="">
                                <a href="{{ url('admin/brands') }}">Manage Brands</a>
                            </li>
                            <li class="">
                                <a href="{{ url('admin/dashboard/cms-pages') }}">Rearrange Brands</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{ url('admin/banners') }}">

                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fas fa-images"></i>
                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Banners</span>

                        </a>
                    </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{ url('admin/admin-langs') }}">


                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-globe"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Language</span>

                        </a>
                    </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{ url('admin/memberships') }}">


                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-user"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">User Membership</span>

                        </a>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{ url('admin/advertises') }}">


                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-ad"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Advertisements</span>

                        </a>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{ url('admin/seofields') }}">


                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-tasks-alt"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Manage SEO</span>

                        </a>
                    </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)">

                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-newspaper"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Manage News Letter</span>

                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ url('admin/newsletters') }}">View Subscriber</a></li>
                            <li><a href="{{ url('admin/compose-mail') }}">Compose Mail</a></li>
                            <li><a href="{{ url('admin/sent-mail') }}">Sent Mail</a></li>

                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{ url('admin/themes') }}">


                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fas fa-user-edit"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Manage Theme</span>

                        </a>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{ url('admin/messages') }}">


                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fas fa-comments"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Manage Messages</span>
                        </a>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)">

                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-cog"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Settings</span>

                        </a>
                        <ul class="sidebar-submenu">
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{ url('admin/templates') }}">
                                    <svg class="fill-icon">
                                    </svg><span class="">Email Templates</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{ url('admin/socialicons') }}">


                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-share-alt"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Social Icons</span>

                        </a>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{ url('admin/pages') }}">


                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-file-alt"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Page</span>

                        </a>
                    </li>


                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{ url('admin/admin-users') }}">


                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fas fa-user-shield"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Admin</span>

                        </a>
                    </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)">

                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-file-chart-line"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Reports</span>

                        </a>
                        <ul class="sidebar-submenu">
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{ url('admin/reports') }}">
                                    <svg class="fill-icon">
                                    </svg><span class="">Ask Question</span>
                                </a>
                            </li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{ url('admin/sellers') }}">
                                    <svg class="fill-icon">
                                    </svg><span class="">Ask Seller</span>
                                </a>
                            </li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{ url('admin/audit-login') }}">
                                    <svg class="fill-icon">
                                    </svg><span class="">Login Reports</span>
                                </a>
                            </li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{ url('admin/request-parts') }}">
                                    <svg class="fill-icon">
                                    </svg><span class="">Request Parts</span>
                                </a>
                            </li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{ url('admin/bidoffer') }}">
                                    <svg class="fill-icon">
                                    </svg><span class="">Bid Offer</span>
                                </a>
                            </li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{ url('admin/saleorder') }}">
                                    <svg class="fill-icon">
                                    </svg><span class="">Sales Order</span>
                                </a>
                            </li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{ url('admin/requestparts') }}">
                                    <svg class="fill-icon">
                                    </svg><span class="">Request Parts Order</span>
                                </a>
                            </li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{ url('admin/parkquestion') }}">
                                    <svg class="fill-icon">
                                    </svg><span class="">Park Question</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{ url('admin/users') }}">


                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-user"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Users</span>

                        </a>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{ url('admin/categories') }}">


                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-th-large"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Category</span>

                        </a>
                    </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)">

                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-money-bill-alt"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Manage Payments</span>

                        </a>
                        <ul class="sidebar-submenu">
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{ url('admin/upgrade-memberships') }}">
                                    <svg class="fill-icon">
                                    </svg><span class="">Manage Membership Payments</span>
                                </a>
                            </li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{ url('admin/credits') }}">
                                    <svg class="fill-icon">
                                    </svg><span class="">Manage Credits</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                            href="javascript:void(0)">

                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                    <i class="fal fa-sliders-h"></i>

                    <svg class="fill-icon">
                        <use href="images/icon-sprite.svg#fill-home"></use>

                    </svg><span class="">CMS pages </span>

                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{ url('admin/dashboard/cms-pages') }}">All Pages</a></li>
                        @foreach ($menus as $menu)
                        <li><a class="" href="index.html">{{ $menu->title }}</a></li>
                        @endforeach

                    </ul>
                    </li> --}}
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)">

                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-chart-bar"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Sales </span>

                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ url('admin/sales') }}">Manage Sales</a></li>
                            <li><a href="{{ url('admin/sales/create') }}">Add new Sale</a></li>
                            <li><a href="{{ url('admin/dashboard/cms-pages') }}">Deactivate Expired Promotion</a></li>
                            <li><a href="{{ url('admin/dashboard/cms-pages') }}">Manage User Credit</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)">

                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fal fa-shield-check"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Success Stories</span>

                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ url('admin/success-stories') }}">Manage Success Stories</a></li>
                            <li><a href="{{ url('admin/success-stories/create') }}">Add a Success Story</a></li>

                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)">

                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="far fa-newspaper"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">News</span>

                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ url('admin/news') }}">Manage News</a></li>
                            <li><a href="{{ url('admin/news/create') }}">Add News</a></li>

                        </ul>
                    </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)">

                            <!-- <img class="dash-icon" src="{{ asset('images/home (1).png') }}"> -->
                            <i class="fas fa-tools"></i>

                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-home"></use>

                            </svg><span class="">Site Settings</span>

                        </a>
                        <ul class="sidebar-submenu">
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{ route('logo.create') }}">
                                    <svg class="fill-icon">
                                    </svg><span class="">Manage Logo</span>
                                </a>
                            </li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{ url('admin/locations') }}">
                                    <svg class="fill-icon">
                                    </svg><span class="">Manage Location</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <!-- <svg class="stroke-icon">
                    <use href="images/icon-sprite.svg#stroke-widget"></use>
                  </svg> -->
                            <img class="dash-icon" src="{{ asset('images/widget.png') }}">
                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-widget"></use>
                            </svg><span class="lan-6">Widgets</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="general-widget.html">General</a></li>
                            <li><a href="chart-widget.html">Chart</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <!-- <svg class="stroke-icon">
                    <use href="images/icon-sprite.svg#stroke-layout"></use>
                  </svg> -->
                            <img class="dash-icon" src="{{ asset('images/page.png') }}">
                            <svg class="fill-icon">
                                <use href="images/icon-sprite.svg#fill-layout"></use>
                            </svg><span class="lan-7">Page layout</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="box-layout.html">Boxed</a></li>
                            <li><a href="layout-rtl.html">RTL</a></li>
                            <li><a href="layout-dark.html">Dark Layout</a></li>
                            <li><a href="hide-on-scroll.html">Hide Nav Scroll</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>