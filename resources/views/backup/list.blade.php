<x-app-layout>
    <div class="row">

        <div class="col-10">
            <h1 class="text-center mb-3">Manage Backup Files</h1>
        </div>
        <div class="col-2">
            {{-- <a href="{{ route('categories.create') }}" class="btn btn-primary">Create new</a> --}}
            <button class="btn btn-primary mb-3" onclick="createBackup()" id="backupDB">Create Backup</button>
        </div>
    </div>
    <div class="custom-scrollbar">
        <table class="table table-hover" id="cmspageslist">
            <thead>
                <tr>
                    <th>SL#</th>
                    <th>File Name</th>
                    <th>Backup Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($backupDbs as $backupDb)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a href="{{ asset('uploads/backup_db/' . $backupDb->backup_file) }}"
                                download>{{ $backupDb->backup_file }}</a></td>
                        </td>
                        <td>{{ $backupDb->created }}</td>
                        <td>
                            <img src="{{ asset('images/ajax-loader.gif') }}" alt=""
                                style="margin-right:5px; width:20px; display:none" id="showloader" />
                            <button class="btn btn-info" onclick="restoreBackup('{{ $backupDb->backup_file }}')"
                                id="restore">Restore</button>
                            <button class="btn btn-danger"
                                onclick="deleteBackup('{{ $backupDb->backup_id }}')">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No backup files found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script>
        function createBackup() {
            $("#backupDB").html("Processing...");
            $.ajax({
                type: 'POST',
                url: '{{ route('backup.create') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $("#backupDB").html("Create Backup");
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    $("#backupDB").html("Create Backup");
                    alert('An error occurred while creating backup.');
                }
            });
        }

        function restoreBackup(filename) {
            $("#showloader").show();
            $("#restore").html("Processing...");
            $.ajax({
                type: 'POST',
                url: '{{ route('backup.restore') }}',
                data: {
                    filename: filename,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#showloader").hide();
                    $("#restore").html("Restore");
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    $("#showloader").hide();
                    $("#restore").html("Restore");
                    alert('An error occurred while restoring backup.');
                }
            });
        }

        function deleteBackup(id) {
            if (confirm('Are you sure you want to delete this backup?')) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('backup.delete') }}',
                    data: {
                        backup_id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while deleting backup.');
                    }
                });
            }
        }
    </script>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>

</x-app-layout>
