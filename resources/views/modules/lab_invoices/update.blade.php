@php $page = 'lab_invoices'; @endphp
@extends('layouts.master', ['activeMenu' => 'invoices_management','activeSubMenu' => $page,'activeThirdMenu' => $page])
@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
        data-select2-id="select2-data-kt_app_toolbar_container">
        <!--begin::Page title-->
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <!--begin::Title-->
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                Update Invoice</h1>
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
                <a href="{{route('lab_invoices.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{titleFilter($page)}}</li>
                </a>
                <!--end::Item-->

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="{{route('lab_invoices.edit', $obj->id)}}">
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
        <!--begin::Body-->
        <form class="form" action="{{route($page.'.update',$obj->id)}}" method="POST" enctype="multipart/form-data" target="_blank">
            @csrf
            @method('patch')

            <div class="card-body">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. Lab Invoice Info</h3>
                <div class="mb-15">

                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Hospital <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">

                            <label class="text-right col-form-label">{{getActiveHospitalName($obj->hospital_id)}}</label>
                            <input type="hidden" name="hospital_id" value="{{$obj->hospital_id}}">

                            <div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Patients <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control form-select" name="patient_id" data-live-search="true"
                                id="kt_select2_1">
                                <option selected disabled> {{ __('Select Patient')}}</option>
                                @isset($patients)
                                @foreach ($patients as $patient)
                                <option value="{{$patient->id}}" @if ($obj->patient_id == $patient->id)
                                selected
                                @endif> {{$patient->name_of_patient}} - {{$patient->cnic_number}} - {{$patient->patient_mr_number}} </option>
                                @endforeach
                                @endisset
                            </select>
                            <div>
                                @error('patient_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">  Investigations <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control select2 form-select" id="kt_select2_3" name="investigations[]"
                                multiple style="display:none;">
                                    @foreach ($investigations as $investigation)
                                    <option value="{{$investigation->id}}"
                                    @foreach ($selected_investigations as $sc)
                                    @if($investigation->id == $sc->investigation_id) selected @endif
                                    @endforeach>
                                    {{$investigation->name}}
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
                        <label class="text-right col-lg-3 col-form-label">Discount Amount <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="input-group">
                                    <input type="number" class="form-control border-end-0" name="discount_amount" value="{{ ($obj->discount_amount*100)/$obj->total_amount }}"
                                        placeholder="Enter Discount Amount" min="0" max="100" oninput="limitDiscount(this)">
                                    <span class="bg-transparent input-group-text border-start-0">%</span>
                                </div>
                            <div>
                                @error('discount_amount')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>

                    {{-- @php
                      $date_issued = Carbon\Carbon::createFromFormat('d/m/Y', $obj->date_issued)->format('d-m-Y');
                    @endphp --}}

                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Date Issued <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">

                            <input type="text" id="datepicker" class="form-control" placeholder="DD/MM/YYYY"
                                name="date_issued" value="{{ \Carbon\Carbon::parse($obj->date_issued)->format('d/m/Y h:i A') }}"
                                readonly
                                >
                            <div>
                                @error('date_issued')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
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
<script src="{{getAssetsURLs('js/custom/select2_invoices.js')}}" async></script>
<link href="{{getAssetsURLs('plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
<script src="{{getAssetsURLs('plugins/global/plugins.bundle.js')}}"></script>
<script>
    new AirDatepicker('#datepicker', {
    dateFormat: 'dd/MM/yyyy',
    autoClose: true,
    timepicker: true,
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

</script>
<script>
    function limitDiscount(input) {
            let val = input.value.replace(/\D/g, ''); // remove non-digits
            val = val.substring(0, 3); // limit to 3 characters

            // Convert to number and clamp between 0 and 100
            let num = parseInt(val, 10);
            if (isNaN(num)) {
                input.value = '';
            } else {
                input.value = Math.min(num, 100);
            }
        }
</script>
@endsection
