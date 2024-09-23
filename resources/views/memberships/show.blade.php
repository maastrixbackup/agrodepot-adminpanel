<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">User Membership Detail</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Membership Type
                </td>
                <td>{{ $usermembership->memb_type }}</td>
            </tr>
            <tr>
                <td>Price</td>
                <td>{{ number_format($usermembership->price, 2) }}</td>
            </tr>
            <tr>
                <td>Credits</td>
                <td>{{ $usermembership->credits }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    @if ($usermembership->status == '1')
                        {{ 'Active' }}
                    @else
                        {{ 'Inactive' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Created</td>
                <td>{{ $usermembership->created ? date('d-m-Y', strtotime($usermembership->created)) : 'NA' }}</td>
            </tr>
            <tr>
                <td>Modified</td>
                <td>{{ $usermembership->modified ? date('d-m-Y', strtotime($usermembership->modified)) : 'NA' }}</td>
            </tr>
        </thead>
    </table>
</x-app-layout>
