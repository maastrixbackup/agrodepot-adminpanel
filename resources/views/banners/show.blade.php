<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">Banner Detail</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Banner Title
                </td>
                <td>{{ $banner->banner_title }}</td>
            </tr>
            <tr>
                <td>Banner Caption</td>
                <td>{!! $banner->banner_caption !!}</td>
            </tr>
            <tr>
                <td>Banner Img</td>
                <td>
                    @if ($banner->banner_img)
                        @php
                            $logopath = asset('/uploads/banner/' . $banner->banner_img);
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
                <td>Created</td>
                <td>{{ $banner->created ? date('d-m-Y', strtotime($banner->created)) : 'NA' }}</td>
            </tr>
        </thead>
    </table>
</x-app-layout>
