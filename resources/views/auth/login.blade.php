<x-guest-layout>
    <style>
        .eyeIcon{
            cursor: pointer;
        }
    </style>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="loginForm" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="admin-email">
            <x-input-label for="email" :value="__('Email')" />
            <div class="add-icon">
                <x-text-input id="email" class="block mt-1 w-full control" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" placeholder="Enter email" />
                <div class="env">
                    <i class="far fa-envelope"></i>
                </div>

            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="add-icon">
                <x-text-input id="password" class="block mt-1 w-full control pwField" type="password" name="password"
                    required autocomplete="current-password" placeholder="Enter password" />
                <div class="view">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="hide">
                    <i class="fas fa-eye-slash eyeIcon"></i>
                </div>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        {{-- <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div> --}}

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
            <span class="forgot-pass"><a href="{{ route('password.request') }}">Forgot Your Password?</a></span>
            @endif
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
    <script>
        const element = document.querySelector(".pwField");
        const eyeIcon = document.querySelector(".loginForm .eyeIcon");
        eyeIcon.addEventListener("click", (e) => {
            if (element.type === "password") {
                element.type = "text";
                eyeIcon.className = "fa-solid fa-eye eyeIcon";
            } else {
                element.type = "password";
                eyeIcon.className = "fa fa-eye-slash eyeIcon";
            }
        });
    </script>
</x-guest-layout>
