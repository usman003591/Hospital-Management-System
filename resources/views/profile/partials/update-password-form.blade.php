<section>
    <header>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure that your password is strong and secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="mb-6 row">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6" :value="__('Current Password')">Current Password</label>
            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                 <input type="password" name="current_password" class="form-control form-control-lg form-control-solid" placeholder="Enter current password">
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>
        </div>
        <br>
        <div class="mb-6 row">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6" for="update_password_password"  :value="__('New Password')">New Password</label>
            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                 <input type="password" name="password" id="update_password_password"  class="form-control form-control-lg form-control-solid" placeholder="Enter new password">
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>
        </div>
        <br>
        <div class="mb-6 row">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6" for="update_password_password_confirmation"  :value="__('Confirm Password')">Confirm Password</label>
            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                 <input type="password" name="password_confirmation" id="update_password_password_confirmation"  class="form-control form-control-lg form-control-solid" placeholder="Confirm new password">
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>
        <br>

        <!--begin::Actions-->
        <div class="py-6 card-footer d-flex justify-content-end px-9">
        <button type="reset" class="btn btn-sm btn-secondary me-2">Discard</button>
        <x-primary-button type="submit" class="btn btn-sm btn-primary">   @if (session('status') === 'password-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600"
            >{{ __('Saved.') }}</p> @else {{ __('Save') }}
            @endif
        </x-primary-button>

    </div>


    </form>
</section>
