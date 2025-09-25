<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    <!--begin::Sidebar-->
    <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
        data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
        <!--begin::Logo-->
        <div class="app-sidebar-logo" id="kt_app_sidebar_logo">
            <!--begin::Logo image-->
            {{-- <a href="{{route('dashboard')}}">
                <img alt="Logo" src="{{ asset('storage/'.session('logo')) }}" class="h-25px app-sidebar-logo-default" />
                <img alt="Logo" src="{{ asset('storage/'.session('logo')) }}"
                    class="h-20px app-sidebar-logo-minimize" />
                {{ session('web_name') }} --}}
                {{-- Dynamic CMS --}}
                {{-- </a> --}}
            <!--end::Logo image-->
            <!--begin::Sidebar toggle-->
            <!--begin::Minimized sidebar setup:
if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") {
1. "src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state.
2. Set data-kt-app-sidebar-minimize="on" attribute for body tag.
3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id.
4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id.
}
-->
            @php
            $doctorPanelValue = checkDoctorPanelVal();
            @endphp

            @php
            $redirect_value = getDashboardLinkByRole();
            @endphp

           <div class="mx-auto mt-1 d-flex justify-content-center align-items-center">
                <a href="{{$redirect_value}}"><img src="{{ asset('src/media/logos/logo_without_background_1.png') }}"
                        class="w-auto h-70px" alt="logo"></a>
            </div>

            <div id="kt_app_sidebar_toggle"
                class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
                data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                data-kt-toggle-name="app-sidebar-minimize">
                <i class="rotate-180 ki-duotone ki-black-left-line fs-3">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
            <!--end::Sidebar toggle-->
        </div>
        <div class="overflow-hidden app-sidebar-menu flex-column-fluid">
            <!--begin::Menu wrapper-->
            <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
                <!--begin::Scroll wrapper-->
                <div id="kt_app_sidebar_menu_scroll" class="mx-3 my-5 scroll-y" data-kt-scroll="true"
                    data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                    data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                    data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                    data-kt-scroll-save-state="true">

                    @include('layouts.include.vertical.partials.dashboard_management')
                    @include('layouts.include.vertical.partials.users_management')
                    @include('layouts.include.vertical.partials.doctors_management')
                    @include('layouts.include.vertical.partials.patients_management')
                    @include('layouts.include.vertical.partials.opd_management')
                    @include('layouts.include.vertical.partials.prescriptions_management')
                    @include('layouts.include.vertical.partials.invoices_management')
                    @include('layouts.include.vertical.partials.finance_verification')
                    @include('layouts.include.vertical.partials.deposit_slips_management')
                    @include('layouts.include.vertical.partials.pharmacy_management')
                    @include('layouts.include.vertical.partials.reports_management')
                    @include('layouts.include.vertical.partials.notifications_management')
                    @include('layouts.include.vertical.partials.settings_management')
                    @include('layouts.include.vertical.partials.hospital_setup')
                    @include('layouts.include.vertical.partials.appointments_management')
                    @include('layouts.include.vertical.partials.pathology_management')
                    @include('layouts.include.vertical.partials.radiology_management')
                    @include('layouts.include.vertical.partials.blood_bank_management')
                    @include('layouts.include.vertical.partials.ambulance_management')
                    @include('layouts.include.vertical.partials.setup_management')
                    @include('layouts.include.vertical.partials.hr_management')
                    @include('layouts.include.vertical.partials.bed_setup_management')

                </div>
            </div>
        </div>
    </div>
