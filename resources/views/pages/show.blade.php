<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Admin Page</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Page Name</td>
                <td>{{ $adminpage->page_name }}</td>
            </tr>
            <tr>
                <td>Page Title </td>
                <td>{{ $adminpage->page_title }}</td>
            </tr>
            <tr>
                <td>Meta Title</td>
                <td>{{ $adminpage->meta_title }}</td>
            </tr>
            <tr>
                <td>Meta Desc</td>
                <td>{{ $adminpage->meta_desc }}</td>
            </tr>
            <tr>
                <td>Meta Keywords</td>
                <td>{{ $adminpage->meta_keywords }}</td>
            </tr>
            <tr>
                <td>Is Active ?</td>
                <td>
                    @if ($adminpage->is_active == '1')
                        {{ 'Active' }}
                    @else
                        {{ 'Inactive' }}
                    @endif
                </td>
            </tr>
        </thead>

    </table>


</x-app-layout>
