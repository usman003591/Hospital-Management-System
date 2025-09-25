@if (checkPersonPermission('view_section_finance_management_61'))
<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="kt_app_sidebar_menu"
    data-kt-menu="true" data-kt-menu-expand="false">

    <!-- Finance Menu Item -->
    <div data-kt-menu-trigger="click"
        class="menu-item menu-accordion {{ isset($activeMenu) && $activeMenu == 'finance_management' ? 'hover show' : '' }}">

        <!--begin:Menu link-->
        <span class="menu-link">
            <span class="menu-icon">
                <i class="ki-duotone ki-bank fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </span>
            <span class="menu-title">Finance</span>
            <span class="menu-arrow"></span>
        </span>
        <!--end:Menu link-->

        <!--begin:Menu sub-->
        <div
            class="menu-sub menu-sub-accordion {{ isset($activeMenu) && $activeMenu == 'finance_management' ? 'show' : '' }}">

            <!-- Verification SubMenu -->
            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion {{ isset($activeSubMenu) && $activeSubMenu == 'verification' ? 'hover show' : '' }}">

                @if(checkPersonPermission('view_summary_summary_70'))
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link @isset($activeSubMenu)
                        {{ $activeSubMenu == 'summary' ? 'active' : '' }}
                        @endisset" href="{{ route('finance.get_summary') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Summary</span>
                    </a>
                </div>
                @endif


                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Verification</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->

                <!--begin:Sub-sub menu-->
                <div
                    class="menu-sub menu-sub-accordion {{ isset($activeSubMenu) && $activeSubMenu == 'verification' ? 'show' : '' }}">

                    @if (checkPersonPermission('list_service_invoices_verification_62'))
                    <!-- Services Invoices -->
                    <div class="menu-item">
                        <a class="menu-link {{ isset($activeThirdMenu) && $activeThirdMenu == 'services_invoices' ? 'active' : '' }}"
                            href="{{ route('finance.service_categories_invoices_verification') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Services Invoices</span>
                        </a>
                    </div>
                    @endif
                    @if (checkPersonPermission('list_pharmacy_invoices_verification_63'))
                    <!-- Pharmacy Invoices -->
                    <div class="menu-item">
                        <a class="menu-link {{ isset($activeThirdMenu) && $activeThirdMenu == 'pharmacy_invoices' ? 'active' : '' }}"
                            href="{{ route('finance.pharmacy_invoices_verification') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pharmacy Invoices</span>
                        </a>
                    </div>
                    @endif
                    @if (checkPersonPermission('list_pathology_invoices_verification_64'))
                    <!-- Pathology Invoices -->
                    <div class="menu-item">
                        <a class="menu-link {{ isset($activeThirdMenu) && $activeThirdMenu == 'pathology_invoices' ? 'active' : '' }}"
                            href="{{ route('finance.pathology_invoices_verification') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pathology Invoices</span>
                        </a>
                    </div>
                    @endif

                </div>
                <!--end:Sub-sub menu-->
            </div>
            <!--end:Verification SubMenu-->

        </div>
        <!--end:Finance Sub Menu-->





    </div>
    <!--end:Finance Menu Item-->

</div>
@endif
