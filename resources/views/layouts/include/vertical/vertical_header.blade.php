<!--begin::Header-->
<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}"
    data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}"
    data-kt-sticky-animation="false">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
        id="kt_app_header_container">
        <!--begin::Sidebar mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        <!--end::Sidebar mobile toggle-->
        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">

            @php
               $redirect_value = giveRedirectValue();
            @endphp

            <a href="{{$redirect_value}}" class="d-lg-none">
                <img alt="Logo" src="{{ asset('src/media/logos/logo_without_background_1.png') }}" class="h-40px" />
                {{ session('web_name') }}
            </a>

        </div>
        <!--end::Mobile logo-->
        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <!--begin::Menu wrapper-->
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
                data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                {{--
                <!--begin::Menu-->
                <!--end::Menu--> --}}
            </div>
            <!--end::Menu wrapper-->
            <!--begin::Navbar-->

            {{-- <form id="globalSearchForm" action="{{ route('global.search') }}" method="GET" class="w-100">
                <div class="container mt-5 d-flex justify-content-center">
                    <div class="row w-75 g-1 align-items-center">
                        <div class="p-1 col-md-8">
                            <div class="input-group">
                                <span class="bg-white input-group-text border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="search_query" name="query" class="form-control form-control-sm border-start-0" placeholder="Search..." aria-label="Search" />
                            </div>
                        </div>

                        <div class="p-1 col-md-2">
                            <select class="form-select form-select-sm w-100" id="module" name="module">
                                <option selected disabled>Select</option>
                                <option value="patients">Patients</option>
                                <option value="opd">OPD</option>
                            </select>
                        </div>

                        <div class="p-1 col-md-2 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-sm w-100">Search</button>
                        </div>
                    </div>
                </div>
            </form> --}}


            <div class="flex-shrink-0 app-navbar">
                <!--begin::Search-->
                <div class="app-navbar-item ms-1 ms-md-4">
                    @if (checkPersonPermission('change_user_preferences_section_52'))
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
                    @endif
                    <!--end::Drawer toggle-->
                </div>
                <!--end::Search-->
                <!--begin::Activities-->

                <!--end::Activities-->
