<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Admin User Detail</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Full Name</td>
                <td>{{$admin_user->full_name}}</td>
            </tr>
            <tr>
                <td>Mail Id</td>
                <td>{{$admin_user->mail_id}}</td>
            </tr>
            <tr>
                <td>User Id</td>
                <td>{{$admin_user->user_id}}</td>
            </tr>
            <tr>
                <td>Is Active ?</td>
                <td>{{$admin_user->is_active}}</td>
            </tr>
            <tr>
                <td>Date</td>
                <td>{{$admin_user->created_at}}</td>
            </tr>
        </thead>
       
    </table>
    

</x-app-layout>
