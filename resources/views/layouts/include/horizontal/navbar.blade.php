<div class="flex-shrink-0 app-navbar">

    <div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Drawer toggle-->
        <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
            data-bs-custom-class="tooltip-inverse" data-bs-toggle="tooltip" data-bs-placement="left"
            data-bs-dismiss="click" data-bs-trigger="hover" id="kt_app_layout_builder_toggle">
            <i class="ki-duotone ki-setting-4 fs-4 me-1">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
                <span class="path5"></span>
            </i>
        </div>
        <!--end::Drawer toggle-->
    </div>


    <!--begin::Notifications-->
    <div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Menu- wrapper-->
        <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
            data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
            data-kt-menu-placement="bottom-end" id="kt_menu_item_wow">
            <i class="ki-duotone ki-notification-status fs-2">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
            </i>
        </div>
        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" tool-tip="notifications"
            data-kt-menu="true" id="kt_menu_notifications">
            <!--begin::Heading-->
            <div class="d-flex flex-column bgi-no-repeat rounded-top"
                style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
                <!--begin::Title-->
                <h3 class="mt-10 mb-6 text-white fw-semibold px-9">Notifications
                    <span class="opacity-75 fs-8 ps-3">24 reports</span>
                </h3>
                <!--end::Title-->
                <!--begin::Tabs-->
                <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                    <li class="nav-item">
                        <a class="pb-4 text-white opacity-75 nav-link opacity-state-100" data-bs-toggle="tab"
                            href="#kt_topbar_notifications_1">Alerts</a>
                    </li>
                </ul>
                <!--end::Tabs-->
            </div>
            <!--end::Heading-->
            <!--begin::Tab content-->
            <div class="tab-content">
                <!--begin::Tab panel-->
                <div class="tab-pane fade" id="kt_topbar_notifications_1" role="tabpanel">
                    <!--begin::Items-->
                    <!--end::Items-->
                    <!--begin::View more-->
                    <div class="py-3 text-center border-top">
                        <a href="pages/user-profile/activity.html"
                            class="btn btn-color-gray-600 btn-active-color-primary">View All
                            <i class="ki-duotone ki-arrow-right fs-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i></a>
                    </div>
                    <!--end::View more-->
                </div>
            </div>
            <!--end::Tab content-->
        </div>
        <!--end::Menu-->
        <!--end::Menu wrapper-->
    </div>
    <!--end::Notifications-->

    <!--begin::Theme mode-->

    <!--end::Theme mode-->
    <!--begin::User menu-->
    <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
            data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            @auth

            @php
            $image = auth()->user()->image;
            @endphp

            @if($image)
            <img src="{{AvatarImagePath($image)}}" alt="image">
            @endif

            @endauth
        </div>
        <!--begin::User account menu-->
        <div class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold fs-6 w-275px"
            data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="px-3 menu-item">
                <div class="px-3 menu-content d-flex align-items-center">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50px me-5">
                        @auth
                        @if($image)
                        <img src="{{url($image)}}" alt="image">
                        @endif
                        @endauth
                    </div>
                    <!--end::Avatar-->
                    <!--begin::Username-->
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5">@auth
                            {{ auth()->user()->name }}
                            @endauth
                        </div>
                        <p class="fw-semibold text-muted fs-7">@auth
                            {{ auth()->user()->email }}
                            @endauth</p>
                            <p class="fw-semibold fs-6">
                                @auth
                                   <span class="badge fs-6">{{ auth()->user()->role ? auth()->user()->role->name : 'N/A' }}</span>
                                @endauth
                            </p>
                    </div>
                    <!--end::Username-->
                </div>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu separator-->
            <div class="my-2 separator"></div>
            <!--end::Menu separator-->
            <!--begin::Menu item-->
            <div class="px-5 menu-item">
                <a href="{{route('profile.edit')}}" class="px-5 menu-link">My Profile</a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu separator-->
            <div class="my-2 separator"></div>
            <!--end::Menu separator-->
            <!--begin::Menu item-->
            {{-- <div class="px-5 menu-item" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                <a href="#" class="px-5 menu-link">
                    <span class="menu-title position-relative">Mode
                        <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                            <i class="ki-duotone ki-night-day theme-light-show fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                                <span class="path6"></span>
                                <span class="path7"></span>
                                <span class="path8"></span>
                                <span class="path9"></span>
                                <span class="path10"></span>
                            </i>
                            <i class="ki-duotone ki-moon theme-dark-show fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span></span>
                </a>
                <!--begin::Menu-->
                <div class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold fs-base w-150px"
                    data-kt-menu="true" data-kt-element="theme-mode-menu">
                    <!--begin::Menu item-->
                    <div class="px-3 my-0 menu-item">
                        <a href="#" class="px-3 py-2 menu-link" data-kt-element="mode" data-kt-value="light">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-duotone ki-night-day fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                    <span class="path6"></span>
                                    <span class="path7"></span>
                                    <span class="path8"></span>
                                    <span class="path9"></span>
                                    <span class="path10"></span>
                                </i>
                            </span>
                            <span class="menu-title">Light</span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="px-3 my-0 menu-item">
                        <a href="#" class="px-3 py-2 menu-link" data-kt-element="mode" data-kt-value="dark">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-duotone ki-moon fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Dark</span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="px-3 my-0 menu-item">
                        <a href="#" class="px-3 py-2 menu-link" data-kt-element="mode" data-kt-value="system">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-duotone ki-screen fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">System</span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->
            </div> --}}
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="px-5 menu-item">
                <a href="{{route('logout_redirect')}}" class="px-5 menu-link">Log Out</a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::User account menu-->
        <!--end::Menu wrapper-->
    </div>
    <!--end::User menu-->
    <!--begin::Header menu toggle-->
    {{-- <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
        <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
            <i class="ki-duotone ki-element-4 fs-1">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
    </div> --}}
    <!--end::Header menu toggle-->
    <!--begin::Aside toggle-->
    <!--end::Header menu toggle-->
</div>
