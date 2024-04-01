<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.header')

<!-- Page Body Start-->
<div class="page-body-wrapper">

    @include('layouts.sidebar')
    <div class="page-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        {{ $slot }}
    </div>
    @include('layouts.footer')


    <script>
        $(document).ready(function() {

            var table = $('#latest-members').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('dashboard.latest-members')}}",
                columns: [{
                        data: 'profile_img'
                    },
                    {
                        data: 'user_id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'join_date'
                    }
                ]
            });


            var table = $('#latest-orders').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('dashboard.latest-orders')}}",
                columns: [{
                        data: 'orderid'
                    },
                    {
                        data: 'adv_name'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'created'
                    }
                ]
            });


            var table = $('#latest-parts-orders').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('dashboard.latest-part-orders')}}",
                columns: [{
                        data: 'orderid'
                    },
                    {
                        data: 'name_piece'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'created'
                    }
                ]
            });



            
        });
    </script>
    </body>

</html>
