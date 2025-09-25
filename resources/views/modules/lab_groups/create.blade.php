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
                Create Lab Group</h1>
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

                <a href="{{route('lab_groups.create')}}">
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

    <div class="col-xl-12">

        <!--begin::List Widget 8-->
        <div class="mb-5 card card-xl-stretch mb-xl-8">
            <!--begin::Header-->
            <!--end::Header-->
            <!--begin::Body-->
            {{-- <form class="form" action="{{ route('lab_groups' . '.add_lab_group') }}" method="POST"
                enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="card-body">
                    <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. Lab Group Info</h3>
                    <div class="mb-15">
                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Hospital <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-4">
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
                            <div class="col-lg-4">
                                <select class="form-control form-select" name="doctor_id" data-live-search="true"
                                    id="kt_select2_2">
                                    <option selected disabled> {{ __('Select Doctor') }}</option>
                                    @isset($doctors)
                                    @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ "$doctor->id"===old('doctor_id') ? 'selected'
                                        : '' }}>
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
                            <div class="col-lg-4">
                                <select class="form-control form-select" name="patient_id" data-live-search="true"
                                    id="patientSelect">
                                    <option selected disabled> {{ __('Select Patient') }}</option>
                                    @isset($patients)
                                    @foreach ($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ "$patient->id"===old('patient_id')
                                        ? 'selected' : '' }}>
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


                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Investigations <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select class="form-control form-select select2" name="investigations[]"
                                    data-live-search="true" multiple id="select2investigations">
                                    <option disabled> {{ __('Select Investigation') }}</option>
                                    @isset($investigations)
                                    @foreach ($investigations as $df)
                                    <option value="{{ $df->id }}"> {{ $df->name }} </option>
                                    @endforeach
                                    @endisset
                                </select>
                                @error('investigations')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Date</label>
                            <div class="col-lg-4">
                                <input type="date" name="dated" class="form-control" id="dated"
                                    min="{{ date('Y-m-d') }}" value="{{ old('dated', now()->format('Y-m-d')) }}">
                                @error('dated')
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
                            <button type="submit" class="mr-2 btn btn-sm btn-primary">Submit</button>
                            <a href="{{ route('lab_groups' . '.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </form> --}}
            <div class="row">
                <!-- Left Side: Form (7 columns) -->
                <div class="col-lg-7">
                    <form class="form" action="{{ route('lab_groups' . '.add_lab_group') }}" method="POST"
                        enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. Lab Group Info</h3>
                            <div class="mb-15">
                                <!-- Your Form Fields -->
                                <div class="form-group row">
                                    <label class="text-right col-lg-3 col-form-label">Hospital <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <label class="text-right col-form-label">{{
                                            getActiveHospitalName($preferences['preference']['hospital_id']) }}</label>
                                        <input type="hidden" name="hospital_id"
                                            value="{{ $preferences['preference']['hospital_id'] }}">
                                    </div>
                                </div>

                                <br>

                                <div class="form-group row">
                                    <label class="text-right col-lg-3 col-form-label">Doctor</label>
                                    <div class="col-lg-9">
                                        <select class="form-control form-select" name="doctor_id"
                                            data-live-search="true" id="kt_select2_2">
                                            <option selected disabled> {{ __('Select Doctor') }}</option>
                                            @isset($doctors)
                                            @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" {{ "$doctor->id"===old('doctor_id')
                                                ? 'selected' : '' }}>
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
                                    <div class="col-lg-9">
                                        <select class="form-control form-select" name="patient_id"
                                            data-live-search="true" id="patientSelect">
                                            <option selected disabled> {{ __('Select Patient') }}</option>
                                            @isset($patients)
                                            @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}" {{ "$patient->id"===old('patient_id')
                                                ? 'selected' : '' }}>
                                                {{ $patient->name_of_patient }} -
                                                {{ $patient->cnic_number }} - {{ $patient->patient_mr_number }}
                                            </option>
                                            @endforeach
                                            @endisset
                                        </select>
                                        @error('patient_id')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <br>

                                {{-- Investigations --}}
                                <div class="form-group row">
                                    <label class="text-right col-lg-3 col-form-label">
                                        Investigations <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9">
                                        <select class="form-control select2 form-select" id="lab_investigations"
                                            name="investigations[]" multiple data-placeholder="Select investigations">
                                            @foreach ($investigations as $investigation)
                                            <option value="{{ $investigation->id }}"
                                                data-name="{{ $investigation->name }}"
                                                data-price="{{ (float) $investigation->price }}">
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

                                <div class="mt-3 form-group row">
                                    <label class="text-right col-lg-3 col-form-label">
                                        Discount Amount <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9">
                                        <div class="input-group">
                                            <input type="number" class="form-control border-end-0"
                                                name="discount_percentage" id="discount_pct"
                                                value="{{ old('discount_percentage', 0) }}"
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
                                    <div class="col-lg-9">
                                        <input type="date" name="dated" class="form-control" id="dated"
                                            min="{{ date('Y-m-d') }}"
                                            value="{{ old('dated', now()->format('Y-m-d')) }}">
                                        @error('dated')
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
                                    <button type="submit" class="mr-2 btn btn-sm btn-primary">Submit</button>
                                    <a href="{{ route('lab_groups' . '.index') }}"
                                        class="btn btn-sm btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Right Side: Calculator (5 columns) -->
                <!-- Right Side: Invoice Calculator (5 columns) -->
