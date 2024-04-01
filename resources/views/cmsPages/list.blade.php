<x-app-layout>
    <div class="row">

        <div class="col-10"><h1 class="text-center mb-3">Cms Pages</h1></div>
        <div class="col-2" style="text-align:right;"><button class="btn btn-primary">Create new</button></div>
    </div>
    <table class="table table-hover" id="cmspageslist">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Page Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($menus as $index => $menu)
                <tr>
                    <td scope="row">{{ $index + 1 }}</td>
                    <td class="text-capitalize">{{ $menu->title }}</td>
                    <td><a href="{{ url('/dashboard/cms-pages/'.$menu->title.'/edit') }}" class="edit-btn"><i class="fas fa-edit"></i></a> </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>
</x-app-layout>
