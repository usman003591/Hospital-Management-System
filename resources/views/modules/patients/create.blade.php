@php $page='patients'; @endphp
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
                Create Patient</h1>
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

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="{{route('patients.create')}}">
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


    <!--begin::Head-->

    <head>
        <base href="../../" />

        <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
        <!--end::Global Stylesheets Bundle-->
    </head>
    <!--end::Head-->

    <body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
        data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
        data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
        data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">

        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">

                <!--begin::Content-->
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Content container-->
                    <div id="kt_app_content_container" class="app-container container-xxl">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->

                            <div class="card-body ">
                                <!--begin::Stepper-->
                                <div class="stepper stepper-links d-flex flex-column pt-15"
                                    id="kt_create_account_stepper">
                                    <!--begin::Nav-->
                                    <div class="mb-6 stepper-nav">
                                        <div class="stepper-item current" data-kt-stepper-element="nav">
                                            <h3 class="stepper-title">Mandatory Information</h3>
                                        </div>
                                        <div class="stepper-item" data-kt-stepper-element="nav">
                                            <h3 class="stepper-title">Additional Information</h3>
                                        </div>
                                        <div class="stepper-item" data-kt-stepper-element="nav">
                                            <h3 class="stepper-title">Emergency Contact Information</h3>
                                        </div>
                                        <!--end::Nav-->
                                        <form class=" w-100 needs-validation" action="{{ route($page.'.store') }}"
                                            method="POST" novalidate="novalidate" id="kt_create_account_form">
                                            @csrf
                                                <input type="hidden" name="patient_id_hidden" id="patient_id_hidden">


                                            <div class="stepper" id="kt_stepper">
                                                <!-- Step 1 -->
                                                <div class="current" data-kt-stepper-element="content">
                                                    <!--begin::Wrapper-->

                                                    <div class="p-0 card-body">
                                                        <h3 class="mb-6 font-size-lg text-dark font-weight-bold"></h3>
                                                        <div >

                                                                <div class="mb-6 row">
                                                                <div class="col-lg-2">
                                                                </div>
                                                                <label class="text-start col-lg-2 col-form-label">CNIC
                                                                    Number <span class="text-info">*</span></label>
                                                                <div class="col-lg-5 cnic-wrapper">
                                                                    <input type="text" id="kt_inputmask_1" name="cnic_number"
                                                                        class="form-control"
                                                                        value="{{ old('cnic_number') }}"
                                                                        placeholder="Enter CNIC" maxlength="15"
                                                                        {{-- oninput="formatCNIC(this)" --}}
                                                                        />
                                                                    @error('cnic_number')<small class="text-danger">{{
                                                                        $message }}</small>@enderror
                                                                </div>

                                                                <div class="col-lg-1 col-md-4 col-sm-3 d-flex justify-content-between align-items-center cnic-wrapper">
                                                                         <label class="col-form-label mb-0 me-2">Skip</label>

                                                               <input type="checkbox" name="has_cnic" id="patientHasCnic" style="padding: 15px !important"
                                                                    class="form-check-input" value="1"
                                                                    {{ old('has_cnic') ? 'checked' : '' }}>
                                                                    @error('has_cnic')<small class="text-danger">{{
                                                                        $message }}</small>@enderror
                                                                </div>
                                                            </div>




                                                            <div class="mb-6 row">
                                                                <div class="col-lg-2">
                                                                </div>
                                                                <label
                                                                    class="text-start col-lg-2 col-form-label">Patient
                                                                    Name <span class="text-danger">*</span></label>

                                                                <div class="col-lg-6">
                                                                    <input type="text" name="name_of_patient"
                                                                        class="form-control"
                                                                        value="{{ old('name_of_patient') }}"
                                                                        maxlength="50"
                                                                        placeholder="Enter patient name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, ''); capitalizeWords(this)"/>
                                                                    @error('name_of_patient')<small
                                                                        class="text-danger">{{ $message
                                                                        }}</small>@enderror
                                                                </div>
                                                            </div>

                                                            <div class="mb-6 row">
                                                                <div class="col-lg-2">
                                                                </div>
                                                                <label class="text-start col-lg-2 col-form-label">DOB <span class="text-danger">*</span></label>
                                                                <div class="col-lg-3">
                                                                      <input type="date" name="date_of_birth" id="datepicker" class="form-control" max="{{ date('Y-m-d') }}"
                                                                    placeholder="DD/MM/YYYY" value="{{ old('date_of_birth') }}" />
                                                                    @error('date_of_birth')<small class="text-danger">{{
                                                                    $message }}</small>@enderror

                                                                </div>
                                                                <label class="text-start col-lg-1 col-form-label">Age <span class="text-info">*</span></label>
                                                                 <div class="col-lg-2">
                                                                      <input type="number" name="age" id="age"
                                                                        class="form-control" placeholder="Enter age"
                                                                        value="{{ old('age') }}" oninput="this.value = this.value.replace(/\D/g, '').substring(0, 3)"/>
                                                                    @error('age')<small class="text-danger">{{
                                                                        $message }}</small>@enderror

                                                            </div>

                                                            </div>


                                                            <div class="mb-6 row">
                                                                <div class="col-lg-2">
                                                                </div>
                                                                <label class="text-start col-lg-2 col-form-label">Cell
                                                                    Number  <span class="text-danger">*</span></label>
                                                                <div class="col-lg-6">
                                                                    <input type="tel" name="cell" class="form-control"
                                                                        value="{{ old('cell') }}"
                                                                        placeholder="Enter cell number"
                                                                        oninput="this.value = this.value.replace(/\D/g, '').substring(0, 11)" />
                                                                    @error('cell')<small class="text-danger">{{ $message
                                                                        }}</small>@enderror
                                                                </div>
                                                            </div>

                                                            <div class="mb-6 row">
                                                                <div class="col-lg-2">
                                                                </div>
                                                                <label
                                                                    class="text-start col-lg-2 col-form-label">Patient
                                                                    Category <span class="text-danger">*</span></label>
                                                                <div class="col-lg-6">
                                                                    <select class="form-control form-select"
                                                                        name="patient_category"
                                                                        id="patientCategory">
                                                                        <option selected disabled>Select Category
                                                                        </option>
                                                                        <option value="resident" {{
                                                                            old('patient_category')=='resident'
                                                                            ? 'selected' : '' }}>Resident</option>
                                                                        <option value="non_resident" {{
                                                                            old('patient_category')=='non_resident'
                                                                            ? 'selected' : '' }}>Non Resident</option>
                                                                        <option value="employee" {{
                                                                            old('patient_category')=='employee'
                                                                            ? 'selected' : '' }}>Employee</option>
                                                                    </select>
                                                                    @error('patient_category')<small
                                                                        class="text-danger">{{ $message
                                                                        }}</small>@enderror
                                                                </div>
                                                            </div>
                                                            <div id="designationField" style="display: none;">
                                                                <div class="mb-6 row">
                                                                    <div class="col-lg-2">
                                                                    </div>
                                                                    <label class="text-start col-lg-2 col-form-label">Designation</label>
                                                                    <div class="col-lg-6">
                                                                        <input type="text" name="designation" class="form-control" value="{{ old('designation') }}"
                                                                            maxlength="150" placeholder="Enter patient's designation" />
                                                                        @error('designation')<small class="text-danger">{{ $message
                                                                            }}</small>@enderror
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="mb-6 row">
                                                                <div class="col-lg-2">
                                                                </div>
                                                                <label class="text-start col-lg-2 col-form-label">Gender
                                                                    <span class="text-danger">*</span></label>
                                                                <div class="col-lg-6">
                                                                    <select class="form-control form-select" name="gender">
                                                                        <option selected disabled>Select Gender</option>
                                                                        <option value="male" {{ old('gender')=='male'
                                                                            ? 'selected' : '' }}>Male</option>
                                                                        <option value="female" {{
                                                                            old('gender')=='female' ? 'selected' : ''
                                                                            }}>Female</option>
                                                                        <option value="other" {{ old('gender')=='other'
                                                                            ? 'selected' : '' }}>Other</option>
                                                                    </select>
                                                                    @error('gender')<small class="text-danger">{{
                                                                        $message }}</small>@enderror
                                                                </div>
                                                            </div>









                                                                 {{--
                                                                <div class="col-lg-6">
                                                                </div>
                                                              </div> --}}

                                                                {{-- <div class="col-lg-3">
                                                                    <button type="submit" name="save_and_go_to_opd"
                                                                        id="saveAndGoToOPDButton"
                                                                        class="btn btn-success">
                                                                        Save and Go to OPD
                                                                    </button>
                                                                </div> --}}



                                                                {{-- <button type="submit" name="save_and_go_to_opd"
                                                                    id="saveAndGoToOPDButton" class="btn btn-success">
                                                                    Save and Go to OPD
                                                                </button> --}}

                                                            </div>

                                                        </div>


                                                        <!--end::Wrapper-->
                                                    </div>

                                                <!--end::Step 1-->

                                                <!-- Step 2 -->
                                                <!--begin::Step 2-->
                                                <div data-kt-stepper-element="content">
                                                    <!--begin::Wrapper-->

                                                    <div class="card-body">

                                                        <br>
                                                        <div class="form-group row">
                                                            <div class="col-lg-2">
                                                            </div>
                                                            <label class="text-start col-lg-2 col-form-label">Email
                                                                Address </label>
                                                            <div class="col-lg-6">
                                                                <input type="email" name="email" class="form-control"
                                                                    value="{{ old('email') }}"
                                                                    placeholder="Enter email" />

                                                                <div>
                                                                    @error('email')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>

                                                        <div class="form-group row">
                                                            <div class="col-lg-2">
                                                            </div>
                                                            <label class="text-start col-lg-2 col-form-label">Phone
                                                                Number </label>
                                                            <div class="col-lg-6">
                                                                <input type="tel" name="phone" class="form-control"
                                                                    value="{{ old('phone') }}"
                                                                    placeholder="Enter phone number (Optional)"
                                                                    oninput="this.value = this.value.replace(/\D/g, '').substring(0, 11)" />
                                                                {{-- <span class="form-text text-muted">We'll never
                                                                    share your phone with anyone else</span>
                                                                --}}
                                                                <div>
                                                                    @error('phone')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>



                                                        <div class="form-group row">
                                                            <div class="col-lg-2">
                                                            </div>
                                                            <label class="text-start col-lg-2 col-form-label">Blood
                                                                Group</label>
                                                            <div class="col-lg-6">
                                                                <input type="text" name="blood_group"
                                                                    class="form-control"
                                                                    value="{{ old('blood_group') }}"
                                                                    placeholder="Enter blood group" maxlength="3" />
                                                                {{-- <span class="form-text text-muted">We'll never
                                                                    share your phone with anyone else</span>
                                                                --}}
                                                                <div>
                                                                    @error('blood_group')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>


                                                        <div class="form-group row">
                                                            <div class="col-lg-2">
                                                            </div>
                                                            <label class="text-start col-lg-2 col-form-label">Referring
                                                                Doctor Name</label>
                                                            <div class="col-lg-6">
                                                                <input type="text"
                                                                    value="{{ old('reffering_doctor_name') }}"
                                                                    oninput="this.value = this.value.replace(/[^a-zA-Z\s.-]/g, '')"
                                                                    name="reffering_doctor_name" class="form-control"
                                                                    maxlength="50"
                                                                    placeholder="Enter referring doctor name (Optional)" />
                                                                {{-- <span class="form-text text-muted">Please enter
                                                                    your full name</span> --}}
                                                                <div>
                                                                    @error('reffering_doctor_name')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>

                                                        <div class="form-group row">
                                                            <div class="col-lg-2">
                                                            </div>
                                                            <label class="text-start col-lg-2 col-form-label">Contact
                                                                Number</label>
                                                            <div class="col-lg-6">
                                                                <input type="tel" name="contact_number"
                                                                    class="form-control"
                                                                    value="{{ old('contact_number') }}"
                                                                    placeholder="Enter contact number (Optional)"
                                                                    oninput="this.value = this.value.replace(/\D/g, '').substring(0, 11)" />
                                                                {{-- <span class="form-text text-muted">We'll never
                                                                    share your phone with anyone else</span>
                                                                --}}
                                                                <div>
                                                                    @error('contact_number')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>

                                                        <div class="form-group row">
                                                            <div class="col-lg-2">
                                                            </div>
                                                            <label
                                                                class="text-start col-lg-2 col-form-label">Address</label>
                                                            <div class="col-lg-6">
                                                                <input type="text" name="address" class="form-control"
                                                                    value="{{ old('address') }}"
                                                                    placeholder="Enter address" maxlength="200" />
                                                                {{-- <span class="form-text text-muted">We'll never
                                                                    share your phone with anyone else</span>
                                                                --}}
                                                                <div>
                                                                    @error('address')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>

                                                        <div class="form-group row">
                                                            <div class="col-lg-2">
                                                            </div>
                                                            <label class="text-start col-lg-2 col-form-label">Permanent
                                                                Address</label>
                                                            <div class="col-lg-6">
                                                                <input type="text" name="permanent_address"
                                                                    class="form-control"
                                                                    value="{{ old('permanent_address') }}"
                                                                    placeholder="Enter permanent address"
                                                                    maxlength="200" />
                                                                <div>
                                                                    @error('permanent_address')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!--end::Wrapper-->
                                                </div>
                                                <!--end::Step 2-->

                                                <!-- Step 3 -->
                                                <!--begin::Step 3-->
                                                <div data-kt-stepper-element="content">
                                                    <!--begin::Wrapper-->

                                                    <div class="card-body">

                                                        <div class="form-group row">
                                                            <div class="col-lg-2">
                                                            </div>
                                                            <label class="text-start col-lg-2 col-form-label">Emergency
                                                                Contact Name </label>
                                                            <div class="col-lg-6">
                                                                <input type="text" name="emergency_contact_name"
                                                                    class="form-control"
                                                                    placeholder="Enter emergency contact name"
                                                                    value="{{ old('emergency_contact_name') }}" required
                                                                    oninput="this.value = this.value.replace(/[^a-zA-Z\s.-]/g, '')"
                                                                    maxlength="50" />
                                                                <div>
                                                                    @error('emergency_contact_name')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>

                                                        <div class="form-group row">
                                                            <div class="col-lg-2">
                                                            </div>
                                                            <label class="text-start col-lg-2 col-form-label">Emergency
                                                                Contact Relation </label>
                                                            <div class="col-lg-6">
                                                                <input type="text" name="emergency_contact_relation"
                                                                    class="form-control" placeholder="Enter relation"
                                                                    value="{{ old('emergency_contact_relation') }}"
                                                                    oninput="this.value = this.value.replace(/[^a-zA-Z\s.-]/g, '')"
                                                                    maxlength="25" required />
                                                                <div>
                                                                    @error('emergency_contact_relation')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>

                                                        <div class="form-group row">
                                                            <div class="col-lg-2">
                                                            </div>
                                                            <label class="text-start col-lg-2 col-form-label">Emergency
                                                                Contact Number </label>
                                                            <div class="col-lg-6">
                                                                <input type="tel" name="emergency_contact_number"
                                                                    class="form-control"
                                                                    placeholder="Enter emergency contact number"
                                                                    value="{{ old('emergency_contact_number') }}"
                                                                    required
                                                                    oninput="this.value = this.value.replace(/\D/g, '').substring(0, 11)" />
                                                                <div>
                                                                    @error('emergency_contact_number')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!--end::Wrapper-->
                                                </div>
                                                <!--end::Step 3-->
                                            </div>


                                            <!-- Navigation Buttons -->
                                            <!--begin::Actions-->
                                            <div class="d-flex flex-stack pt-15">
                                                <!--begin::Wrapper-->
                                                <div class="mr-2">
                                                    <button type="button" class="btn btn-lg btn-light-primary me-3"
                                                        data-kt-stepper-action="previous">
                                                        <i class="ki-duotone ki-arrow-left fs-4 me-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>Back</button>
                                                        </div>

                                                               <div class="d-flex flex-wrap gap-3 justify-content-end">
                                                                    <button type="submit" name="save_and_go_to_prescriptions"
                                                                        id="saveAndGoToPrescriptionsButton"
                                                                        class="btn btn-primary">
                                                                        Save and Go to Prescriptions
                                                                    </button>



                                                                    <button type="submit" name="save_and_go_to_opd"
                                                                        id="saveAndGoToOPDButton"
                                                                        class="btn btn-primary">
                                                                        Save and Go to OPD
                                                                    </button>
                                                                    <div>
                                                <!--end::Wrapper-->
                                                <!--begin::Wrapper-->


                                                    <button type="submit" class="btn btn-lg btn-primary me-3"
                                                        data-kt-stepper-action="submit">
                                                        <span class="indicator-label">Submit
                                                            <i class="ki-duotone ki-arrow-right fs-3 ms-2 me-0">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i></span>
                                                        <span class="indicator-progress">Please wait...
                                                            <span
                                                                class="align-middle spinner-border spinner-border-sm ms-2"></span></span>
                                                    </button>


                                                    <button type="button" class="btn btn-lg btn-primary"
                                                        data-kt-stepper-action="next">Continue
                                                        <i class="ki-duotone ki-arrow-right fs-4 ms-1 me-0">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i></button>
                                                </div>

                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Actions-->




                                        </form>

                                        <!--end::Form-->
                                    </div>
                                    <!--end::Stepper-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Content container-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Content wrapper-->

        </div>
        <!--end:::Main-->
        <!--begin::Javascript-->
        <script src="assets/js/scripts.bundle.js"></script>
        <script src="assets/js/custom/utilities/modals/create-account.js"></script>
        <!--end::Javascript-->
    </body>
    <!--end::Body-->

    <!--end::List Widget 8-->
