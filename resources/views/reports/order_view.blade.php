<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">Sale Details</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>User Name</td>
                <td>{{ $data->first_name }} </td>
                  
            </tr>
            <tr>
                <td>Category</td>
                <td>{{ $data->category_name }}</td>
            </tr>
            <tr>
                <td>Sub Category</td>
                <td>{{ optional($data->subCategory)->category_name}}</td>
            </tr>
            <tr>
                <td>Advertisement Name</td>
                <td>{{ $data->adv_name }}</td>
            </tr>
            <tr>
                <td>Advertisement Details</td>
                <td>{{ $data->adv_details }}</td>
            </tr>
            <tr>
                <td>Image</td>
                <td>
                    @foreach($images as $image )
                    <li class="list-group-item image-item"><img src="{{ asset('uploads/postad/' . $image->img_path) }}" style="width:100px; height:100px" alt="Image"></li>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>Brand</td>
                
                <td>{{ $data->brand_name}}</td>
            </tr>
            <tr>
                <td>Model</td>
                <td>{{ $data->SubBrand->brand_name ?? 'no data' }}</td>
            </tr>
            <tr>
                <td>Product Condition</td>
                <td>{{ $data->product_cond}}</td>
            </tr>
            <tr>
                <td>Price</td>
                <td>{{ $data->price}} {{ $data->currency}}</td>
            </tr>
            <tr>
                <td>Quantity</td>
                <td>{{ $data->quantity}}</td>
            </tr>
            <tr>
                <td>Payment Mode</td>
                <td>{{ $data->payment_mode}}</td>
            </tr>
            <tr>
                <td>Delivery Method</td>
                <td>{{ $data->delivery_method}}</td>
            </tr>
            <tr>
                <td>Time Required</td>
                <td>{{ $data->time_required}}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>@if($data->adv_status == 1)
                    Publish
                 @else
                    Unpublish
                 @endif</td>
            </tr>
            <tr>
                <td>Created</td>
                <td>{{ $data->created}}</td>
            </tr>
            <tr>
                <td>Modified</td>
                <td>{{ $data->modified}}</td>
            </tr>
        </thead>
       
    </table>
    

</x-app-layout>
