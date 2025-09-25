<div class="row">
    <div class="mb-10 col-xl-12 col-md-12">
        <!--begin::Lists Widget 19-->
        <div class="card card-flush h-xl-100">
            <!--begin::Heading-->
            <div class="rounded card-header bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px" style="background-color: #0d0e12" data-bs-theme="light">
                <!--begin::Title-->
                <h3 class="text-white card-title align-items-start flex-column pt-15">
                    <span class="mb-3 fw-bold fs-2x">HMS Modules</span>
                    <div class="text-white fs-4">
                        {{-- <span class="opacity-75">You have</span> --}}
                        <span class="position-relative d-inline-block">
                            {{-- <a href="pages/user-profile/projects.html" class="mb-1 link-white opacity-75-hover fw-bold d-block">4 tasks</a> --}}
                            <!--begin::Separator-->
                            <span class="bottom-0 border-2 opacity-50 position-absolute start-0 border-body border-bottom w-100"></span>
                            <!--end::Separator-->
                        </span>
                        {{-- <span class="opacity-75">to complete</span> --}}
                    </div>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                {{-- <div class="pt-5 card-toolbar">
                    <!--begin::Menu-->
                    <button class="bg-white bg-opacity-25 btn btn-sm btn-icon btn-active-color-primary btn-color-white bg-hover-opacity-100 bg-hover-white bg-active-opacity-25 w-20px h-20px" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <i class="ki-duotone ki-dots-square fs-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                    </button>
                    <!--begin::Menu 2-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="px-3 menu-item">
                            <div class="px-3 py-4 text-gray-900 menu-content fs-6 fw-bold">Quick Actions</div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="mb-3 opacity-75 separator"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="px-3 menu-item">
                            <a href="#" class="px-3 menu-link">New Ticket</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="px-3 menu-item">
                            <a href="#" class="px-3 menu-link">New Customer</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="px-3 menu-item" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                            <!--begin::Menu item-->
                            <a href="#" class="px-3 menu-link">
                                <span class="menu-title">New Group</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <!--end::Menu item-->
                            <!--begin::Menu sub-->
                            <div class="py-4 menu-sub menu-sub-dropdown w-175px">
                                <!--begin::Menu item-->
                                <div class="px-3 menu-item">
                                    <a href="#" class="px-3 menu-link">Admin Group</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="px-3 menu-item">
                                    <a href="#" class="px-3 menu-link">Staff Group</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="px-3 menu-item">
                                    <a href="#" class="px-3 menu-link">Member Group</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu sub-->
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="px-3 menu-item">
                            <a href="#" class="px-3 menu-link">New Contact</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="mt-3 opacity-75 separator"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="px-3 menu-item">
                            <div class="px-3 py-3 menu-content">
                                <a class="px-4 btn btn-primary btn-sm" href="#">Generate Reports</a>
                            </div>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu 2-->
                    <!--end::Menu-->
                </div> --}}
                <!--end::Toolbar-->
            </div>
            <!--end::Heading-->
            <!--begin::Body-->
            <div class="card-body mt-n20">
                <!--begin::Stats-->
                <div class="mt-n20 position-relative">
                    <!--begin::Row-->
                    <div class="row g-3 g-lg-6">
                        <!--begin::Col-->

                        <div class="col-6">
                            <!--begin::Items-->
                            <div class="px-6 py-5 bg-gray-200 bg-opacity-70 rounded-2">
                                <a href="{{route('doctors.index')}}">
                                <!--begin::Symbol-->
                                <div class="mb-8 symbol symbol-30px me-5">
                                    <span class="symbol-label">
                                        <i class="ki-duotone ki-pulse fs-1 text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span class="mb-1 text-black fw-bolder d-block fs-2qx lh-1 ls-n1">{{$data['doctors_count']}}</span>
                                    <!--end::Number-->
                                    <!--begin::Desc-->
                                    <span class="text-black fw-semibold fs-6">Doctors</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                                </a>
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Items-->
                            <div class="px-6 py-5 bg-gray-200 bg-opacity-70 rounded-2">
                                <a href="{{route('patients.index')}}">
                                <!--begin::Symbol-->
                                <div class="mb-8 symbol symbol-30px me-5">
                                    <span class="symbol-label">
                                        <i class="ki-duotone ki-capsule fs-1 text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span class="mb-1 text-black fw-bolder d-block fs-2qx lh-1 ls-n1">{{$data['patients_count']}}</span>
                                    <!--end::Number-->
                                    <!--begin::Desc-->
                                    <span class="text-black fw-semibold fs-6">Patients</span>
                                    <!--end::Desc-->
                                </div>
                                </a>
                                <!--end::Stats-->
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Items-->
                            <div class="px-6 py-5 bg-gray-200 bg-opacity-70 rounded-2">
                                <a href="{{route('prescriptions.index')}}">
                                <!--begin::Symbol-->
                                <div class="mb-8 symbol symbol-30px me-5">
                                    <span class="symbol-label">
                                        <i class="ki-duotone ki-menu fs-1 text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span class="mb-1 text-black fw-bolder d-block fs-2qx lh-1 ls-n1">{{$data['prescriptions_count']}}</span>
                                    <!--end::Number-->
                                    <!--begin::Desc-->
                                    <span class="text-black fw-semibold fs-6">Prescriptions</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                                </a>
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Items-->
                            <div class="px-6 py-5 bg-gray-200 bg-opacity-70 rounded-2">
                                <a href="{{route('invoices.index')}}">
                                <!--begin::Symbol-->
                                <div class="mb-8 symbol symbol-30px me-5">
                                    <span class="symbol-label">
                                        <i class="ki-duotone ki-menu fs-1 text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span class="mb-1 text-black fw-bolder d-block fs-2qx lh-1 ls-n1">{{$data['invoices_count']}}</span>
                                    <!--end::Number-->
                                    <!--begin::Desc-->
                                    <span class="text-black fw-semibold fs-6">Invoices</span>
                                    <!--end::Desc-->
                                </div>
                                </a>
                                <!--end::Stats-->
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Stats-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Lists Widget 19-->
    </div>
</div>
