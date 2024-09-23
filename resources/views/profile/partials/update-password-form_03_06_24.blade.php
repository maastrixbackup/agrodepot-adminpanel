<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('admin-password-update') }}" class="mt-6 space-y-6">
        @csrf

        <div class="col-10 form-group">
            <div>
                <label for="update_password_current_password">Current Password</label>
                <input type="password" name="current_password" class="form-control" id="update_password_current_password"
                    autocomplete="current-password">
                @error('current_password', 'updatePassword')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="update_password_password">New Password</label>
                <input type="password" name="password" class="form-control" id="update_password_password"
                    autocomplete="new-password">
                @error('password', 'updatePassword')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="update_password_password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control"
                    id="update_password_password_confirmation" autocomplete="new-password">
                @error('password_confirmation', 'updatePassword')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <div class="col-lg-6">
                    <button class="btn-one" type="submit">Save</button>
                </div>

                @if (session('status') === 'password-updated')
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const alertBox = document.createElement('div');
                            alertBox.className = 'alert alert-success alert-dismissible fade show';
                            alertBox.role = 'alert';
                            alertBox.innerText = 'Password Changed Successfully.';

                            document.querySelector('.page-body').prepend(alertBox);

                            setTimeout(function() {
                                alertBox.classList.remove('show');
                            }, 5000);
                        });
                    </script>
                @endif
            </div>
        </div>
    </form>
</section>
