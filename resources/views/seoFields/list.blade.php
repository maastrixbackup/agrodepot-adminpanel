<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage SEO</h1>
        </div>
        <div class="col-2"><a href="{{ route('seofields.create') }}" class="btn btn-primary">Create new</a></div>
    </div>
    <div class="custom-scrollbar">
        <table class="brandsTable table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th scope="col">#SL</th>
                    <th scope="col">Page Name</th>
                    <th scope="col">Meta Title</th>
                    <th scope="col">Meta Description</th>
                    <th scope="col">Meta Keywords</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="brands_sortable">
                @foreach ($data as $index => $menu)
                    <tr id="{{ $menu->seo_id }}">
                        <td scope="row">{{ $index + 1 }}</td>
                        <td scope="row">{{ $menu->page_name }}</td>
                        <td scope="row">{{ $menu->meta_title }}</td>
                        <td scope="row">{{ $menu->meta_desc }}</td>
                        <td scope="row">{{ $menu->meta_keyword }}</td>
                        <td>
                            <div class="d-flex">
                                <div class="customButtonContainer"><a class="edit-btn" title="Edit"
                                        href="{{ url('admin/seofields/' . $menu->seo_id . '/edit') }}"><i
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
        let table = new DataTable('#cmspageslist');
    </script>
</x-app-layout>