</div>
@endsection
@section('scripts')
<script src="{{getAssetsURLs('js/custom/helper_scripts.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>
<script>
$('#saveAndGoToPrescriptionsButton').on('click', function () {
    let button = $(this);
    button.prop('disabled', true); // Disable the button

    setTimeout(function () {
        button.prop('disabled', false); // Enable after 5 seconds
    }, 5000);
});

$('#saveAndGoToOPDButton').on('click', function () {
    let button = $(this);
    button.prop('disabled', true); // Disable the button

    setTimeout(function () {
        button.prop('disabled', false); // Enable after 5 seconds
    }, 5000);
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    Inputmask({
    "mask" : "99999-9999999-9",
    "showMaskOnHover": false,
    "showMaskOnFocus": false,
    "clearIncomplete": true,
}).mask("#kt_inputmask_1");
})

$(document).ready(function() {
  $('input[type="checkbox"]').on('change', function() {
    if ($(this).is(':checked')) {
      $(this).val(1);
    } else {
      // Set the value to 0 and ensure the field is submitted if needed
      $(this).prop('checked', false).val(0);
    }
  });
});

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
<script>
    document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("kt_create_account_form");
    if (!form) return;

    const submitButton = document.querySelector("[data-kt-stepper-action='submit']");
    const opdButton = document.getElementById("saveAndGoToOPDButton");
    const prescriptionsButton = document.getElementById("saveAndGoToPrescriptionsButton");
    const cnicInput = document.getElementById("kt_inputmask_1");

    if (submitButton) {
        submitButton.addEventListener("click", (event) => {
            event.preventDefault();
            form.submit();
        });
    }

    if (opdButton) {
        opdButton.addEventListener("click", (event) => {
            event.preventDefault();

            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "save_and_go_to_opd";
            input.value = "1";

            form.appendChild(input);
            form.submit();
        });
    } else {
        opdButton.addEventListener("click", (event) => {
            event.preventDefault();

            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "save_and_go_to_opd";
            input.value = "0";

            form.appendChild(input);
            form.submit();
        });
    }

     if (prescriptionsButton) {
        prescriptionsButton.addEventListener("click", (event) => {
            event.preventDefault();

            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "save_and_go_to_prescriptions";
            input.value = "1";

            form.appendChild(input);
            form.submit();
        });
    } else {
       prescriptionsButton.addEventListener("click", (event) => {
            event.preventDefault();

            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "save_and_go_to_prescriptions";
            input.value = "0";

            form.appendChild(input);
            form.submit();
        });
    }

    let lastCheckedCnic = '';
      if (cnicInput) {
        cnicInput.addEventListener("input", function () {
            const cnic = this.value;
            const isValidCnic = /^\d{5}-\d{7}-\d{1}$/.test(cnic);
        if (isValidCnic && cnic !== lastCheckedCnic) {
            lastCheckedCnic = cnic;
                fetch(`/patients/check-cnic?cnic=${cnic}`)
                    .then(res => res.json())
                    .then(data => {
                           console.log("Response data:", data);
                        if (data.status === 'found') {
                            document.querySelector('[name="name_of_patient"]').value = data.data.name;
                            document.querySelector('[name="cell"]').value = data.data.cell_number;
                            document.querySelector('[name="gender"]').value = data.data.gender;
                            document.querySelector('[name="age"]').value = data.data.age;
                        //      const year = data.data.year_of_birth;
                        // if (year && /^\d{4}$/.test(year)) {
                            document.querySelector('[name="date_of_birth"]').value = data.data.date_of_birth;
                        // }
                            document.querySelector('[name="patient_category"]').value = data.data.patient_category;
                            document.getElementById("patient_id_hidden").value = data.data.id;
                            toastr.success(" Patient found. Ready to proceed.");
                        } else {
                                clearPatientFormFields();
                                var message = " Patient not found. Please complete form to register";
                            toastr.error( message);
                        }
                    });
            }
             else if (cnic.length < 15) {
            lastCheckedCnic = '';
           clearPatientFormFields();
        }
        });
    }
     function clearPatientFormFields() {
        document.querySelector('[name="name_of_patient"]').value = '';
        document.querySelector('[name="cell"]').value = '';
        // document.querySelector('[name="gender"]').value = '';
        document.querySelector('[name="age"]').value = '';
         document.querySelector('[name="date_of_birth"]').value = '';
        // document.querySelector('[name="patient_category"]').value = '';
        document.getElementById("patient_id_hidden").value = '';
    }

 });
