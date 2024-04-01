<x-app-layout>
    <div class="row">
        <style>
            .image-item {
                margin-right: 10px;
            }
        </style>

<div class="col-2"><a href="{{ route('bidoffer.index') }}" class="btn btn-primary">Manage Bid Offer</a></div>
        <div class="col-10">
            <h1 class="text-center mb-3">Bid Offer Detail</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Posted By</td>
                <td>{{ optional($data)->first_name }} {{ optional($data)->last_name }}</td>


            </tr>
            <tr>
                <td>Brand</td>
                <td>{{optional($data)->brand_name}}</td>
            </tr>
            <tr>
                <td>Model</td>
                <td>{{optional($data)->model_name}}</td>
            </tr>
            <tr>
                <td>Version</td>
                <td>{{optional($data)->version}}</td>
            </tr>
            <tr>
                <td>Year Of manufacture</td>
                <td>{{optional($data)->manufature}}</td>
            </tr>
            <tr>
                <td>Engines</td>
                <td>{{optional($data)->engine}}</td>
            </tr>
            <tr>
                <td>Vehicle Identification Number</td>
                <td>{{optional($data)->vehicle}}</td>
            </tr>
            <tr>
                <td>I offer parts</td>
                <td>{{optional($data)->i_offer_parts}}</td>
            </tr>
            <tr>
                <td>County</td>
                <td>{{optional($data)->county}}</td>
            </tr>
            <tr>
                <td>City</td>
                <td>{{optional($data)->city}}</td>
            </tr>

            <tr>
                <td>Name piece</td>
                <td>{{optional($data)->name_piece}}</td>
            </tr>
            <tr>
                <td>Description</td>
                <td>{{optional($data)->description}}</td>
            </tr>
            <tr>
                <td>Part No	</td>
                <td>{{optional($data)->part_no}}</td>
            </tr>
            <tr>
                <td>Maximum price</td>
                <td>{{optional($data)->max_price}} {{optional($data)->currency}}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                @if(optional($data)->status == 0)
                    Inactive
                @elseif(optional($data)->status == 1)
                    Active
                @elseif(optional($data)->status == 2)
                    Resolved
                @endif
                </td>
            </tr>
            <tr>
                <td>Total offer</td>
                <td>{{optional($data)->offerno}}</td>
            </tr>
            <tr>
                <td>Request Date</td>
                <td>{{optional($data)->modified}}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <ul class="nav nav-pills">
                        @foreach($images as $image )
                        <li class="list-group-item image-item"><img src="{{ asset('uploads/requestpart/' . $image->img_path) }}" style="width:100px; height:100px" alt="Image"></li>
                        @endforeach
                    </ul>
                    </td>
            </tr>
        </thead>

    </table>


</x-app-layout>
