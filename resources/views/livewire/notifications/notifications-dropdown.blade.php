<div class="app-navbar-item ms-1 ms-md-4" wire:poll.5s="loadNotifications">
    <!--begin::Menu- wrapper-->
    <div class="btn btn-icon btn-custom btn-icon-muted btn-active-color-primary w-35px h-35px"
        data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
        data-kt-menu-placement="bottom-end" id="kt_menu_item_wow">
        <i class="ki-duotone ki-notification fs-2">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>

            @if($unreadCount > 0)
                <span
                    class="position-absolute top-0 start-100 translate-middle bg-danger rounded-circle" style="padding: 0.3rem">
                </span>
            @endif
        </i>
    </div>

    <!--begin::Menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" tool-tip="notifications"
        data-kt-menu="true" id="kt_menu_notifications">

        <!--begin::Heading-->
        <div class="d-flex flex-column bgi-no-repeat rounded-top"
            style="background-image:url('{{ asset('assets/media/misc/menu-header-bg.jpg') }}')">

            <h3 class="mt-10 mb-6 text-white fw-semibold px-9">
                Notifications
                <span class="opacity-75 fs-8 ps-3">
                    {{ $unreadCount }} unread
                </span>
            </h3>

            <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                <li class="nav-item">
                    <a class="pb-4 text-white opacity-75 nav-link opacity-state-100" data-bs-toggle="tab"
                        href="#kt_topbar_notifications_1">Alerts</a>
                </li>
            </ul>
        </div>
        <!--end::Heading-->

        <div class="tab-content">
            <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                <div class="scroll-y mh-325px my-5 px-8">
                    @forelse($notifications as $notification)
                        <div class="d-flex flex-stack py-4">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-35px me-4">
                                    <span class="symbol-label bg-light-primary">
                                        <i class="ki-duotone ki-address-book fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </span>
                                </div>

                                <div class="mb-0 d-flex flex-column">
                                    <button wire:click="markAsRead({{ $notification->id }})"
                                        class="text-start btn btn-link p-0 m-0">
                                        <span class="fs-6 text-gray-800 fw-semibold">
                                            {{ $notification->notification_title }}
                                        </span>
                                        <span class="fs-7 text-muted">
                                            {!! Str::limit($notification->notification_message, 40) !!}
                                        </span>
                                    </button>
                                </div>
                            </div>

                            @if(!$notification->is_read)
                                <span class="badge badge-light-danger">New</span>
                            @else
                                <span class="badge badge-light-success">Read</span>
                            @endif
                        </div>
                    @empty
                        <div class="py-4 text-center text-muted">
                            No notifications found.
                        </div>
                    @endforelse
                </div>

                <div class="py-3 text-center border-top">
                    <a href="{{ route('notifications.view') }}"
                        class="btn btn-color-gray-600 btn-active-color-primary">
                        View All
                        <i class="ki-duotone ki-arrow-right fs-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
