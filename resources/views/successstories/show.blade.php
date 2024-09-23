<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">Success Story Detail</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>User Name</td>
                <td>{{ optional($successstory_data->user)->first_name }} {{ optional($successstory_data->user)->last_name }}</td>
            </tr>
            <tr>
                <td>Submitted By</td>
                <td>
                    @if ($successstory_data->submit_from == '1')
                        {{ 'Admin' }}
                    @else
                        {{ 'User' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Description</td>
                <td>{!! $successstory_data->content !!}</td>
            </tr>
            <tr>
                <td>Post date</td>
                <td>{{ $successstory_data->created ? date('d-m-Y', strtotime($successstory_data->created)) : 'NA' }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    @if ($successstory_data->status == '1')
                        {{ 'Active' }}
                    @else
                        {{ 'Inactive' }}
                    @endif
                </td>
            </tr>
        </thead>
    </table>
</x-app-layout>
