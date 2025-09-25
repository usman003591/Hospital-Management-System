        @if (checkPersonPermission('view_section_opd_section_48'))
                    {{-- clinical diagnosis starts here --}}
                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                        id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item @isset($activeMenu)
                {{ $activeMenu == 'clinical_diagnosis_management' ? ' menu-accordion hover show' : ' menu-accordion' }}
                @else
                menu-accordion
                @endisset">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-syringe fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">OPD</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion @isset($activeMenu)
                    {{ $activeMenu == 'clinical_diagnosis_management' ? 'show' : '' }}
                    @endisset" @isset($activeMenu) {{ $activeMenu=='clinical_diagnosis_management' ? 'style=""'
                                : 'style="display: none; overflow: hidden;"' }} @endisset>

                                @if(!$doctorPanelValue)
                                @if (checkPersonPermission('list_all_49'))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'clinical_diagnosis' ? 'active' : '' }}
                            @endisset" href="{{ route('clinical_diagnosis.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">All</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                @endif
                                @endif

                                @if (checkPersonPermission('list_doctor_opd_50'))
                                @if($doctorPanelValue)
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                                    {{ $activeSubMenu == 'clinical_diagnosis_my_all' ? 'active' : '' }}
                                    @endisset" href="{{ route('clinical_diagnosis.myAllListingRecord') }}">

                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">All</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>

                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                                    {{ $activeSubMenu == 'clinical_diagnosis_my_daily' ? 'active' : '' }}
                                    @endisset" href="{{ route('clinical_diagnosis.myDailyListingRecord') }}">

                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Daily</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif
                                @endif

                                <!--end:Menu item-->
                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    {{-- clinical diagnosis ends here --}}
                    @endif
