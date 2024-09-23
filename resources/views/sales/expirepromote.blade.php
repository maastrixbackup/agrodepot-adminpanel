<x-app-layout>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('delete-expirepromote') }}" class="row" enctype="multipart/form-data">
            @csrf
            <div class="col-10 form-group">
                <h3>
                    Deactivated all expire promoted ad
                </h3>
            <button class="btn btn-primary" style="margin-top: 15px;" type="submit">Deactivated all expire promoted ad</button>

            </div>
        </form>

    </div>

</x-app-layout>
