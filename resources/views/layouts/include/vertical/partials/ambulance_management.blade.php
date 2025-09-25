        @if (auth()->user()->role_id == 1)
                    {{-- Ambulance starts here --}}
                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                        id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item @isset($activeMenu)
                            {{ $activeMenu == 'ambulance_management' ? ' menu-accordion hover show' : ' menu-accordion' }}
                            @else
                            menu-accordion
                            @endisset">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-delivery fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Ambulance</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion @isset($activeMenu)
                        {{ $activeMenu == 'ambulance_management' ? 'show' : '' }}
                        @endisset" @isset($activeMenu) {{ $activeMenu=='ambulance_management' ? 'style=""'
                                : 'style="display: none; overflow: hidden;"' }} @endisset>


                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                                {{ $activeSubMenu == 'blood_bank' ? 'active' : '' }}
                                @endisset" href="">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">List</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->

                                <!--end:Menu item-->
                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    {{-- Ambulance end here --}}
                    @endif
