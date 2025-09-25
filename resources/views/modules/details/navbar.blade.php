@extends('layouts.master')

    @section('styles')
<link href="{{getAssetsURLs('plugins/custom/vis-timeline/vis-timeline.bundle.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')

<div class="mb-6 card mb-xl-9">
    <div class="pb-0 card-body pt-9">
        <!--begin::Details-->
        <div class="flex-wrap mb-6 d-flex flex-sm-nowrap">

            <!--begin::Wrapper-->
            <div class="flex-grow-1">
                <!--begin::Head-->
                <div class="flex-wrap mb-2 d-flex justify-content-between align-items-start">
                    <!--begin::Details-->
                    <div class="d-flex flex-column">
                        <!--begin::Status-->
                        <div class="mb-1 d-flex align-items-center">
                            <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">CRM Dashboard</a>
                            <span class="badge badge-light-success me-auto">In Progress</span>
                        </div>
                        <!--end::Status-->
                        <!--begin::Description-->
                        <div class="flex-wrap mb-4 text-gray-500 d-flex fw-semibold fs-5">#1 Tool to get started with Web Apps any Kind &amp; size</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Details-->

                </div>
                <!--end::Head-->
                <!--begin::Info-->
                <div class="flex-wrap d-flex justify-content-start">
                    <!--begin::Stats-->
                    <div class="flex-wrap d-flex">
                        <!--begin::Stat-->
                        <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold">29 Jan, 2024</div>
                            </div>
                            <!--end::Number-->
                            <!--begin::Label-->
                            <div class="text-gray-500 fw-semibold fs-6">Due Date</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->
                        <!--begin::Stat-->
                        <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <div class="fs-4 fw-bold counted" data-kt-countup="true" data-kt-countup-value="75" data-kt-initialized="1">75</div>
                            </div>
                            <!--end::Number-->
                            <!--begin::Label-->
                            <div class="text-gray-500 fw-semibold fs-6">Open Tasks</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->
                        <!--begin::Stat-->
                        <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <div class="fs-4 fw-bold counted" data-kt-countup="true" data-kt-countup-value="15000" data-kt-countup-prefix="$" data-kt-initialized="1">$15,000</div>
                            </div>
                            <!--end::Number-->
                            <!--begin::Label-->
                            <div class="text-gray-500 fw-semibold fs-6">Budget Spent</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->
                    </div>
                    <!--end::Stats-->

                </div>
                <!--end::Info-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Details-->
        <div class="separator"></div>
        <!--begin::Nav-->
        <ul class="border-transparent nav nav-stretch nav-line-tabs nav-line-tabs-2x fs-5 fw-bold">
            <!--begin::Nav item-->
            <li class="nav-item">
                <a class="py-5 nav-link text-active-primary me-6 active" href="apps/projects/project.html">Overview</a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item">
                <a class="py-5 nav-link text-active-primary me-6" href="apps/projects/targets.html">Reports</a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item">
                <a class="py-5 nav-link text-active-primary me-6" href="apps/projects/budget.html">Clinical Diagnosis</a>
            </li>
            <!--end::Nav item-->
        </ul>
        <!--end::Nav-->
    </div>
</div>
    <!--end::Header menu toggle-->
    <!--begin::Aside toggle-->
    <!--end::Header menu toggle-->

@endsection