<div class="col-lg-4" style="padding-top: 60px;">
    <div class="border-0 shadow-sm card rounded-3">
        <!-- Header -->
        <div class="py-3 text-center text-white card-header bg-primary rounded-top">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-receipt-cutoff me-2"></i> Bill Summary
            </h5>
        </div>

        <!-- Body -->
        <div class="p-4 card-body">
            <!-- Items Table -->
            <div class="mb-3 table-responsive">
                <table class="table align-middle table-sm text-nowrap" id="calc-items-table">
                    <thead class="fw-bold">
                        <tr class="text-gray-600 fw-semibold text-uppercase fs-7">
                            <th style="width:5%">#</th>
                            <th style="width:55%">Investigation</th>
                            <th class="text-end" style="width:30%">Price (Rs)</th>
                            <th style="width:10%"></th>
                        </tr>
                    </thead>
                    <tbody id="calc-items-body">
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 small">
                                <em>No investigations selected</em>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Divider -->
            <div class="my-3 separator separator-dashed"></div>

            <!-- Totals -->
            <div class="py-1 d-flex justify-content-between">
                <span class="text-gray-600">Subtotal</span>
                <span id="calc_subtotal" class="fw-semibold">0</span>
            </div>
            <div class="py-1 d-flex justify-content-between">
                <span class="text-gray-600">Discount</span>
                <span id="calc_discount_amt" class="fw-semibold text-danger">0</span>
            </div>
            <div class="pt-3 mt-2 d-flex justify-content-between border-top fs-5">
                <span class="fw-bold">Grand Total</span>
                <span id="calc_grand_total" class="fw-bold text-success">0</span>
            </div>

            <!-- Hidden fields for form submission -->
            <input type="hidden" name="subtotal" id="subtotal_input" value="0">
            <input type="hidden" name="discount_value" id="discount_value_input" value="0">
            <input type="hidden" name="grand_total" id="grand_total_input" value="0">
        </div>
    </div>
</div>

                <div class="col-lg-1">
                </div>

                <!--end::List Widget 8-->
            </div>
            @endsection
@section('scripts')
<script>
$(document).ready(function() {
    $('#patientSelect').select2({
    placeholder: "Select a patient",
    allowClear: true
    });


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

recalcTotals(num);

}

function recalcTotals(discountPct = 0) {
    // Get subtotal from the DOM (text, not input)
    let subtotalText = document.getElementById('calc_subtotal').textContent || "0";
    let subtotal = parseFloat(subtotalText.replace(/,/g, '')) || 0;

    // Apply discount
    let discountAmt = subtotal * (discountPct / 100);
    let grandTotal = subtotal - discountAmt;

    // Update UI
    document.getElementById('calc_discount_amt').textContent = discountAmt.toFixed(2);
    document.getElementById('calc_grand_total').textContent = grandTotal.toFixed(2);

    // Update hidden inputs if you save these
    document.getElementById('discount_value_input').value = discountAmt.toFixed(2);
    document.getElementById('grand_total_input').value = grandTotal.toFixed(2);
}

$('#lab_investigations').select2({
  placeholder: "Select a investigation",
  allowClear: true
});

let investigationsMap = {};
let sr = 0;

function renderTable() {
    let $tbody = $('#calc-items-body');
    $tbody.empty();

    let sr = 1;
    let total = 0;
    let discount = 0;

    $.each(investigationsMap, function (id, item) {

        total += item.price;
        let rowHtml = `
            <tr id="row-${id}">
                <td>${sr}</td>
                <td>${item.name}</td>
                <td class="text-end">${item.price.toFixed(2)}</td>
                <td class="text-center">
                 <button type="button" class="btn btn-sm btn-transparent btn-danger remove-item" data-id="${id}" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $tbody.append(rowHtml);
        sr++;
    });

    if ($.isEmptyObject(investigationsMap)) {
        $tbody.html(`<tr><td colspan="4" class="text-center text-muted">No investigations selected</td></tr>`);
        $('#calc_subtotal').html("0.00");
    } else {
        $('#calc_subtotal').html(total.toFixed(2));
    }
}

$('#lab_investigations').on('select2:select', function (e) {
    let option = e.params.data.element;
    let id = $(option).val();
    let name = $(option).data('name');
    let price = parseFloat($(option).data('price'));

    investigationsMap[id] = { id, name, price };
    renderTable();
});

$('#lab_investigations').on('select2:unselect', function (e) {
    let option = e.params.data.element;
    let id = $(option).val();

    delete investigationsMap[id];
    renderTable();
});

$(document).on('click', '.remove-item', function () {
    let id = $(this).data('id');
    delete investigationsMap[id];
    $('#lab_investigations').find(`option[value="${id}"]`).prop('selected', false);
    $('#lab_investigations').trigger('change');
    renderTable();
});
</script>
<script>
    $(document).ready(function() {
    $("#downloadInvoiceButton").on("click", function() {
        $(this).attr("disabled", "disabled");
        $("#downloadInvoiceForm").submit();
        doWork();
    });
});

function doWork() {
    setTimeout('$("#downloadInvoiceButton").removeAttr("disabled")', 3000);
}
</script>
<script src="{{ getAssetsURLs('js/custom/select2_invoices.js') }}" async></script>
@endsection
