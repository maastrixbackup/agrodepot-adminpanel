<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterUser;
use App\Models\SalesOrder;
use App\Models\SalesView;
use App\Models\SalesAdvertisement;
use App\Models\RecentView;
use App\Models\PartsOrder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentDate = Carbon::now();
        $totalUser = MasterUser::count();

        // Fetch data for weekly, monthly, and yearly total users
        // $weeklyTotalUsers = MasterUser::where('created', '>=', $currentDate->startOfWeek()->subWeek()->format('Y-m-d H:i:s'))->count();
        // $monthlyTotalUsers = MasterUser::where('created', '>=', $currentDate->startOfMonth()->subMonth()->format('Y-m-d H:i:s'))->count();
        // $yearlyTotalUsers = MasterUser::where('created', '>=', $currentDate->startOfYear()->subYear()->format('Y-m-d H:i:s'))->count();

        // Get counts for last week
        $weeklyTotalUsers = MasterUser::whereBetween('created', [$currentDate->copy()->subWeek(), $currentDate])
            ->count();

        // Get counts for current month
        $monthlyTotalUsers = MasterUser::whereYear('created', $currentDate->year)
            ->whereMonth('created', $currentDate->month)
            ->count();

        // Get counts for current year
        $yearlyTotalUsers = MasterUser::whereYear('created', $currentDate->year)
            ->count();
        // dd($yearlyTotalUsers);

        // Calculate monthly percentage change
        $monthlyPercentageChange = $yearlyTotalUsers / ($totalUser - $yearlyTotalUsers) * 100;

        $monthlyPercentageChange = round($monthlyPercentageChange);


        // Format the date string for comparison
        $comparisonDate = Carbon::now()->subMonth()->format('M Y');

        $totalBuyer = MasterUser::where('user_type_id', 1)->count();
        // dd($totalBuyer);
        $totalSeller = MasterUser::where('user_type_id', 2)->count();

        $totalSellerBuyer = $totalSeller + $totalBuyer;
        $sellerPercent = ($totalSeller / $totalSellerBuyer) * 100;
        $buyerPercent = ($totalBuyer / $totalSellerBuyer) * 100;

        $sellerPercent = round($sellerPercent);
        $buyerPercent = round($buyerPercent);


        // $yearlyBuyers = MasterUser::where('user_type_id', 1)->where('created', '>=', $currentDate->startOfYear()->subYear()->format('Y-m-d H:i:s'))->count();
        $yearlyBuyers = MasterUser::where('user_type_id', 1)
            ->whereYear('created', $currentDate->year)
            ->count();

        $totalbuyerthisyear = round($yearlyBuyers / ($totalBuyer - $yearlyBuyers) * 100);
        // $weeklyBuyers = MasterUser::where('user_type_id', 1)->where('created', '>=', $currentDate->startOfWeek()->subWeek()->format('Y-m-d H:i:s'))->count();
        $weeklyBuyers = MasterUser::where('user_type_id', 1)
            ->whereBetween('created', [$currentDate->copy()->subWeek(), $currentDate])
            ->count();
        // $monthlyBuyers = MasterUser::where('user_type_id', 1)->where('created', '>=', $currentDate->startOfMonth()->subMonth()->format('Y-m-d H:i:s'))->count();
        $monthlyBuyers = MasterUser::where('user_type_id', 1)
            ->whereYear('created', $currentDate->year)
            ->whereMonth('created', $currentDate->month)
            ->count();
        // dd($totalbuyerlastyear);


        // $yearlySeller = MasterUser::where('user_type_id', 2)->where('created', '>=', $currentDate->startOfYear()->subYear()->format('Y-m-d H:i:s'))->count();
        // Get counts for current year
        $yearlySeller = MasterUser::where('user_type_id', 2)
            ->whereYear('created', $currentDate->year)
            ->count();

        $totalSellerthisyear = round($yearlySeller / ($totalSeller - $yearlySeller) * 100);


        // $weeklySeller = MasterUser::where('user_type_id', 2)->where('created', '>=', $currentDate->startOfWeek()->subWeek()->format('Y-m-d H:i:s'))->count();
        // Get counts for last week
        $weeklySeller = MasterUser::where('user_type_id', 2)
            ->whereBetween('created', [$currentDate->copy()->subWeek(), $currentDate])
            ->count();
        // $monthlySeller = MasterUser::where('user_type_id', 2)->where('created', '>=', $currentDate->startOfMonth()->subMonth()->format('Y-m-d H:i:s'))->count();
        // Get counts for current month
        $monthlySeller = MasterUser::where('user_type_id', 2)
            ->whereYear('created', $currentDate->year)
            ->whereMonth('created', $currentDate->month)
            ->count();


        $totSalesMade =  SalesOrder::where('status', 2)->orderby('id', 'desc')->count();
        // dd($totSalesMade);

        // $yearlySalesmade = SalesOrder::where('status', 2)->orderby('id', 'desc')->where('created', '>=', $currentDate->startOfYear()->subYear()->format('Y-m-d H:i:s'))->count();
        // Get counts for current year
        $yearlySalesmade = SalesOrder::where('status', 2)->orderby('id', 'desc')->whereYear('created', $currentDate->year)
            ->count();
        // dd($yearlySalesmade);

        $totalSalesmadethisyear = round($yearlySalesmade / ($totSalesMade - $yearlySalesmade) * 100);


        // Get counts for last week
        $weeklySalesmade = SalesOrder::where('status', 2)->orderby('id', 'desc')->whereBetween('created', [$currentDate->copy()->subWeek(), $currentDate])
            ->count();

        // Get counts for current month
        $monthlySalesmade = SalesOrder::where('status', 2)->orderby('id', 'desc')->whereYear('created', $currentDate->year)
            ->whereMonth('created', $currentDate->month)
            ->count();

        $totalautoParts = SalesAdvertisement::count();


        $latestVisits = RecentView::leftJoin('sales_advertisements', 'sales_advertisements.adv_id', '=', 'recent_views.adv_id')->whereDate('recent_views.exp_date', '>=', $currentDate)
            ->orWhere('adv_status', 1)
            ->orderByDesc('recent_views.created')
            ->limit(5)
            ->select(
                'recent_views.*',
                'sales_advertisements.adv_id',
                'sales_advertisements.adv_name',
                'sales_advertisements.slug',
                'sales_advertisements.product_cond',
                'sales_advertisements.price',
                'sales_advertisements.currency',
                'sales_advertisements.quantity',
                'sales_advertisements.adv_details',
            )
            ->get();

        $mostViewRes = SalesView::leftJoin('sales_advertisements', 'sales_view.adv_id', '=', 'sales_advertisements.adv_id')
            ->leftJoin('postad_img as pi', 'sales_advertisements.adv_id', '=', 'pi.post_ad_id')
            ->select(
                'pi.img_path',
                'sales_advertisements.adv_id',
                'sales_advertisements.adv_name',
                'sales_advertisements.slug',
                'sales_advertisements.product_cond',
                'sales_advertisements.price',
                'sales_advertisements.currency',
                'sales_advertisements.quantity',
                'sales_advertisements.adv_details'
            )
            ->limit(5)
            ->get();

        return view('dashboard', compact('totalUser', 'totalBuyer', 'totalSeller', 'sellerPercent', 'buyerPercent', 'totSalesMade', 'totalautoParts', 'latestVisits', 'mostViewRes', 'weeklyTotalUsers', 'monthlyTotalUsers', 'yearlyTotalUsers', 'monthlyPercentageChange', 'comparisonDate', 'totalbuyerthisyear', 'totalSellerthisyear', 'totalSalesmadethisyear', 'weeklyBuyers', 'monthlyBuyers', 'yearlyBuyers', 'weeklySeller', 'monthlyBuyers', 'yearlySeller', 'weeklySalesmade', 'monthlySalesmade', 'yearlySalesmade'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    /**
     * Get Latest Members
     */
    public function latestMembers(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $row = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        $columnIndex = $request['order'][0]['column']; // Column index
        $columnName = $request['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $request['order'][0]['dir']; // asc or desc
        $searchValue = $request['search']['value']; // Search value
        ## Read value
        $data = array();

        $totalRecords = MasterUser::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MasterUser::select('count(*) as allcount')->where('user_id', 'like', '%' . $searchValue . '%')->orwhere('first_name', 'like', '%' . $searchValue . '%')->orwhere('last_name', 'like', '%' . $searchValue . '%')->orwhere('created', 'like', '%' . $searchValue . '%')->count();
        // Fetch records
        $memberRecords = MasterUser::orderBy($columnName, $columnSortOrder)
            ->where('user_id', 'like', '%' . $searchValue . '%')
            ->orwhere('first_name', 'like', '%' . $searchValue . '%')
            ->orwhere('last_name', 'like', '%' . $searchValue . '%')
            ->orwhere('created', 'like', '%' . $searchValue . '%')
            ->select('master_users.*')->skip($row)->take(8)->get();
        $i = 1;
        foreach ($memberRecords as $key => $record) {
            // Convert $member->created to a date string
            $joinDate = date("Y-m-d", strtotime($record->created));

            // Get today's date
            $today = date("Y-m-d");

            // Get the previous day
            $prevDay = date("Y-m-d", strtotime('-1 day'));

            // Compare $joinDate with today's date
            if ($joinDate === $today) {
                $joinDate = "Today";
            } elseif ($joinDate === $prevDay) {
                $joinDate = "Yesterday";
            } else {
                $joinDate = date("d M", strtotime($joinDate));
            }
            if (!empty($record->profile_img)) {
                $image = '<div class="d-flex align-items-center gap-2"><div class="flex-shrink-0"><img src="' . asset('uploads/profileimg/' . $record->profile_img) . '" alt=""></div></div>';
            } else {
                $image = '<div class="d-flex align-items-center gap-2"><div class="product-img"><img src="' . asset('images/profile.png') . '"  width="50px" height="50px" alt="Sales Image"></div>
                </div>';
            }

            $data[] = array(
                "profile_img" => $image,
                "user_id" => $record->user_id,
                "name" => $record->first_name . ' ' . $record->last_name,
                "join_date" => $joinDate

            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "data" => $data
        );

        echo json_encode($response);
    }


    /**
     * Get Latest Orders
     */
    public function latestOrders(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $row = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        $columnIndex = $request['order'][0]['column']; // Column index
        $columnName = $request['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $request['order'][0]['dir']; // asc or desc
        $searchValue = $request['search']['value']; // Search value
        ## Read value
        $data = array();


        $totalRecords = SalesOrder::leftJoin('sales_advertisements as sa', 'sales_order.adv_id', '=', 'sa.adv_id')->select('sales_order.sales_order.count(*) as allcount')->count();
        $totalRecordswithFilter = SalesOrder::leftJoin('sales_advertisements as sa', 'sales_order.adv_id', '=', 'sa.adv_id')->select('sales_order.count(*) as allcount')->where('orderid', 'like', '%' . $searchValue . '%')->orwhere('adv_name', 'like', '%' . $searchValue . '%')->orwhere('status', 'like', '%' . $searchValue . '%')->orwhere('sales_order.created', 'like', '%' . $searchValue . '%')->count();
        // Fetch records
        $salesRecords = SalesOrder::leftJoin('sales_advertisements as sa', 'sales_order.adv_id', '=', 'sa.adv_id')->orderBy($columnName, $columnSortOrder)
            ->where('orderid', 'like', '%' . $searchValue . '%')
            ->orwhere('adv_name', 'like', '%' . $searchValue . '%')
            ->orwhere('status', 'like', '%' . $searchValue . '%')
            ->orwhere('sales_order.created', 'like', '%' . $searchValue . '%')
            ->select('sales_order.id', 'sales_order.orderid', 'sales_order.status', 'sales_order.created', 'sa.adv_name')->skip($row)->take(8)->get();
        $i = 1;
        foreach ($salesRecords as $key => $record) {
            if ($record->status == 0) {
                $status =  'New order';
            } elseif ($record->status == 1) {
                $status = 'confirmed order';
            } elseif ($record->status == 2) {
                $status = 'completed order';
            } elseif ($record->status == 3) {
                $status = 'shipped order';
            } elseif ($record->status == 4) {
                $status = 'cancel Order';
            }
            $url = url('admin/saleorder/' . $record->id);
            $order = '<a href="' . $url  . '">' . $record->orderid . '</a>';

            $data[] = array(
                "orderid" => $order,
                "adv_name" => $record->adv_name,
                "status" => $status,
                "created" =>  date("Y-m-d", strtotime($record->created))

            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "data" => $data
        );

        echo json_encode($response);
    }


    /**
     * Get Latest Part Orders
     */
    public function latestPartOrders(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $row = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        $columnIndex = $request['order'][0]['column']; // Column index
        $columnName = $request['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $request['order'][0]['dir']; // asc or desc
        $searchValue = $request['search']['value']; // Search value
        ## Read value
        $data = array();



        $totalRecords = PartsOrder::leftJoin('request_accessories as ra', 'parts_order.parts_id', '=', 'ra.part_id')->select('parts_order.count(*) as allcount')->count();
        $totalRecordswithFilter = PartsOrder::leftJoin('request_accessories as ra', 'parts_order.parts_id', '=', 'ra.part_id')->select('parts_order.count(*) as allcount')->where('orderid', 'like', '%' . $searchValue . '%')->orwhere('name_piece', 'like', '%' . $searchValue . '%')->orwhere('parts_order.status', 'like', '%' . $searchValue . '%')->orwhere('parts_order.created', 'like', '%' . $searchValue . '%')->count();
        // Fetch records
        $partsRecords = PartsOrder::leftJoin('request_accessories as ra', 'parts_order.parts_id', '=', 'ra.part_id')->orderBy($columnName, $columnSortOrder)
            ->where('orderid', 'like', '%' . $searchValue . '%')
            ->orwhere('name_piece', 'like', '%' . $searchValue . '%')
            ->orwhere('parts_order.status', 'like', '%' . $searchValue . '%')
            ->orwhere('parts_order.created', 'like', '%' . $searchValue . '%')
            ->select('parts_order.id', 'parts_order.orderid', 'parts_order.status', 'parts_order.created', 'ra.name_piece')->skip($row)->take(8)->get();
        $i = 1;
        foreach ($partsRecords as $key => $record) {
            if ($record->status == 0) {
                $status =  'New order';
            } elseif ($record->status == 1) {
                $status = 'confirmed order';
            } elseif ($record->status == 2) {
                $status = 'completed order';
            } elseif ($record->status == 3) {
                $status = 'shipped order';
            } elseif ($record->status == 4) {
                $status = 'cancel Order';
            }
            $url = url('admin/saleorder/' . $record->id);
            $order = '<a href="' . $url  . '">' . $record->orderid . '</a>';

            $data[] = array(
                "orderid" => $order,
                "name_piece" => $record->name_piece,
                "status" => $status,
                "created" =>  date("Y-m-d", strtotime($record->created))

            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "data" => $data
        );

        echo json_encode($response);
    }
}
