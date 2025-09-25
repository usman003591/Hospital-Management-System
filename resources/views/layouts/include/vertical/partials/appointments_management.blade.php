 @if (checkPersonPermission('view_section_appointments_sections_38'))
                    {{-- Appointments starts here --}}
                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                        id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item @isset($activeMenu)
                    {{ $activeMenu == 'appointment_management' ? ' menu-accordion hover show' : ' menu-accordion' }}
                    @else
                    menu-accordion
                    @endisset">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-calendar-add fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Appointments</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion @isset($activeMenu)
                   {{ $activeMenu == 'appointment_management' ? 'show' : '' }}
                   @endisset" @isset($activeMenu) {{ $activeMenu=='appointment_management' ? 'style=""'
                                : 'style="display: none; overflow: hidden;"' }} @endisset>


                                @if (checkPersonPermission('list_appointment_requests_39'))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                           {{ $activeSubMenu == 'appointment_requests' ? 'active' : '' }}
                           @endisset" href="{{ route('appointment_requests.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Appointment Requests</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                @endif

                                @if (checkPersonPermission('list_appointments_40'))
                                @if(!$doctorPanelValue)
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <a class="menu-link @isset($activeSubMenu)
                                    {{ $activeSubMenu == 'appointments' ? 'active' : '' }}
                                    @endisset" href="{{ route('appointments.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">All</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <!--end:Menu item-->
                                @endif
                                @endif

                                @if($doctorPanelValue)
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                                    {{ $activeSubMenu == 'doctor_appointments_all' ? 'active' : '' }}
                                    @endisset" href="{{ route('appointments.logged_in_doctor_appointments') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">All Appointments</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if($doctorPanelValue)
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                                    {{ $activeSubMenu == 'doctor_appointments_daily' ? 'active' : '' }}
                                    @endisset" href="{{ route('appointments.logged_in_doctor_appointments_daily') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Daily Appointments</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    @endif
