<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <!-- Container-fluid starts-->
    <div class="container-fluid dashboard-3">
        <div class="row">
            <div class="admin-card-bx">
                <div class="card">
                    <div class="card-body pb-0 total-sells">
                        <div class="d-flex align-items-center gap-3">
                            <h2>{{$totalUser}}</h2>
                            <div class="flex-shrink-0"><img src="/images/coin1.png" alt="icon"></div>
                        </div>
                        <div id="admissionRatio"></div>
                    </div>
                    <div class="card-header card-no-border pb-0">
                        <div class="header-top daily-revenue-card">
                            <div class="dropdown icon-dropdown">
                                <button class="btn dropdown-toggle" id="userdropdown" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="icon-more-alt"></i></button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown"><a
                                        class="dropdown-item" href="#">Weekly</a><a class="dropdown-item"
                                        href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex total-icon">
                                    <p class="mb-0 up-arrow bg-light-success"><i class="fa fa-arrow-up text-success"></i></p><span class="f-w-500 font-success">+ {{ $monthlyPercentageChange }}%</span>
                                </div>
                            </div>
                            <h4>Total No of Users</h4>
                            <p class="text-truncate">Compared to {{ $comparisonDate }}</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body pb-0 total-sells-2">
                        <div class="d-flex align-items-center gap-3">
                            <h2>{{$totalBuyer}}</h2>
                            <div class="flex-shrink-0"><img src="/images/shopping1.png" alt="icon">
                            </div>
                        </div>
                        <div id="order-value"></div>
                    </div>
                    <div class="card-header card-no-border pb-0">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2">

                                <div class="d-flex total-icon">
                                    <p class="mb-0 up-arrow bg-light-{{$totalbuyerthisyear < 0 ? 'danger' : 'success'}}">
                                        <i class="fa fa-arrow-{{$totalbuyerthisyear < 0 ? 'down' : 'up'}} text-{{$totalbuyerthisyear < 0 ? 'danger' : 'success'}}"></i>
                                    </p>
                                    <span class="f-w-500 font-{{$totalbuyerthisyear < 0 ? 'danger' : 'success'}}">
                                        {{$totalbuyerthisyear < 0 ? '-' : '+'}} {{$totalbuyerthisyear}}%
                                    </span>
                                </div>
                            </div>
                            <h4>Buyer</h4>
                            <p class="text-truncate">{{$buyerPercent}}% Buyer from Total user</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body pb-0 total-sells-3">
                        <div class="d-flex align-items-center gap-3">
                            <h2>{{$totalSeller}}</h2>
                            <div class="flex-shrink-0"><img src="/images/sent1.png" alt="icon"></div>
                        </div>
                        <div id="daily-value"></div>
                    </div>
                    <div class="card-header card-no-border pb-0">
                        <!-- <div class="header-top daily-revenue-card">
                            <div class="dropdown icon-dropdown">
                                <button class="btn dropdown-toggle" id="userdropdown3" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="icon-more-alt"></i></button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown3"><a
                                        class="dropdown-item" href="#">Weekly</a><a class="dropdown-item"
                                        href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a>
                                </div>
                            </div>
                        </div> -->
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex total-icon">
                                    <p class="mb-0 up-arrow bg-light-{{$totalSellerthisyear < 0 ? 'danger' : 'success'}}">
                                        <i class="fa fa-arrow-{{$totalSellerthisyear < 0 ? 'down' : 'up'}} text-{{$totalSellerthisyear < 0 ? 'danger' : 'success'}}"></i>
                                    </p>
                                    <span class="f-w-500 font-{{$totalSellerthisyear < 0 ? 'danger' : 'success'}}">
                                        {{$totalSellerthisyear < 0 ? '-' : '+'}} {{$totalSellerthisyear}}%
                                    </span>
                                </div>
                            </div>
                            <h4>Seller</h4>
                            <p class="text-truncate"> {{$sellerPercent}}% Seller from Total user</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body pb-0 total-sells-4">
                        <div class="d-flex align-items-center gap-3">
                            <h2>{{$totSalesMade}}</h2>
                            <div class="flex-shrink-0"><img src="/images/revenue1.png" alt="icon">
                            </div>
                        </div>
                        <div id="daily-revenue"></div>
                    </div>
                    <div class="card-header card-no-border pb-0">
                        <!-- <div class="header-top daily-revenue-card">
                            <div class="dropdown icon-dropdown">
                                <button class="btn dropdown-toggle" id="userdropdown4" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="icon-more-alt"></i></button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown4"><a
                                        class="dropdown-item" href="#">Weekly</a><a class="dropdown-item"
                                        href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a>
                                </div>
                            </div>
                        </div> -->
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex total-icon">
                                <p class="mb-0 up-arrow bg-light-{{$totalSalesmadethisyear < 0 ? 'danger' : 'success'}}">
                                        <i class="fa fa-arrow-{{$totalSalesmadethisyear < 0 ? 'down' : 'up'}} text-{{$totalSalesmadethisyear < 0 ? 'danger' : 'success'}}"></i>
                                    </p>
                                    <span class="f-w-500 font-{{$totalSalesmadethisyear < 0 ? 'danger' : 'success'}}">
                                        {{$totalSalesmadethisyear < 0 ? '-' : '+'}} {{$totalSalesmadethisyear}}%
                                    </span>
                                </div>
                            </div>
                            <h4>Total Sales Made</h4>
                            <p class="text-truncate"></p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body pb-0 total-sells-4">
                        <div class="d-flex align-items-center gap-3">
                            <h2>{{$totalautoParts}}</h2>
                            <div class="flex-shrink-0"><img src="/images/revenue1.png" alt="icon">
                            </div>
                        </div>
                        <!-- <div id="daily-revenue"></div> -->
                    </div>
                    <div class="card-header card-no-border pb-0">
                        <!-- <div class="header-top daily-revenue-card">
                            <div class="dropdown icon-dropdown">
                                <button class="btn dropdown-toggle" id="userdropdown4" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="icon-more-alt"></i></button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown4"><a
                                        class="dropdown-item" href="#">Weekly</a><a class="dropdown-item"
                                        href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a>
                                </div>
                            </div>
                        </div> -->
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex total-icon">
                                    <p class="mb-0 up-arrow bg-light-danger"><i class="fa fa-arrow-up text-danger"></i></p><span class="f-w-500 font-danger">- 17.06%</span>
                                </div>
                            </div>
                            <h4>Total Auto Parts</h4>
                            <p class="text-truncate"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-space">
                    <div class="card-header card-no-border pb-0">
                        <div class="header-top">
                            <h4>Latest Members</h4>
                            <div class="dropdown icon-dropdown">
                                <button class="btn dropdown-toggle" id="userdropdown5" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown5"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body recent-orders">
                        <div class="table-responsive theme-scrollbar">
                            <table class="table display" id="latest-members" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>userID</th>
                                        <th>Name</th>
                                        <th>JoinDate</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="view-btn">
                        <a href="{{ url('admin/users') }}" class="view-all">View All Users</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <div class="header-top">
                            <h4>Latest visited Ads</h4>
                            <div class="dropdown icon-dropdown">
                                <button class="btn dropdown-toggle" id="userdropdown5" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown5"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body recent-orders">
                        <div class="table-responsive theme-scrollbar">
                            <ul>
                                @if(!empty($latestVisits))
                                @foreach($latestVisits as $latestVisit)
                                @php



                                $adv_details = strip_tags($latestVisit->adv_details);
                                $content = (strlen($adv_details) > 200) ? substr($adv_details, 0, 200).'...' : $adv_details;

                                $postId = $latestVisit->adv_id;
                                $adv_name = $latestVisit->adv_name;
                                $product_cond = $latestVisit->product_cond;
                                $price = $latestVisit->price;
                                $currency = $latestVisit->currency;
                                $quantity = $latestVisit->quantity;

                                $slug = $latestVisit->slug;
                                $salespath = "https://agrodepot-frontend.vercel.app/sales-details/{$slug}";

                                $postadimg = App\Models\PostadImg::where('post_ad_id',$latestVisit->adv_id)->first();
                                $profileImagePath = asset('uploads/postad/' . $postadimg->img_path);
                                @endphp

                                <li class="item">
                                    @if (!empty( $postadimg->img_path))
                                    <div class="product-img">
                                        <img src="{{$profileImagePath }}" alt="Sales Image">
                                    </div>
                                    @else
                                    <div class="product-img">
                                        <img src="{{ asset('uploads/brand/noimage.jpg') }}" alt="Sales Image">
                                    </div>
                                    @endif
                                    <div class="product-info">
                                        <a href="{{$salespath}}" class="product-title" target="_blank">{{ $adv_name }} <span class="label label-warning pull-right">{{ $price }} {{ $currency }}</span></a>
                                        <span class="product-description">
                                            {!! nl2br($content) !!}
                                        </span>
                                    </div>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="view-btn">
                        <a href="{{ url('admin/sales') }}" class="view-all">View All Ads</a>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <div class="header-top">
                            <h4>Most Viewed Ads</h4>
                            <div class="dropdown icon-dropdown">
                                <button class="btn dropdown-toggle" id="userdropdown5" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown5"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body recent-orders">
                        <div class="table-responsive theme-scrollbar">
                            <ul>
                                @if(!empty($mostViewRes))
                                @foreach($mostViewRes as $mostViewResult)
                                @php
                                $postId = $mostViewResult->adv_id;
                                $adv_name = $mostViewResult->adv_name;
                                $product_cond = $mostViewResult->product_cond;
                                $price = $mostViewResult->price;
                                $currency = $mostViewResult->currency;
                                $quantity = $mostViewResult->quantity;
                                $adv_details = strip_tags($mostViewResult->adv_details);
                                $content = (strlen($adv_details) > 200) ? substr($adv_details, 0, 200).'...' : $adv_details;
                                $slug = $mostViewResult->slug;
                                $salespath = "https://agrodepot-frontend.vercel.app/sales-details/{$slug}";

                                $profileImagePath = asset('uploads/postad/' . $mostViewResult->img_path);

                                @endphp

                                <li class="item">
                                    @if (!empty($mostViewResult->img_path))
                                    <div class="product-img">
                                        <img src="{{$profileImagePath }}" alt="Sales Image" width="50px" height="50px">
                                    </div>
                                    @else
                                    <div class="product-img">
                                        <img src="{{ asset('uploads/brand/noimage.jpg') }}" alt="Sales Image" width="50px" height="50px">
                                    </div>
                                    @endif
                                    <div class="product-info">
                                        <a href="{{$salespath}}" class="product-title" target="_blank">{{ $adv_name }} <span class="label label-warning pull-right">{{ $price }} {{ $currency }}</span></a>
                                        <span class="product-description">
                                            {!! nl2br($content) !!}
                                        </span>
                                    </div>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="view-btn">
                        <a href="{{ url('admin/sales') }}" class="view-all">View All Ads</a>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <div class="header-top">
                            <h4>Latest Sales Order</h4>
                            <div class="dropdown icon-dropdown">
                                <button class="btn dropdown-toggle" id="userdropdown5" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown5"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body recent-orders">
                        <div class="table-responsive theme-scrollbar">
                            <table class="table display" id="latest-orders" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Sales Name</th>
                                        <th>Status</th>
                                        <th>Ordered Date</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                    <div class="view-btn">
                        <a href="{{ url('admin/saleorder') }}" class="view-all">View All Orders</a>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <div class="header-top">
                            <h4>Latest Parts Order</h4>
                            <div class="dropdown icon-dropdown">
                                <button class="btn dropdown-toggle" id="userdropdown5" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown5"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body recent-orders">
                        <div class="table-responsive theme-scrollbar">
                            <table class="table display" id="latest-parts-orders" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Parts Name</th>
                                        <th>Status</th>
                                        <th>Ordered Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="view-btn">
                        <a href="{{ url('admin/requestparts') }}" class="view-all">View All Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</x-app-layout>

