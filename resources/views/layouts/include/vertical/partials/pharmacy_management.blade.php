     @if (checkPersonPermission('view_section_pharmacy_section_41'))
<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="kt_app_sidebar_menu"
    data-kt-menu="true" data-kt-menu-expand="false">
    <!--begin:Menu item-->
    <div data-kt-menu-trigger="click" class="menu-item @isset($activeMenu)
                        {{ $activeMenu == 'pharmacy_management' ? 'menu-accordion hover show' : 'menu-accordion' }}
                        @else
                        menu-accordion
                        @endisset">
        <!--begin:Menu link-->
        <span class="menu-link">
            <span class="menu-icon">
                <i class="ki-duotone ki-pill fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
            </span>
            <span class="menu-title">Pharmacy</span>
            <span class="menu-arrow"></span>
        </span>
        <!--end:Menu link-->
        <!--begin:Menu sub-->
        <div class="menu-sub menu-sub-accordion @isset($activeMenu)
                            {{ $activeMenu == 'pharmacy_management' ? 'show' : '' }}
                            @endisset" @isset($activeMenu) {{ $activeMenu=='pharmacy_management' ? 'style=""'
            : 'style="display: none; overflow: hidden;"' }} @endisset>

            @if (checkPersonPermission('list_pharmacy_inventory_71'))
            <div class="menu-item">
                <a class="menu-link @isset($activeSubMenu){{ $activeSubMenu == 'inventory_management' ? 'active' : '' }} @endisset"
                href="{{ route('pharmacy.list_pharmacy_inventory') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Pharmacy Inventory</span>
                </a>
            </div>
            @endif

            @if (checkPersonPermission('list_patient_medicines_42'))
            <!--end:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link @isset($activeSubMenu)
                                    {{ $activeSubMenu == 'patient_medicines' ? 'active' : '' }}
                                    @endisset" href="{{ route('patient_medication_record.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Patient Medicines</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endif

            @if (checkPersonPermission('list_pharmacy_cashiers_43'))
            <!--end:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'cashiers' ? 'active' : '' }}
                            @endisset" href="{{ route('cashiers.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Pharmacy Cashiers</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endif

            <!--end:Menu item-->
            @if (checkPersonPermission('list_medicine_categories_44'))
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'medicine_categories' ? 'active' : '' }}
                            @endisset" href="{{ route('medicine_categories.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Medicine Categories</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endif

            @if (checkPersonPermission('list_medicine_inventory_status_45'))
            <!--end:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'medicine_inventory_statuses' ? 'active' : '' }}
                            @endisset" href="{{ route('medicine_inventory_statuses.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Medicine Inventory Status</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endif
            @if (checkPersonPermission('list_payment_methods_46'))
            <!--end:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'payment_methods' ? 'active' : '' }}
                            @endisset" href="{{ route('payment_methods.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Payment Methods</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endif

            @if (checkPersonPermission('list_order_status_47'))
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link @isset($activeSubMenu)
                    {{ $activeSubMenu == 'order_statuses' ? 'active' : '' }}
                    @endisset" href="{{ route('order_statuses.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Order Status</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endif

        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu item-->
</div>
@endif
