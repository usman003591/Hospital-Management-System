@extends('layouts.master',['activeMenu' => 'performance', 'activeSubMenu' => 'pathology_dashboard', 'activeThirdMenu' =>'pathology_dashboard'])
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
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <a href="">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Pathology Dashboard</li>
                </a>
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
@if (checkPersonPermission('dashboard_actions_pathology_dashboard_74'))
<div class="row gy-5 g-xl-12">
    <div class="col-sm-6 col-xl-4 mb-xl-10">
        <a href="{{route('lab_groups.create')}}">
        <div class="card h-lg-60" style="background-color: #0148a5">
            <div class="card-body">
                <div class="m-0 d-flex justify-content-between align-items-start flex-column">
                   <i class="text-white ki-duotone ki-plus-square fs-6hx ms-n1 flex-grow-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                </div>
                <div class="d-flex flex-column align-items-start my-7">
                    <div class="m-0">
                        <span class="text-white fw-semibold fs-1">Add New Lab Record</span>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-4 mb-xl-10">
        <a href="{{route('lab_groups.index')}}">
        <div class="card h-lg-60" style="background-color: #0148a5">
            <div class="card-body">
                <div class="m-0 d-flex justify-content-between align-items-start flex-column">
                   <i class="text-white ki-duotone ki-magnifier fs-6hx ms-n1 flex-grow-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                </div>
                <div class="d-flex flex-column align-items-start my-7">
                    <div class="m-0">
                        <span class="text-white fw-semibold fs-1">Search Lab Record</span>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
        <div class="col-sm-6 col-xl-4 mb-xl-10">
        <a href="{{route('clinical_diagnosis.index')}}">
        <div class="card h-lg-60" style="background-color: #0148a5">
            <div class="card-body">
                <div class="m-0 d-flex justify-content-between align-items-start flex-column">
                   <i class="text-white ki-duotone ki-magnifier fs-6hx ms-n1 flex-grow-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                </div>
                <div class="d-flex flex-column align-items-start my-7">
                    <div class="m-0">
                        <span class="text-white fw-semibold fs-1">Search OPD Investigations</span>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
</div>
@endif
@if (checkPersonPermission('dashboard_stats_pathology_dashboard_74'))
<div class="mb-5 row g-5 g-xl-10 mb-xl-10">
    <div class="col-xxl-12">
        <div class="row g-5 g-xl-10">
            <div class="col-md-4">
                <div class="card card-flush h-xl-100" style="background-color: #01a54e">
                    <div class="pt-5 card-header flex-nowrap">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="text-white card-label fw-bold fs-4">Daily Amount</span>
                            <span class="mt-1 fw-semibold fs-7" style="color:"></span>
                        </h3>
                    </div>
                    <div class="pt-5 text-center card-body">
                        <img src="assets/media/svg/illustrations/easy/1.svg" class="mb-5 h-125px" alt="">
                        <div class="text-start">
                            <span class="text-white d-block fw-bold fs-1">{{ $stats['daily']['total_amount'] }} Rs/- Total</span>
                            <span class="text-white mt-1 fw-semibold fs-3" style="color:">{{ $stats['daily']['discount_amount'] }} Rs/- Discount</span><br>
                            <span class="text-white mt-1 fw-semibold fs-3" style="color:">{{ $stats['daily']['received_amount'] }} Rs/- Received</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-flush h-xl-100" style="background-color: #c31318">
                    <div class="pt-5 card-header flex-nowrap">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="text-white card-label fw-bold fs-4">Weekly Amount</span>
                            <span class="mt-1 fw-semibold fs-7" style="color:"></span>
                        </h3>
                    </div>
                    <div class="pt-5 text-center card-body">
                        <img src="assets/media/svg/illustrations/easy/1.svg" class="mb-5 h-125px" alt="">
                        <div class="text-start">
                            <span class="text-white d-block fw-bold fs-1">{{ $stats['weekly']['total_amount'] }} Rs/- Total</span>
                            <span class="text-white mt-1 fw-semibold fs-3" style="color:">{{ $stats['weekly']['discount_amount'] }} Rs/- Discount</span><br>
                            <span class="text-white mt-1 fw-semibold fs-3" style="color:">{{ $stats['weekly']['received_amount'] }} Rs/- Received</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-flush h-xl-100" style="background-color: #f5811e">
                    <div class="pt-5 card-header flex-nowrap">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="text-white card-label fw-bold fs-4">Monthly Amount</span>
                            <span class="mt-1 fw-semibold fs-7" style="color:"></span>
                        </h3>
                    </div>
                    <div class="pt-5 text-center card-body">
                        <img src="assets/media/svg/illustrations/easy/1.svg" class="mb-5 h-125px" alt="">
                        <div class="text-start">
                            <span class="text-white d-block fw-bold fs-1">{{ $stats['monthly']['total_amount'] }} Rs/- Total</span>
                            <span class="text-white mt-1 fw-semibold fs-3" style="color:">{{ $stats['monthly']['discount_amount'] }} Rs/- Discount</span><br>
                            <span class="text-white mt-1 fw-semibold fs-3" style="color:">{{ $stats['monthly']['received_amount'] }} Rs/- Received</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
