@extends('layouts.master',['activeMenu' => 'performance', 'activeSubMenu' => 'finance_dashboard', 'activeThirdMenu'
=>'finance_dashboard'])
@section('styles')
<link href="{{getAssetsURLs('plugins/custom/vis-timeline/vis-timeline.bundle.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('breadcrumbs')
@include('include.global_search')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
        data-select2-id="select2-data-kt_app_toolbar_container">
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                {{getActiveHospitalName($preferences['preference']['hospital_id'] )}} </h1>
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <a href="">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">
                        {{getActiveHospitalName($preferences['preference']['hospital_id'] )}}</li>
                </a>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <a href="">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Finance Dashboard</li>
                </a>
            </ul>
        </div>
        <div class="gap-2 d-flex align-items-center gap-lg-3" data-select2-id="select2-data-122-cw9r">
        </div>
    </div>
</div>
@endsection
@section('content')
@include('include.messages')
@if (checkPersonPermission('dashboard_stats_finance_dashboard_76'))
<div class="mb-5 row g-5 g-xl-10 mb-xl-10">
    <div class="col-xxl-12">
        <div class="row g-5 g-xl-10">
            <div class="col-md-4">
                <a href="{{route('finance.service_categories_invoices_verification')}}">
                <div class="card card-flush h-xl-100" style="background-color: #01a54e">
                    <div class="pt-5 card-header flex-nowrap">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="text-white card-label fw-bold fs-4">Services Invoices</span>
                            <span class="mt-1 fw-semibold fs-7" style="color:"></span>
                        </h3>
                    </div>
                    <div class="pt-5 text-center card-body">
                        <img src="assets/media/svg/illustrations/easy/1.svg" class="mb-5 h-125px" alt="">
                        <div class="text-start">
                            <span class="text-white d-block fw-bold fs-1">@isset($services_invoice_stats) {{$services_invoice_stats['total_invoices']}} @endisset Total Invoices</span>
                            <span class="mt-1 fw-semibold fs-3" style="color:">@isset($services_invoice_stats) {{$services_invoice_stats['verified_invoices']}} @endisset Verified</span><br>
                            <span class="mt-1 fw-semibold fs-3" style="color:">@isset($services_invoice_stats) {{$services_invoice_stats['unverified_invoices']}} @endisset Un Verified</span>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{route('finance.pathology_invoices_verification')}}">
                <div class="card card-flush h-xl-100" style="background-color: #c31318">
                    <div class="pt-5 card-header flex-nowrap">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="text-white card-label fw-bold fs-4">Pathology Invoices</span>
                            <span class="mt-1 fw-semibold fs-7" style="color:"></span>
                        </h3>
                    </div>
                    <div class="pt-5 text-center card-body">
                        <img src="assets/media/svg/illustrations/easy/1.svg" class="mb-5 h-125px" alt="">
                        <div class="text-start">
                            <span class="text-white d-block fw-bold fs-1">@isset($pathology_invoice_stats) {{$pathology_invoice_stats['total_invoices']}} @endisset Total Invoices</span>
                            <span class="mt-1 fw-semibold fs-3" style="color:">@isset($pathology_invoice_stats) {{$pathology_invoice_stats['verified_invoices']}} @endisset Verified</span><br>
                            <span class="mt-1 fw-semibold fs-3" style="color:">@isset($pathology_invoice_stats) {{$pathology_invoice_stats['unverified_invoices']}} @endisset Un Verified</span>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{route('finance.pharmacy_invoices_verification')}}">
                <div class="card card-flush h-xl-100" style="background-color: #f5811e">
                    <div class="pt-5 card-header flex-nowrap">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="text-white card-label fw-bold fs-4">Pharmacy Invoices</span>
                            <span class="mt-1 fw-semibold fs-7" style="color:"></span>
                        </h3>
                    </div>
                    <div class="pt-5 text-center card-body">
                        <img src="assets/media/svg/illustrations/easy/1.svg" class="mb-5 h-125px" alt="">
                        <div class="text-start">
                            <span class="text-white d-block fw-bold fs-1">@isset($pharmacy_invoice_stats) {{$pharmacy_invoice_stats['total_invoices']}} @endisset Total Invoices</span>
                            <span class="mt-1 fw-semibold fs-3" style="color:">@isset($pharmacy_invoice_stats) {{$pharmacy_invoice_stats['verified_invoices']}} @endisset Verified</span><br>
                            <span class="mt-1 fw-semibold fs-3" style="color:">@isset($pharmacy_invoice_stats) {{$pharmacy_invoice_stats['unverified_invoices']}} @endisset Un Verified</span>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
