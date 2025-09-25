@php $page='lab_groups'; @endphp
@extends('layouts.master',['activeMenu' => 'pathology_management', 'activeSubMenu' => 'lab_groups', 'activeThirdMenu' =>
'lab_groups'])
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
                Update Lab Group</h1>
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
                <a href="{{route('lab_groups.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Lab Groups</li>
                </a>
                <!--end::Item-->

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="{{route('patients.edit', $obj->id)}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Update</li>
                </a>
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        {{-- <div class="gap-2 d-flex align-items-center gap-lg-3" data-select2-id="select2-data-122-cw9r">
            <!--begin::Filter menu-->
            <div class="m-0" data-select2-id="select2-data-121-45f5">
                <!--begin::Menu toggle-->
                <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">
                    <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Filter</a>
                <!--end::Menu toggle-->
                <!--begin::Menu 1-->
                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                    id="kt_menu_6606384d61246" style="" data-select2-id="select2-data-kt_menu_6606384d61246">
                    <!--begin::Header-->
                    <div class="py-5 px-7">
                        <div class="text-gray-900 fs-5 fw-bold">Filter Options</div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Menu separator-->
                    <div class="border-gray-200 separator"></div>
                    <!--end::Menu separator-->
                    <!--begin::Form-->
                    <div class="py-5 px-7" data-select2-id="select2-data-120-s3mi">
                        <!--begin::Input group-->
                        <div class="mb-10" data-select2-id="select2-data-119-md49">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Status:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div data-select2-id="select2-data-118-i4go">
                                <select class="form-select form-select-solid select2-hidden-accessible" multiple=""
                                    data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_6606384d61246" data-allow-clear="true"
                                    data-select2-id="select2-data-7-19z1" tabindex="-1" aria-hidden="true"
                                    data-kt-initialized="1">
                                    <option data-select2-id="select2-data-125-g7ns"></option>
                                    <option value="1" data-select2-id="select2-data-126-g09z">Approved</option>
                                    <option value="2" data-select2-id="select2-data-127-23ft">Pending</option>
                                    <option value="2" data-select2-id="select2-data-128-ql51">In Process</option>
                                    <option value="2" data-select2-id="select2-data-129-fwv5">Rejected</option>
                                </select><span
                                    class="select2 select2-container select2-container--bootstrap5 select2-container--below"
                                    dir="ltr" data-select2-id="select2-data-8-x24w" style="width: 100%;"><span
                                        class="selection"><span
                                            class="select2-selection select2-selection--multiple form-select form-select-solid"
                                            role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1"
                                            aria-disabled="false">
                                            <ul class="select2-selection__rendered" id="select2-fkxw-container"></ul>
                                            <span class="select2-search select2-search--inline"><textarea
                                                    class="select2-search__field" type="search" tabindex="0"
                                                    autocorrect="off" autocapitalize="none" spellcheck="false"
                                                    role="searchbox" aria-autocomplete="list" autocomplete="off"
                                                    aria-label="Search" aria-describedby="select2-fkxw-container"
                                                    placeholder="Select option" style="width: 100%;"></textarea></span>
                                        </span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Member Type:</label>
                            <!--end::Label-->
                            <!--begin::Options-->
                            <div class="d-flex">
                                <!--begin::Options-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1">
                                    <span class="form-check-label">Author</span>
                                </label>
                                <!--end::Options-->
                                <!--begin::Options-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="2" checked="checked">
                                    <span class="form-check-label">Customer</span>
                                </label>
                                <!--end::Options-->
                            </div>
                            <!--end::Options-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Notifications:</label>
                            <!--end::Label-->
                            <!--begin::Switch-->
                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="" name="notifications"
                                    checked="checked">
                                <label class="form-check-label">Enabled</label>
                            </div>
                            <!--end::Switch-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true">Reset</button>
                            <button type="submit" class="btn btn-sm btn-primary"
                                data-kt-menu-dismiss="true">Apply</button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Menu 1-->
            </div>
            <!--end::Filter menu-->
            <!--begin::Secondary button-->
            <!--end::Secondary button-->
            <!--begin::Primary button-->
            <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal"
                data-bs-target="#kt_modal_create_app">Create</a>
            <!--end::Primary button-->
        </div> --}}
        <!--end::Actions-->
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
        <form class="form" action="{{route($page.'.update',$obj->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="card-body">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. Lab Group Info</h3>
                <div class="mb-15">
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Hospital <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <label class="text-right col-form-label">{{
                                getActiveHospitalName($preferences['preference']['hospital_id']) }}</label>
                            <input type="hidden" name="hospital_id"
                                value="{{ $preferences['preference']['hospital_id'] }}">
                            <div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Doctor</label>
                        <div class="col-lg-6">
                            <select class="form-control form-select" name="doctor_id" data-live-search="true"
                                id="kt_select2_2">
                                <option selected disabled> {{ __('Select Doctor') }}</option>
                                @isset($doctors)
                                @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" @if ($doctor->id === $obj->doctor_id)
                                    selected
                                    @endif >
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
                                <option value="{{ $patient->id }}" @if ($patient->id === $obj->patient_id )
                                    selected
                                    @endif>
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
                    <!--begin::Form-->

                                                {{-- Investigations --}}
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">
                            Investigations <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-6">
                            <select class="form-control select2 form-select" id="lab_investigations"
                                name="investigations[]" multiple data-placeholder="Select investigations">
                                @foreach ($investigations as $investigation)
                                <option value="{{ $investigation->id }}"
                                    data-name="{{ $investigation->name }}"
                                    data-price="{{ (float) $investigation->price }}" @isset($selectedInvestigations) @foreach ($selectedInvestigations as $selectedInvestigation)
                                        @if ($selectedInvestigation->id === $investigation->id)
                                            selected
                                        @endif
                                    @endforeach
                                    @endisset>
                                    {{ $investigation->name }} — {{ number_format($investigation->price) }}
                                    Rs
                                </option>
                                @endforeach
                            </select>
                            <div>
                                @error('investigations')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Status <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control form-select" name="status" data-live-search="true"
                                id="deviceSelect">
                                <option selected disabled> {{ __('Select Status')}}</option>
                                <option value="pending" @if($obj->status=='pending') selected @endif > pending </option>
                                <option value="completed" @if($obj->status=='completed') selected @endif > completed
                                </option>
                                <option value="cancelled" @if($obj->status=='cancelled') selected @endif > cancelled
                                </option>
                            </select>
                            <div>
                                @error('status')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="mt-3 form-group row">
                        <label class="text-right col-lg-3 col-form-label">
                            Discount Amount <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <input type="number" class="form-control border-end-0" name="discount_percentage"
                                    id="discount_pct" value="{{ old('discount_percentage', 0) }}"
                                    placeholder="Enter Discount %" min="0" max="100" step="0.01"
                                    oninput="limitDiscount(this)">
                                <span class="bg-transparent input-group-text border-start-0">%</span>
                            </div>
                            <div>
                                @error('discount_percentage')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Date</label>
                        <div class="col-lg-6">
                            <input type="date" name="dated" class="form-control" id="dated" min="{{ date('Y-m-d') }}"
                                value="{{ old('dated', now()->format('Y-m-d')) }}">
                            @error('dated')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br>



                    {{-- <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Date <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="date" name="dated" class="form-control" id="dated" min="{{ date('Y-m-d') }}"
                                value="{{ old('dated', now()->format('Y-m-d')) }}">
                            @error('dated')
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
<script src="{{ getAssetsURLs('js/custom/select2_lab_groups.js') }}"></script>
<script>

$('#lab_investigations').select2({
  placeholder: "Select a investigation",
  allowClear: true
});

    function limitDiscount(input) {
        if (input.value > 100) {
            input.value = 100;
        } else if (input.value < 0) {
            input.value = 0;
        }
    }
</script>
<script>
    function formatCNIC(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length > 5) {
        value = value.substring(0,5) + '-' + value.substring(5);
    }
    if (value.length > 13) {
        value = value.substring(0,13) + '-' + value.substring(13);
    }
    value = value.substring(0, 15);
    input.value = value;
}
</script>
{{-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        let dob = "{{ $obj->date_of_birth ? \Carbon\Carbon::parse($obj->date_of_birth)->format('d/m/Y') : '' }}";

        let datepicker = new AirDatepicker('#datepicker', {
            dateFormat: 'dd/MM/yyyy',
            autoClose: true,
            minDate: new Date(1900, 0, 1),
            maxDate: new Date(),
            locale: {
                days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
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

        // Set the default date if available
        if (dob) {
            let parts = dob.split('/'); // Convert "DD/MM/YYYY" to "YYYY-MM-DD"
            let formattedDate = new Date(parts[2], parts[1] - 1, parts[0]);
            datepicker.selectDate(formattedDate);
        }
    });
</script> --}}
@endsection
