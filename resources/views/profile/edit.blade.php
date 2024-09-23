<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <div class="col-lg-4">
        <div class="card" style="background-color: rgb(250 189 169 / 0%);box-shadow: 0 .3rem .8rem rgb(113 118 109);margin-bottom: 1.5rem;border: 0 solid transparent;left: 100%;border-top: 10px solid #79c042;border-radius: 25px 0;">
            <div class="card-body">
                @include('profile.partials.update-profile-image-form')
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="row max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-5">
            <div class="col-lg-6">
                <div class="max-w-xl p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg h-100">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <div class="col-lg-6">
                <div class="max-w-xl p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg h-100">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
