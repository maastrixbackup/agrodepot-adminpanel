
<x-app-layout>
    <div class="row">
        <div class="col-10">
            <h1 class="text-center mb-3">View Question Image</h1>
        </div>
    </div>
    <div>
        <img src="{{ asset('uploads/salesquestion/' . $image->img_file) }}" alt="Image {{ $image->id }}">
    </div>   
</x-app-layout>
