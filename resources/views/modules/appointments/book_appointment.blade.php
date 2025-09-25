@extends('layouts.app')
@section('content')
    <div class="col-xl-12">
        <!--begin::Contacts-->


        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @include('include.success_messages')
                </div>
            </div>
        </div>

        <div class="card card-flush h-lg-100" id="kt_contacts_main">
            <!--begin::Card header-->

            <div class="card-header pt-7" id="kt_chat_contacts_header">
                <!--begin::Card title-->
                <div class="card-title">
                    <i class="ki-duotone ki-badge fs-1 me-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                        <span class="path5"></span>
                    </i>
                    <h2>Book Appointment</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="pt-5 card-body">
                <!--begin::Form-->
                <form id="kt_ecommerce_settings_general_form" action="{{ route('patients.save_appointment') }}"
                    method="POST" class="form fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                    <!--begin::Input group-->
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7 fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="mt-3 fs-6 fw-semibold form-label">
                            <span class="required">Name</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" placeholder="Enter name here"
                            name="patient_name" value="{{ old('patient_name') }}">
                        <!--end::Input-->
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            @error('patient_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->

                    <!--end::Input group-->
                    <!--begin::Row-->
                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="mt-3 fs-6 fw-semibold form-label">
                                    <span class="required">Email</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" class="form-control form-control-solid" placeholder="Enter email here"
                                    name="patient_email" value="{{ old('patient_email') }}">
                                <!--end::Input-->
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    @error('patient_email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="mt-3 fs-6 fw-semibold form-label">
                                    <span class="required">Phone</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="tel" class="form-control form-control-solid" placeholder="Enter phone here"
                                    name="patient_number" value="{{ old('patient_number') }}"
                                    oninput="this.value = this.value.replace(/\D/g, '').substring(0, 11)">
                                <!--end::Input-->
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    @error('patient_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                    <!--begin::Row-->
                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="mt-3 fs-6 fw-semibold form-label">
                                    <span class="required">CNIC Number</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid required" id="kt_inputmask_1"
                                    placeholder="Enter CNIC number here" name="patient_cnic_number"
                                    value="{{ old('patient_cnic_number') }}"
                                    maxlength="15" />
                                <!--end::Input-->

                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    @error('patient_cnic_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="mt-3 fs-6 fw-semibold form-label">
                                    <span class="required">Hospitals</span>
                                </label>
                                <!--end::Label-->
                                <div class="w-100">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" id="hospital_id"
                                        value="{{ old('hospital_id') }}" name="hospital_id" tabindex="-1"
                                        aria-hidden="true">
                                        <option disabled selected> Select Hospital </option>
                                        @isset($hospitals)
                                            @foreach ($hospitals as $hos)
                                                <option value="{{ $hos->id }}" {{ "$hos->id"===old('hospital_id')
                                        ? 'selected' : '' }}>{{ $hos->name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>


                                    <!--end::Select2-->
                                </div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    @error('hospital_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                    </div>


                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="mt-3 fs-6 fw-semibold form-label">
                                    <span class="required">Departments</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="w-100">
                                    <select class="form-select form-select-solid" id="departmentId"
                                        value="{{ old('department_id') }}" name="department_id" tabindex="-1"
                                        aria-hidden="true">
                                        <option disabled selected> Select Department </option>
                                        @isset($departments)
                                            @foreach ($departments as $hos)
                                                <option value="{{ $hos->id }}" {{ "$hos->id"===old('department_id') ? 'selected' : '' }}>
                                                    {{ $hos->name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <!--end::Input-->

                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    @error('department_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 fv-plugins-icon-container" id="doctorsContainer">
                                <!--begin::Label-->
                                <label class="mt-3 fs-6 fw-semibold form-label">
                                    <span class="required">Doctors</span>
                                </label>
                                <!--end::Label-->
                                <div class="w-100">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" id="doctor_id"
                                        value="{{ old('doctor_id') }}" name="doctor_id" tabindex="-1"
                                        aria-hidden="true">
                                        <option disabled selected> Select Doctor </option>
                                        {{-- @isset($doctors)
                                            @foreach ($doctors as $hos)
                                                <option value="{{ $hos->id }}">{{ $hos->doctor_name }}</option>
                                            @endforeach
                                        @endisset --}}
                                    </select>






                                    <!--end::Select2-->
                                </div>

                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    @error('doctor_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                    </div>


                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="mt-3 fs-6 fw-semibold form-label">
                                    <span class="required">Preferred Date</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" class="form-control form-control-solid"
                                    value="{{ old('preferred_date') }}" name="preferred_date">
                                <!--end::Input-->

                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    @error('preferred_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="mt-3 fs-6 fw-semibold form-label">
                                    <span class="required">Preferred Time</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="time" class="form-control form-control-solid"
                                    value="{{ old('preferred_time') }}" name="preferred_time">

                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    @error('preferred_time')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                    </div>


                    <!--end::Row-->
                    <!--begin::Input group-->
                    {{-- <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="mt-3 fs-6 fw-semibold form-label">
                        <span>Notes</span>
                        <span class="ms-1" data-bs-toggle="tooltip" aria-label="Enter any additional notes about the contact (optional)." data-bs-original-title="Enter any additional notes about the contact (optional)." data-kt-initialized="1">
                            <i class="ki-duotone ki-information fs-7">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea class="form-control form-control-solid" name="notes"></textarea>
                    <!--end::Input-->
                </div> --}}
                    <!--end::Input group-->
                    <!--begin::Separator-->
                    <div class="mb-6 separator"></div>
                    <!--end::Separator-->
                    <!--begin::Action buttons-->
                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <button type="reset" data-kt-contacts-type="cancel" class="btn btn-light me-3">Cancel</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" data-kt-contacts-type="submit" class="btn btn-primary">
                            <span class="indicator-label">Book</span>
                            <span class="indicator-progress">Please wait...
                                <span class="align-middle spinner-border spinner-border-sm ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Action buttons-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Contacts-->
    </div>
@endsection
{{-- @section('scripts') --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        Inputmask({
        "mask" : "99999-9999999-9",
        "showMaskOnHover": false,
        "showMaskOnFocus": false,
        "clearIncomplete": true,
    }).mask("#kt_inputmask_1");
    })
</script>

<script>

    $(document).ready(function() {
    $('#hospital_id').on('change', function() {
        var hospitalId = $(this).val();
        if (hospitalId) {
            $.ajax({
                url: '/api/fetch-hospital-doctors/' + hospitalId,
                type: 'GET',
                success: function(response) {
                    $('#doctor_id').empty();
                    $('#doctor_id').append('<option disabled selected>Select Doctor</option>');
                    if (response.status == 200) {
                        $.each(response.doctors, function(key, doctor) {
                            $('#doctor_id').append('<option value="'+ doctor.id +'">'+ doctor.name +'</option>');
                        });
                    } else {
                        $('#doctor_id').append('<option disabled>No doctors found</option>');
                    }
                }
            });
        } else {
            $('#doctor_id').empty();
            $('#doctor_id').append('<option disabled selected>Select Doctor</option>');
        }
    });
});

</script>


{{-- @endsection --}}

