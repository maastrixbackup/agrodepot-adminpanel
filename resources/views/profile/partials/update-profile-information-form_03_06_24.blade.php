<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div class="col-10 form-group">
            <div>
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name"
                    value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" id="email"
                    value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="">
                <div class="col-lg-6">
                    <button class="btn-one" type="submit">Save</button>
                </div>

                @if (session('status') === 'profile-updated')
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const alertBox = document.createElement('div');
                            alertBox.className = 'alert alert-success alert-dismissible fade show';
                            alertBox.role = 'alert';
                            alertBox.innerText = 'Profile Information Updated Successfully.';
                            
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
