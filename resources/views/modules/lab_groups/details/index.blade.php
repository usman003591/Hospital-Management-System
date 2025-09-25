@php $page='lab_groups'; @endphp
@extends('layouts.master',['activeMenu' => 'pathology_management', 'activeSubMenu' => 'lab_groups', 'activeThirdMenu' =>
'lab_groups'])
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
                    <li class="breadcrumb-item text-muted text-hover-primary">Detail</li>
                </a>
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->

    </div>
    <!--end::Toolbar container-->
</div>
@include('modules.'.$page.'.details.modals.delete', [$page => 'lab_tests'])
@include('modules.'.$page.'.details.modals.add_tests', [$page => 'lab_tests'])

@endsection
@section('content')
@include('modules.lab_groups.details.include.nav_partial',['tab' => 'overview'])
@include('include.messages')
<div class="col-xl-12">
											<!--begin::Card widget 19-->
											<div class="card card-flush h-lg-100">
												<!--begin::Header-->
												<div class="pt-5 card-header">
													<!--begin::Title-->
													<h3 class="card-title align-items-start flex-column">
														<span class="text-gray-900 card-label fw-bold">Lab Group #@isset($lab_group_data->lab_group_number) {{$lab_group_data->lab_group_number}} @endisset Stats</span>
													</h3>
													<!--end::Title-->
													<!--begin::Toolbar-->
													<!--end::Toolbar-->
												</div>
												<!--end::Header-->
												<!--begin::Card body-->
												<div class="pt-6 card-body d-flex align-items-end">
													<!--begin::Row-->
													<div class="mx-0 row align-items-center w-100">
														<!--begin::Col-->
														<div class="px-0 col-7">
															<!--begin::Labels-->
															<div class="d-flex flex-column content-justify-center">
																<!--begin::Label-->
																<div class="d-flex fs-6 fw-semibold align-items-center">
																	<!--begin::Bullet-->
																	<div class="bullet bg-info me-3" style="border-radius: 3px;width: 12px;height: 12px"></div>
																	<!--end::Bullet-->
																	<!--begin::Label-->
																	<div class="text-gray-600 fs-5 fw-bold me-5">Total :</div>
																	<!--end::Label-->
																	<!--begin::Stats-->
																	<div class="text-gray-700 ms-auto fw-bolder text-end">{{$lab_group_stats['total']}}</div>
																	<!--end::Stats-->
																</div>
																<!--end::Label-->
																<!--begin::Label-->
																<div class="my-4 d-flex fs-6 fw-semibold align-items-center">
																	<!--begin::Bullet-->
																	<div class="bullet bg-primary me-3" style="border-radius: 3px;width: 12px;height: 12px"></div>
																	<!--end::Bullet-->
																	<!--begin::Label-->
																	<div class="text-gray-600 fs-5 fw-bold me-5">Pending:</div>
																	<!--end::Label-->
																	<!--begin::Stats-->
																	<div class="text-gray-700 ms-auto fw-bolder text-end">{{$lab_group_stats['pending']}}</div>
																	<!--end::Stats-->
																</div>
																<!--end::Label-->
																<!--begin::Label-->
																<div class="d-flex fs-6 fw-semibold align-items-center">
																	<!--begin::Bullet-->
																	<div class="bullet bg-success me-3" style="border-radius: 3px;background-color: #E4E6EF;width: 12px;height: 12px"></div>
																	<!--end::Bullet-->
																	<!--begin::Label-->
																	<div class="text-gray-600 fs-5 fw-bold me-5">Collected:</div>
																	<!--end::Label-->
																	<!--begin::Stats-->
																	<div class="text-gray-700 ms-auto fw-bolder text-end">{{$lab_group_stats['collected']}}</div>
																	<!--end::Stats-->
																</div>
																<!--end::Label-->
															</div>
															<!--end::Labels-->
														</div>
														<!--end::Col-->
														<!--begin::Col-->
														{{-- <div class="px-0 col-5 d-flex justify-content-end">
															<!--begin::Chart-->
															<div id="kt_card_widget_19_chart" class="min-h-auto h-150px w-150px" data-kt-size="150" data-kt-line="25"><span></span><canvas height="150" width="150"></canvas></div>
															<!--end::Chart-->
														</div> --}}
														<!--end::Col-->
													</div>
													<!--end::Row-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Card widget 19-->
										</div>
@endsection
