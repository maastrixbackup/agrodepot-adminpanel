<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">Advertisement Detail</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Title
                </td>
                <td>{{ $advertisement_data->title }}</td>
            </tr>
            <tr>
                <td>Ad Type</td>
                <td>
                    @if ($advertisement_data->ad_type == '1')
                        {{ 'Banner' }}
                    @else
                        {{ 'Script' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Banner Title</td>
                <td>{{ $advertisement_data->banner_title }}</td>
            </tr>
            <tr>
                <td>Banner Link</td>
                <td>{{ $advertisement_data->banner_link }}</td>
            </tr>
            <tr>
                <td>Show Position</td>
                <td>
                    @if ($advertisement_data->show_position == 1)
                        {{ 'Top' }}
                    @elseif($advertisement_data->show_position == 2)
                        {{ 'left1' }}
                    @elseif($advertisement_data->show_position == 3)
                        {{ 'left2' }}
                    @elseif($advertisement_data->show_position == 4)
                        {{ 'Middle' }}
                    @else
                        {{ 'Unknown Position' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    @if ($advertisement_data->status == '1')
                        {{ 'Active' }}
                    @else
                        {{ 'Inactive' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Created</td>
                <td>{{ $advertisement_data->created ? date('d-m-Y', strtotime($advertisement_data->created)) : 'NA' }}
                </td>
            </tr>
            <tr>
                <td>Modified</td>
                <td>{{ $advertisement_data->modified ? date('d-m-Y', strtotime($advertisement_data->modified)) : 'NA' }}
                </td>
            </tr>
        </thead>
    </table>
</x-app-layout>