<!--begin::Notifications-->
<livewire:notifications.notifications-dropdown />
<!--end::Notifications-->

                <!--end::Notifications-->
                <!--begin::Chat-->

                <!--end::Chat-->
                <!--begin::My apps links-->

                <!--end::My apps links-->
                <!--begin::Theme mode-->

                <!--end::Theme mode-->

                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-35px"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">
                        @if (auth()->user()->image)
                        <img src="{{ asset(auth()->user()->image) }}" class="rounded-3" alt="user">
                        @else
                        <img src="{{ asset('assets/media/avatars/300-3.jpg') }}" class="rounded-3" alt="user">
                        @endif
                        {{-- @if (file_exists(auth()->user()->image))
                        <img src="@auth {{ auth()->user()->image }} @endauth" class="rounded-3" alt="user">
                        @else
                        <img src="assets/media/avatars/300-3.jpg" class="rounded-3" alt="user">
                        @endif --}}
                    </div>
                    <!--begin::User account menu-->
                    <div class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold fs-6 w-275px"
                        data-kt-menu="true" style="">
                        <!--begin::Menu item-->
                        <div class="px-3 menu-item">
                            <div class="px-3 menu-content d-flex">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-70px me-5">
                                    @if (auth()->user()->image)
                                    <img src="{{ asset(auth()->user()->image) }}" class="rounded-3" alt="user">
                                    @else
                                    <img alt="Logo" src="{{ asset('assets/media/avatars/300-3.jpg') }}">
                                    @endif
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column text-break">
                                    <div class="fw-bold d-flex align-items-center fs-5 ">@auth
                                        {{ auth()->user()->name }}
                                        @endauth</div>
                                    <p class="fw-semibold text-muted fs-7">@auth
                                        {{ auth()->user()->email }}
                                        @endauth</p>
                                    <p class="fw-semibold fs-6" style="margin-top: -2px">
                                        @auth
                                        <span class="fs-6">{{ auth()->user()->role ? auth()->user()->role->name :
                                            'N/A' }}</span>
                                        @endauth
                                    </p>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        @if(checkPersonPermission('overview_profile_section_53'))
                        <!--begin::Menu separator-->
                        <div class="my-2 separator"></div>
                        <div class="px-5 menu-item">
                            <a href="{{route('profile.edit')}}" class="px-5 menu-link">My Profile</a>
                        </div>
                        <!--end::Menu item-->
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        @endif


                        <div class="my-2 separator"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        {{-- <div class="px-5 menu-item">
                            <a href="{{route('profile.edit')}}" class="px-5 menu-link">My Profile</a>
                        </div> --}}
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <!--end::Menu item-->
                        <!--begin::Menu item-->

                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        {{-- <div class="px-5 menu-item">
                            <a href="{{route('users.edit',auth()->user()->id)}}" class="px-5 menu-link">Update
                                Profile</a>
                        </div> --}}
                        <div class="px-5 menu-item">
                            <a href="{{route('logout_redirect')}}" class="px-5 menu-link">Log Out</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                </div>

                <!--begin::User menu-->
                {{-- <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle"> --}}
                    <!--begin::Menu wrapper-->
                    {{-- <div class="cursor-pointer symbol symbol-35px"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">
                        @auth
                        @php
                        $image = auth()->user()->image;
                        @endphp
                        @if($image)
                        <img src="{{AvatarImagePath($image)}}" alt="image" class="rounded-3">
                        @endif
                        @endauth
                    </div> --}}
                    <!--begin::User account menu-->
                    {{-- <div
                        class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold fs-6 w-275px"
                        data-kt-menu="true"> --}}
                        <!--begin::Menu item-->
                        {{-- <div class="px-3 menu-item">
                            <div class="px-3 menu-content d-flex align-items-center">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    @auth
                                    @if($image)
                                    <img src="{{url($image)}}" alt="image" class="rounded-3">
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
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">@auth
                                        {{ auth()->user()->email }}
                                        @endauth</a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div> --}}
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        {{-- <div class="my-2 separator"></div> --}}
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        {{-- <div class="px-5 menu-item">
                            <a href="{{route('profile.edit')}}" class="px-5 menu-link">My Profile</a>
                        </div> --}}
                        <!--end::Menu item-->
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        {{-- <div class="my-2 separator"></div> --}}
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
                            </a> --}}
                            <!--begin::Menu-->
                            {{-- <div
                                class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold fs-base w-150px"
                                data-kt-menu="true" data-kt-element="theme-mode-menu">
                                <!--begin::Menu item-->
                                <div class="px-3 my-0 menu-item">
                                    <a href="#" class="px-3 py-2 menu-link" data-kt-element="mode"
                                        data-kt-value="light">
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
                                    <a href="#" class="px-3 py-2 menu-link" data-kt-element="mode"
                                        data-kt-value="system">
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
                            </div> --}}
                            <!--end::Menu-->
                            {{--
                        </div> --}}
                        <!--end::Menu item-->
                        <!--begin::Menu item-->

                        <!--end::Menu item-->
                        <!--begin::Menu item-->

                        <!--end::Menu item-->
                        <!--begin::Menu item-->

                        <!--begin::Menu item-->
                        {{-- <div class="px-5 menu-item">
                            <a href="{{route('logout_redirect')}}" class="px-5 menu-link">Log Out</a>
                        </div> --}}
                        <!--end::Menu item-->

                        {{--
                        <a class="px-5 menu-link" style="margin-left: 50px">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-responsive-nav-link>
                            </form>
                        </a> --}}

                        <!--end::Menu item-->
                        {{--
                    </div> --}}
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                    {{--
                </div> --}}
                <!--end::User menu-->
                <!--begin::Header menu toggle-->
                {{-- <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                    <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px"
                        id="kt_app_header_menu_toggle">
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
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
<!--end::Header-->
