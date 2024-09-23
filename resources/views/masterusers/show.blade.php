<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">User Detail</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Name</td>
                <td>{{ $masteruser_data->first_name . ' ' . $masteruser_data->last_name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $masteruser_data->email }}</td>
            </tr>
            <tr>
                <td>Telephone 1</td>
                <td>{{ $masteruser_data->telephone1 }}</td>
            </tr>
            <tr>
                <td>Telephone 2</td>
                <td>{{ $masteruser_data->telephone2 }}</td>
            </tr>
            <tr>
                <td>Telephone 3</td>
                <td>{{ $masteruser_data->telephone3 }}</td>
            </tr>
            <tr>
                <td>Telephone 4</td>
                <td>{{ $masteruser_data->telephone4 }}</td>
            </tr>
            <tr>
                <td>County</td>
                <td>{{ $country ? $country->country_name : 'N/A' }}</td>
            </tr>
            <tr>
                <td>Locality</td>
                <td>{{ $location ? $location->location_name : 'N/A' }}</td>
            </tr>
            <tr>
                <td>Postal Code</td>
                <td>{{ $masteruser_data->postal_code }}</td>
            </tr>
            <tr>
                <td>Other Add</td>
                <td>{{ $masteruser_data->other_add }}</td>
            </tr>
            <tr>
                <td>User Type</td>
                <td>{{ $u_type ? $u_type->user_type : 'N/A' }}</td>
            </tr>
            <tr>
                <td>Promotion ads total credits</td>
                <td>
                    @if ($userTotalCredit !== null)
                        {{ $userTotalCredit->credits . ' RON' }}
                    @else
                        {{ '0 RON' }}
                    @endif
                </td>
            </tr>

            <tr>
                <td>Status</td>
                <td>
                    @if ($masteruser_data->status == '1')
                        {{ 'Active' }}
                    @else
                        {{ 'Inactive' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Last Login</td>
                <td>
                    @if ($masteruser_data->last_login)
                        {{ date('d-m-Y', strtotime($masteruser_data->last_login)) }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Reg Date</td>
                <td>{{ $masteruser_data->created ? date('d-m-Y', strtotime($masteruser_data->created)) : 'NA' }}</td>
            </tr>
            <tr>
                <td>Modified</td>
                <td>{{ $masteruser_data->modified ? date('d-m-Y', strtotime($masteruser_data->modified)) : 'NA' }}</td>
            </tr>
        </thead>
    </table>
</x-app-layout>
