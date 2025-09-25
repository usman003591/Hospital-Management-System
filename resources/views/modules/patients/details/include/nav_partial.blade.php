<div class="mb-5 card mb-xxl-8">
    <div class="pb-0 card-body pt-9">
        <!--begin::Details-->
        <div class="flex-wrap d-flex flex-sm-nowrap">
            <!--begin: Pic-->
            <div class="mb-4 me-7">
                {{-- <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <img src="assets/media/avatars/300-1.jpg" alt="image">
                    <div
                        class="bottom-0 mb-6 border-4 position-absolute translate-middle start-100 bg-success rounded-circle border-body h-20px w-20px">
                    </div>
                </div> --}}
            </div>
            <!--end::Pic-->
            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="flex-wrap mb-2 d-flex justify-content-between align-items-start">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->

                        <div class="mb-2 d-flex align-items-center">
                            <a href="#"
                                class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">@isset($patient->name_of_patient)
                                {{$patient->name_of_patient}}
                                @endisset</a>
                        </div>
                        <!--end::Name-->
                        <!--begin::Info-->
                        <div class="flex-wrap mb-4 d-flex fw-semibold fs-6 pe-2">
                            @isset($patient->patient_category)
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                {{titleFilter($patient->patient_category)}}
                            </a>@endisset
                            @isset($patient->address)
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                <i class="ki-duotone ki-geolocation fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ucfirst($patient->address)}}
                                </a>@endisset
                                @isset($patient->email)
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary">
                                <i class="ki-duotone ki-sms fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{$patient->email}}
                                </a>@endisset
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->
                    <div class="d-flex flex-column flex-md-row gap-1">
                        <livewire:patient-details.brief-history-form :patientId="$patient->id"/>

                        <button type="button" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal"
                            data-bs-target="#PatientExDoc">Upload External Documents</button>
                        <a href="{{route('clinical_diagnosis.create')}}" class="btn btn-sm btn-primary">Add OPD
                            Record</a>&nbsp;
                                      <a href="{{route('patients.index')}}" class="btn btn-sm btn-light-primary" >
                            <i class="ki-duotone ki-black-left fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>Back</a>
                    </div>

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
                                    {{-- <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="80"
                                        data-kt-initialized="1">@isset($patient->patient_mr_number)
                                        {{$patient->patient_mr_number}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">MR Number</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            @isset($patient->cnic_number)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        {{$patient->cnic_number}}
                                        </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">CNIC</div>
                                <!--end::Label-->
                            </div>
                            @endisset

                            @isset($patient->cell)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        {{$patient->cell}}
                                        </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Phone Number</div>
                                <!--end::Label-->
                            </div>
                            @endisset
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            @isset($patient->blood_group)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                        data-kt-countup-value="4500" data-kt-countup-prefix="$" data-kt-initialized="1">

                                        {{$patient->blood_group}}
                                        </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Blood Group</div>
                                <!--end::Label-->
                            </div>
                            @endisset
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            @isset($patient->age)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        {{$patient->age}}
                                        </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Age</div>
                                <!--end::Label-->
                            </div>
                            @endisset
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            @isset($patient->gender)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        {{ucfirst($patient->gender)}}
                                        </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Gender</div>
                                <!--end::Label-->
                            </div>
                            @endisset
                            @isset($patient->designation)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        {{ucfirst($patient->designation)}}
                                        </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Designation</div>
                                <!--end::Label-->
                            </div>
                            @endisset
                            <!--end::Stat-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Progress-->
                    {{-- <div class="mt-3 d-flex align-items-center w-200px w-sm-300px flex-column">
                        <div class="mt-auto mb-2 d-flex justify-content-between w-100">
                            <span class="text-gray-500 fw-semibold fs-6">Profile Compleation</span>
                            <span class="fw-bold fs-6">50%</span>
                        </div>
                        <div class="mx-3 mb-3 h-5px w-100 bg-light">
                            <div class="rounded bg-success h-5px" role="progressbar" style="width: 50%;"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div> --}}
                    <!--end::Progress-->
                </div>
                <!--end::Stats-->
            </div>

            <!--end::Info-->
        </div>
        @if(isset($patient->emergencyContact) && ($patient->emergencyContact->name || $patient->emergencyContact->relation || $patient->emergencyContact->contact))
        <br>
        <div class="flex-wrap d-flex flex-sm-nowrap">
            <div class="mb-4 me-7">
            </div>
            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="flex-wrap mb-2 d-flex justify-content-between align-items-start">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->
                        <div class="mb-2 d-flex align-items-center">
                            <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">Emergency Details
                            </a>
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

                            <!--begin::Stat-->
                            @isset($patient->emergencyContact->name)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="80"
                                        data-kt-initialized="1">
                                        {{$patient->emergencyContact->name}}
                                    </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Emergency Contact Name</div>
                                <!--end::Label-->
                            </div>
                            @endisset
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            @isset($patient->emergencyContact->relation)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="80"
                                        data-kt-initialized="1">
                                        {{$patient->emergencyContact->relation}}
                                    </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Emergency Contact Relation</div>
                                <!--end::Label-->
                            </div>
                            @endisset
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            @isset($patient->emergencyContact->contact)
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="80"
                                        data-kt-initialized="1">
                                        {{$patient->emergencyContact->contact}}
                                    </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Emergency Contact Number</div>
                                <!--end::Label-->
                            </div>
                            @endisset
                            <!--end::Stat-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Progress-->
                    {{-- <div class="mt-3 d-flex align-items-center w-200px w-sm-300px flex-column">
                        <div class="mt-auto mb-2 d-flex justify-content-between w-100">
                            <span class="text-gray-500 fw-semibold fs-6">Profile Compleation</span>
                            <span class="fw-bold fs-6">50%</span>
                        </div>
                        <div class="mx-3 mb-3 h-5px w-100 bg-light">
                            <div class="rounded bg-success h-5px" role="progressbar" style="width: 50%;"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div> --}}
                    <!--end::Progress-->
                </div>
                <!--end::Stats-->
            </div>

            <!--end::Info-->
        </div>
        @endif
        <!--end::Details-->
        <!--begin::Navs-->
        <br>
        <ul class="border-transparent nav nav-stretch nav-line-tabs nav-line-tabs-2x fs-5 fw-bold">
            <!--begin::Nav item-->
            <li class="mt-2 nav-item">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @isset($tab) @if($tab == 'overview') active @endif @endisset"
                    href="{{route('patients.detail_page',$patient->id)}}">Overview</a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="mt-2 nav-item">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @isset($tab) @if($tab == 'opd_record') active @endif @endisset"
                    href="{{route('patients.opd_record',$patient->id)}}">OPD
                    Record</a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="mt-2 nav-item">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @isset($tab) @if($tab == 'invoice_record') active @endif @endisset"
                    href="{{route('patients.invoice_record',$patient->id)}}">Invoice
                    Record</a>
            </li>

            <li class="mt-2 nav-item">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @isset($tab) @if($tab == 'documents_list') active @endif @endisset"
                    href="{{route('patients.documents_list',$patient->id)}}">Documents List</a>
            </li>

            <li class="mt-2 nav-item">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @isset($tab) @if($tab == 'patient_brief_history') active @endif @endisset"
                    href="{{route('patients.brief_histories',$patient->id)}}">Brief History List</a>
            </li>
            <li class="mt-2 nav-item">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @isset($tab) @if($tab == 'patient_lab_groups') active @endif @endisset"
                    href="{{route('patients.lab_groups',$patient->id)}}">Lab Groups</a>
            </li>
        </ul>
        <!--begin::Navs-->
    </div>
</div>
<div class="modal fade" id="PatientExDoc" tabindex="-1" aria-labelledby="PatientExDocLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="PatientExDocLabel">Upload Patient's External Documents</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!--begin::Form-->
                <form class="form" action="#" method="post">
                    <input type="hidden" id="patient_id" value="{{ $patient->id }}">
                    <!--begin::Input group-->
                    <div class="fv-row">
                        <!--begin::Dropzone-->
                        <div class="dropzone" id="kt_dropzonejs_example_1">
                            <!--begin::Message-->
                            <div class="dz-message needsclick d-flex align-items-center justify-content-center">
                                <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span
                                        class="path2"></span></i>

                                <!--begin::Info-->
                                <div class="ms-4">
                                    <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                    <span class="fs-7 fw-semibold text-gray-500">Upload up to 10 files</span>
                                </div>
                                <!--end::Info-->
                            </div>
                        </div>
                        <!--end::Dropzone-->
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="text-danger w-50" style="display: none;" id="validationMsg"></span>
                        <div class="w-100 d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-primary mt-3" id="uploadAllFilesBtn">Upload</button>
                        </div>
                    </div>
                    <!--end::Input group-->
                </form>

                <!--end::Form-->
            </div>

        </div>
    </div>
</div>
