   @if(checkPersonPermission('view_section_notifications_66'))
                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                        id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item @isset($activeMenu)
                         {{ $activeMenu == 'notification_management' ? ' menu-accordion hover show' : ' menu-accordion' }}
                        @else
                        menu-accordion
                         @endisset">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-address-book fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Notification</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion @isset($activeMenu)
                        {{ $activeMenu == 'notification' ? 'show' : '' }}
                        @endisset" @isset($activeMenu) {{ $activeMenu=='notification' ? 'style=""'
                                : 'style="display: none; overflow: hidden;"' }} @endisset>

                                @if(checkPersonPermission('list_notifications_68'))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                                {{ $activeSubMenu == 'notifications' ? 'active' : '' }}
                                @endisset" href="{{ route('notifications.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Notifications</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif
                                <!--end:Menu item-->
                                @if(checkPersonPermission('list_notification_categories_67'))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                                {{ $activeSubMenu == 'notification_categories' ? 'active' : '' }}
                                @endisset" href="{{ route('notification_categories.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Notification Categories</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                @endif

                                <!--end:Menu item-->
                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    @endif
