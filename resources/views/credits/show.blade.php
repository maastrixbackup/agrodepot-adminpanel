<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Admin</h1>
        </div>
    </div>
    <table class="table table-hover" id="cmspageslist">
        <thead>
            <tr>
                <th scope="col">SL#</th>
                <th scope="col">Credited By</th>
                <th scope="col">Credits</th>
                <th scope="col">Credits Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $menu)


                <tr>
                    <th scope="row">{{ (int)$index + 1 }}</th>
                    <td class="text-capitalize">@if($menu->credits_by == 1)
                        Admin
                     @else
                         User
                     @endif</td>

                    <td class="text-capitalize">{!! $menu->credits !!}</td>
                    <td class="text-capitalize">{!! $menu->created !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>

</x-app-layout>
