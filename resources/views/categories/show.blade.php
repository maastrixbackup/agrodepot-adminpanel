<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">Category Detail</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Category Name</td>
                <td>{{ $category->category_name }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    @if ($category->status == '1')
                        {{ 'Active' }}
                    @else
                        {{ 'Inactive' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Created</td>
                <td>{{ $category->created ? date('d-m-Y', strtotime($category->created)) : 'NA' }}</td>
            </tr>
        </thead>
    </table>
</x-app-layout>
