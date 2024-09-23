<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">Brand Detail</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Brand Name</td>
                <td>{{ $brands->brand_name }}</td>
            </tr>
            <tr>
                <td>Brand Logo</td>
                <td>
                    @if ($brands->image)
                        @php
                            $logopath = asset('/uploads/brand/' . $brands->image);
                        @endphp
                        <img src="{{ $logopath }}" alt="" style="height: 100px; width: 100px;">
                    @else
                        @php
                            $logopath = asset('/uploads/no-image.jpg');
                        @endphp
                        <img src="{{ $logopath }}" alt="" style="height: 100px; width: 100px;">
                    @endif
                </td>
            </tr>
            <tr>
                <td>Parent</td>
                <td>{{ optional($brands->parent)->brand_name }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    @if ($brands->status == '1')
                        {{ 'Active' }}
                    @else
                        {{ 'Inactive' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Created</td>
                <td>{{ $brands->created ? date('d-m-Y', strtotime($brands->created)) : 'NA' }}</td>
            </tr>
            <tr>
                <td>Modified</td>
                <td>{{ $brands->modified ? date('d-m-Y', strtotime($brands->modified)) : 'NA' }}</td>
            </tr>
        </thead>
    </table>
</x-app-layout>