</script>
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
// function formatCNIC(input) {
//     // Remove all non-numeric characters
//     let value = input.value.replace(/\D/g, '');

//     // Limit to 13 digits
//     value = value.substring(0, 15);

//     // Add dashes after 5th and 12th digits if they exist
//     if (value.length > 5) {
//         value = value.substring(0, 5) + '-' + value.substring(5);
//     }
//     if (value.length > 13) {
//         value = value.substring(0, 13) + '-' + value.substring(13);
//     }

//     input.value = value;
// }
</script>
{{-- <script>
    document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("kt_create_account_form");
    if (!form) return;

    const submitButton = document.querySelector("[data-kt-stepper-action='submit']");
    const opdButton = document.getElementById("saveAndGoToOPDButton");

    if (submitButton) {
        submitButton.addEventListener("click", (event) => {
            event.preventDefault();
            form.submit();
        });
    }

    if (opdButton) {
        opdButton.addEventListener("click", (event) => {
            event.preventDefault();

            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "save_and_go_to_opd";
            input.value = "1";

            form.appendChild(input);
            form.submit();
        });
    }
});

</script> --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const patientType = document.getElementById("patientCategory");
        const designationField = document.getElementById("designationField");

        function toggleDesignationField() {
            if (patientType.value === "employee") {
                designationField.style.display = "block";
            } else {
                designationField.style.display = "none";
            }
        }

        // Initial check on page load (for old value or validation error)
        toggleDesignationField();

        // Listen for changes
        patientType.addEventListener("change", toggleDesignationField);
    });
