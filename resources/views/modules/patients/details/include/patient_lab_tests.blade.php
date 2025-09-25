@php $page='lab_groups'; @endphp
@extends('layouts.master',['activeMenu' => 'patients_management', 'activeSubMenu' => 'patients', 'activeThirdMenu' =>
'patients'])
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
                Lab Group Detail</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <a href="{{route('lab_groups.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{titleFilter($page)}}</li>
                </a>
                <!--end::Item-->

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="{{route('lab_groups.detail',['id' => $obj->id ])}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Lab Tests</li>
                </a>
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->

    </div>
    <!--end::Toolbar container-->
</div>
@endsection
@section('content')
<div class="mb-5 card mb-xxl-8">
    <div class="pb-0 card-body pt-9">
        <div class="flex-wrap d-flex flex-sm-nowrap">
            <div class="mb-4 me-7">
            </div>
            <div class="flex-grow-1">
                <div class="flex-wrap mb-2 d-flex justify-content-between align-items-start">
                    <div class="d-flex flex-column">
                        <div class="mb-2 d-flex align-items-center">
                            @isset($patient->name_of_patient)
                            <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">
                                {{$patient->name_of_patient}}
                            </a>
                            @endisset
                        </div>
                        <div class="flex-wrap mb-4 d-flex fw-semibold fs-6 pe-2">
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>@isset($patient->patient_category)
                                {{titleFilter($patient->patient_category)}}
                                @endisset</a>
                            @isset($lab_group_data->hospital_name)
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                <i class="ki-duotone ki-geolocation fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ucfirst($lab_group_data->hospital_name)}}
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
                    </div>
                    <div>
                        <a href="{{route('patients.lab_groups', $patient->id)}}" class="btn btn-sm btn-light-primary">
                            <i class="ki-duotone ki-black-left fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>Back</a>
                    </div>

                </div>
                <div class="flex-wrap d-flex flex-stack">
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <div class="flex-wrap d-flex">

                            @isset($patient->patient_mr_number)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
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
                                <div class="text-gray-500 fw-semibold fs-6">MR Number</div>
                            </div>
                            @endisset
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

                            <!--begin::Stat-->
                            @isset($patient->gender)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <div class="d-flex align-items-center">

                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        {{ucfirst($patient->gender)}}
                                    </div>
                                </div>

                                <div class="text-gray-500 fw-semibold fs-6">Gender</div>
                            </div>
                            @endisset
                            @isset($lab_group_data->lab_group_number)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">

                                        {{$lab_group_data->lab_group_number}}
                                    </div>
                                </div>
                                <div class="text-gray-500 fw-semibold fs-6">Lab Group Number</div>
                            </div>
                            @endisset
                            @isset($lab_group_data->doctor_name)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <div class="d-flex align-items-center">

                                    <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                        data-kt-countup-value="4500" data-kt-countup-prefix="$" data-kt-initialized="1">

                                        {{$lab_group_data->doctor_name}}
                                    </div>
                                </div>
                                <div class="text-gray-500 fw-semibold fs-6">Doctor Name</div>
                            </div>
                            @endisset
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <br>
    </div>
</div>

@include('include.messages')

<div class="flex-wrap d-flex flex-stack pb-7">
    <div class="flex-wrap my-1 d-flex align-items-center">
        <h3 class="my-1 fw-bold me-5">Tests: (@isset($count)
            {{$count}}
            @endisset)</h3>

    </div>
</div>

