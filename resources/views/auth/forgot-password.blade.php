<x-guest-layout>
    <div class="mx-auto mt-5 mb-20 d-flex justify-content-center">
        <img src="{{ asset('assets/media/logos/logo_without_background_1.png') }}"
            class="rounded d-block app-sidebar-logo-default" style="height: 12rem" alt="logo">
    </div>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password
        reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" class="form w-100" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label class="mt-10" for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full form-control bg-transparent" type="email" name="email"
                :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="d-grid mt-10">
            <x-primary-button class="btn btn-primary">
                <span class="indicator-label">{{ __('Email Password Reset Link') }}</span>

            </x-primary-button>
        </div>
    </form>
</x-guest-layout>