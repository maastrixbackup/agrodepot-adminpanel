<x-app-layout>
    <div class="row">
        <style>
            .image-item {
                margin-right: 10px;
            }
        </style>
        <div class="col-10">
            <h1 class="text-center mb-3">Bid Offer Details</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Bid By</td>
                <td>{{ $data->first_name }} {{ $data->last_name }}</td>
                  
            </tr>
            <tr>
                <td>Name of the piece</td>
                <td>{{ $data->piece }}</td>
            </tr>
            <tr>
                <td>Against</td>
                <td>{{ $data->price}} {{ $data->currency}}</td>
            </tr>
            <tr>
                <td>Delivery</td>
                <td>
                @php
                    $delivery = [];
                @endphp
                
                @if ($data->personal_teaching == 1)
                    @php $delivery[] = 'Personal Teaching'; @endphp
                @endif
                
                @if ($data->courier == 1 || $data->free_courier == 1)
                    @if ($data->free_courier == 1 && $data->courier == 0)
                        @php $delivery[] = 'Free delivery by courier'; @endphp
                    @endif
                    @if ($data->free_courier == 0 && $data->courier == 1)
                        @php $delivery[] = 'Courier(' . $data->courier_cost . ')'; @endphp
                    @endif
                @endif
                
                @if ($data->roman_mail == 1 || $data->free_roman_mail == 1)
                    @if ($data->free_roman_mail == 1 && $data->roman_mail == 0)
                        @php $delivery[] = 'Free delivery by Romanian mail'; @endphp
                    @endif
                    @if ($data->free_roman_mail == 0 && $data->roman_mail == 1)
                        @php $delivery[] = 'Romanian Mail(' . $data->roman_mail_cost . ')'; @endphp
                    @endif
                @endif
                
                @if (!empty($delivery))
                    {{ implode(", ", $delivery) }}
                @endif
            </td>
            </tr>
            <tr>
                <td>The payment</td>
                <td>{{ $data->payment_method}}</td>
            </tr>
            <tr>
                <td>Guarantee</td>
                <td>{{ $data->warranty}}</td>
            </tr>
            <tr>
                <td>Validity</td>
                <td>{{ $data->validity}}</td>
            </tr>
            <tr>
                <td>You want the song</td>
                <td>{{ $data->offers}}</td>
            </tr>
            <tr>
                <td>Bid Date</td>
                <td>{{ $data->created}}</td>
            </tr>
        </thead>
       
    </table>
    

</x-app-layout>
