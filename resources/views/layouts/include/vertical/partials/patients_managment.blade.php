
                    <!--begin::Menu Patients-->
                    @if (checkPersonPermission('list_patients_section_6'))
                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                        id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'patients' ? 'active' : '' }}
                             @endisset" href="{{ route('patients.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-capsule fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Patients</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                    </div>
                    @endif
                    <!--end::Menu Patients-->
