        @if (checkPersonPermission('view_section_invoices_section_8'))
<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="kt_app_sidebar_menu"
    data-kt-menu="true" data-kt-menu-expand="false">
    <div data-kt-menu-trigger="click" class="menu-item @isset($activeMenu)
                    {{ $activeMenu == 'invoices_management' ? 'menu-accordion hover show' : 'menu-accordion' }}
                    @else
                    menu-accordion
                    @endisset">
        <span class="menu-link">
            <span class="menu-icon">
                <i class="ki-duotone ki-credit-cart fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
            </span>
            <span class="menu-title">Invoices</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion @isset($activeMenu)
                        {{ $activeMenu == 'invoices_management' ? 'show' : '' }}
                        @endisset" @isset($activeMenu) {{ $activeMenu=='invoices_management' ? 'style=""'
            : 'style="display: none; overflow: hidden;"' }} @endisset>

            @if (checkPersonPermission('list_services_invoices_65'))
            <div class="menu-item">
                <a class="menu-link @isset($activeSubMenu)
                        {{ $activeSubMenu == 'invoices' ? 'active' : '' }}
                        @endisset" href="{{ route('invoices.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Services</span>
                </a>
            </div>
            @endif



            @if (checkPersonPermission('list_lab_invoices_60'))
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link @isset($activeSubMenu)
                        {{ $activeSubMenu == 'lab_invoices' ? 'active' : '' }}
                        @endisset" href="{{ route('lab_invoices.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Labs</span>
                </a>
            </div>
            @endif


        </div>
        <!--end:Menu sub-->
    </div>
    <!--end:Menu item-->

</div>
@endif
