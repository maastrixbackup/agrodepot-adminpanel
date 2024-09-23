<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">Manage Sale Detail</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>User Name</td>
                <td>{{ $users->first_name }}</td>
            </tr>
            <tr>
                <td>Category</td>
                <td>{{ $category->category_name }}</td>
            </tr>
            <tr>
                <td>Sub Category</td>
                <td>{{ $sub_category->category_name }}</td>
            </tr>
            <tr>
                <td>Advertisement Name</td>
                <td>{{ $sales_data->adv_name }}</td>
            </tr>
            <tr>
                <td>Advertisement Details</td>
                <td>{!! $sales_data->adv_details !!}</td>
            </tr>
            <tr>
                <td>Image</td>
                <td>
                    @if ($post_images->isNotEmpty())
                        @foreach ($post_images as $post_image)
                            @php
                                $logopath = asset('uploads/postad/' . $post_image->img_path);
                            @endphp
                            <img src="{{ $logopath }}" alt="" style="height: 100px; width: 100px;">
                        @endforeach
                    @else
                        @php
                            $logopath = asset('/uploads/no-image.jpg');
                        @endphp
                        <img src="{{ $logopath }}" alt="" style="height: 100px; width: 100px;">
                    @endif
                </td>
            </tr>

            <tr>
                <td>Brand</td>
                <td>{{ $brand ? $brand->brand_name : 'N/A' }}</td>
            </tr>
            <tr>
                <td>Model</td>
                <td>{{ $model ? $model->brand_name : 'N/A' }}</td>
            </tr>
            <tr>
                <td>Product Condition</td>
                <td>{{ $sales_data->product_cond }}</td>
            </tr>
            <tr>
                <td>Price</td>
                <td>{{ $sales_data->price . ' ' . $sales_data->currency }}</td>
            </tr>
            <tr>
                <td>Quantity</td>
                <td>{{ $sales_data->quantity }}</td>
            </tr>
            <tr>
                <td>Payment Mode</td>
                <td>{{ $sales_data->payment_mode }}</td>
            </tr>
            <tr>
                <td>Delivery Method</td>
                <td>
                    @php
                        $dm = '';
                        if ($sales_data->personal_teaching) {
                            $dm .= __('Personal Teaching') . ', ';
                        }
                        if ($sales_data->courier) {
                            if ($sales_data->free_courier == 1) {
                                $dm .= __('Courier (Free)') . ', ';
                            } else {
                                $dm .= __('Courier (:cost RON)', ['cost' => $sales_data->courier_cost]) . ', ';
                            }
                        }
                        if ($sales_data->romanian_mail) {
                            if ($sales_data->free_romanian_mail == 1) {
                                $dm .= __('Romanian Mail (Free)');
                            } else {
                                $dm .= __('Romanian Mail (:cost RON)', ['cost' => $sales_data->romanian_mail_cost]);
                            }
                        }
                        echo rtrim($dm, ', ');
                    @endphp
                </td>
            </tr>
            <tr>
                <td>Time Required</td>
                <td>{{ $sales_data->time_required . ' Day' }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    @if ($sales_data->status == '1')
                        {{ 'Publish' }}
                    @else
                        {{ 'Unpublish' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Created</td>
                <td>{{ $sales_data->created ? date('d-m-Y', strtotime($sales_data->created)) : 'NA' }}</td>
            </tr>
            <tr>
                <td>Modified</td>
                <td>{{ $sales_data->modified ? date('d-m-Y', strtotime($sales_data->modified)) : 'NA' }}</td>
            </tr>
        </thead>
    </table>
</x-app-layout>