</script>
{{-- <script>
    new AirDatepicker('#datepicker', {
    dateFormat: 'dd/MM/yyyy',
    autoClose: true,
    minDate: new Date(1900, 0, 1),
    maxDate: new Date(),
    locale: {
        days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Th  u', 'Fri', 'Sat'],
        daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        today: 'Today',
        clear: 'Clear',
        dateFormat: 'dd/MM/yyyy',
        timeFormat: 'hh:mm aa',
        firstDay: 0
    }
});

</script> --}}

<script>
$('#patientHasCnic').on('change', function() {
        if ($(this).is(':checked')) {
        $('#patientHasCnic').val('1');
    } else {
        $('#patientHasCnic').val('0');
    }
});
document.addEventListener("DOMContentLoaded", function () {
    const cnicWrapper = document.querySelector('.cnic-wrapper');
    const skipCheckbox = document.getElementById("patientHasCnic");

    function toggleCNIC() {
        if (skipCheckbox.checked) {
            cnicWrapper.style.display = 'none';
             clearPatientFormFields();
        } else {
            cnicWrapper.style.display = 'block';
        }
    }
    toggleCNIC();
    skipCheckbox.addEventListener("change", toggleCNIC);

        function clearPatientFormFields() {
        document.querySelector('[name="cnic_number"]').value = '';
        document.querySelector('[name="name_of_patient"]').value = '';
        document.querySelector('[name="cell"]').value = '';
        document.querySelector('[name="gender"]').selectedIndex = 0;
        document.querySelector('[name="age"]').value = '';
        document.querySelector('[name="date_of_birth"]').value = '';
        document.querySelector('[name="patient_category"]').selectedIndex = 0;
        document.getElementById("patient_id_hidden").value = '';
    }});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const ageInput = document.getElementById("age");
    const dobInput = document.getElementById("datepicker");

    function formatDateToYMD(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    dobInput.addEventListener("change", function () {
        const dobValue = this.value.trim();

        if (dobValue === '') {
            ageInput.value = '';
            return;
        }

        const dob = new Date(dobValue);
        const today = new Date();

        if (!isNaN(dob)) {
            let age = today.getFullYear() - dob.getFullYear();
            const m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            ageInput.value = age >= 0 ? age : '';
        }
    });

    ageInput.addEventListener("input", function () {
        const value = this.value.trim();

        if (value === '') {
            dobInput.value = '';
            return;
        }

        const age = parseInt(value);
        if (!isNaN(age) && age > 0) {
            const today = new Date();
            const dob = new Date(today.getFullYear() - age, 0, 1);
            dobInput.value = formatDateToYMD(dob);
        }
    });
});
</script>
<script>
    function capitalizeWords(input) {
        let words = input.value.toLowerCase().split(' ');
        for (let i = 0; i < words.length; i++) {
            words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
        }
        input.value = words.join(' ');
    }
</script>




@endsection