<script>
    // Update the series data dynamically based on weekly, monthly, and yearly counts
var admissionRatioOption = {
    series: [
        {
            name: 'Total Users',
            data: [{{$weeklyTotalUsers}}, {{$monthlyTotalUsers}}, {{$yearlyTotalUsers}}],
        },
    ],
    chart: {
        type: 'area',
        height: 90,
        offsetY: -10,
        offsetX: 0,
        toolbar: {
            show: false,
        },
    },
    stroke: {
        width: 2,
        curve: 'smooth'
    },
    grid: {
        show: false,
        borderColor: 'var(--light)',
        padding: {
            top: 5,
            right: 0,
            bottom: -30,
            left: 0,
        },
    },
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.5,
            opacityTo: 0.1,
            stops: [0, 90, 100]
        }
    },
    dataLabels: {
        enabled: false,
    },
    colors: [MofiAdminConfig.primary],
    xaxis: {
        categories: ['Weekly', 'Monthly', 'Yearly'], // Add labels here
        labels: {
            show: true,
        },
        tooltip: {
            enabled: false,
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
    },
    yaxis: {
        opposite: false,
        min: {{$weeklyTotalUsers}}, // Set min value dynamically
        max: {{$yearlyTotalUsers}}, // Set max value dynamically
        logBase: 100,
        tickAmount: 4,
        forceNiceScale: false,
        floating: false,
        decimalsInFloat: undefined,
        labels: {
            show: false,
            offsetX: -12,
            offsetY: -15,
            rotate: 0,
        },
    },
    legend: {
        horizontalAlign: 'left',
    },
};

