<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">View Question Image</h1>
        </div>
    </div>
    <div class="img-bx">
        @foreach ($images as $img)
            <div class="img-item"> <img src="{{ asset('uploads/parkimg/' . $img->img_path) }}" alt="Image" width="100px"
                    height="100px"></div>
        @endforeach
    </div>
</x-app-layout>
