    @if (checkPersonPermission('view_section_pathology_lab_section_54'))
                    {{-- Pathology starts here --}}
                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                        id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item @isset($activeMenu)
                    {{ $activeMenu == 'pathology_management' ? ' menu-accordion hover show' : ' menu-accordion' }}
                    @else
                    menu-accordion
                    @endisset">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-flask fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Pathology</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion @isset($activeMenu)
                {{ $activeMenu == 'pathology_management' ? 'show' : '' }}
                @endisset" @isset($activeMenu) {{ $activeMenu=='pathology_management' ? 'style=""'
                                : 'style="display: none; overflow: hidden;"' }} @endisset>

                                <!--begin:Menu item-->
                                @if (checkPersonPermission('list_lab_groups_55'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                                            {{ $activeSubMenu == 'lab_groups' ? 'active' : '' }}
                                            @endisset" href="{{route('lab_groups.index')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Lab groups</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>

                                <!--end:Menu item-->
                                <!--end:Menu item-->
                                {{-- @if (auth()->user()->role_id == 1)
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                                            {{ $activeSubMenu == 'invoices' ? 'active' : '' }}
                                            @endisset" href="{{ route('lab_invoices.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Invoices</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif --}}
                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    {{-- pharmacy_management end here --}}
                    @endif
                    @endif
