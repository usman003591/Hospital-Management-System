<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" class="form w-100" action="{{ route('login') }}" {{-- id="login-form" --}}>
        @csrf

        <div class="mx-auto mt-5 mb-5 d-flex justify-content-center">
            <img src="assets/media/logos/logo_without_background_1.png" class="rounded d-block app-sidebar-logo-default"
                style="height: 12rem" alt="logo">
        </div>
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="mb-3 text-gray-900 fw-bolder">Hospital Information Managment System</h1>
            <!--end::Title-->
        </div>
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1 bg-transparent form-control" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username" />
        </div>
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <x-text-input id="password" class="block w-full pr-10 mt-1 bg-transparent form-control" type="password"
                    name="password" required autocomplete="current-password" />
                    <i class="bi bi-eye position-absolute top-50 translate-middle-y" id="togglePassword" style="right: 10px; cursor: pointer;"></i>
                {{-- <button type="button" class="absolute inset-y-0 right-0 flex items-center px-3">
                    <i class="bi bi-eye" id="togglePassword"></i>
                </button> --}}
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="text-indigo-600 border-gray-300 rounded shadow-sm dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="text-sm text-gray-600 ms-2 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <div class="flex-wrap gap-3 mb-8 d-flex flex-stack fs-base fw-semibold">
                <div></div>
                <!--begin::Link-->
                <a href="{{ route('password.request') }}" class="link-primary"> {{ __('Forgot your password?') }}</a>
                <!--end::Link-->
            </div>

            <div class="mb-10 d-grid">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                    <!--begin::Indicator label-->
                    <span class="indicator-label"> {{ __('Log in') }}</span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">Please wait...
                        <span class="align-middle spinner-border spinner-border-sm ms-2"></span></span>
                    <!--end::Indicator progress-->
                </button>
            </div>
        </div>
    </form>

    <style>
        .relative {
            position: relative;
        }
        #togglePassword {
            position: absolute;
            top: 53%;
            right: 10px;
            transform: translateY(-50%);
            z-index: 10;
            background: none;
        border: none;
        cursor: pointer;
        }
        /* #togglePassword:focus {
        outline: none;
    } */
    #password {
        padding-right: 2.5rem;
    }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function() {
                // Toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                // Toggle the icon
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');


            });
        });
        </script>
    <!-- JavaScript for Remember Me Functionality -->

</x-guest-layout>
