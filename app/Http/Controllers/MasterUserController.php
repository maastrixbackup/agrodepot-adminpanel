<?php

namespace App\Http\Controllers;

use App\Models\AddCredit;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Models\MasterUser;
use App\Models\MasterCountry;
use App\Models\MasterLocation;
use App\Models\MasterUserType;
use App\Models\UpgradeMembership;
use App\Models\UserCreditAccount;
use App\Models\UserMembership;
use App\Models\UserRating;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Models\UserTotalCredit;

class MasterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_type = $request->input('user_type');

        $query = MasterUser::with('userType')->orderBy('user_id', 'desc');

        if ($user_type && $user_type != 3) {
            $query->where('user_type_id', $user_type);
        }

        $data = $query->get();
        $totalUser = MasterUser::count();
        $totalBuyer = MasterUser::where('user_type_id', 1)->count();
        $totalSeller = MasterUser::where('user_type_id', 2)->count();
        $userMembership = UserMembership::where('status', 1)->orderBy('memb_id', 'desc')->get();

        return view('masterusers.list', compact('data', 'totalUser', 'totalBuyer', 'totalSeller', 'userMembership', 'user_type'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = MasterCountry::pluck('country_name', 'country_id');

        $users = MasterUserType::pluck('user_type', 'ut_id');
        return view("masterusers.add", compact('countries', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'telephone1' => 'required',
            // 'telephone2' => 'required',
            // 'telephone3' => 'required',
            // 'telephone4' => 'required',
            'country' => 'required',
            'city' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = new MasterUser();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->pass = bcrypt($request->input('password'));
        $user->telephone1 = $request->input('telephone1');
        // $user->telephone2 = $request->input('telephone2');
        // $user->telephone3 = $request->input('telephone3');
        // $user->telephone4 = $request->input('telephone4');
        $user->country_id = $request->input('country');
        $user->locality_id = $request->input('city');
        $user->user_type_id = $request->input('user_type');
        $user->is_active = $request->input('status');
        $user->save();

        //dd($user);
        return redirect()->route('users.index')->with('success', 'User added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $masteruser_data = MasterUser::find($id);
        $country = MasterCountry::where('country_id', $masteruser_data->country_id)->select('country_name')
            ->first();
        $location = MasterLocation::where('location_id', $masteruser_data->location_id)
            ->select('location_name')
            ->first();
        $u_type = MasterUserType::where('ut_id', $masteruser_data->user_type_id)->first();

        $userTotalCredit = UserTotalCredit::where('user_id', $masteruser_data->user_id)->first();

        return view('masterusers.show', compact('masteruser_data', 'country', 'location', 'u_type', 'userTotalCredit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = MasterUser::find($id);
        $countries = MasterCountry::pluck('country_name', 'country_id');
        $city = MasterLocation::select('location_id', 'location_name')->paginate(20);
        $users = MasterUserType::pluck('user_type', 'ut_id');
        return view("masterusers.edit", compact("data", "countries", "city", "users"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = MasterUser::find($id);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->pass = $request->input('password');
        $user->telephone1 = $request->input('telephone1');
        // $user->telephone2 = $request->input('telephone2');
        // $user->telephone3 = $request->input('telephone3');
        // $user->telephone4 = $request->input('telephone4');
        $user->country_id = $request->input('country');
        $user->locality_id = $request->input('city');
        $user->user_type_id = $request->input('user_type');
        $user->is_active = $request->input('status');
        $user->save();


        return redirect()->route('users.index')->with('success', 'User saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = MasterUser::find($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }


    public function updateStatus(Request $request, $userId)
    {
        $user = MasterUser::find($userId);
        $user->is_active = $request->input('is_active');
        $user->save();

        return response()->json(['message' => 'Status updated successfully', 'status' => $user->is_active]);
    }

    public function updatePassword(Request $req, $uId)
    {
        try {
            MasterUser::where('user_id', $uId)->update(['pass' => md5($req->password)]);
            return response()->json([
                'status' => true,
                'message' => 'Password Changed Successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }


    public function upgradeMember(Request $request)
    {
        if ($request->isMethod('post')) {
            $uid = $request->input('uid');
            $memid = $request->input('memid');

            $userMembership = UserMembership::where('status', 1)
                ->where('memb_id', $memid)
                ->orderBy('price', 'desc')
                ->first();

            if ($userMembership) {
                // Check if UpgradeMembership record already exists for the user
                $upgradeMembership = UpgradeMembership::where('user_id', $uid)->first();

                if (!$upgradeMembership) {
                    // If UpgradeMembership record doesn't exist, create a new one
                    $upgradeMembership = new UpgradeMembership();
                }

                // Update the fields of the UpgradeMembership instance
                $upgradeMembership->user_id = $uid;
                $upgradeMembership->member_type = $userMembership->memb_id;
                $upgradeMembership->payment_method = '';
                $upgradeMembership->payment_status = 1;
                $upgradeMembership->plan_status = 1;
                $upgradeMembership->price = $userMembership->price;
                $upgradeMembership->credit = $userMembership->credits;
                $upgradeMembership->created = now();
                $upgradeMembership->modified = now();

                // Save the UpgradeMembership record
                if ($upgradeMembership->save()) {
                    $insertId = $upgradeMembership->upgrade_id;

                    $userCreditAccount = UserCreditAccount::where('user_id', $uid)->first();

                    if ($userCreditAccount) {
                        $creditId = $userCreditAccount->credit_id;
                        $updateCredit = $userCreditAccount->credits + $userMembership->credits;

                        $userCreditAccount->update(['credits' => $updateCredit, 'credit_id' => $creditId, 'upgrade_id' => $insertId]);

                        $updCreditId = $creditId;
                    } else {
                        $updateCredit = $userMembership->credits;

                        $userCreditAccount = new UserCreditAccount();
                        $userCreditAccount->upgrade_id = $insertId;
                        $userCreditAccount->user_id = $uid;
                        $userCreditAccount->credits = $updateCredit;
                        $userCreditAccount->created = now();
                        $userCreditAccount->modified = now();
                        $userCreditAccount->save();

                        $updCreditId = $userCreditAccount->id;
                    }

                    if ($updCreditId) {
                        $addCredit = new AddCredit();
                        $addCredit->credit_id = $updCreditId;
                        $addCredit->credits = $userMembership->credits;
                        $addCredit->credits_by = 0; // Assuming it's for users
                        $addCredit->created = now(); // Set the created field to the current timestamp
                        $addCredit->modified = now(); // Set the modified field to the current timestamp
                        $addCredit->save();

                        return response()->json('1'); // Return JSON-encoded string '1' instead of integer 1
                    }
                }
            }
        }
        return response()->json(0);
    }

    public function showRatings(Request $request, $id)
    {
        // Check if the user exists
        // $chkuser = AdminUser::where('uid', $id)->first();
        // if (!$chkuser) {
        //     abort(404, 'Invalid manage user');
        // }

        $user = MasterUser::where('user_id', $id)->first();

        $countyname = MasterCountry::where('country_id', $user->country_id)->value('country_name');
        // dd($country_name);

        $city = MasterLocation::where('location_id', $user->locality_id)->value('location_name');
        // dd($location);

        $memdetails = UpgradeMembership::leftJoin('user_memberships', 'user_memberships.memb_id', '=', 'upgrade_membership.member_type')
            ->where('upgrade_membership.user_id', $user->user_id)
            ->select('user_memberships.*', 'upgrade_membership.*')
            ->orderByDesc('upgrade_membership.upgrade_id')
            ->first();
        // dd($membership);

        $userprofileid = $id;

        // Fetch user details
        $userDetail = MasterUser::where('user_id', $userprofileid)->firstOrFail();

        $title_for_layout = $userDetail->first_name . ' ' . $userDetail->last_name . "'s Profile";

        // Fetch user ratings
        $userRatings = UserRating::where('user_id', $userprofileid)->orderBy('rating_id', 'desc')->get();
        // dd($userRatings);

        // Separate ratings by type
        $raceiveasbuyer = $userRatings->where('rating_type', 2);
        $receivedtheseller = $userRatings->where('rating_type', 1);

        // Grade count queries
        $allpositivegrade = $userRatings->where('grade', 1)->count();
        $allneutralgrade = $userRatings->where('grade', 0)->count();
        $allnegativegrade = $userRatings->where('grade', -1)->count();

        $last6month = now()->subMonths(6);
        $lastyr = now()->subMonths(12);
        $lastmonth = now()->subMonth();

        // Grade count queries for last year
        $lastyrpositivegrade = $userRatings->where('grade', 1)
            ->where('created_at', '>=', $lastyr)
            ->where('created_at', '<=', now())
            ->count();
        $lastyrneutralgrade = $userRatings->where('grade', 0)
            ->where('created_at', '>=', $lastyr)
            ->where('created_at', '<=', now())
            ->count();
        $lastyrnegativegrade = $userRatings->where('grade', -1)
            ->where('created_at', '>=', $lastyr)
            ->where('created_at', '<=', now())
            ->count();

        // Grade count queries for last 6 months
        $last6mthpositivegrade = $userRatings->where('grade', 1)
            ->where('created_at', '>=', $last6month)
            ->where('created_at', '<=', now())
            ->count();
        $last6mthneutralgrade = $userRatings->where('grade', 0)
            ->where('created_at', '>=', $last6month)
            ->where('created_at', '<=', now())
            ->count();
        $last6mthnegativegrade = $userRatings->where('grade', -1)
            ->where('created_at', '>=', $last6month)
            ->where('created_at', '<=', now())
            ->count();

        // Grade count queries for last month
        $lastmthpositivegrade = $userRatings->where('grade', 1)
            ->where('created_at', '>=', $lastmonth)
            ->where('created_at', '<=', now())
            ->count();
        $lastmthneutralgrade = $userRatings->where('grade', 0)
            ->where('created_at', '>=', $lastmonth)
            ->where('created_at', '<=', now())
            ->count();
        $lastmthnegativegrade = $userRatings->where('grade', -1)
            ->where('created_at', '>=', $lastmonth)
            ->where('created_at', '<=', now())
            ->count();

        return view('masterusers.user-rating', compact('user', 'countyname', 'city', 'memdetails', 'userDetail', 'title_for_layout', 'userRatings', 'raceiveasbuyer', 'receivedtheseller', 'allpositivegrade', 'allneutralgrade', 'allnegativegrade', 'lastyrpositivegrade', 'lastyrneutralgrade', 'lastyrnegativegrade', 'last6mthpositivegrade', 'last6mthneutralgrade', 'last6mthnegativegrade', 'lastmthpositivegrade', 'lastmthneutralgrade', 'lastmthnegativegrade'));
    }

    public function exportUsersToCsv()
    {
        $users = MasterUser::with('userType')
            ->orderBy("user_id", "desc")
            ->get();


        // Define the headers for the CSV file
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users.csv"',
        ];

        // Generate CSV data
        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            // Write headers
            fputcsv($file, ['Sl No', 'First Name', 'Last Name', 'Email', 'Telephone', 'User Type', 'Country', 'City', 'Postal Code', 'Is Premium']);

            // Write data
            foreach ($users as $index => $user) {
                $country = MasterCountry::where('country_id', $user->country_id)->first();
                $city = MasterLocation::where('location_id', $user->locality_id)->first();
                // Handle Is Premium
                $isPremium = $user->is_premium ? 'Yes' : 'No';
                fputcsv($file, [
                    $index + 1,
                    $user->first_name,
                    $user->last_name,
                    $user->email,
                    $user->telephone1, // Assuming 'telephone1' is the first phone number field
                    optional($user->userType)->user_type,
                    optional($country)->country_name, // Added optional() to handle cases where country is null
                    optional($city)->location_name, // Fixed a typo in accessing the city
                    $user->postal_code,
                    $isPremium,
                ]);
            }

            fclose($file);
        };

        // Return CSV file as response
        return response()->stream($callback, 200, $headers);
    }
}