var admissionRatio = new ApexCharts(document.querySelector('#admissionRatio'), admissionRatioOption);
admissionRatio.render();


var admissionRatioOption = {
    series: [
        {
            name: 'Buyers',
            data: [{{$weeklyBuyers}}, {{$monthlyBuyers}}, {{$yearlyBuyers}}],
        },
    ],
    chart: {
        type: 'area',
        height: 90,
        offsetY: -10,
        offsetX: 0,
        toolbar: {
            show: false,
        },
    },
    stroke: {
        width: 2,
        curve: 'smooth'
    },
    grid: {
        show: false,
        borderColor: 'var(--light)',
        padding: {
            top: 5,
            right: 0,
            bottom: -30,
            left: 0,
        },
    },
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.5,
            opacityTo: 0.1,
            stops: [0, 80, 100]
        }
    },
    dataLabels: {
        enabled: false,
    },
    colors: [MofiAdminConfig.secondary],
    xaxis: {
        categories: ['Weekly', 'Monthly', 'Yearly'], // Add labels here
        labels: {
            show: false,
        },
        tooltip: {
            enabled: false,
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
    },
    yaxis: {
        opposite: false,
        min: {{$weeklyBuyers}}, // Set min value dynamically
        max: {{$yearlyBuyers}}, // Set max value dynamically
        logBase: 100,
        tickAmount: 4,
        forceNiceScale: false,
        floating: false,
        decimalsInFloat: undefined,
        labels: {
            show: false,
            offsetX: -12,
            offsetY: -15,
            rotate: 0,
        },
    },
    legend: {
        horizontalAlign: 'left',
    },
    responsive: [

    ],
};

