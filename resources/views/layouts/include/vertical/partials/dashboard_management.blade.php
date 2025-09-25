@if (checkPersonPermission('view_section_performance_section_4'))
<!--begin::Menu Dashboard-->
<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu"
    data-kt-menu="true" data-kt-menu-expand="false">
    <!--begin:Menu item-->
    <div data-kt-menu-trigger="click" class="menu-item @isset($activeMenu)
                {{ $activeMenu == 'performance' ? ' menu-accordion hover show' : ' menu-accordion' }}
                @else
                menu-accordion
                @endisset">
        <!--begin:Menu link-->
        <span class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'dashboard' ? 'active' : '' }}
                            @endisset">
            <span class="menu-icon">
                <i class="ki-duotone ki-element-11 fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
            </span>
            <span class="menu-title">Performance</span>
            <span class="menu-arrow"></span>
        </span>
        <!--end:Menu link-->
        <!--begin:Menu sub-->
        <div class="menu-sub menu-sub-accordion @isset($activeMenu)
                    {{ $activeMenu == 'performance' ? 'show' : '' }}
                    @endisset" @isset($activeMenu) {{ $activeMenu=='performance' ? 'style=""'
            : 'style="display: none; overflow: hidden;"' }} @endisset>
            <!--begin:Menu item-->

            @if (checkPersonPermission('view_opd_dashboard_69'))
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'dashboard' ? 'active' : '' }}
                            @endisset" href="{{route('dashboard')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">OPD Dashboard</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endif

            @if (checkPersonPermission('view_doctor_dashboard_75'))
            @if($doctorPanelValue)
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'doctor_dashboard' ? 'active' : '' }}
                            @endisset" href="{{route('doctor.dashboard')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Doctor Dashboard</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endif
            @endif

            @if (checkPersonPermission('view_pharmacy_dashboard_73'))
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'pharmacy_dashboard' ? 'active' : '' }}
                            @endisset" href="{{route('pharmacy.dashboard')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Pharmacy Dashboard</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endif

            @if (checkPersonPermission('view_pathology_dashboard_74'))
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'pathology_dashboard' ? 'active' : '' }}
                            @endisset" href="{{route('pathology.dashboard')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Pathology Dashboard</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endif

            @if (checkPersonPermission('view_finance_dashboard_76'))
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'finance_dashboard' ? 'active' : '' }}
                            @endisset" href="{{route('finance.dashboard')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Finance Dashboard</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endif

        </div>
        <!--end:Menu sub-->
    </div>
    <!--end:Menu item-->
</div>
<!--end::Menu Dashboard-->
@endif
