@php
    // $page = 'clinical_diagnosis';
    // $sc = 'Clinical Diagnosis';
@endphp
@extends('layouts.master', ['activeMenu' => 'clinical_diagnosis_management', 'activeSubMenu' => 'clinical_diagnosis', 'activeThirdMenu' => 'clinical_diagnosis'])
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
                    Create OPD</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bg-gray-500 bullet w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <a href="{{ route('clinical_diagnosis.index') }}">
                        <span></span>
                        <li class="breadcrumb-item text-muted text-hover-primary">OPD</li>
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
            <!--end::Header-->
            <!--begin::Body-->
            <form class="form" action="{{ route('clinical_diagnosis' . '.store') }}" method="POST" id="cdForm" @if(!$errors->any()) target="_blank" @endif
                enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="card-body">
                    <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. OPD Info</h3>
                    <div class="mb-15">
                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Hospital <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">

                                <label
                                    class="text-right col-form-label">{{ getActiveHospitalName($preferences['preference']['hospital_id']) }}</label>
                                <input type="hidden" name="hospital_id"
                                    value="{{ $preferences['preference']['hospital_id'] }}">

                                <div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Doctor </label>
                            <div class="col-lg-6">
                                <select class="form-control form-select" name="doctor_id" data-live-search="true"
                                    id="kt_select2_2">
                                    <option selected disabled> {{ __('Select Doctor') }}</option>
                                    @isset($doctors)
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ "$doctor->id" === old('doctor_id') ? 'selected' : '' }}>
                                                {{ $doctor->doctor_name }} -
                                                {{ $doctor->department_name }} </option>
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
                                    <option selected disabled> {{ __('Select Patient') }}</option>
                                    @isset($patients)
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}"
                                                {{ "$patient->id" === old('patient_id') ? 'selected' : '' }}>
                                                {{ $patient->name_of_patient }} -
                                                {{ $patient->cnic_number }} - {{ $patient->patient_mr_number }} </option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('patient_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Counter <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select class="form-control form-select" name="counter_id" data-live-search="true" id="kt_select2_1">
                                    <option selected disabled> {{ __('Select Counter') }}</option>
                                    @isset($counters)
                                    @foreach ($counters as $counter)
                                    <option value="{{ $counter->id }}" {{ (old('counter_id', '1' )==$counter->id) ? 'selected' : '' }}>
                                        {{ $counter->name }}
                                    </option>
                                    @endforeach
                                    @endisset
                                </select>
                                @error('counter_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Start Date <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="date" name="start_date" class="form-control" id="start_date"
                                    min="{{ date('Y-m-d') }}" value="{{ old('start_date', now()->format('Y-m-d')) }}">
                                @error('start_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">End Date <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="date" name="end_date" class="form-control" id="end_date"
                                    min="{{ date('Y-m-d') }}" value="{{ old('end_date', now()->format('Y-m-d')) }}">
                                @error('end_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <br>

                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-9"></div>
                        <div class="col-lg-3 text-end">
                            <button type="submit" id="submissionButton" class="mr-2 btn btn-sm btn-primary">Submit & Preview</button>
                            <a href="{{ route('clinical_diagnosis' . '.index') }}"
                                class="btn btn-sm btn-secondary">Cancel</a>
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
    <script src="{{ getAssetsURLs('js/custom/select2_invoices.js') }}"></script>
    {{-- <script>
            $('#submissionButton').on('click', function () {
                let button = $(this);
                button.prop('disabled', true); // Disable the button

                setTimeout(function () {
                    button.prop('disabled', false); // Enable after 5 seconds
                }, 5000);
            });
    </script> --}}
    <script>
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
    <script>
    $(document).ready(function() {
    function getQueryParam(param) {
        let urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    let patient_id = getQueryParam('patient_id');
    $('#kt_select2_1').val(patient_id).trigger('change');;

    //kt_select2_1
});
</script>

    {{-- <script>
        // Function to convert date from YYYY-MM-DD to DD/MM/YYYY
        function formatDate(dateString) {
            const [year, month, day] = dateString.split('-');
            return `${day}/${month}/${year}`;
        }

        // Add event listeners to the date inputs
        document.getElementById('start_date').addEventListener('change', function() {
            const formattedDate = formatDate(this.value);
            this.type = 'text'; // Switch input type to text to show custom format
            this.value = formattedDate;
        });

        document.getElementById('end_date').addEventListener('change', function() {
            const formattedDate = formatDate(this.value);
            this.type = 'text'; // Switch input type to text to show custom format
            this.value = formattedDate;
        });

        // Revert to 'date' type when the user focuses on the input
        document.getElementById('start_date').addEventListener('focus', function() {
            this.type = 'date';
        });

        document.getElementById('end_date').addEventListener('focus', function() {
            this.type = 'date';
        });
    </script> --}}
@endsection

