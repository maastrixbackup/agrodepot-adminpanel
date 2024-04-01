<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Languages</h1>
        </div>
        <div class="col-2"><a href="{{ route('admin-langs.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <table class="table table-hover" id="cmspageslist">
        <thead>
            <tr>
                <th scope="col">SL#</th>
                <th scope="col">English Label</th>
                <th scope="col">Romanian Label</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $menu)
            <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td class="text-capitalize">{!! $menu->en_label !!}</td>
                <td class="text-capitalize">{!! $menu->roman_label !!}</td>
                <td>
                    <div class="customButtonContainer"><a class="mx-2" href="{{ url('admin/admin-langs/' . $menu->lid . '/edit') }}"><i class="fas fa-edit"></i></a>
                    </div>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>

</x-app-layout>