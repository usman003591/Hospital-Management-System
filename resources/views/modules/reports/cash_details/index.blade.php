@php $page='cash_details_report'; @endphp
@extends('layouts.master',['activeMenu' => 'reports_management', 'activeSubMenu' => $page, 'activeThirdMenu' => $page])
@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
        data-select2-id="select2-data-kt_app_toolbar_container">
        <!--begin::Page title-->
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <!--begin::Title-->
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                Generate Reports</h1>
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
                    <li class="breadcrumb-item text-muted text-hover-primary">{{titleFilter($page)}}</li>
                </a>
                <!--end::Item-->

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Create</li>
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
<div class="col-xl-12">

    <!--begin::List Widget 8-->
    <div class="mb-5 card card-xl-stretch mb-xl-8">
        <!--begin::Header-->
        <div class="mt-4 border-0 card-header align-items-center">
            <h3 class="card-title align-items-start flex-column">
                <span class="text-gray-900 fw-bold">Generate</span>
                {{-- <span class="mt-1 text-muted fw-semibold fs-7">Gifts and more</span> --}}
            </h3>
            <div class="card-toolbar">
            </div>
        </div>
        <!--end::Header-->


        <!--begin::Body-->
        <form class="form" action="{{route($page.'.store')}}" method="POST" enctype="multipart/form-data"
            class="needs-validation" novalidate>
            @csrf
            <div class="card-body">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. {{titleFilter($page)}}</h3>
                <div class="mb-15">

                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">{{titleFilter($page)}} Duration <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                                <input class="form-control form-control-solid" name="date_range" placeholder="Pick date rage" id="kt_daterangepicker_1"/>
                        </div>
                    </div>
                </div>
                <br>

            </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-9"></div>
            <div class="col-lg-3 text-end">
                @if(checkPersonPermission('download_reports_section_9'))
                <button type="submit" class="mr-2 btn btn-sm btn-primary">Download {{titleFilter($page)}}</button>
                @endif
                <a href="{{route('dashboard')}}" class="btn btn-sm btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
    </form>
    <!--end::Body-->
</div>
<!--end::List Widget 8-->
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>

<script>
    $("#kt_daterangepicker_1").daterangepicker();
    (function () {
    'use strict'

    var forms = document.querySelectorAll('.needs-validation')

    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()
</script>
@endsection
