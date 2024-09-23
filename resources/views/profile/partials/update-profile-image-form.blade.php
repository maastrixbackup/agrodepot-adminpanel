<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile-image.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="d-flex flex-column align-items-center text-center position-relative">
            <div class="profile-image-wrapper position-relative">
                <img id="profileImage"
                    src="{{ $user->prof_img ? asset('/uploads/adminprofile/' . $user->prof_img) : 'https://warehousenetworks.maastrixdemo.com/images/avatar-2.png' }}"
                    alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                <div class="edit-icon position-absolute" style="top: 10px; right: 10px; cursor: pointer;">
                    <i class="fa fa-pencil-alt"></i>
                </div>
            </div>
            <input type="file" name="image" class="form-control-file d-none" id="profileImageInput"
                accept="image/*">
            <div class="mt-3">
                <h4>{{ $user->name }}</h4>
                <p class="mb-1">{{ $user->email }}</p>
            </div>
        </div>
        <div class="col-10 form-group">
            <div class="col-lg-6">
                <button class="btn-one" type="submit">Save</button>
            </div>

            @if (session('status') === 'profile-image-updated')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const alertBox = document.createElement('div');
                        alertBox.className = 'alert alert-success alert-dismissible fade show';
                        alertBox.role = 'alert';
                        alertBox.innerText = 'Profile Image Updated Successfully.';

                        document.querySelector('.page-body').prepend(alertBox);

                        setTimeout(function() {
                            alertBox.classList.remove('show');
                        }, 5000);
                    });
                </script>
            @endif
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editIcon = document.querySelector('.edit-icon');
        const profileImageInput = document.querySelector('#profileImageInput');
        const profileImage = document.querySelector('#profileImage');

        editIcon.addEventListener('click', function() {
            profileImageInput.click();
        });

        profileImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImage.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>

<style>
    .profile-image-wrapper {
        position: relative;
        display: inline-block;
    }

    .edit-icon {
        font-size: 12px;
        background-color: white;
        border-radius: 50%;
        padding: 5px;
        color: black;
        border: 1px solid gray;
        position: absolute;
        top: 5px;
        right: 5px;
    }

    .edit-icon:hover {
        background-color: #f0f0f0;
    }
</style>
