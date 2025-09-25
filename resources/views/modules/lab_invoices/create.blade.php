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
                    Create Invoice</h1>
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
                    <a href="{{ route('invoices.index') }}">
                        <span></span>
                        <li class="breadcrumb-item text-muted text-hover-primary">{{ titleFilter($page) }}</li>
                    </a>
                    <!--end::Item-->

                    <li class="breadcrumb-item">
                        <span class="bg-gray-500 bullet w-5px h-2px"></span>
                    </li>

                    <a href="{{ route('invoices.create') }}">
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
            <!--begin::Body-->
            <form class="form" id="downloadInvoiceForm" action="{{ route($page . '.store') }}" method="POST" target="_blank"
                enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="card-body">
                    <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. Invoice Info</h3>
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
                            <label class="text-right col-lg-3 col-form-label">Patients <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select class="form-control form-select" name="patient_id" data-live-search="true"
                                    id="kt_select2_1">
                                    <option selected disabled> {{ __('Select Patient') }}</option>
                                    @isset($patients)
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}> {{ $patient->name_of_patient }} -
                                                {{ $patient->cnic_number }} - {{ $patient->patient_mr_number }} </option>
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
                            <label class="text-right col-lg-3 col-form-label">
                                Investigations <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <select
                                class="form-control select2 form-select"
                                id="kt_select2_3"
                                name="investigations[]"
                                multiple
                                data-placeholder="Select investigations"
                                >
                                @foreach ($investigations as $investigation)
                                    <option
                                    value="{{ $investigation->id }}"
                                    data-name="{{ $investigation->name }}"
                                    data-price="{{ (float) $investigation->price }}"
                                    >
                                    {{ $investigation->name }} — {{ number_format($investigation->price) }} Rs
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

                            <!-- Discount % (keeps your original name) -->
                            <div class="form-group row mt-3">
                            <label class="text-right col-lg-3 col-form-label">
                                Discount Amount <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                       <input
                                        type="number"
                                        class="form-control border-end-0"
                                        name="discount_percentage"
                                        id="discount_pct"
                                        value="{{ old('discount_percentage', 0) }}"
                                        placeholder="Enter Discount %"
                                        min="0"
                                        max="100"
                                        >
                                <span class="bg-transparent input-group-text border-start-0">%</span>
                                </div>
                                <div>
                                @error('discount_percentage')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                </div>
                            </div>
                            </div>

                            <!-- Bill Summary -->
                            <div class="row mt-4">
                            <div class="col-lg-6 offset-lg-3">
                                <div class="card shadow-sm" style="border-radius: 1rem;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Bill Summary</h5>
                                    <small class="text-muted">Auto-updates on every change</small>
                                    </div>

                                    <div class="table-responsive">
                                    <table class="table align-middle mb-0" id="bill-items-table">
                                        <thead class="border-bottom">
                                        <tr>
                                            <th style="width:60%">Investigation</th>
                                            <th class="text-end" style="width:40%">Price (Rs)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr><td colspan="2" class="text-center text-muted">No investigations selected</td></tr>
                                        </tbody>
                                    </table>
                                    </div>

                                    <hr class="my-3">

                                    <div class="d-flex flex-column gap-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Subtotal</span>
                                        <span id="subtotal" class="fw-semibold">0</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Discount</span>
                                        <span id="discount_amt" class="fw-semibold">0</span>
                                    </div>
                                    <div class="d-flex justify-content-between fs-5 mt-2">
                                        <span class="fw-bold">Grand Total</span>
                                        <span id="grand_total" class="fw-bold">0</span>
                                    </div>
                                    </div>

                                    <!-- Hidden fields for backend -->
                                    <input type="hidden" name="subtotal" id="subtotal_input" value="0">
                                    <input type="hidden" name="discount_value" id="discount_value_input" value="0">
                                    <input type="hidden" name="grand_total" id="grand_total_input" value="0">
                                </div>
                                </div>
                            </div>
                            <div class="col-lg-3"></div>
                            </div>



                         {{-- <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Investigations <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select class="form-control select2 form-select" id="kt_select2_3" name="investigations[]"
                                    multiple style="display:none;">
                                    @foreach ($investigations as $investigation)
                                        <option value="{{ $investigation->id }}"> {{ $investigation->name }} - {{ $investigation->price }} RS/- </option>
                                    @endforeach
                                </select>
                                <div>
                                    @error('investigations')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br> --}}

                        {{-- <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Discount Amount <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <input type="number" class="form-control border-end-0" name="discount_amount" value="{{ old('discount_amount') }}"
                                        placeholder="Enter Discount Amount" min="0" max="100" oninput="limitDiscount(this)">
                                    <span class="bg-transparent input-group-text border-start-0">%</span>
                                </div>
                                <div>
                                    @error('discount_amount')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}
                        <br>
                        {{--
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Payment Status</label>
                        <div class="col-lg-6">
                            <select class="form-control" name="invoice_payment_status_id" data-live-search="true" id="">
                                <option selected disabled> {{ __('Select payment status')}}</option>

                                @isset($payment_statuses)
                                @foreach ($payment_statuses as $status)
                                <option value="{{$status->id}}" {{ "$status->id"===old('invoice_payment_status_id')
                                    ? 'selected' : '' }}>
                                    {{$status->name}} </option>
                                @endforeach
                                @endisset

                            </select>
                            <div>
                                @error('invoice_payment_status_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br> --}}


                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-9"></div>
                        <div class="col-lg-3 text-end">
                            <button type="submit" id="downloadInvoiceButton"
                                class="mr-2 btn btn-sm btn-primary">Download</button>
                            <a href="{{ route($page . '.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
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

<!-- ===== Scripts ===== -->
<script>
  (function () {
    // init Select2 (safe-guard: only init if not already)
    if (window.jQuery) {
      var $sel = jQuery('#kt_select2_3');
      if (!$sel.data('select2')) {
        $sel.select2({
          placeholder: $sel.data('placeholder') || 'Select investigations',
          width: '100%'
        });
      }
    }

    const fmt = new Intl.NumberFormat('en-PK', { maximumFractionDigits: 0 });

    const els = {
      select: document.getElementById('kt_select2_3'),
      tbody:  document.querySelector('#bill-items-table tbody'),
      subtotal: document.getElementById('subtotal'),
      discountPct: document.getElementById('discount_pct'),
      discountAmt: document.getElementById('discount_amt'),
      grand: document.getElementById('grand_total'),
      subtotalInput: document.getElementById('subtotal_input'),
      discountValueInput: document.getElementById('discount_value_input'),
      grandInput: document.getElementById('grand_total_input')
    };

    function getSelectedItems() {
      // Always read from the actual <select> so it works with/without Select2
      const options = els.select ? Array.from(els.select.querySelectorAll(':checked')) : [];
      return options.map(opt => ({
        id: opt.value,
        name: opt.getAttribute('data-name') || opt.textContent.trim(),
        price: parseFloat(opt.getAttribute('data-price') || '0') || 0
      }));
    }

    function renderTable(items) {
      els.tbody.innerHTML = items.length
        ? items.map(i => `
            <tr>
              <td>${i.name}</td>
              <td class="text-end">${fmt.format(i.price)}</td>
            </tr>
          `).join('')
        : `<tr><td colspan="2" class="text-center text-muted">No investigations selected</td></tr>`;
    }

    function recalc() {
      const items = getSelectedItems();
      renderTable(items);

      const subtotal = items.reduce((s, i) => s + i.price, 0);
      const discountPct = Math.min(100, Math.max(0, parseFloat(els.discountPct?.value || '0') || 0));
      const discountAmt = Math.max(0, subtotal * (discountPct / 100));
      const grand = Math.max(0, subtotal - discountAmt);

      els.subtotal.textContent = fmt.format(subtotal);
      els.discountAmt.textContent = fmt.format(discountAmt);
      els.grand.textContent = fmt.format(grand);

      // Hidden inputs for backend
      els.subtotalInput.value = Math.round(subtotal);
      els.discountValueInput.value = Math.round(discountAmt);
      els.grandInput.value = Math.round(grand);
    }

    function clampDiscountAndRecalc() {
      let v = parseFloat(els.discountPct.value || '0');
      if (isNaN(v)) v = 0;
      v = Math.min(100, Math.max(0, v));
      els.discountPct.value = v;
      recalc();
    }

    document.addEventListener('DOMContentLoaded', function () {
      recalc();

      // Listen for all relevant Select2 events + native change (covers add/remove)
      if (window.jQuery) {
        const $s = jQuery('#kt_select2_3');
        $s.on('change select2:select select2:unselect', recalc); // fires on add/remove
      } else {
        els.select.addEventListener('change', recalc);
      }

      // Recalc on discount changes
      ['input', 'change', 'keyup'].forEach(ev => {
        els.discountPct.addEventListener(ev, clampDiscountAndRecalc);
      });
    });
  })();
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

    <script src="{{ getAssetsURLs('js/custom/select2_invoices.js') }}" async></script>
@endsection
