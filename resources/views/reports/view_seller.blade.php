<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">View Question Image</h1>
        </div>
    </div>
    {{ $image
        ? '<img src="' + asset('uploads/bidimg/' + $image->img_path) + '" alt="Image ' + $image->img_id + '">'
        : 'Image not available' }}

    <div>

    </div>
</x-app-layout>
