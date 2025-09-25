@extends('layouts.master', ['activeMenu' => 'clinical_diagnosis_management', 'activeSubMenu' => $page, 'activeThirdMenu'
=> $page])
@section('styles')
<link href="{{ URL::to('src/sass/components/_variables.scss') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
<style>
/* dropdown list items */
.selectMedicine + .select2-container .select2-results__option.is-in-house {
    background-color:#d4edda !important;
    color:#155724 !important;
}

/* tag / single-select text once chosen */
.selectMedicine + .select2-container
    .select2-selection__choice.is-in-house,
.selectMedicine + .select2-container
    .select2-selection__rendered.is-in-house {
    background-color:#d4edda !important;
    color:#155724 !important;
}
</style>
@endsection
@section('breadcrumbs')
@include('include.global_search')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
        data-select2-id="select2-data-kt_app_toolbar_container">
        <!--begin::Page title-->
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <!--begin::Title-->
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                Detail </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <a href="{{ route('clinical_diagnosis.index') }}">
                    <span></span>
                    {{-- <li class="breadcrumb-item text-muted text-hover-primary">{{ $sc }}</li> --}}
                    <li class="breadcrumb-item text-muted text-hover-primary">Investigation</li>
                </a>
                <!--end::Item-->

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a>
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Create Investigations</li>
                </a>

            </ul>
            <!--end::Breadcrumb-->
        </div>



        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="gap-2 d-flex align-items-center gap-lg-3" data-select2-id="select2-data-122-cw9r">
            <!--begin::Filter menu-->
            {{-- <div class="m-0" data-select2-id="select2-data-121-45f5">
                <!--begin::Menu toggle-->
                <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">
                    <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Filter</a>
                <!--end::Menu toggle-->
                <!--begin::Menu 1-->
                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                    id="kt_menu_6606384d61246" style="" data-select2-id="select2-data-kt_menu_6606384d61246">
                    <!--begin::Header-->
                    <div class="py-5 px-7">
                        <div class="text-gray-900 fs-5 fw-bold">Filter Options</div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Menu separator-->
                    <div class="border-gray-200 separator"></div>
                    <!--end::Menu separator-->
                    <!--begin::Form-->
                    <div class="py-5 px-7" data-select2-id="select2-data-120-s3mi">
                        <!--begin::Input group-->
                        <div class="mb-10" data-select2-id="select2-data-119-md49">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Status:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div data-select2-id="select2-data-118-i4go">
                                <select class="form-select form-select-solid select2-hidden-accessible" multiple=""
                                    data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_6606384d61246" data-allow-clear="true"
                                    data-select2-id="select2-data-7-19z1" tabindex="-1" aria-hidden="true"
                                    data-kt-initialized="1">
                                    <option data-select2-id="select2-data-125-g7ns"></option>
                                    <option value="1" data-select2-id="select2-data-126-g09z">Approved</option>
                                    <option value="2" data-select2-id="select2-data-127-23ft">Pending</option>
                                    <option value="2" data-select2-id="select2-data-128-ql51">In Process</option>
                                    <option value="2" data-select2-id="select2-data-129-fwv5">Rejected</option>
                                </select><span
                                    class="select2 select2-container select2-container--bootstrap5 select2-container--below"
                                    dir="ltr" data-select2-id="select2-data-8-x24w" style="width: 100%;"><span
                                        class="selection"><span
                                            class="select2-selection select2-selection--multiple form-select form-select-solid"
                                            role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1"
                                            aria-disabled="false">
                                            <ul class="select2-selection__rendered" id="select2-fkxw-container"></ul>
                                            <span class="select2-search select2-search--inline"><textarea
                                                    class="select2-search__field" type="search" tabindex="0"
                                                    autocorrect="off" autocapitalize="none" spellcheck="false"
                                                    role="searchbox" aria-autocomplete="list" autocomplete="off"
                                                    aria-label="Search" aria-describedby="select2-fkxw-container"
                                                    placeholder="Select option" style="width: 100%;"></textarea></span>
                                        </span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Member Type:</label>
                            <!--end::Label-->
                            <!--begin::Options-->
                            <div class="d-flex">
                                <!--begin::Options-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1">
                                    <span class="form-check-label">Author</span>
                                </label>
                                <!--end::Options-->
                                <!--begin::Options-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="2" checked="checked">
                                    <span class="form-check-label">Customer</span>
                                </label>
                                <!--end::Options-->
                            </div>
                            <!--end::Options-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Notifications:</label>
                            <!--end::Label-->
                            <!--begin::Switch-->
                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="" name="notifications"
                                    checked="checked">
                                <label class="form-check-label">Enabled</label>
                            </div>
                            <!--end::Switch-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true">Reset</button>
                            <button type="submit" class="btn btn-sm btn-primary"
                                data-kt-menu-dismiss="true">Apply</button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Menu 1-->
            </div> --}}
            <!--end::Filter menu-->
            <!--begin::Secondary button-->
            <!--end::Secondary button-->
            <!--begin::Primary button-->
            <!--end::Primary button-->
            {{-- @if (checkPersonPermission('create_service_categories_11')) --}}
            {{-- <a href="{{route($page.'.create')}}">
                <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_add_permission">
                    <i class="ki-duotone ki-plus-square fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>Add {{$sc}}</button></a> --}}
        </div>


        <!--end::Actions-->
    </div>
    <!--end::Toolbar container-->
</div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
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

                                    {{-- <button type="button" class="btn btn-sm btn-dark me-3 investigations-details"
                                        data-bs-toggle="modal" data-id="{{$CdObj->id}}" data-bs-target="#investigationsModal">
                                        <i class="text-white ki-outline ki-printer"></i>
                                        Print Investigations
                                    </button> --}}

                                    @isset($lab_group_data->receipt_file_path)
                                        <a href="{{$lab_group_data->receipt_file_path}}" target="_blank" type="button" class="btn btn-sm btn-info me-3"
                                            data-id="{{$CdObj->id}}">
                                            <i class="text-white ki-outline ki-file-down"></i>
                                        </a>
                                    @endisset

                                     {{-- @include('modules.clinical_diagnosis.detail.modals.investigations') --}}


                        {{-- <a class="btn btn-sm btn-primary me-3" id="previewButton"
                            href="{{ route('clinical_diagnosis.preview', $obj->id) }}">Preview</a> --}}

                                        <a class="btn btn-sm btn-primary me-3" id="backButtonButton"
                                        href="{{ route('clinical_diagnosis.index') }}"> <i
                                            class="text-white ki-outline ki-to-left"></i>Back</a>
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

            {{-- @include('modules.clinical_diagnosis.detail.include.navbar') --}}
            @include('include.messages')

            <div class="mb-5 card card-xl-stretch mb-xl-8">

              @include('modules.clinical_diagnosis.detail.modern.lab_pathology_investigations')

            </div>
        </div>
    </div>
</div>

{{-- @include('modules.clinical_diagnosis.detail.modals.preview') --}}
@endsection

@section('scripts')
{{-- <script src="{{ getAssetsURLs('js/custom/search_partial.js') }}"></script> --}}
<script src="{{ getAssetsURLs('js/custom/helper_scripts.js') }}"></script>
<script src="{{ getAssetsURLs('plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script src="{{getAssetsURLs('js/custom/helper_scripts.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
<script>

function limitDiscount(input) {
    if (input.value > 100) {
        input.value = 100;
    } else if (input.value < 0) {
        input.value = 0;
    }
}

$('#addAllInvestigations').on('click', function () {
    $('.checkboxValues').each(function () {
        $(this).prop('checked', true).val("true");
    });
});

// $(document).ready(function () {
//     $('#kt_docs_repeater_advanced_pathology').repeater({
//         initEmpty: false,
//         defaultValues: {
//             'selected': '0'
//         },
//         show: function () {
//             $(this).slideDown();

//             // Attach checkbox listener for newly added item
//             $(this).find('.checkboxValues').on('change', function () {
//                 $(this).val(this.checked ? 1 : 0);
//             });
//         }
//     });

//     // Attach for initial items
//     $(document).on('change', '.checkboxValues', function () {
//         $(this).val(this.checked ? 1 : 0);
//     });
// });

$('#kt_docs_repeater_advanced_pathology').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
                $(this).find('[data-kt-repeater="pathology_select_2"]').select2({
                    placeholder: "Select Pathology test",
                    tags: false,
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="pathology_select_2"]').select2({
                    placeholder: "Select Pathology test",
                    tags: false,
                });
            }
        });

</script>
@endsection
