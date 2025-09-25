@extends('layouts.master', ['activeMenu' => 'appointment_management', 'activeSubMenu' => $page,
'activeThirdMenu' => $page])
@section('breadcrumbs')
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
                <a href="{{route($page.'.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{titleFilter($page)}}</li>
                </a>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="#">
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
<div class="mb-5 card mb-xxl-8">
    <div class="card-body pt-9 pb-7">
        <div class="mb-2 d-flex align-items-center justify-content-center">
            <a class="text-gray-900 text-hover-primary fs-1 fw-bold me-1">@isset($appointmentReq->hospital_name)
                {{$appointmentReq->hospital_name}}
                @endisset</a>
        </div>
    </div>
</div>
<div class="mb-5 card mb-xxl-8">
    @if ($appointmentReq->is_visitor == 1)
    <div class="pb-0 card-body pt-9">
        <!--begin::Details-->
        <div class="flex-wrap d-flex flex-sm-nowrap">

            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="flex-wrap mb-2 d-flex justify-content-between align-items-start">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->


                        <div class="mb-2 d-flex align-items-center">
                            <p class="text-gray-900 fs-4 fw-bold me-1">
                                Patient Details</p>
                        </div>
                        <div class="mb-2 d-flex align-items-center">
                            <p class="text-gray-900 fs-1 fw-bold me-1">
                                @isset($appointmentReq->patient_name)
                                {{titleFilter($appointmentReq->patient_name)}}
                                @endisset</p>
                        </div>
                        <!--end::Name-->
                        <!--begin::Info-->
                        <div class="flex-wrap mb-4 d-flex fw-semibold fs-6 pe-2">

                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary">
                                <i class="ki-duotone ki-sms fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>@isset($appointmentReq->patient_email)
                                {{$appointmentReq->patient_email}}
                                @endisset</a>
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->

                </div>
                <!--end::Title-->
                <!--begin::Stats-->
                <div class="flex-wrap d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <!--begin::Stats-->
                        <div class="flex-wrap d-flex">


                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        @isset($appointmentReq->patient_cnic_number)
                                        {{$appointmentReq->patient_cnic_number}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">CNIC</div>
                                <!--end::Label-->
                            </div>

                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        @isset($appointmentReq->patient_number)
                                        {{$appointmentReq->patient_number}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Phone Number</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->


                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Wrapper-->

                </div>
                <!--end::Stats-->
            </div>

            <div class="text-center">
                <a href="{{route('patients.create')}}" class="btn btn-sm btn-primary">Register</a>
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->
        <!--begin::Navs-->
        <br>

    </div>
    @else
    <div class="pb-0 card-body pt-9">
        <!--begin::Details-->
        <div class="flex-wrap d-flex flex-sm-nowrap">

            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="flex-wrap mb-2 d-flex justify-content-between align-items-start">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->


                        <div class="mb-2 d-flex align-items-center">
                            <p class="text-gray-900 fs-4 fw-bold me-1">
                                Patient Details</p>
                        </div>
                        <div class="mb-2 d-flex align-items-center">
                            <p class="text-gray-900 fs-1 fw-bold me-1">
                                @isset($appointmentReq->name_of_patient)
                                {{titleFilter($appointmentReq->name_of_patient)}}
                                @endisset</p>
                        </div>
                        <!--end::Name-->
                        <!--begin::Info-->
                        <div class="flex-wrap mb-4 d-flex fw-semibold fs-6 pe-2">
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>@isset($appointmentReq->patient_category)
                                {{titleFilter($appointmentReq->patient_category)}}
                                @endisset</a>
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                <i class="ki-duotone ki-geolocation fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>@isset($appointmentReq->address)
                                {{ucfirst($appointmentReq->address)}}
                                @endisset</a>
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary">
                                <i class="ki-duotone ki-sms fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>@isset($appointmentReq->email)
                                {{$appointmentReq->email}}
                                @endisset</a>
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->

                </div>
                <!--end::Title-->
                <!--begin::Stats-->
                <div class="flex-wrap d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <!--begin::Stats-->
                        <div class="flex-wrap d-flex">

                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">

                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="80"
                                        data-kt-initialized="1">@isset($appointmentReq->patient_mr_number)
                                        {{$appointmentReq->patient_mr_number}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">MR Number</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">

                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        @isset($appointmentReq->cnic_number)
                                        {{$appointmentReq->cnic_number}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">CNIC</div>
                                <!--end::Label-->
                            </div>

                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">

                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        @isset($appointmentReq->cnic_number)
                                        {{$appointmentReq->cell}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Phone Number</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            @isset($appointmentReq->blood_group)
                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">

                                    <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                        data-kt-countup-value="4500" data-kt-countup-prefix="$" data-kt-initialized="1">
                                        {{$appointmentReq->blood_group}}
                                        </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Blood Group</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            @endisset
                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">

                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">@isset($appointmentReq->age)
                                        {{$appointmentReq->age}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Age</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">

                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        @isset($appointmentReq->gender)
                                        {{ucfirst($appointmentReq->gender)}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Gender</div>
                                <!--end::Label-->
                            </div>

                            <!--end::Stat-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Wrapper-->

                </div>
                <!--end::Stats-->
            </div>


            <!--end::Info-->
        </div>
        <!--end::Details-->
        <!--begin::Navs-->
        <br>

    </div>
    @endif
</div>

{{-- second card begins here --}}
<div class="mb-5 card mb-xxl-8">
    <div class="pb-0 card-body pt-9">
        <!--begin::Details-->
        <div class="flex-wrap d-flex flex-sm-nowrap">
            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="flex-wrap mb-2 d-flex justify-content-between align-items-start">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <div class="mb-2 d-flex align-items-center">
                            <p class="text-gray-900 fs-4 fw-bold me-1">
                                Appointment Details</p>
                        </div>
                        <!--end::Name-->
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->
                <!--begin::Stats-->
                <div class="flex-wrap d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <!--begin::Stats-->
                        <div class="flex-wrap d-flex">

                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        @isset($appointmentReq->doctor_name)
                                        {{$appointmentReq->doctor_name}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Doctor/Consultant</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                        data-kt-countup-value="4500" data-kt-countup-prefix="$" data-kt-initialized="1">
                                        @isset($appointmentReq->appointment_request_status)
                                        {{ucfirst($appointmentReq->appointment_request_status)}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Status</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        @isset($appointmentReq->request_date)
                                        {{$appointmentReq->request_date}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Request Date</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        @isset($appointmentReq->preferred_date)
                                        {{$appointmentReq->preferred_date}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Preferred Date</div>
                                <!--end::Label-->
                            </div>
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        @isset($appointmentReq->preferred_time)
                                        {{$appointmentReq->preferred_time}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Preferred Time</div>
                                <!--end::Label-->
                            </div>
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        @isset($appointmentReq->is_visitor)
                                        @if ($appointmentReq->is_visitor == 0)
                                        No
                                        @else
                                        Yes
                                        @endif
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Visitor</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Wrapper-->
                    @if ($appointmentReq->is_visitor == 0)
                    <div class="text-center">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#appointmentModal">
                            Book Appointment
                        </button>
                    </div>
                    @endif
                </div>
                <!--end::Stats-->
            </div>

            <!--end::Info-->
        </div>
        <!--end::Details-->
        <br>

    </div>
</div>
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Book Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form needs-validation" action="{{ route('appointments.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" name="appointment_request_id" value="{{ $appointmentRequest->id }}">
                    <div class="mb-3">
                        <label class="form-label">Hospital <span class="text-danger">*</span></label>
                        <input type="hidden" name="hospital_id" value="{{ $preferences['preference']['hospital_id'] }}">
                        <p class="form-control-plaintext">{{ getActiveHospitalName($preferences['preference']['hospital_id']) }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Doctor <span class="text-danger">*</span></label>
                        <select class="form-control form-select" name="doctor_id" data-live-search="true" id="kt_select2_2">
                            @isset($doctors)
                                @foreach ($doctors as $doctor)
                                <option value="{{$doctor->id}}" @if ($appointmentReq->doctor_id === $doctor->id)
                                    selected @endif> {{$doctor->doctor_name}} - {{ $doctor->department_name}}
                                    </option>
                                @endforeach
                                @endisset
                        </select>
                        @error('doctor_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Patient <span class="text-danger">*</span></label>
                        <select class="form-control form-select" name="patient_id" data-live-search="true" id="kt_select2_1">
                            @isset($patients)
                                @foreach ($patients as $patient)
                                <option value="{{$patient->id}}" @if ($appointmentReq->patient_id === $patient->id) selected @endif> {{$patient->name_of_patient}} - {{$patient->cnic_number}} - {{$patient->patient_mr_number}} </option>
                                @endforeach
                                @endisset
                        </select>
                        @error('patient_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control" id="start_date" min="{{ date('Y-m-d') }}" value="{{ $appointmentReq->preferred_date }}">
                        @error('date') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Time <span class="text-danger">*</span></label>
                        <input type="time" name="time" class="form-control" id="time" value="{{ $appointmentReq->preferred_time }}">
                        @error('time') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var appointmentModal = document.getElementById('appointmentModal');
        appointmentModal.addEventListener('hidden.bs.modal', function () {
            this.querySelector('form').reset();
        });
    });
</script>
@endsection
