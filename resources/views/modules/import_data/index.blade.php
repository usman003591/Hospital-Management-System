@php $page='import_opd_data';
$sc = 'Import OPD Data';
$tab = 'complaints';
@endphp
@extends('layouts.master',['activeMenu' => 'settings_management', 'activeSubMenu' => $page, 'activeThirdMenu' => $page])
@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
        data-select2-id="select2-data-kt_app_toolbar_container">
        <!--begin::Page title-->
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <!--begin::Title-->
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                {{ $sc }}</h1>
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
                <a href="{{route('import_opd_data')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{ $sc }}</li>
                </a>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <!--end::Actions-->
    </div>
    <!--end::Toolbar container-->
</div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('include.messages')


            <div class="py-5">
                <div class="p-10 rorder-0 ounded b d-flex flex-column flex-md-row">
                    <ul class="flex-row mb-3 border-0 nav nav-tabs nav-pills flex-md-column me-5 mb-md-0 fs-6 min-w-lg-200px"
                        role="tablist">
                        <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                            <a class="nav-link active w-100 btn btn-flex btn-active-light-primary"
                                data-bs-toggle="tab" id="kt_vtab_pane_4_link" href="#kt_vtab_pane_4" aria-selected="false" tabindex="-1"
                                role="tab">
                                <i class="ki-duotone ki-information-4 fs-1">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                </i>
                                &nbsp;
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-4 fw-bold">Complaints</span>
                                    <span class="fs-7"></span>
                                </span>
                            </a>
                        </li>

                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                href="#kt_vtab_pane_7" id="kt_vtab_pane_7_link"  aria-selected="false" tabindex="-1" role="tab">
                                <i class="ki-duotone ki-magnifier fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                &nbsp;
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-4 fw-bold">GPE</span>
                                    <span class="fs-7"></span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                href="#kt_vtab_pane_8" id="kt_vtab_pane_8_link"  aria-selected="false" tabindex="-1" role="tab">
                                <i class="ki-duotone ki-pulse fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                &nbsp;
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-4 fw-bold">SPE</span>
                                    <span class="fs-7"></span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                href="#kt_vtab_pane_9" id="kt_vtab_pane_9_link" aria-selected="false" tabindex="-1" role="tab">
                                <i class="ki-duotone ki-test-tubes fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                &nbsp;
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-4 fw-bold">Investigations</span>
                                    <span class="fs-7"></span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                href="#kt_vtab_pane_10" id="kt_vtab_pane_10_link"  aria-selected="false" tabindex="-1" role="tab">
                                <i class="ki-duotone ki-virus fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                &nbsp;
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-4 fw-bold">Diagnosis</span>
                                    <span class="fs-7"></span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                href="#kt_vtab_pane_11" id="kt_vtab_pane_11_link"  aria-selected="false" tabindex="-1" role="tab">
                                <i class="ki-duotone ki-syringe fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                &nbsp;
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-4 fw-bold">Medication</span>
                                    <span class="fs-7"></span>
                                </span>
                            </a>
                        </li>


                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                href="#kt_vtab_pane_12" id="kt_vtab_pane_12_link"  aria-selected="false" tabindex="-1" role="tab">
                                <i class="ki-duotone ki-syringe fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                &nbsp;
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-4 fw-bold">Medical Camp</span>
                                    <span class="fs-7"></span>
                                </span>
                            </a>
                        </li>



                    </ul>

                    <div class="tab-content" id="myTabContent">

                        {{-- Complaints tab content starts here --}}
                        <div class="tab-pane fade show active" id="kt_vtab_pane_4" role="tabpanel">
                           @include('modules.import_data.partials.complaints_partial')
                        </div>
                        {{-- Complaints tab content ends here --}}

                        <div class="tab-pane fade" id="kt_vtab_pane_7" role="tabpanel">
                            @include('modules.import_data.partials.gpe_partial')
                        </div>

                        <div class="tab-pane fade" id="kt_vtab_pane_8" role="tabpanel">
                            @include('modules.import_data.partials.spe_partial')
                        </div>

                        <div class="tab-pane fade" id="kt_vtab_pane_9" role="tabpanel">
                            @include('modules.import_data.partials.investigations_partial')
                        </div>

                        <div class="tab-pane fade" id="kt_vtab_pane_10" role="tabpanel">
                            @include('modules.import_data.partials.diagnosis_partial')
                        </div>

                        <div class="tab-pane fade" id="kt_vtab_pane_11" role="tabpanel">
                            @include('modules.import_data.partials.treatment_partial')
                        </div>

                        <div class="tab-pane fade" id="kt_vtab_pane_12" role="tabpanel">
                            @include('modules.import_data.partials.medical_camp')
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{getAssetsURLs('js/custom/helper_scripts.js')}}"></script>
<script>
</script>
@endsection
