<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">View Question Image</h1>
        </div>
    </div>
    <div class="img-bx">
        @if ($image)
            <div class="img-item">
                <img src="{{ asset('uploads/bidimg/' . $image->img_path) }}" alt="Image {{ $image->img_id }}">
            </div>
        @else
            <p>Image not available</p>
        @endif
    </div>
</x-app-layout>
