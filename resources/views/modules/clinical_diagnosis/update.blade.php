@php $page='clinical_diagnosis';
$sc = 'OPD';
@endphp
@extends('layouts.master',['activeMenu' => 'clinical_diagnosis_management', 'activeSubMenu' => $page, 'activeThirdMenu'
=> $page])
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
                Update {{ $sc }}</h1>
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
                <a href="{{route('clinical_diagnosis.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{$sc}}</li>
                </a>
                <!--end::Item-->

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Update</li>
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
        <!--end::Header-->
        <!--begin::Body-->
        <form class="form" action="{{route($page.'.update', $obj->id)}}" method="POST" enctype="multipart/form-data"
            class="needs-validation" novalidate>
            @csrf
            @method('PATCH')
            <div class="card-body">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. OPD Info</h3>
                <div class="mb-15">

                    {{-- <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Doctor <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control form-select" name="doctor_id" data-live-search="true"
                                id="kt_select2_2">
                                <option selected disabled> {{ __('Select Doctor')}}</option>
                                @isset($doctors)
                                @foreach ($doctors as $doctor)
                                <option value="{{$doctor->id}}"> {{$doctor->doctor_name}} - {{ $doctor->department_name
                                    }} </option>
                                @endforeach
                                @endisset
                            </select>
                            @error('doctor_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br> --}}
                    <input type="hidden" name="cd_id" value="{{ $obj->id }}">
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Hospital <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">

                            <label
                                class="text-right col-form-label">{{getActiveHospitalName($obj->hospital_id)}}</label>
                            <input type="hidden" name="hospital_id" value="{{$obj->hospital_id}}">

                            <div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Doctor <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control form-select" name="doctor_id" data-live-search="true"
                                id="kt_select2_2">
                                {{-- <option selected disabled> {{ __('Select Doctor')}}</option> --}}

                                @isset($doctors)
                                @foreach ($doctors as $doctor)
                                <option value="{{$doctor->id}}"
                                    @if (isset($doctor_info) && $doctor_info->doctor_id == $doctor->id) selected @endif>
                                    {{$doctor->doctor_name}} - {{ $doctor->department_name }}
                                </option>

                                @endforeach
                                @endisset
                            </select>
                            @error('doctor_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br>

                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Patient <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control form-select" name="patient_id" data-live-search="true"
                                id="kt_select2_1">
                                <option selected disabled> {{ __('Select Patient')}}</option>
                                @isset($patients)
                                @foreach ($patients as $patient)
                                <option value="{{$patient->id}}" @if ($obj->patient_id === $patient->id) selected
                                    @endif> {{$patient->name_of_patient}} - {{$patient->cnic_number}} -
                                    {{$patient->patient_mr_number}} </option>
                                @endforeach
                                @endisset
                            </select>
                            @error('patient_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br>

                    {{-- <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Start Date <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="date" name="start_date" class="form-control" id="start_date"
                                value="{{$doctor_info->start_date}}">
                            @error('start_date')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br> --}}

                    {{-- <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">End Date <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="date" name="end_date" class="form-control" id="end_date"
                                value="{{$doctor_info->end_date}}">
                            @error('end_date')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br> --}}

                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-9"></div>
                    <div class="col-lg-3 text-end">
                        <button type="submit" class="mr-2 btn btn-sm btn-primary">Submit</button>
                        <a href="{{route($page.'.index')}}" class="btn btn-sm btn-secondary">Cancel</a>
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
<script src="{{getAssetsURLs('js/custom/select2_invoices.js')}}"></script>
<script>
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
