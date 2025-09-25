@extends('layouts.master',['activeMenu' => 'performance', 'activeSubMenu' => 'doctor_dashboard', 'activeThirdMenu' => 'doctor_dashboard'])
@section('styles')
<link href="{{getAssetsURLs('plugins/custom/vis-timeline/vis-timeline.bundle.css')}}" rel="stylesheet" type="text/css">
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
                {{getActiveHospitalName($preferences['preference']['hospital_id'] )}} </h1>
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
                <a href="">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">
                        {{getActiveHospitalName($preferences['preference']['hospital_id'] )}}</li>
                </a>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="gap-2 d-flex align-items-center gap-lg-3" data-select2-id="select2-data-122-cw9r">
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar container-->
</div>
@endsection
@section('content')
@include('include.messages')
@if (checkPersonPermission('dashboard_stats_doctor_dashboard_75'))
<div class="mb-0 row g-5 gx-xl-10 mb-xl-0">

    <div class="col-xl-4">
        <!--begin::Card widget 3-->
        <a href="{{ route('clinical_diagnosis.myDailyListingRecord') }}">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100"
                style="background-color: #000000;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">

                <!--begin::Header-->
                <div class="pt-5 mb-3 card-header">
                    <!--begin::Icon-->
                    <div class="d-flex flex-center rounded-circle h-80px w-80px"
                        style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #000000">
                        <i class="text-white ki-duotone ki-pulse fs-2qx lh-0">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                            <span class="path6"></span>
                            <span class="path7"></span>
                            <span class="path8"></span>
                        </i>
                    </div>
                    <!--end::Icon-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="mb-3 card-body d-flex align-items-end">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center">
                        <span class="text-white fs-4hx fw-bold me-6">@isset($d['all_patients_count'])
                            {{$d['all_patients_count']}} @endisset</span>
                        <div class="text-white fw-bold fs-6">
                            <span class="d-block">Tody's</span>
                            <span class="">All Patients</span>
                        </div>
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <!--end::Card footer-->
            </div>
            <!--end::Card widget 3-->
        </a>
    </div>


    <div class="col-xl-4">
        <a href="{{ route('clinical_diagnosis.myDailyListingRecord') }}">
            <!--begin::Card widget 3-->
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100"
                style="background-color: #000000;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
                <!--begin::Header-->
                <div class="pt-5 mb-3 card-header">
                    <!--begin::Icon-->
                    <div class="d-flex flex-center rounded-circle h-80px w-80px"
                        style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #000000">
                        <i class="text-white ki-duotone ki-thermometer fs-2qx lh-0">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                            <span class="path6"></span>
                            <span class="path7"></span>
                            <span class="path8"></span>
                        </i>
                    </div>
                    <!--end::Icon-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="mb-3 card-body d-flex align-items-end">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center">
                        <span class="text-white fs-4hx fw-bold me-6">@isset($d['pending_patient_count'])
                            {{$d['pending_patient_count']}} @endisset</span>
                        <div class="text-white fw-bold fs-6">
                            <span class="d-block">Today's</span>
                            <span class="">Pending Patients</span>
                        </div>
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->

                <!--end::Card footer-->
            </div>
            <!--end::Card widget 3-->
        </a>
    </div>

    <div class="col-xl-4">
        <a href="{{ route('clinical_diagnosis.myDailyListingRecord') }}">
            <!--begin::Card widget 3-->
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100"
                style="background-color: #000000;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
                <!--begin::Header-->
                <div class="pt-5 mb-3 card-header">
                    <!--begin::Icon-->
                    <div class="d-flex flex-center rounded-circle h-80px w-80px"
                        style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #000000">
                        <i class="text-white ki-duotone ki-syringe fs-2qx lh-0">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                            <span class="path6"></span>
                            <span class="path7"></span>
                            <span class="path8"></span>
                        </i>
                    </div>
                    <!--end::Icon-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="mb-3 card-body d-flex align-items-end">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center">
                        <span class="text-white fs-4hx fw-bold me-6">@isset($d['referred_patient_count'])
                            {{$d['referred_patient_count']}} @endisset</span>
                        <div class="text-white fw-bold fs-6">
                            <span class="d-block">Today's</span>
                            <span class="">Referred Patients</span>
                        </div>
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->

                <!--end::Card footer-->
            </div>
            <!--end::Card widget 3-->
        </a>
    </div>
    <!--begin::Col-->
    {{-- <div class="mb-5 col-xxl-6 mb-xl-2">
        <!--begin::Tiles Widget 5-->
        <a href="{{route('patients.create')}}" class="card card-xxl-stretch bg-primary">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column justify-content-between">
                <i class="text-white ki-duotone ki-plus-square fs-4hx ms-n1 flex-grow-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <div class="d-flex flex-column">
                    <div class="mt-5 mb-0 text-white fw-bold fs-1"></div>
                    <div class="text-white fw-semibold fw-bold fs-4">New Registration</div>
                </div>
            </div>
            <!--end::Body-->
        </a>
        <!--end::Tiles Widget 5-->
    </div> --}}
    <!--end::Col-->
    <!--begin::Col-->

    <!--end::Col-->
    <!--begin::Col-->

    <!--end::Col-->
</div>
@endif

@endsection
