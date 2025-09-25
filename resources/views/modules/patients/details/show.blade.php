@php $page='patients';@endphp
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
                {{titleFilter($page)}} List</h1>
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
                <a href="{{route('patients.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{titleFilter($page)}}</li>
                </a>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="{{route($page.'.detail_page', ['id' => $patient->id])}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Details</li>
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

@include('modules.patients.details.include.nav_partial',['tab' => 'overview'])
<div class="mb-0 row g-5 gx-xl-10 mb-xl-0">
    <!--begin::Col-->
    <div class="mb-5 col-xxl-6 mb-xl-2">
        <!--begin::Tiles Widget 5-->
        <a href="{{route('patients.opd_record',$patient->id)}}" class="card card-xxl-stretch bg-primary">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column justify-content-between">
                <i class="text-white ki-duotone ki-information-4 fs-4hx ms-n1 flex-grow-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <div class="d-flex flex-column">
                    <div class="mt-5 mb-0 text-white fw-bold fs-1"></div>
                    <div class="text-white fw-semibold fw-bold fs-4">@isset($patients_count) {{$patients_count}} @endisset OPD Visits</div>
                </div>
            </div>
            <!--end::Body-->
        </a>
        <!--end::Tiles Widget 5-->
    </div>
    <!--end::Col-->
    <!--begin::Col-->
    <div class="mb-5 col-xxl-6 mb-xl-2">
        <!--begin::Tiles Widget 5-->
        <a href="{{route('patients.invoice_record',$patient->id)}}" class="card card-xxl-stretch bg-primary">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column justify-content-between">
                <i class="text-white ki-duotone ki-text-align-justify-center fs-4hx ms-n1 flex-grow-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <div class="d-flex flex-column">
                    <div class="mt-5 mb-0 text-white fw-bold fs-1"></div>
                    <div class="text-white fw-semibold fw-bold fs-4">@isset($invoices_count) {{$invoices_count}} @endisset Invoices </div>
                </div>
            </div>
            <!--end::Body-->
        </a>
        <!--end::Tiles Widget 5-->
    </div>
    <!--end::Col-->
    <!--begin::Col-->
    {{-- <div class="mb-5 col-xxl-4 mb-xl-2">
        <!--begin::Tiles Widget 5-->
        <a href="{{route('service_categories.index')}}" class="card card-xxl-stretch bg-primary">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column justify-content-between">
                <i class="text-white ki-duotone ki-abstract-26 fs-4hx ms-n1 flex-grow-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <div class="d-flex flex-column">
                    <div class="mt-5 mb-0 text-white fw-bold fs-1"></div>
                    <div class="text-white fw-semibold fw-bold fs-4">Service Categories</div>
                </div>
            </div>
            <!--end::Body-->
        </a>
        <!--end::Tiles Widget 5-->
    </div> --}}
    <!--end::Col-->
</div>
@endsection
@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var appointmentModal = document.getElementById('PatientExDoc');
        appointmentModal.addEventListener('hidden.bs.modal', function () {
            this.querySelector('form').reset();
        });
    });
</script>
<script>
    window.patientConfig = {
        storeUrl: "{{ route('patient_external_documents.store') }}",
        csrfToken: "{{ csrf_token() }}",
        patientId: "{{ $patient->id }}",
        documentsListUrl: "{{ route('patients.documents_list', $patient->id) }}"
    };
</script>
<script src="{{getAssetsURLs('js/custom/patient_ex_docs.js')}}"></script>
@endsection
