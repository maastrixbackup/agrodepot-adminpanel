<x-app-layout>
    <div class="row">
        <style>
            .image-item {
                margin-right: 10px;
            }
        </style>
        <div class="col-10">
            <h1 class="text-center mb-3">Request Parts Detail</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Item Title</td>
                <td>{{ $data->name_piece }}</td>

            </tr>
            <tr>
                <td>About the song</td>
                <td>{{ $data->description }}</td>
            </tr>
            <tr>
                <td>Brand car</td>
                <td>{{ $data->brand_name }}</td>
            </tr>
            <tr>
                <td>Model</td>
                <td>{{ optional($data->parent)->brand_name }}</td>
            </tr>
            <tr>
                <td>Version </td>
                <td>{{ $data->version }}</td>
            </tr>
            <tr>
                <td>Year</td>
                <td>{{ $data->yr_of_manufacture }}</td>
            </tr>
            <tr>
                <td>Engines</td>
                <td>{{ $data->engines }}</td>
            </tr>
            <tr>
                <td>Series Chassis</td>
                <td>{{ $data->vehicle_identy_no }}</td>
            </tr>
            <tr>
                <td>Want song</td>
                <td>{{ $data->want_song }}</td>
            </tr>
            <tr>
                <td>County</td>
                <td>{{ $data->county }}</td>
            </tr>

            <tr>
                <td>Location</td>
                <td>{{ $data->city }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <ul class="nav nav-pills">
                        @foreach ($images as $image)
                            <li class="list-group-item image-item"><img
                                    src="{{ asset('uploads/requestpart/' . $image->img_path) }}"
                                    style="width:100px; height:100px" alt="Image"></li>
                        @endforeach
                    </ul>
                </td>
            </tr>
        </thead>

    </table>


</x-app-layout>
