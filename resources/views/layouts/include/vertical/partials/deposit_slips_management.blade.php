           @if (checkPersonPermission('list_deposit_slips_section_51'))
                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                        id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'deposit_slips' ? 'active' : '' }}
                             @endisset" href="{{ route('deposit_slips.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-menu fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Deposit Slips</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                    </div>
                    @endif
