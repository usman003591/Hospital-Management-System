@php $page='service_categories';
$sc = 'Service Category';
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
                Create {{ $sc }}</h1>
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
                <a href="{{route('service_categories.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Service Categories</li>
                </a>
                <!--end::Item-->

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="{{route('service_categories.create')}}">
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
        <form class="form" action="{{route($page.'.store')}}" method="POST" enctype="multipart/form-data"
            class="needs-validation" novalidate>
            @csrf
            <div class="card-body">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. {{ $sc }} Info</h3>
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
                        <label class="text-right col-lg-3 col-form-label">Service Name <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" name="service_name" class="form-control"
                                value="{{ old('service_name') }}" placeholder="Enter service name" maxlength="50" {{--
                                oninput="this.value = this.value.replace(/[^a-zA-Z\s.\-(){0-9}]/g, '')" --}} />
                            <div>
                                @error('service_name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Default Amount <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="number" name="default_amount" class="form-control"
                                value="{{ old('default_amount') }}" placeholder="Enter default amount" min="0"
                                oninput="this.value = this.value.replace(/\D/g, '').substring(0, 12)" />
                            <div>
                                @error('default_amount')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Employee Amount <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="number" name="employee_amount" class="form-control"
                                value="{{ old('employee_amount') }}" placeholder="Enter employee amount" min="0"
                                oninput="this.value = this.value.replace(/\D/g, '').substring(0, 12)" />

                            <div>
                                @error('employee_amount')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Resident Amount <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="number" name="resident_amount" class="form-control"
                                value="{{ old('resident_amount') }}" placeholder="Enter resident amount" min="0"
                                oninput="this.value = this.value.replace(/\D/g, '').substring(0, 12)" />
                            <div>
                                @error('resident_amount')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Parent</label>
                        <div class="col-lg-6">
                            <select class="mb-2 form-control mb-md-0 selectComplaint" name="parent_id"
                                data-live-search="true" id="symptomSelect" placeholder="Select complaint">
                                <option selected disabled> {{ __('Select Parent')}}</option>
                                @isset($serviceCategories)
                                @foreach ($serviceCategories as $item)
                                <option value="{{$item->id}}"> {{$item->service_name}} </option>
                                @endforeach
                                @endisset
                            </select>
                        </div>
                    </div>


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
