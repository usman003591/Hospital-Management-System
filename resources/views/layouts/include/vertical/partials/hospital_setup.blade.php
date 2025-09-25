

                    @if(!$doctorPanelValue)
                    @if(auth()->user()->role_id == 1)
                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                        id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                        <!--begin:Menu item-->
                        @if (checkPersonPermission('view_section_hospital_setup_section_33'))
                        <div data-kt-menu-trigger="click" class="menu-item @isset($activeMenu)
                    {{ $activeMenu == 'hospital_setups_management' ? 'menu-accordion hover show' : 'menu-accordion' }}
                    @else
                    menu-accordion
                    @endisset">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-gear fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Hospital Setup</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion @isset($activeMenu)
                        {{ $activeMenu == 'hospital_setups_management' ? 'show' : '' }}
                        @endisset" @isset($activeMenu) {{ $activeMenu=='hospital_setups_management' ? 'style=""'
                                : 'style="display: none; overflow: hidden;"' }} @endisset>

                                @if (checkPersonPermission('list_floors_34'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                    {{ $activeSubMenu == 'floors' ? 'active' : '' }}
                    @endisset" href="{{ route('floors.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Floors</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission(per: 'list_wards_35'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                        {{ $activeSubMenu == 'wards' ? 'active' : '' }}
                        @endisset" href="{{ route('wards.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Wards</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission('list_beds_36'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                        {{ $activeSubMenu == 'beds' ? 'active' : '' }}
                        @endisset" href="{{ route('beds.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Beds</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission('list_rooms_37'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                        {{ $activeSubMenu == 'rooms' ? 'active' : '' }}
                        @endisset" href="{{ route('rooms.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Rooms</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif
                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
                        @endif
                    </div>
                    @endif
                    @endif
