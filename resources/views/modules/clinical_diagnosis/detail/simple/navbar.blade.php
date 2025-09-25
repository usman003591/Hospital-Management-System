<div class="mb-5 card mb-xxl-8">
    <div class="pb-0 card-body pt-9">
        <!--begin::Details-->
        <div class="flex-wrap d-flex flex-sm-nowrap">
            <!--begin: Pic-->
            <div class="mb-4 me-7">
                {{-- <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <img src="assets/media/avatars/300-1.jpg" alt="image">
                    <div
                        class="bottom-0 mb-6 border border-4 position-absolute translate-middle start-100 bg-success rounded-circle border-body h-20px w-20px">
                    </div>
                </div> --}}
            </div>
            <!--end::Pic-->
            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="flex-wrap mb-2 d-flex justify-content-between align-items-start">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->




                        <div class="mb-2 d-flex align-items-center">
                            <a href="#"
                                class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">@isset($patient->name_of_patient)
                                {{$patient->name_of_patient}}
                                @endisset</a>
                            {{-- <a href="#">
                                <i class="ki-duotone ki-verify fs-1 text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </a> --}}
                        </div>
                        <!--end::Name-->
                        <!--begin::Info-->
                        <div class="flex-wrap mb-4 d-flex fw-semibold fs-6 pe-2">
                            @isset($patient->patient_category)
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                {{titleFilter($patient->patient_category)}}
                            </a>
                            @endisset
                            @isset($patient->address)
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                <i class="ki-duotone ki-geolocation fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ucfirst($patient->address)}}
                            </a>
                            @endisset
                            @isset($patient->email)
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary">
                                <i class="ki-duotone ki-sms fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{$patient->email}}
                            </a>
                            @endisset
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->
                    <!--begin::Actions-->
                    <div class="my-4 d-flex">
                        {{-- <button type="button" class="btn btn-sm btn-primary me-3"
                            data-bs-toggle="modal" data-bs-target="#UploadManualPresc">Upload Manual Prescription</button> --}}
                        <a class="btn btn-sm btn-primary me-3" id="previewButton"
                            href="{{ route('clinical_diagnosis.preview', $obj->id) }}">Preview</a>

                        <a class="btn btn-sm btn-primary me-3" id="backButtonButton" href="{{ route('clinical_diagnosis.index') }}"> <i
                                class="ki-outline ki-to-left text-white"></i>Back</a>

                        {{--<a href="#" class="btn btn-sm btn-light me-2" id="kt_user_follow_button">
                            <i class="ki-duotone ki-check fs-3 d-none"></i>
                            <!--begin::Indicator label-->
                            <span class="indicator-label">Follow</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">Please wait...
                                <span class="align-middle spinner-border spinner-border-sm ms-2"></span></span>
                            <!--end::Indicator progress-->
                        </a>
                        <!--begin::Menu-->
                        <div class="me-0">
                            <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="ki-solid ki-dots-horizontal fs-2x"></i>
                            </button>
                            <!--begin::Menu 3-->
                            <div class="py-3 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                data-kt-menu="true">
                                <!--begin::Heading-->
                                <div class="px-3 menu-item">
                                    <div class="px-3 pb-2 menu-content text-muted fs-7 text-uppercase">Payments</div>
                                </div>
                                <!--end::Heading-->
                                <!--begin::Menu item-->
                                <div class="px-3 menu-item">
                                    <a href="#" class="px-3 menu-link">Create Invoice</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="px-3 menu-item">
                                    <a href="#" class="px-3 menu-link flex-stack">Create Payment
                                        <span class="ms-2" data-bs-toggle="tooltip"
                                            aria-label="Specify a target name for future usage and reference"
                                            data-bs-original-title="Specify a target name for future usage and reference"
                                            data-kt-initialized="1">
                                            <i class="ki-duotone ki-information fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span></a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="px-3 menu-item">
                                    <a href="#" class="px-3 menu-link">Generate Bill</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="px-3 menu-item" data-kt-menu-trigger="hover"
                                    data-kt-menu-placement="right-end">
                                    <a href="#" class="px-3 menu-link">
                                        <span class="menu-title">Subscription</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <!--begin::Menu sub-->
                                    <div class="py-4 menu-sub menu-sub-dropdown w-175px">
                                        <!--begin::Menu item-->
                                        <div class="px-3 menu-item">
                                            <a href="#" class="px-3 menu-link">Plans</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="px-3 menu-item">
                                            <a href="#" class="px-3 menu-link">Billing</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="px-3 menu-item">
                                            <a href="#" class="px-3 menu-link">Statements</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="my-2 separator"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Menu item-->
                                        <div class="px-3 menu-item">
                                            <div class="px-3 menu-content">
                                                <!--begin::Switch-->
                                                <label
                                                    class="form-check form-switch form-check-custom form-check-solid">
                                                    <!--begin::Input-->
                                                    <input class="form-check-input w-30px h-20px" type="checkbox"
                                                        value="1" checked="checked" name="notifications">
                                                    <!--end::Input-->
                                                    <!--end::Label-->
                                                    <span class="form-check-label text-muted fs-6">Recuring</span>
                                                    <!--end::Label-->
                                                </label>
                                                <!--end::Switch-->
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu sub-->
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="px-3 my-1 menu-item">
                                    <a href="#" class="px-3 menu-link">Settings</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu 3-->
                        </div> --}}
                        <!--end::Menu-->
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Title-->
                <!--begin::Stats-->
                <div class="flex-wrap d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <!--begin::Stats-->
                        <div class="flex-wrap d-flex">

                            <!--begin::Stat-->
                            @isset($patient->patient_mr_number)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="80"
                                        data-kt-initialized="1">
                                        {{$patient->patient_mr_number}}
                                    </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">MR Number</div>
                                <!--end::Label-->
                            </div>
                            @endisset
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            @isset($patient->cnic_number)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        {{$patient->cnic_number}}
                                    </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">CNIC</div>
                                <!--end::Label-->
                            </div>
                            @endisset
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            @isset($patient->blood_group)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                        data-kt-countup-value="4500" data-kt-countup-prefix="$" data-kt-initialized="1">
                                        {{$patient->blood_group}}
                                    </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Blood Group</div>
                                <!--end::Label-->
                            </div>
                            @endisset
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            @isset($patient->age)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        {{$patient->age}} years
                                        </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Age</div>
                                <!--end::Label-->
                            </div>
                            @endisset
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            @isset($patient->gender)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        {{ucfirst($patient->gender)}}
                                        </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Gender</div>
                                <!--end::Label-->
                            </div>
                            @endisset
                            @isset($patient->designation)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        {{ucfirst($patient->designation)}}
                                        </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Designation</div>
                                <!--end::Label-->
                            </div>
                            @endisset
                            <!--end::Stat-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Progress-->
                    {{-- <div class="mt-3 d-flex align-items-center w-200px w-sm-300px flex-column">
                        <div class="mt-auto mb-2 d-flex justify-content-between w-100">
                            <span class="text-gray-500 fw-semibold fs-6">Profile Compleation</span>
                            <span class="fw-bold fs-6">50%</span>
                        </div>
                        <div class="mx-3 mb-3 h-5px w-100 bg-light">
                            <div class="rounded bg-success h-5px" role="progressbar" style="width: 50%;"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div> --}}
                    <!--end::Progress-->
                </div>
                <!--end::Stats-->
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->
        <!--begin::Navs-->
        <br>
        <ul class="border-transparent nav nav-stretch nav-line-tabs nav-line-tabs-2x fs-5 fw-bold">
            <!--begin::Nav item-->
            {{-- <li class="mt-2 nav-item">
                <a class="py-5 nav-link text-active-primary ms-0 me-10 active"
                    href="pages/user-profile/overview.html">Overview</a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="mt-2 nav-item">
                <a class="py-5 nav-link text-active-primary ms-0 me-10"
                    href="pages/user-profile/projects.html">Projects</a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="mt-2 nav-item">
                <a class="py-5 nav-link text-active-primary ms-0 me-10"
                    href="pages/user-profile/campaigns.html">Campaigns</a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="mt-2 nav-item">
                <a class="py-5 nav-link text-active-primary ms-0 me-10"
                    href="pages/user-profile/documents.html">Documents</a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="mt-2 nav-item">
                <a class="py-5 nav-link text-active-primary ms-0 me-10"
                    href="pages/user-profile/followers.html">Followers</a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="mt-2 nav-item">
                <a class="py-5 nav-link text-active-primary ms-0 me-10"
                    href="pages/user-profile/activity.html">Activity</a>
            </li> --}}
            <!--end::Nav item-->
        </ul>
        <!--begin::Navs-->
    </div>
</div>

{{-- Upload manual Prescription div --}}
{{-- <div class="modal fade" id="UploadManualPresc" tabindex="-1" aria-labelledby="uploadManualPrescLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadManualPrescLabel">Upload Manual Prescription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form needs-validation" action="" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" name="id" value="{{ $obj->id }}">


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div> --}}

