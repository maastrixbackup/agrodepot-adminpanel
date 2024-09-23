<x-app-layout>
    <ul class="nav nav-tabs nav-fill mb-3 umaTable" id="ex1" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="ex2-tab-1" data-bs-toggle="tab" href="#ex2-tabs-1" role="tab"
                aria-controls="ex2-tabs-1" aria-selected="true">Our Working Process Section</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex2-tab-2" data-bs-toggle="tab" href="#ex2-tabs-2" role="tab"
                aria-controls="ex2-tabs-2" aria-selected="false">Sale section</a>
        </li>
        {{-- <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex2-tab-3" data-bs-toggle="tab" href="#ex2-tabs-3" role="tab"
                aria-controls="ex2-tabs-3" aria-selected="false">Statistics section</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex2-tab-4" data-bs-toggle="tab" href="#ex2-tabs-4" role="tab"
                aria-controls="ex2-tabs-4" aria-selected="false">Success section</a>
        </li> --}}
    </ul>
    <form action="{{ url('admin/cms-pages/' . $data->title) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="tab-content" id="ex2-content">

            <div class="tab-pane fade show active" id="ex2-tabs-1" role="tabpanel" aria-labelledby="ex2-tab-1">
                @include('cmsPages.Homepage.working-process')
            </div>
            <div class="tab-pane fade" id="ex2-tabs-2" role="tabpanel" aria-labelledby="ex2-tab-2">
                @include('cmsPages.Homepage.saleSection')
            </div>
            {{-- <div class="tab-pane fade" id="ex2-tabs-3" role="tabpanel" aria-labelledby="ex2-tab-3">
                @include('cmsPages.Homepage.statisticsSection')
            </div>
            <div class="tab-pane fade" id="ex2-tabs-4" role="tabpanel" aria-labelledby="ex2-tab-4">
                @include('cmsPages.Homepage.sucessSection')
            </div> --}}
        </div>
        <button class="btn btn-primary customSaveButton" type="submit">Save</button>
    </form>
    <script>
        CKEDITOR.replace('bannerTitle1', {
            allowedContent: true,
            extraPlugins: 'colorbutton'
        });
        CKEDITOR.replace('bannerTitle2', {
            allowedContent: true,
            extraPlugins: 'colorbutton'
        });
        CKEDITOR.replace('statisticsTitle1', {
            allowedContent: true,
            extraPlugins: 'colorbutton'
        });
    </script>

</x-app-layout>