var admissionRatio = new ApexCharts(document.querySelector('#order-value'), admissionRatioOption);
admissionRatio.render();
    // ======================================
var admissionRatioOption = {
    series: [
        {
            name: 'Seller',
            data: [{{$weeklySeller}}, {{$monthlyBuyers}}, {{$yearlySeller}}],
        },
    ],
    chart: {
        type: 'area',
        height: 90,
        offsetY: -10,
        offsetX: 0,
        toolbar: {
            show: false,
        },
    },
    stroke: {
        width: 2,
        curve: 'smooth'
    },
    grid: {
        show: false,
        borderColor: 'var(--light)',
        padding: {
            top: 5,
            right: 0,
            bottom: -30,
            left: 0,
        },
    },
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.5,
            opacityTo: 0.1,
            stops: [0, 90, 100]
        }
    },
    dataLabels: {
        enabled: false,
    },
    colors: ['#C95E9E'],
    xaxis: {
        categories: ['Weekly', 'Monthly', 'Yearly'], // Add labels here
        labels: {
            show: false,
        },
        tooltip: {
            enabled: false,
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
    },
    yaxis: {
        opposite: false,
        min: {{$weeklySeller}}, // Set min value dynamically
        max: {{$yearlySeller}}, // Set max value dynamically
        logBase: 100,
        tickAmount: 4,
        forceNiceScale: false,
        floating: false,
        decimalsInFloat: undefined,
        labels: {
            show: false,
            offsetX: -12,
            offsetY: -15,
            rotate: 0,
        },
    },
    legend: {
        horizontalAlign: 'left',
    },
    responsive: [

    ],
};


var admissionRatio = new ApexCharts(document.querySelector('#daily-value'), admissionRatioOption);
    admissionRatio.render();

var admissionRatioOption = {
    series: [
        {
            name: 'Total Sales Made',
            data: [{{$weeklySalesmade}}, {{$monthlySalesmade}}, {{$yearlySalesmade}}],
        },
    ],
    chart: {
        type: 'area',
        height: 90,
        offsetY: -10,
        offsetX: 0,
        toolbar: {
            show: false,
        },
    },
    stroke: {
        width: 2,
        curve: 'smooth'
    },
    grid: {
        show: false,
        borderColor: 'var(--light)',
        padding: {
            top: 5,
            right: 0,
            bottom: -30,
            left: 0,
        },
    },
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.5,
            opacityTo: 0.1,
            stops: [0, 90, 100]
        }
    },
    dataLabels: {
        enabled: false,
    },
    colors: ['#C95E9E'],
    xaxis: {
        categories: ['Weekly', 'Monthly', 'Yearly'], // Add labels here
        labels: {
            show: false,
        },
        tooltip: {
            enabled: false,
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
    },
    yaxis: {
        opposite: false,
        min: {{$weeklySalesmade}}, // Set min value dynamically
        max: {{$yearlySalesmade}}, // Set max value dynamically
        logBase: 100,
        tickAmount: 4,
        forceNiceScale: false,
        floating: false,
        decimalsInFloat: undefined,
        labels: {
            show: false,
            offsetX: -12,
            offsetY: -15,
            rotate: 0,
        },
    },
    legend: {
        horizontalAlign: 'left',
    },
    responsive: [

    ],
};


var admissionRatio = new ApexCharts(document.querySelector('#daily-revenue'), admissionRatioOption);

</script>