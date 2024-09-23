<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Credits List</h1>
        </div>
        <div class="col-2"><a href="{{ route('add-credit') }}" class="btn btn-primary">Add Credits</a></div>
    </div>

    <div class="custom-scrollbar">
        <table class="brandsTable table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Credited By</th>
                    <th scope="col">User Email</th>
                    <th scope="col">Credits</th>
                    <th scope="col">Credits Date</th>
                </tr>
            </thead>
            <tbody id="brands_sortable">
                @foreach ($creditsList as $index => $menu)
                    @php
                        $userdetail = App\Models\MasterUser::where('user_id', $menu->user_id)->first();
                    @endphp
                    <tr id="{{ $menu->credit_id }}">
                        <td scope="row">{{ $index + 1 }}</td>
                        <td scope="row">{{ $menu->credits_by == 1 ? 'Admin' : 'User' }}</td>
                        <td scope="row">{{ optional($userdetail)->email }}</td>
                        <td scope="row">{{ $menu->credits }} RON</td>
                        <td scope="row">{{ $menu->created->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>
</x-app-layout>
