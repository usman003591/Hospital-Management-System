@php $page='invoices'; @endphp
@extends('layouts.master', ['activeMenu' => 'invoices_management', 'activeSubMenu' => $page, 'activeThirdMenu' => $page])

@section('breadcrumbs')
    <div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
             data-select2-id="select2-data-kt_app_toolbar_container">
            <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
                <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                    Create Invoice</h1>
                <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bg-gray-500 bullet w-5px h-2px"></span>
                    </li>
                    <a href="{{ route('invoices.index') }}">
                        <span></span>
                        <li class="breadcrumb-item text-muted text-hover-primary">{{ titleFilter($page) }}</li>
                    </a>
                    <li class="breadcrumb-item">
                        <span class="bg-gray-500 bullet w-5px h-2px"></span>
                    </li>
                    <a href="{{ route('invoices.create') }}">
                        <span></span>
                        <li class="breadcrumb-item text-muted text-hover-primary">Create</li>
                    </a>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="mb-5 card card-xl-stretch mb-xl-8">
            <form class="form needs-validation" id="downloadInvoiceForm"
                  action="{{ route($page . '.store') }}" method="POST" target="_blank"
                  enctype="multipart/form-data" novalidate>
                @csrf

                <div class="card-body">
                    <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. Invoice Info</h3>

                    <div class="mb-15">
                        {{-- Hospital --}}
                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Hospital <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <label class="text-right col-form-label">
                                    {{ getActiveHospitalName($preferences['preference']['hospital_id']) }}
                                </label>
                                <input type="hidden" name="hospital_id" value="{{ $preferences['preference']['hospital_id'] }}">
                            </div>
                        </div>

                        <br>

                        {{-- Patient --}}
                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Patients <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select class="form-control form-select" name="patient_id" data-live-search="true" id="kt_select2_1">
                                    <option selected disabled>{{ __('Select Patient') }}</option>
                                    @isset($patients)
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->name_of_patient }} - {{ $patient->cnic_number }} - {{ $patient->patient_mr_number }}
                                            </option>
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

                        {{-- Services --}}
                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Services <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select class="form-control select2 form-select" id="kt_select2_3" name="services[]" multiple style="display:none;">
                                    @foreach ($serviceCategories as $service)
                                        <optgroup label="{{ $service->service_name }}">
                                            @foreach ($service->children as $child)
                                                <option
                                                    value="{{ $child->id }}"
                                                    data-name="{{ $child->service_name }}"
                                                    data-code="{{ $child->category_code }}"
                                                    data-price="{{ $child->default_amount }}"
                                                    {{ in_array($child->id, old('services', [])) ? 'selected' : '' }}>
                                                    {{ $child->service_name }} - {{ $child->category_code }} - {{ number_format($child->default_amount) }} Rs/-
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <div>
                                    @error('services')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <br>

                        {{-- Discount (%) --}}
                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Discount Amount <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <input type="number"
                                           class="form-control border-end-0"
                                           name="discount_amount"
                                           value="{{ old('discount_amount') ?? 0 }}"
                                           placeholder="Enter Discount Amount"
                                           min="0" max="100"
                                           oninput="limitDiscount(this)">
                                    <span class="input-group-text border-start-0 bg-transparent">%</span>
                                </div>
                                <div>
                                    @error('discount_amount')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bottom-centered Bill Summary (with items list) --}}
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">

                            {{-- ===== BILL SUMMARY AT BOTTOM ===== --}}
                            <div class="mt-0">
                                <div class="card card-flush">
                                    <div class="card-header align-items-center">
                                        <div class="card-title">
                                            <h3 class="card-label mb-0">Bill Summary</h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <span class="badge badge-light-primary">
                                                <span id="bs_items_count">0</span> items
                                            </span>
                                        </div>
                                    </div>

                                    <div class="card-body pt-5">
                                        {{-- Items table --}}
                                        <div class="table-responsive">
                                            <table class="table align-middle table-row-dashed gy-3">
                                                <thead class="text-gray-600">
                                                    <tr>
                                                        <th style="width:60px">#</th>
                                                        <th>Service</th>
                                                        <th style="width:140px" class="text-end">Price (Rs)</th>
                                                        <th style="width:90px" class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bs_items_table">
                                                    <tr id="bs_items_empty">
                                                        <td colspan="4" class="text-center text-gray-500">No items selected</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="separator my-6"></div>

                                        {{-- Totals --}}
                                        <div class="d-flex flex-column gap-3">
                                            <div class="d-flex justify-content-between">
                                                <span class="text-gray-700">Subtotal</span>
                                                <span class="fw-bold" id="bs_subtotal">Rs 0</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-gray-700">Discount</span>
                                                <span class="fw-bold">
                                                    <span id="bs_discount_percent">0</span>%
                                                    <span class="text-gray-600"> (Rs <span id="bs_discount_amount">0</span>)</span>
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between fs-5">
                                                <span class="fw-semibold">Grand Total</span>
                                                <span class="fw-bold" id="bs_total">Rs 0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Hidden fields to submit computed values --}}
                                <input type="hidden" name="summary_items_count" id="summary_items_count" value="0">
                                <input type="hidden" name="summary_subtotal" id="summary_subtotal" value="0">
                                <input type="hidden" name="summary_discount_percent" id="summary_discount_percent" value="{{ old('discount_amount', 0) }}">
                                <input type="hidden" name="summary_discount_amount" id="summary_discount_amount" value="0">
                                <input type="hidden" name="summary_grand_total" id="summary_grand_total" value="0">
                            </div>
                            {{-- ===== END BILL SUMMARY ===== --}}

                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    {{-- /Bottom-centered Bill Summary --}}

                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-9"></div>
                        <div class="col-lg-3 text-end">
                            <button type="submit" id="downloadInvoiceButton" class="mr-2 btn btn-sm btn-primary">Download</button>
                            <a href="{{ route($page . '.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Bootstrap bundle (if not already globally included) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"></script>

    {{-- Prevent double-submit on Download --}}
    <script>
        $(document).ready(function() {
            $("#downloadInvoiceButton").on("click", function() {
                $(this).attr("disabled", "disabled");
                $("#downloadInvoiceForm").submit();
                setTimeout(function () {
                    $("#downloadInvoiceButton").removeAttr("disabled");
                }, 3000);
            });
        });
    </script>

    {{-- Limit discount between 0–100 --}}
    <script>
        function limitDiscount(input) {
            let val = input.value.replace(/\D/g, '');
            val = val.substring(0, 3);
            let num = parseInt(val, 10);
            if (isNaN(num)) {
                input.value = '';
            } else {
                input.value = Math.min(num, 100);
            }
        }
    </script>

    {{-- Bill Summary: items table + totals --}}
    <script>
        function clampPercent(v) {
            v = parseInt(v, 10);
            if (isNaN(v) || v < 0) return 0;
            if (v > 100) return 100;
            return v;
        }

        function formatPK(n) {
            try { return Number(n || 0).toLocaleString('en-PK'); }
            catch(e) { return (n || 0); }
        }

        function getSelectedOptions() {
            return $('#kt_select2_3 option:selected');
        }

        function rebuildItemsTable() {
            const $tbody = $('#bs_items_table');
            $tbody.empty();

            const $opts = getSelectedOptions();
            if ($opts.length === 0) {
                $tbody.append('<tr id="bs_items_empty"><td colspan="4" class="text-center text-gray-500">No items selected</td></tr>');
                return;
            }

            let idx = 1;
            $opts.each(function () {
                const $o = $(this);
                const id    = $o.val();
                const name  = $o.data('name') || $o.text();
                const code  = $o.data('code') || '';
                const price = parseFloat($o.data('price')) || 0;

                $tbody.append(
                    '<tr>' +
                        '<td>' + (idx++) + '</td>' +
                        '<td>' +
                            '<div class="fw-semibold">' + name + '</div>' +
                            '<div class="text-gray-600 fs-8">Code: ' + code + '</div>' +
                        '</td>' +
                        '<td class="text-end">' + formatPK(price) + '</td>' +
                        '<td class="text-end">' +
                            '<button type="button" class="btn btn-sm btn-light-danger bs-remove-item" data-id="' + id + '">Remove</button>' +
                        '</td>' +
                    '</tr>'
                );
            });
        }

        function recalcTotals() {
            let subtotal = 0;
            getSelectedOptions().each(function () {
                subtotal += parseFloat($(this).data('price')) || 0;
            });

            const itemsCount = getSelectedOptions().length;
            const discountPercent = clampPercent($('input[name="discount_amount"]').val());
            const discountAmount = Math.round(subtotal * (discountPercent / 100));
            const total = Math.max(0, subtotal - discountAmount);

            // Update counts and totals
            $('#bs_items_count').text(itemsCount);
            $('#bs_subtotal').text('Rs ' + formatPK(subtotal));
            $('#bs_discount_percent').text(discountPercent);
            $('#bs_discount_amount').text(formatPK(discountAmount));
            $('#bs_total').text('Rs ' + formatPK(total));

            // Hidden fields
            $('#summary_items_count').val(itemsCount);
            $('#summary_subtotal').val(subtotal);
            $('#summary_discount_percent').val(discountPercent);
            $('#summary_discount_amount').val(discountAmount);
            $('#summary_grand_total').val(total);
        }

        function recalcBillSummary() {
            rebuildItemsTable();
            recalcTotals();
        }

        $(document).ready(function () {
            // Recalc when services change
            $('#kt_select2_3').on('change', recalcBillSummary);

            // Recalc when discount changes
            $('input[name="discount_amount"]').on('input', function () {
                const v = clampPercent($(this).val());
                $(this).val(v);
                recalcBillSummary();
            });

            // Remove item from summary -> deselect in Select2 source
            $(document).on('click', '.bs-remove-item', function () {
                const id = $(this).data('id');
                const $opt = $('#kt_select2_3 option[value="' + id + '"]');
                $opt.prop('selected', false);
                $('#kt_select2_3').trigger('change'); // will rebuild + recalc
            });

            // Initial build (handles old() preselected values)
            recalcBillSummary();
        });
    </script>

    {{-- Your Select2 init (kept) --}}
    <script src="{{ getAssetsURLs('js/custom/select2_invoices.js') }}" async></script>
@endsection
