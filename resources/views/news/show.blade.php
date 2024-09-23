<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">News Detail</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Title</td>
                <td>{{ $news_data->news_title }}</td>
            </tr>
            <tr>
                <td>Description</td>
                <td>{!! $news_data->news_content !!}</td>
            </tr>
            <tr>
                <td>Image</td>
                <td>
                    @if ($news_data->news_img)
                        @php
                            $logopath = asset('/uploads/news/' . $news_data->news_img);
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
                <td>Post date</td>
                <td>{{ $news_data->created ? date('d-m-Y', strtotime($news_data->created)) : 'NA' }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    @if ($news_data->status == '1')
                        {{ 'Active' }}
                    @else
                        {{ 'Inactive' }}
                    @endif
                </td>
            </tr>
        </thead>
    </table>
</x-app-layout>
