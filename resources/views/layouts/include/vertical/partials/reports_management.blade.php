   @if (checkPersonPermission('view_section_reports_section_9'))
                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                        id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item @isset($activeMenu)
                {{ $activeMenu == 'reports_management' ? ' menu-accordion hover show' : ' menu-accordion' }}
                @else
                menu-accordion
                @endisset">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-menu fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Reports</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion @isset($activeMenu)
                    {{ $activeMenu == 'reports_management' ? 'show' : '' }}
                    @endisset" @isset($activeMenu) {{ $activeMenu=='reports_management' ? 'style=""'
                                : 'style="display: none; overflow: hidden;"' }} @endisset>

                                <!--begin:Menu item-->
                                @if (checkPersonPermission('create_reports_section_9'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'reports' ? 'active' : '' }}
                            @endisset" href="{{ route('reports.create') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Excel Report</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                @endif

                                @if (checkPersonPermission('cash_details_report_reports_section_9'))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'cash_details_report' ? 'active' : '' }}
                            @endisset" href="{{ route('reports.cash_details_report') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Cash Details</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                @endif

                                <!--begin:Menu item-->
                                {{-- <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'patient_details_report' ? 'active' : '' }}
                            @endisset" href="{{ route('reports.patient_details_report') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Patient Details</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div> --}}
                                <!--end:Menu item-->

                                @if (checkPersonPermission('patient_details_prescription_report_reports_section_9'))
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Patient Details</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion menu-active-bg" kt-hidden-height="292"
                                        style="display: none; overflow: hidden;">
                                        <!--begin:Menu item-->
                                        <!--end:Menu item-->

                                        <!--begin:Menu item-->
                                        {{-- <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link" href="authentication/email/promo-1.html">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">OPD</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div> --}}
                                        <!--end:Menu item-->

                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link"
                                                href="{{ route('reports.patient_prescriptions_details_report') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Prescriptions</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->

                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                                @endif

                                <!--end:Menu item-->
                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    @endif
