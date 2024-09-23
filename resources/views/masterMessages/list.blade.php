<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Success Messages
            </h1>
        </div>
        <div class="col-2"><a href="{{ route('messages.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <div class="custom-scrollbar">
        <table class="brandsTable table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">#SL</th>
                    <th scope="col">Message Name</th>
                    <th scope="col">Message</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="brands_sortable">
                @foreach ($data as $index => $menu)
                    <tr id="{{ $menu->msg_id }}">
                        <td scope="row">{{ $index + 1 }}</td>
                        <td scope="row">{{ $menu->msg_name }}</td>
                        <td scope="row">{{ $menu->msg }}</td>
                        <td>
                            <div class="d-flex">
                                <div class="customButtonContainer"><a class="edit-btn" title="Edit"
                                        href="{{ url('admin/messages/' . $menu->msg_id . '/edit') }}"><i
                                            class="fas fa-edit"></i></a>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $('#cmspageslist').dataTable({
            // "bPaginate": false
        });
    </script>
</x-app-layout>
