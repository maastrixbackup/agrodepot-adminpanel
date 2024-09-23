<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">Social Icon Details</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Social Name</td>
                <td>{{ $socialicon_data->social_name }}</td>
            </tr>
            <tr>
                <td>Social Image</td>
                <td>
                    @if ($socialicon_data->social_img)
                        @php
                            $logopath = asset('/uploads/socialicon/' . $socialicon_data->social_img);
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
                <td>Social Link</td>
                <td>{{ optional($socialicon_data->parent)->social_link }}</td>
            </tr>
            <tr>
                <td>Order No</td>
                <td>{{ $socialicon_data ? $socialicon_data->orderno : 'NA' }}</td>
            </tr>
            <tr>
                <td>Created</td>
                <td>{{ $socialicon_data->created ? date('d-m-Y', strtotime($socialicon_data->created)) : 'NA' }}</td>
            </tr>
        </thead>
    </table>
</x-app-layout>