<div id="kt_project_users_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
    <div id="" class="table-responsive">
        <table id="kt_project_users_table"
            class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable" style="width: 100%;">
            <colgroup>
                <col data-dt-column="0" style="width: 0px;">
                <col data-dt-column="1" style="width: 0px;">
                <col data-dt-column="2" style="width: 0px;">
                <col data-dt-column="3" style="width: 0px;">
                <col data-dt-column="4" style="width: 0px;">
            </colgroup>
            <thead class="text-gray-500 fs-7 text-uppercase">
                <tr>
                    <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="0" rowspan="1" colspan="1"
                        aria-label="Manager: Activate to sort" tabindex="0" style="min-width: 20rem"><span
                            class="dt-column-title" role="button">Investigation Name</span><span
                            class="dt-column-order"></span></th>
                    <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1" colspan="1"
                        aria-label="Date: Activate to sort" tabindex="0" style="min-width: 20rem"><span
                            class="dt-column-title" role="button">Lab Group Number</span><span
                            class="dt-column-order"></span></th>
                    <th class="-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1" colspan="1"
                        aria-label="Date: Activate to sort" tabindex="0" style="min-width: 18rem"><span
                            class="dt-column-title" role="button">Report Date</span><span
                            class="dt-column-order"></span></th>
                    <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1" colspan="1"
                        aria-label="Date: Activate to sort" tabindex="0" style="min-width: 18rem"><span
                            class="dt-column-title" role="button">Received Date</span><span
                            class="dt-column-order"></span></th>
                    <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1" colspan="1"
                        aria-label="Status: Activate to sort" tabindex="0" style="min-width: 14rem"><span
                            class="dt-column-title" role="button">Status</span><span class="dt-column-order"></span>
                    </th>
                    <th class="text-center dt-orderable-none" data-dt-column="4" rowspan="1" colspan="1"
                        aria-label="Details" style="min-width: 7rem"><span class="dt-column-title">Actions</span><span
                            class="dt-column-order"></span></th>
                </tr>
            </thead>
            <tbody class="fs-6">

                @isset($lab_group_tests)
                @if (count($lab_group_tests) > 0)
                @foreach ($lab_group_tests as $d)
                <tr>
                    <td>
                        <!--begin::User-->
                        <div class="d-flex align-items-center">
                            <!--begin::Wrapper-->
                            <div class="me-5 position-relative">
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Info-->
                            <div class="d-flex flex-column justify-content-center">
                                <a href="" class="mb-1 text-gray-800 text-hover-primary">@isset($d->name)
                                    {{$d->name}}
                                    @endisset</a>
                                {{-- <div class="text-gray-500 fw-semibold fs-6">smith@kpmg.com</div> --}}
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                    </td>
                    <td>@isset($d->lab_group_number)
                        {{$d->lab_group_number}}
                        @endisset</td>
                    <td data-order="2025-08-19T00:00:00+05:00">@isset($d->report_date){{ $d->report_date }}@endisset
                    </td>
                    <td data-order="2025-08-19T00:00:00+05:00">@isset($d->received_date){{ $d->received_date }}@endisset
                    </td>

                    {{-- @if(checkPersonPermission('change_lab_test_status_lab_group_detail_56')) --}}
                    <td>
                        @if ( $d->status === 'pending')
                        <span class="badge badge-warning p-2">Pending</span>
                        @elseif ( $d->status === 'completed')
                        <span class="badge badge-success p-2">Completed</span>
                        @elseif ( $d->status === 'cancelled')
                        <span class="badge badge-danger p-2">Cancelled</span>
                        @elseif ( $d->status === 'collected')
                        <span class="badge badge-primary p-2">Collected</span>
                        @endif
                    </td>
                    {{-- @endif --}}

                    @if(checkPersonPermission('download_lab_test_lab_group_detail_56'))
                    @if ($d->generated_report_pdf_path)
                    <td class="text-center">
                        <a title="Download Lab Report" target="_blank"
                            href="{{route('lab_tests.download',$d->id)}}"><button
                                class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_update_permission">
                                <i class="ki-duotone ki-eye fs-3 text-success">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                            </button>
                        </a>
                    </td>
                    @endif
                    @endif
                </tr>
                @endforeach
                @endif
                @endisset
            </tbody>

        </table>
    </div>
</div>

@endsection
@php
$page = 'lab_tests';
@endphp
@section('scripts')
<script src="{{getAssetsURLs('js/custom/search_partial_lab_groups.js')}}"></script>
<script src="{{getAssetsURLs('js/custom/helper_scripts.js')}}"></script>
<script src="{{ getAssetsURLs('js/custom/select2_lab_groups.js') }}"></script>
@endsection
